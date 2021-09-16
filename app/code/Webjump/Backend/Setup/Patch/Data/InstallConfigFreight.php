<?php
namespace Webjump\Backend\Setup\Patch\Data;

use DomainException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\File\Csv;
use Magento\Setup\Module\Setup;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;

class InstallConfigFreight implements DataPatchInterface
{

    CONST TABLERATES_PATH_FILE = __DIR__ . '/upload/importrates.csv';
    CONST TABLE_SHIPPING_NAME = 'shipping_tablerate';

    private ModuleDataSetupInterface $moduleDataSetup;
    private ConfigInterface $configInterface;
    private Csv $csv;
    private Setup $setup;
    private WebsiteRepositoryInterface $websiteRepositoryInterface;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, ConfigInterface $configInterface, Csv $csv, Setup $setup, WebsiteRepositoryInterface $websiteRepositoryInterface)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
        $this->csv = $csv;
        $this->setup = $setup;
        $this->websiteRepositoryInterface = $websiteRepositoryInterface;
    }


    public function importTableRates ($file) : void {
        if (!file_exists($file)) {
            throw new DomainException('O arquivo de importação csv não se encontra na pasta upload ');
        }

        $csvdata = $this->csv->getData($file);

        $columns = $csvdata[0];
        unset($csvdata[0]);
        $datas = array_values($csvdata);

        $i = 0;

        foreach ($datas as $value) {
            $datas[$i][0] = $this->websiteRepositoryInterface->get($value[0])->getId();
            $i++;
        }

        $this->setup->getConnection()->insertArray(self::TABLE_SHIPPING_NAME, $columns, $datas);
    }

    public function DataConfigFreight () : array {
        return [
            ['carriers/tablerate/active', true],
            ['carriers/tablerate/title', 'Webjump entreguinhas '],
            ['carriers/tablerate/name', 'Metodo de entregas da Webjump '],
            ['carriers/tablerate/condition_name', 'package_value_with_discount'],
            ['carriers/tablerate/include_virtual_price', true],
            ['carriers/tablerate/handling_type', 'F'],
            ['carriers/tablerate/handling_fee', '5.0'],
            ['carriers/tablerate/specificerrmsg', 'Este metodo de envio não esta disponivel no momento :|'],
            ['carriers/tablerate/sallowspecific', true],
            ['carriers/tablerate/specificcountry', 'BR,US,CA'],
            ['carriers/tablerate/sort_order', 0],
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $arry_data = $this->DataConfigFreight();

        foreach ($arry_data as $data) {
            $this->configInterface->saveConfig($data[0], $data[1]);
        }

        $this->importTableRates(self::TABLERATES_PATH_FILE);

        $this->moduleDataSetup->getConnection()->endSetup();

    }

    public static function getDependencies()
    {
        return [
            InstallWGS::class
        ];
    }

    public function getAliases()
    {
        return [];
    }

}
