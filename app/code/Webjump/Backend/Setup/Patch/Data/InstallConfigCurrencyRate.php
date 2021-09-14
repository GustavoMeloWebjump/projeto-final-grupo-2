<?php
namespace Webjump\Backend\Setup\Patch\Data;

use FG\ASN1\Universal\Set;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Setup\Module\Setup;

class InstallConfigCurrencyRate implements DataPatchInterface
{
    const TABLE_NAME = 'directory_currency_rate';
    const USD_PRICE = 0.193147000000;

    private ModuleDataSetupInterface $moduleDataSetup;
    private ConfigInterface $configInterface;
    private Setup $setup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, Setup $setup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->setup = $setup;
    }

    public function getColumns (): array {
        return ['currency_from', 'currency_to', 'rate'];
    }

    public function getValues () : array {
        return [['BRL', 'USD', self::USD_PRICE]];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->setup->getConnection()->insertArray(
            self::TABLE_NAME,
            $this->getColumns(),
            $this->getValues()
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies () {
        return [InstallWGS::class];
    }

    public function getAliases()
    {
        return [];
    }
}