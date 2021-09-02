<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\Store\Model\ScopeInterface;

class InstallStoresConfig implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface  */
    private $moduleDataSetup;

    /** @var ConfigInterface */
    private $configInterface;
    
    /** @var StoreRepositoryInterface */
    private $storeRepository;
    
    /** @var WebsiteRepositoryInterface */
    private $websiteRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ConfigInterface $configInterface,
        StoreRepositoryInterface $storeRepository,
        WebsiteRepositoryInterface $websiteRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
        $this->storeRepository = $storeRepository;
        $this->websiteRepository = $websiteRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $patinhas_en = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId();

        // editing Patinhas English locale
        $this->configInterface->saveConfig(
            'general/locale/code',
            'en_US',
            ScopeInterface::SCOPE_STORES,
            $patinhas_en
        );

        // editing Patinhas English currency
        $this->configInterface->saveConfig(
            'currency/options/allow',
            'USD',
            ScopeInterface::SCOPE_STORES,
            $patinhas_en
        );

        $this->configInterface->saveConfig(
            'currency/options/default',
            'USD',
            ScopeInterface::SCOPE_STORES,
            $patinhas_en
        );

        // configuring websites urls
        $patinhas_web = $this->websiteRepository->get(InstallWGS::PATINHAS_WEBSITE_CODE);
        $fanon_web = $this->websiteRepository->get(InstallWGS::FANON_WEBSITE_CODE);

        $this->configInterface->saveConfig(
            'web/unsecure/base_url',
            'http://patinhas.localhost',
            ScopeInterface::SCOPE_WEBSITES,
            $patinhas_web->getId()
        );

        $this->configInterface->saveConfig(
            'web/unsecure/base_url',
            'http://fanon.localhost',
            ScopeInterface::SCOPE_WEBSITES,
            $fanon_web->getId()
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [
            InstallWGS::class
        ];
    }
}
