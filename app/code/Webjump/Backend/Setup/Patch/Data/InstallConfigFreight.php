<?php
namespace Webjump\Backend\Setup\Patch\Data;

use DomainException;
use Magento\Cookie\Model\Config\Backend\Domain;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\File\Csv;
use Magento\Setup\Module\Setup;

class InstallConfigFreight implements DataPatchInterface
{

    CONST TABLERATES_PATH_FILE = __DIR__ . '/upload/importrates.csv';

    private ModuleDataSetupInterface $moduleDataSetup;
    private ConfigInterface $configInterface;
    private Csv $csv;
    private Setup $setup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, ConfigInterface $configInterface, Csv $csv, Setup $setup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
        $this->csv = $csv;
        $this->setup = $setup;
    }


    public function importTableRates ($file) {
        if (!file_exists($file)) {
            throw new DomainException('O arquivo de importação csv não se encontra na pasta upload ');
        }

        $csvdata = $this->csv->getData($file);

        $columns = $csvdata[0];
        unset($csvdata[0]);
        $datas = array_values($csvdata);

        $this->setup->getConnection()->insertArray('shipping_tablerate', $columns, $datas);
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->configInterface->saveConfig(
            'carriers/tablerate/active',
            true);

        $this->configInterface->saveConfig(
            'carriers/tablerate/title',
            'Webjump entreguinhas ');

        $this->configInterface->saveConfig(
            'carriers/tablerate/name',
            'Metodo de entregas da Webjump');

        $this->configInterface->saveConfig(
            'carriers/tablerate/condition_name',
            'package_value_with_discount'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/include_virtual_price',
            true
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/handling_type',
            'F'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/handling_fee',
            '5.0'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/specificerrmsg',
            'Este metodo de envio não esta disponivel no momento :| '
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/sallowspecific',
            true
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/specificcountry',
            'BR,US,CA'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/sort_order',
            0
        );

        $this->importTableRates(self::TABLERATES_PATH_FILE);

        $this->moduleDataSetup->getConnection()->endSetup();

    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

}
