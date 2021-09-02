<?php
declare(strict_types=1);

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;

/**
 * Patch to apply creation of the block Charges and fees
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CreateCarroselBlockFanon implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'carrosel_main_fanon';

    /**
     * @var string TITLE
     */
    const TITLE = 'carrosel_fanon';

    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var BlockRepositoryInterface $blockRepository
     */
    private $blockRepository;

    /**
     * @var BlockInterfaceFactory $blockFactory
     */
    private $blockFactory;

    /**
     * @var StoreRepositoryInterface $storeRepository
     */
    private $storeRepository;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();
        $content = <<<HTML
        <style>#html-body [data-pb-style=XULRJQX]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;margin:0}#html-body [data-pb-style=E9U4C83]{text-align:center}</style><div class="row-style" data-content-type="row" data-appearance="full-bleed" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="XULRJQX"><h3 data-content-type="heading" data-appearance="default" data-element="main" data-pb-style="E9U4C83">Conheça nossos lançamentos!</h3><div class="banner-fanon-style" data-content-type="products" data-appearance="carousel" data-autoplay="true" data-autoplay-speed="1500" data-infinite-loop="true" data-show-arrows="true" data-show-dots="true" data-carousel-mode="default" data-center-padding="90px" data-element="main">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Magento_PageBuilder::catalog/product/widget/content/carousel.phtml" anchor_text="" id_path="" show_pager="0" products_count="6" condition_option="category_ids" condition_option_value="11" type_name="Catalog Products Carousel" conditions_encoded="^[`1`:^[`aggregator`:`all`,`new_child`:``,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`value`:`1`^],`1--1`:^[`operator`:`==`,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`value`:`11`^]^]" sort_order="position"}}</div></div>
        HTML;
        $this->blockRepository->save($this->getCmsBlock($content));
        $this->moduleDataSetup->endSetup();
    }

    /**
     * Method create CMS block
     *
     * @return \Magento\Cms\Api\Data\BlockInterface
     */
    private function getCmsBlock($content): \Magento\Cms\Api\Data\BlockInterface
    {
        $fanon = $this->storeRepository->get(InstallWGS::FANON_STORE_CODE);
        
        return $this->blockFactory->create()
            ->load(self::IDENTIFIER, 'identifier')
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$fanon->getId()])
            ->setContent($content);
    }

  /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
}