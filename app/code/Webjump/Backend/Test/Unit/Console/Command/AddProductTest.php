<?php
namespace Webjump\Backend\Test\Unit\Console\Command;

use PHPUnit\Framework\TestCase;
use Webjump\Backend\Console\Command\AddProduct as CommandAddProduct;
use Webjump\Backend\Model\Product\AddProduct;

class AddProductTest extends TestCase
{

    /** @var AddProduct */
    private $itemFactoryMock;

    private $addProduct;

    protected function setUp(): void
    {
        $this->itemFactoryMock = $this->createMock(AddProduct::class);

        $this->addProduct = new CommandAddProduct($this->itemFactoryMock);

    }

    public function testIntance()
    {
        $this->assertInstanceOf(CommandAddProduct::class, $this->addProduct);
    }
}
