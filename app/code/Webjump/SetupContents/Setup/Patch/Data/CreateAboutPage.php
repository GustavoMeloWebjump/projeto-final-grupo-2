<?php

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class CreateAboutPage implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var Website
     */
    private $website;

    /**
     * @var WriterInterface
     */
    private $writerInterface;

    /**
     * @var WebsiteFactory
     */
    private $websiteFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    private $pageResource;

    /**
     * const CODE_WEBSITE 
     */
    const CODE_WEBSITE =  ['sneakers_code'];
    
    /**
     * AddNewCmsPage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param \Magento\Cms\Model\ResourceModel\Page $pageResource
     * @param Website $website
     * @param WriterInterface $writerInterface
     * @param WebsiteFactory $websiteFactory
     * @param StoreManager $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        \Magento\Cms\Model\ResourceModel\Page $pageResource,
        Website $website,
        WriterInterface $writerInterface,
        WebsiteFactory $websiteFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function setCreateAboutPage(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $content = <<<HTML
        <div></div>
        HTML;

        $pageIdentifier = 'quemsomos';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('quemsomos');
        $cmsPageModel->setStores([$website->getStoreId()]);
        $cmsPageModel->setTitle('Quem somos');
        $cmsPageModel->setContentHeading('Quem somos');
        $cmsPageModel->setPageLayout('1column');
        $cmsPageModel->setIsActive(1);
        $cmsPageModel->setContent($content)->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $web) {
            if (in_array($web->getCode(), self::CODE_WEBSITE)) {
                $website = $this->websiteFactory->create();
                $website->load($web->getCode());
                $this->setCreateAboutPage($website);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}