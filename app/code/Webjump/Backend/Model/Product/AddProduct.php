<?php
namespace Webjump\Backend\Model\Product;

use Magento\Catalog\Api\Data\ProductLinkInterfaceFactory;
use Magento\ImportExport\Model\Import;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ImportExport\Model\ImportFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Symfony\Component\Console\Output\ConsoleOutput;
use Webjump\Backend\App\CustomState;

class AddProduct
{

    const IMPORT_DATA = [
        0 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'fanon_products.csv'
        ],
        1 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'patinhas_products.csv'
        ],
        3 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'grouped_products.csv'
        ],
        4 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'bundle_products.csv'
        ],
        5 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'virtual_download_products.csv'
        ],
        6 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'configurable_products.csv'
        ],
        7 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'website_products.csv'
        ],

    ];

    /**
     * @var CsvFactory
     */
    private $csv;

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

    /** @var ConsoleOutput */
    private $output;

    public function __construct(
        CsvFactory $csv,
        ImportFactory $importFactory,
        File $file,
        ReadFactory $readFile,
        ConsoleOutput $output
    )
    {
        $this->csv = $csv;
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->readFile = $readFile;
        $this->output = $output;
    }


    public function execute()
    {
        foreach (self::IMPORT_DATA as $data) {
            $this->importData(
                $data['file'],
                $data['entity'],
                $data['behavior'],
            );

        }
    }

    private function importData($filename, $entity, $behavior)
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

            $this->output->writeln("Importado {$filename} com sucesso!");

            if ($result) {
                $importSetup->invalidateIndex();
            }
        }

    }

    private function getData($filename) {

        $import_file = $this->file->getPathInfo(__DIR__ . '/csv/' . $filename);


        $readSetup = $this->readFile->create($import_file['dirname']);

        $csvFile = $this->csv->create([
            'file' => $import_file['basename'],
            'directory' => $readSetup,
        ]);


        return $csvFile;
    }
}
