<?php

namespace Webjump\Backend\Test\Unit\Model\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductLinkInterfaceFactory;
use PHPUnit\Framework\TestCase;
use Webjump\Backend\App\CustomState;
use Webjump\Backend\Model\Product\CreateRelation;
use Magento\Catalog\Api\Data\ProductLinkInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class CreateRelationTest extends TestCase
{

    /**
     * @var ProductLinkInterfaceFactory
     */
    private $producLinkInterfaceFactoryMock;

    private $productLinkInterfaceMock;

    private $productRepositoryMock;

    private $customStateMock;

    private $productInterfaceMock;

    private $createRelation;


    protected function setUp(): void
    {
        $this->producLinkInterfaceFactoryMock = $this->getMockBuilder('Magento\Catalog\Api\Data\ProductLinkInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();


        $this->productLinkInterfaceMock = $this->getMockBuilder(ProductLinkInterface::class)
        ->disableOriginalConstructor()
        ->setMethods(['setQty'])
        ->onlyMethods(['setSku', 'setLinkedProductSku','setLinkType', 'setLinkedProductType'])
        ->getMockForAbstractClass();

        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);

        $this->customStateMock = $this->createMock(CustomState::class);

        $this->productInterfaceMock = $this->createMock(ProductInterface::class);

        $this->createRelation = new CreateRelation(
            $this->producLinkInterfaceFactoryMock,
            $this->productRepositoryMock,
            $this->customStateMock
        );
    }

    public function testShouldBeAbleCreateRelationWithGrouped()
    {
        $iteration = count(CreateRelation::RELATION_DATA);

        $this->producLinkInterfaceFactoryMock
            ->expects($this->exactly($iteration))
            ->method('create')
            ->willReturn($this->productLinkInterfaceMock);

        $this->productLinkInterfaceMock
            ->expects($this->exactly($iteration))
            ->method('setSku')
            ->willReturnSelf();

        $this->productLinkInterfaceMock
            ->expects($this->exactly($iteration))
            ->method('setLinkedProductSku')
            ->willReturnSelf();


        $this->productLinkInterfaceMock
            ->expects($this->exactly($iteration))
            ->method('setLinkType')
            ->willReturnSelf();

        $this->productLinkInterfaceMock
            ->expects($this->exactly($iteration))
            ->method('setLinkedProductType')
            ->willReturnSelf();

        $this->productLinkInterfaceMock
            ->expects($this->exactly($iteration))
            ->method('setQty')
            ->with(1);

        $this->productRepositoryMock
            ->expects($this->exactly($iteration))
            ->method('get')
            ->willReturn($this->productInterfaceMock);

        $this->productInterfaceMock
            ->expects($this->exactly($iteration))
            ->method('setProductLinks')
            ->with([
                $this->productLinkInterfaceMock
            ])
            ->willReturnSelf();

        $this->productRepositoryMock
            ->expects($this->exactly($iteration))
            ->method('save')
            ->with($this->productInterfaceMock)
            ->willReturn($this->productInterfaceMock);


        $this->createRelation->execute();

    }
}
