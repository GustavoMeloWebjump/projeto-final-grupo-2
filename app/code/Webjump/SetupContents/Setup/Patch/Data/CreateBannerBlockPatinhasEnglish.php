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
class CreateBannerBlockPatinhasEnglish implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'banner_main_patinhas_english';

    /**
     * @var string TITLE
     */
    const TITLE = 'banner_patinhas_english';

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
        <style>#html-body [data-pb-style=CCJTRD6],#html-body [data-pb-style=CU26AM7]{background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=CCJTRD6]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top}#html-body [data-pb-style=CU26AM7]{background-position:center top}#html-body [data-pb-style=FQN0OY0]{border-radius:0;min-height:350px;background-color:transparent}</style><div data-content-type="row" data-appearance="full-bleed" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="CCJTRD6"><div data-content-type="banner" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main" class="banner-style"><div data-element="empty_link"><div class="pagebuilder-banner-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/banner-ingles.jpg}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/2.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="CU26AM7"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="FQN0OY0"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div></div>
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
        $patinhas_en = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE);
        
        return $this->blockFactory->create()
            ->load(self::IDENTIFIER, 'identifier')
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$patinhas_en->getId()])
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