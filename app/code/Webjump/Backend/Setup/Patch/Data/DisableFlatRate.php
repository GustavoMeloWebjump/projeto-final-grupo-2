<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class DisableFlatRate implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     *
     * @var ConfigInterface
     */
    private $configInterface;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, ConfigInterface $configInterface)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->configInterface->saveConfig('carriers/flatrate/active', false);

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
