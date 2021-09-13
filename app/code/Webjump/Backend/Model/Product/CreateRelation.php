<?php
namespace Webjump\Backend\Model\Product;

use Magento\Catalog\Api\Data\ProductLinkInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Webjump\Backend\App\CustomState;

class CreateRelation
{

    const RELATION_DATA = [
        0 => [
            'sku_grouped' => 'F-KTG-1',
            'first_sku_product' => 'F-ANR-1',
            'second_sku_product' => 'F-ANR-2',
            'link_type' => 'associated',
            'product_type' => 'simple'
        ],
        1 => [
            'sku_grouped' => 'P-KBCG-1',
            'first_sku_product' => 'P-BCL-1',
            'second_sku_product' => 'P-BGT-1',
            'link_type' => 'associated',
            'product_type' => 'simple'
        ],
    ];

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductLinkInterfaceFactory
     */
    private $productLink;

    /**
     * @var CustomState
     */
    private $customState;


    public function __construct(
        ProductLinkInterfaceFactory $productLink,
        ProductRepositoryInterface $productInterface,
        CustomState $customState
    )
    {
        $this->productLink = $productLink;
        $this->productRepository = $productInterface;
        $this->customState = $customState;
    }


    public function execute()
    {
        if (!$this->customState->validateAreaCode()) {
            $this->customState->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        }

        foreach(self::RELATION_DATA as $data) {
            $this->createRelation(
                $data['sku_grouped'],
                $data['first_sku_product'],
                $data['second_sku_product'],
                $data['link_type'],
                $data['product_type']
            );
        }
    }

    private function createRelation($sku_grouped, $first_sku_product, $second_sku_product, $link_type, $product_type)
    {

        $firstProductLink = $this->productLink->create();

        // Pega a sku do grupo e faz uma relação

        $firstProductLink
            ->setSku($sku_grouped)
            ->setLinkedProductSku($first_sku_product)
            ->setLinkType($link_type)
            ->setLinkedProductType($product_type)
            ->setQty(1);

        $secondProductLink = $this->productLink->create();

        $secondProductLink
            ->setSku($sku_grouped)
            ->setLinkedProductSku($second_sku_product)
            ->setLinkType($link_type)
            ->setLinkedProductType($product_type)
            ->setQty(1);


        $gruped = $this->productRepository
            ->get($sku_grouped, true);

        $gruped->setProductLinks([$firstProductLink, $secondProductLink]);

        $this->productRepository->save($gruped);

    }

}
