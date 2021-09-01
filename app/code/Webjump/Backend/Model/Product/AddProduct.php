<?php
namespace Webjump\Backend\Model\Product;

use Magento\Framework\File\Csv;
use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\ImportFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\Framework\Filesystem\Directory\ReadFactory;

class AddProduct
{

    const CSV_FILE = "/Csv/product.csv";

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

    public function __construct(
     CsvFactory $csv,
     ImportFactory $importFactory,
     File $file,
     ReadFactory $readFile
    )
    {
        $this->csv = $csv;
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->readFile = $readFile;
    }

    public function importData()
    {
        $importSetup = $this->importFactory->create();

        $importSetup->setData([
            'entity' => 'products',
            'behavior' => Import::BEHAVIOR_ADD_UPDATE,
            'validation_strategy' => 'validation-stop-on-errors'
        ]);

        $importSetup->validateSource($this->getData());
    }

    public function getData() {

        $import_file = $this->file->getPathInfo(__DIR__ . self::CSV_FILE);



        $readSetup = $this->readFile->create($import_file["basename"]);

        var_dump($readSetup);

        $csvFile = $this->csv->create([
            'file' => $import_file["basename"],
            'directory' => $readSetup,
        ]);


        return $csvFile;
    }
}
