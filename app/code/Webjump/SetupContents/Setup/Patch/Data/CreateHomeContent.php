<?php
/**
 *
 *  PHP version 7
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2021 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 *
 * @link        http://www.webjump.com.br
 */
declare(strict_types=1);

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\PageRepository;
use Magento\Cms\Model\ResourceModel\Block as BlockResourceModel;
use Magento\Cms\Model\BlockFactory;

/**
 * Class HomePageUpdate
 */
class CreateHomeContent implements DataPatchInterface {

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

      /**
     * @var BlockResourceModel $blockResourceModel
     */
    private $blockResourceModel;

       /**
     * @var BlockFactory $blockFactory
     */
    private $blockFactory;
    
    /** @var PageFactory */
    private $pageFactory;

    /** @var PageRepository */
    private $pageRepository;

    const PAGE_IDENTIFIER = 'home';

    /**
     * HomePageUpdate Construct
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param PageRepository $pageRepository
     * @param BlockFactory $blockFactory
     * @param BlockResourceModel $blockResourceModel
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        PageRepository $pageRepository,
        BlockFactory $blockFactory,
        BlockResourceModel $blockResourceModel
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->blockFactory = $blockFactory;
        $this->blockResourceModel = $blockResourceModel;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $blockBannerFanonId = $this->getBlockId('banner_main_fanon');
        
        $blockBannerPatinhasId = $this->getBlockId('banner_main_patinhas');

        $blockBannerPatinhasEnglishId = $this->getBlockId('banner_main_patinhas_english');
        
        $blockCarroselPatinhasId = $this->getBlockId('carrosel_main_patinhas');
        
        $blockCarroselPatinhasEnglishId = $this->getBlockId('carrosel_main_patinhas_english');
        
        $blockCarroselFanonId = $this->getBlockId('carrosel_main_fanon');
        
        $content = <<<HTML
        <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockBannerFanonId type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockCarroselFanonId type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockBannerPatinhasId type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockBannerPatinhasEnglishId type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockCarroselPatinhasId type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockCarroselPatinhasEnglishId type_name="CMS Static Block"}}</div>
        HTML;
        $cmsPage = $this->pageFactory->create()->load(self::PAGE_IDENTIFIER, 'identifier');
        if ($cmsPage->getId()) {
            $cmsPage->setStores(['0']);
            $cmsPage->setPageLayout('1column');
            $cmsPage->setContent($content);
            $this->pageRepository->save($cmsPage);
        }
        

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getBlockId($blockIdentifier): string
    {
        $block = $this->blockFactory->create();
        $this->blockResourceModel->load($block, $blockIdentifier, 'identifier');
        return $block->getId();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [
            CreateBannerBlockFanon::class,
            CreateBannerBlockPatinhas::class,
            CreateCarroselBlockFanon::class,
            CreateCarroselBlockPatinhas::class,
            CreateBannerBlockPatinhasEnglish::class,
            CreateCarroselBlockPatinhasEnglish::class
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}