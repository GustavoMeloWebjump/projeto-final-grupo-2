<?php

namespace Webjump\Backend\Test\Unit\Model\Product;

use PHPUnit\Framework\TestCase;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\ImportFactory;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\ImportExport\Model\Import\Source\Csv;
use Symfony\Component\Console\Output\ConsoleOutput;
use Webjump\Backend\Model\Product\AddProduct as Model;

class AddProductTest extends TestCase
{

    private $importFactory;

    private $file;

    private $csvFactory;

    private $readFactory;

    private $output;

    private $import;

    private $read;

    private $csv;

    /** @var Model */
    private $addProduct;


    protected function setUp(): void
    {
        $this->importFactory = $this->getMockBuilder('Magento\ImportExport\Model\ImportFactory'::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->file = $this->createMock(File::class);

        $this->csvFactory = $this
            ->getMockBuilder('Magento\ImportExport\Model\Import\Source\CsvFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->readFactory = $this
            ->getMockBuilder('Magento\Framework\Filesystem\Directory\ReadFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();


        $this->output = $this->createMock(ConsoleOutput::class);

        $this->import = $this->createMock(Import::class);

        $this->read = $this->createMock(Read::class);

        $this->csv = $this->createMock(Csv::class);

        $this->addProduct = new Model(
            $this->csvFactory,
            $this->importFactory,
            $this->file,
            $this->readFactory,
            $this->output,
        );
    }


    public function testExecuteShouldNotImportWhenValidationFails()
    {
        $iterations = count(Model::IMPORT_DATA);
        $pathInfo = [
            'dirname' => 'path/to/file',
            'basename' => 'path/to/file'
        ];

        $this->importFactory->expects($this->exactly($iterations))
            ->method('create')
            ->willReturn($this->import);

        $this->import->expects($this->exactly($iterations))
            ->method('setData');

        $this->import->expects($this->exactly($iterations))
            ->method('validateSource')
            ->willReturn(false);

        $this->file->expects($this->exactly($iterations))
            ->method('getPathInfo')
            ->willReturn($pathInfo);

        $this->readFactory->expects($this->exactly($iterations))
            ->method('create')
            ->willReturn($this->read);

        $this->csvFactory->expects($this->exactly($iterations))
            ->method('create')
            ->willReturn($this->csv);

        $this->addProduct->execute();
    }

    public function testExecuteShouldImportWhenValidationSucceeds()
    {
        $iterations = count(Model::IMPORT_DATA);
        $pathInfo = [
            'dirname' => 'path/to/file',
            'basename' => 'path/to/file'
        ];

        $this->importFactory->expects($this->exactly($iterations))
            ->method('create')
            ->willReturn($this->import);

        $this->import->expects($this->exactly($iterations))
            ->method('setData');

        $this->import->expects($this->exactly($iterations))
            ->method('validateSource')
            ->willReturn(true);

        $this->file->expects($this->exactly($iterations))
            ->method('getPathInfo')
            ->willReturn($pathInfo);

        $this->readFactory->expects($this->exactly($iterations))
            ->method('create')
            ->willReturn($this->read);

        $this->csvFactory->expects($this->exactly($iterations))
            ->method('create')
            ->willReturn($this->csv);

        $this->import->expects($this->exactly($iterations))
            ->method('importSource')
            ->willReturn(true);

        $this->output->expects($this->exactly($iterations))
            ->method('writeln');

        $this->import->expects($this->exactly($iterations))
            ->method('invalidateIndex')
            ->willReturn(true);

        $this->addProduct->execute();
    }
}
