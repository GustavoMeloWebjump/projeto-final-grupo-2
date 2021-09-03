<?php
// namespace Webjump\Backend\Model\Product;

// use Magento\Framework\File\Csv;
// use Magento\ImportExport\Model\ImportFactory;
// use Magento\Framework\App\State;
// use Magento\Framework\Filesystem\Io\File;
// use Magento\Framework\Filesystem\Directory\ReadFactory;
// use Magento\Catalog\Api\Data\ProductInterfaceFactory as ProductFactory;
// use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepository;
// use Magento\Setup\Module\Setup;
// use Magento\Eav\Api\AttributeSetRepositoryInterface;
// use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterfaceFactory;



// class AddNewProducts
// {

//     const CSV_FILE = "/Csv/Produtos.csv";

//     /**
//      * @var Csv
//      */
//     private $csv;


//     /**
//      * @var ImportFactory
//      */
//     private $importFactory;

//     /**
//      * @var ProductFactory
//      */
//     private $productFactory;

//     /**
//      * @var Setup
//      */
//     private Setup $setup;


//     /**
//      * @var ProductRepository
//      */
//     private $productRepository;

//     /**
//      * @var AttributeSetRepositoryInterface
//      */
//     private $attributeSetRepository;

//     /**
//      * @var ProductAttributeMediaGalleryEntryInterfaceFactory
//      */

//      private $productMediasFactory;


//     public function __construct(
//      Setup $setup,
//      Csv $csv,
//      ImportFactory $importFactory,
//      ProductFactory $productFactory,
//      ProductRepository $productRepository,
//      AttributeSetRepositoryInterface $attributeSetRepository,
//      ProductAttributeMediaGalleryEntryInterfaceFactory $productMediasFactory,
//     )
//     {
//         $this->setup = $setup;
//         $this->csv = $csv;
//         $this->importFactory = $importFactory;
//         $this->productFactory = $productFactory;
//         $this->productRepository = $productRepository;
//         $this->attributeSetRepository = $attributeSetRepository;
//         $this->productMediasFactory = $productMediasFactory;
//     }

//     public function setData() {

//         $csv = $this->getData();

//         $columns = $csv[0];

//         unset($csv[0]);

//         $csv = array_values($csv);

//         var_dump($csv);


//         foreach($csv as $value) {
//             $productSetup = $this->productFactory->create();

//             $attributeId = $this->attributeSetRepository->get($value[1])->getAttributeSetId();

//             $path = __DIR__ . $value[15];

//             $image = $this->productMediasFactory->create();

//             $image->setFile($path);

//             $productSetup
//             ->setAttributeSetId($attributeId)
//             ->setName($value[2])
//             ->setSku($value[3])
//             ->setPrice($value[4])
//             ->setWeight($value[12])
//             ->setVisibility($value[14])
//             ->setMediaGalleryEntries([$image])
//             ->setStockStatus($value[11])
//             ->setQty($value[10])
//             ->setTax($value[5])
//             ->setIsActive($value[0])
//             ->setCustomAttribute()

//         }


//         // $productSetup
//         // ->setName()
//         // ->setSku()
//         // ->setTypeId()
//         // ->addImageToMediaGallery()
//         // ->setPrice()
//         // ->setQty()
//         // ->setWeight()
//         // ->setUrlKey()
//         // ->setStoreId()
//         // ->setVisibility();


//     }


//     public function getData() {

//         $path = __DIR__ . self::CSV_FILE;

//         $csvFile = $this->csv->getData($path);


//         return $csvFile;
//     }

// }
