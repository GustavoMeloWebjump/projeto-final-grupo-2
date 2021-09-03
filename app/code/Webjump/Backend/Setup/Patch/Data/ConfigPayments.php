<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface as ConfigResourceConfigInterface;
use Magento\Framework\App\ScopeInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ConfigPayments implements DataPatchInterface
{
    private $moduleDataSetup;
    private $configInterface;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetupInterface,
        ConfigResourceConfigInterface $configInterface
    )
    {
        $this->moduleDataSetup = $moduleDataSetupInterface;
        $this->configInterface = $configInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->configInterface->saveConfig(
            'payment/banktransfer/active', 
            true, 
            ScopeInterface::SCOPE_DEFAULT);
            
        $this->configInterface->saveConfig(
            'payment/checkmo/active', 
            true, 
            ScopeInterface::SCOPE_DEFAULT);
            
        $this->configInterface->saveConfig(
            'payment/purchaseorder/active', 
            true, 
            ScopeInterface::SCOPE_DEFAULT);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
