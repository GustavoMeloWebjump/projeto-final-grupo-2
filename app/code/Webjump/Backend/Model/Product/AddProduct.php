<?php
namespace Webjump\Backend\Model\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\ImportFactory;
use Magento\Framework\App\State;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterfaceFactory as MediaFactory;

class AddProduct
{
    const CSV_FILE = "/csv/products.csv";

    const IMPORT_DATA = [
        0 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => '/csv/sneakers_products.csv'
        ],
        1 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => '/csv/website-products.csv'
        ],
        2 => [
            'entity' => 'stock_sources',
            'behavior' => 'append',
            'file' => '/csv/stock.csv'
        ],
        3 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => '/csv/petshop-products.csv'
        ]
    ];

    /**
     * @var CsvFactory
     */
    private $csv;

    /**
     * @var State
     */
    private $state;

    /**
     * @var ImportFactory
     */
    private $importFactory;

    /**
     * @var File
     */
    private $file;

    /**
     * @var ReadFactory
     */
    private $readFile;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var MediaFactory
     */
    private $mediaFactory;

    public function __construct(
     CsvFactory $csv,
     ImportFactory $importFactory,
     File $file,
     State $state,
     ReadFactory $readFile,
     ProductRepositoryInterface $productRepository,
     MediaFactory $mediaFactory
    )
    {
        $this->csv = $csv;
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->readFile = $readFile;
        $this->state = $state;
        $this->productRepository = $productRepository;
        $this->mediaFactory = $mediaFactory;
    }


    public function execute(OutputInterface $output)
    {
        foreach (self::IMPORT_DATA  as $data) {
            $this->importData(
                $data['file'],
                $data['entity'],
                $data['behavior']
            );

            $output->writeln("Import " . __DIR__ . $data['file']);
        }

        $media = $this->mediaFactory->create();
        $media->setFile(__DIR__ . '/img/image_test.jpg')
            ->setMediaType('image');

        $product = $this->productRepository->get('P-CA4E-1', true);

        $product->setMediaGalleryEntries([$media]);
        
        $this->productRepository->save($product);
    }

    public function importData($filename, $entity, $behavior)
    {
        $importSetup = $this->importFactory->create();

        $importSetup->setData([
            'entity' => $entity,
            'behavior' => $behavior,
            'validation_strategy' => 'validation-stop-on-errors'
        ]);

        $validation = $importSetup->validateSource($this->getData($filename));

        if($validation) {
        $result = $importSetup->importSource();
            if ($result) {
                $importSetup->invalidateIndex();
            }
        }

    }

    private function getData(string $filename) {

        $path = __DIR__ . $filename;

        $import_file = $this->file->getPathInfo($path);


        $readSetup = $this->readFile->create($import_file["dirname"]);

        $csvFile = $this->csv->create([
            'file' => $import_file["basename"],
            'directory' => $readSetup,
        ]);


        return $csvFile;
    }
}
