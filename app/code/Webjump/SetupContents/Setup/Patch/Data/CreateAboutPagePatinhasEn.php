<?php

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;

class CreateAboutPagePatinhasEn implements DataPatchInterface
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
    * @var StoreRepositoryInterface $storeRepository
    */
    private $storeRepository;

    /**
     * const CODE_WEBSITE 
     */
    const CODE_WEBSITE = [InstallWGS::PATINHAS_WEBSITE_CODE];
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
        StoreManagerInterface $storeManager,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function setCreateAboutPage(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $patinhas_en = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE);

        $content = <<<HTML
        <style>#html-body [data-pb-style=CAGLR31]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;padding-top:20px}#html-body [data-pb-style=QU5SPWF]{text-align:right}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="CAGLR31"><h1 data-content-type="heading" data-appearance="default" data-element="main">About Us</h1><div data-content-type="text" data-appearance="default" data-element="main" data-pb-style="QU5SPWF"><p style="text-align: left;">We are an online trading company specializing in Pet Products and Related. We make a point of ensuring that our customers have the best online shopping experience. And that you always have the best products available.</p>
        <p style="text-align: left;">We work so that you and your pets have the best experience in our stores, whether through aesthetic and veterinary services or through the variety of products spread across the most diverse worlds: dogs, cats, fish, birds. Ah, we keep our ears up to find out what's new in the pet world and bring it to you. Determined to make a difference, we want to democratize and simplify pet care, offering the best experience for tutors and empowering veterinarians and entrepreneurs in the pet segment.</p></div></div></div>
        HTML;

        $pageIdentifier = 'about-us';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('about-us');
        $cmsPageModel->setStores([$patinhas_en->getId()]);
        $cmsPageModel->setTitle('About us');
        $cmsPageModel->setContentHeading('About us');
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