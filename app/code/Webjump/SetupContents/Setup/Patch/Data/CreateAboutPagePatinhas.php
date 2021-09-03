<?php

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;

class CreateAboutPagePatinhas implements DataPatchInterface
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
    const CODE_WEBSITE =  [InstallWGS::PATINHAS_WEBSITE_CODE];

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
        <style>#html-body [data-pb-style=UMX3GX3]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="UMX3GX3"><h1 data-content-type="heading" data-appearance="default" data-element="main">Sobre Nós</h1><div data-content-type="text" data-appearance="default" data-element="main"><p>Nós somos um petshop de São Paulo, Brasil.</p>
        <p>Lorem ipsum dolor sit amet. Est delectus voluptatem id voluptatem fugiat rem inventore facere ad porro dolores hic nostrum itaque. In cumque nobis et officiis laborum hic vitae quae non aliquam rerum eum numquam dolorem sit libero consectetur. Ut deleniti laudantium sit sunt rerum et atque internos! Repudiandae tempora est velit quisquam vel enim ipsum a corporis error et similique enim non aliquam consequuntur et enim quae!</p>
        <p>Ut sunt veritatis quo velit quae qui sapiente suscipit et asperiores quia. Aut consequuntur placeat nam quaerat possimus sed maxime autem est suscipit totam aut repellendus veritatis!</p>
        <p>At quae laborum sit quia dolor et rerum quia rem numquam voluptatem eum culpa labore ea beatae quasi? Ea unde doloremque eum dolorem officiis est ducimus quia 33 aspernatur magnam ab dolore mollitia At Quis voluptas cum dolor repellat. Aut dignissimos laudantium est praesentium quia et reiciendis voluptatem aut dolore blanditiis rem fugiat voluptatum aut odit ipsum. Et quidem iste id voluptatibus sunt in maxime rerum.</p></div></div></div>
        HTML;

        $pageIdentifier = 'about';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('about');
        $cmsPageModel->setStores($website->getStoreIds());
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
