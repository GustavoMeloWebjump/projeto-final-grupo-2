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
use Magento\Framework\Api\Data\ImageContentInterfaceFactory;
use Webjump\Backend\App\CustomState;


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
            'file' => '/csv/petshop-products.csv'
        ],
        // 2 => [
        //     'entity' => 'catalog_product',
        //     'behavior' => 'add_update',
        //     'file' => '/csv/website-products.csv'
        // ]
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

    /**
     * @var ImageContentInterfaceFactory
     */
    private $imageFactory;

    /**
     * @var CustomState
     */
    private $customState;

    public function __construct(
     CsvFactory $csv,
     ImportFactory $importFactory,
     File $file,
     State $state,
     ReadFactory $readFile,
     ProductRepositoryInterface $productRepository,
     MediaFactory $mediaFactory,
     ImageContentInterfaceFactory $imageFactory,
     CustomState $customState
    )
    {
        $this->csv = $csv;
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->readFile = $readFile;
        $this->state = $state;
        $this->productRepository = $productRepository;
        $this->mediaFactory = $mediaFactory;
        $this->imageFactory = $imageFactory;
        $this->customState = $customState;
    }


    public function execute(OutputInterface $output)
    {

        if (!$this->customState->validateAreaCode()) {
            $this->customState->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        }

        foreach (self::IMPORT_DATA  as $data) {
            $this->importData(
                $data['file'],
                $data['entity'],
                $data['behavior']
            );

            $output->writeln("Import " . __DIR__ . $data['file']);
        }

        $images_array = $this->getImages();

        foreach($images_array as $index => $value) {

            $img = file_get_contents($index[key($value)]);

            $data = base64_encode($img);

            $image = $this->imageFactory->create();
            $image
            ->setBase64EncodedData($data)
            ->setName(key($value))
            ->setType('image/jpeg');

            $media = $this->mediaFactory->create();
            $media
            ->setMediaType('image')
            ->setTypes(['image', 'small_image', 'thumbnail'])
            ->setContent($image);

            $product = $this->productRepository->get(key($value), true);
            $product
            ->setMediaGalleryEntries([$media]);

            $this->productRepository->save($product);
        }
    }

    private function getImages()
    {
        return [
            'patinhas' => [
                  'P-SAP-1'=>
                'https://www.petlove.com.br/images/products/224783/product/Shampoo_Sanol_Dog_Antipulgas_-_500_mL_3103184.jpg',

                  'P-CBD-1'=>
                'https://www.petlove.com.br/images/products/136527/product/7897085911917.jpg',

                  'P-RC-1'=>
                'https://a-static.mlcdn.com.br/574x431/racao-magnus-todo-dia-sabor-carne-para-caes-adultos-20kg/mercadopetmaxmaringa/8894268986/d97ecd366746917bc3e8db5e8ff102ea.jpg',

                  'P-CPC-1'=>
                'https://www.petlove.com.br/images/products/142321/product/Peitoral-Jambo-Color-Square.jpg',

                  'P-REN-1'=>
                'https://www.petlove.com.br/images/products/191163/product/Racao-Farmina-Ecopet-Natural-Frango-para-Caes-Adultos-de-Racas-Medias-e-Grandes.jpg',

                  'P-SCD-1'=>
                'https://images.tcdn.com.br/img/img_prod/771572/soft_care_baby_gel_dental_40_g_35523_1_20201214015611.jpg',

                  'P-AM-1'=>
                'https://www.terradospassaros.com/loja/images/688_grd.jpg',

                  'P-VP-1'=>
                'https://30646.cdn.simplo7.net/static/30646/sku/passaros-viveiro-chalesco-chale-branco--p-1548952327436.jpg',

                  'P-RW-1'=>
                'https://primo-supermercado.s3.amazonaws.com/media/uploads/produto/racao_whiskas_gatos_castrados_500g_fa7a78af-66d3-490b-8031-69d930bd4bfc.jpg',

                  'P-RM-1'=>
                'https://www.petlove.com.br/images/products/183569/product/3104972.jpg',

                  'P-AG-1'=>
                'https://www.olivar.com.br/media/catalog/product/cache/1/image/400x400/9df78eab33525d08d6e5fb8d27136e95/7/9/7908086105349-mesa-arranhador-pet-persa---preto---infinito.jpg',

                  'P-CA4E-1'=>
                'https://www.petlove.com.br/images/products/200100/product/Brinquedo_Arranhador_The_Pets_Brasil_02_Bases_Suspensas_e_Caixa_1962827.jpg',

            ],
            'fanon' => [
                  'F-AO-1'=>
                'https://media.very.co.uk/i/very/RHXMH_SQ1_0000000226_BLACK_BLACK_SLf/adidas-originals-ozweego-blacknbsp.jpg',

                  'F-AO-2'=>
                'https://media.littlewoods.com/i/littlewoods/RHXPY_SQ1_0000000067_CREAM_SLf/adidas-ozweego-creamnbsp.jpg',

                  'F-AF1-1'=>
                'https://media.littlewoods.com/i/littlewoods/PLG7R_SQ1_0000000269_WHITE_BLACK_SLf/nike-air-force-1-07-shoe-whiteblack.jpg',

                  'F-AF1-2'=>
                'https://media.very.co.uk/i/very/PKDDT_SQ1_0000000226_BLACK_BLACK_SLf/nike-air-force-1-junior-trainers-black.jpg',

                  'F-AJ1H-1'=>
                'https://cdn.shopify.com/s/files/1/0587/5571/1152/products/HIGHOGTWIST1_480x480.jpg',

                  'F-AM270-1'=>
                'https://media.littlewoods.com/i/littlewoods/NT9HJ_SQ1_0000000226_BLACK_BLACK_SLf/nike-air-max-270-blacknbsp.jpg',

                  'F-AM270-2'=>
                'https://media.very.co.uk/i/very/QJ3DJ_SQ1_0000000486_WHITE_NAVY_SLf/nike-air-max-270-react.jpg',

                  'F-AM90-1'=>
                'https://media.littlewoods.com/i/littlewoods/RPAJY_SQ1_0000000329_WHITE_GREEN_SLf/nike-womens-air-max-90-whitegreen.jpg',

                  'F-AM90-2'=>
                'https://media.littlewoods.com/i/littlewoods/R4JMG_SQ1_0000000013_WHITE_SLf/adidas-originals-nmd_r1-white.jpg',

                  'F-PRX-1'=>
                'https://media.very.co.uk/i/very/RU67X_SQ1_0000000114_BLACK_GREY_SLf/puma-rs-znbspcollege-blackgrey.jpg',

                  'F-PRX-2'=>
                'https://media.very.co.uk/i/very/RFKM4_SQ1_0000000726_GREY_RED_SLf/puma-rs-xsup3-twill-airmesh-greyred.jpg',

                  'F-AJ3R-1'=>
                'https://krosbery.com.ua/content/images/6/360x480l80nn0/jordan-3-retro-fragment-16729390710254.png',

                  'F-ANR-1'=>
                'https://cdn.shopify.com/s/files/1/0068/3707/6025/products/adi-gx8312-blk-1_5ab75d1a-cf47-4d20-a732-aa8d009f8971_large.jpg',

                  'F-ANR-2'=>
                'https://media.littlewoods.com/i/littlewoods/R4JMG_SQ1_0000000013_WHITE_SLf/adidas-originals-nmd_r1-white.jpg',

            ],

        ];
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
