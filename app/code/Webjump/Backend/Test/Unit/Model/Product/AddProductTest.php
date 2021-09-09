<?php
namespace Webjump\Backend\Test\Unit\Model\Product;

use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\Import\Source\Csv;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\ImportExport\Model\ImportFactory;
use PHPUnit\Framework\TestCase;
use Webjump\Backend\Model\Product\AddProduct;
use Magento\Framework\Filesystem\Directory\ReadInterface;

class AddProductTest extends TestCase
{

    private $csvFactoryMock;

    private $importFactoryMock;

    private $fileMock;

    private $readFileMock;

    private $addProduct;

    private $importMock;

    private $readInterfaceMock;

    private $csv;


    protected function setUp():void
    {

        $this->csvFactoryMock = $this->createMock(CsvFactory::class);
        $this->importFactoryMock = $this->createMock(ImportFactory::class);
        $this->fileMock = $this->createMock(File::class);
        $this->readFileMock = $this->createMock(ReadFactory::class);
        $this->importMock = $this->createMock(Import::class);
        $this->readInterfaceMock = $this->getMockForAbstractClass(ReadInterface::class);
        $this->csvMock = $this->createMock(Csv::class);

        $this->addProduct = new AddProduct(
            $this->csvFactoryMock,
            $this->importFactoryMock,
            $this->fileMock,
            $this->readFileMock
        );

        $this->assertInstanceOf(AddProduct::class, $this->addProduct);
    }



    public function testExecute()
    {

        $data = AddProduct::IMPORT_DATA;
        $path = 'test/product.csv';

        $this->importFactoryMock
            ->expects($this->exactly(5))
            ->method('create')
            ->willReturn($this->importMock);

        $this->importMock
            ->expects($this->exactly(5))
            ->method('setData')
            ->with([
                'entity' => 'catalog_product',
                'behavior' => 'add_update',
                'validation_strategy' => 'validation-stop-on-errors'
            ])
            ->willReturnSelf();

        $this->fileMock
            ->expects($this->exactly(5))
            ->method('getPathInfo')
            ->with($path[0]['file'])
            ->willReturn([
                'dirname' => $path[0]['file'],
                'extension' => 'csv',
                'basename' => 'product.csv'
            ]);

        $this->readFileMock
            ->expects($this->exactly(5))
            ->method('create')
            ->with(__DIR__ . 'test/product.csv')
            ->willReturn($this->readInterfaceMock);

        $this->csvFactoryMock
            ->expects($this->exactly(5))
            ->method('create')
            ->with([
                'file' => 'product.csv',
                'directory' => $this->readInterfaceMock
            ])
            ->willReturn($this->csv);


        $this->importMock
            ->expects($this->exactly(5))
            ->method('validateSource')
            ->with($this->csv)
            ->willReturn(true);


        $this->importMock
            ->expects($this->exactly(5))
            ->method('importSource')
            ->willReturn(true);

        $this->importMock
            ->expects($this->exactly(5))
            ->method('invalidateIndex')
            ->willReturnSelf();

        $this->addProduct->execute();
    }


    /**
     * @codeCoverageIgnore
     */
    public function isValidate() {
        return [
            'enabled' => [
                'isEnabled' => true,
                'exactly' => 1
            ],
            'disabled' => [
                'isEnabled' => null,
                'exactly' => 0
            ]
        ];
    }
}
