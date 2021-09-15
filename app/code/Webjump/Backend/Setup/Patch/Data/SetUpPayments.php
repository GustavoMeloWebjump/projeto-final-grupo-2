<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface as ConfigResourceConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;

class SetUpPayments implements DataPatchInterface
{
    private $moduleDataSetup;
    private $configInterface;
    private $storeRepository;

    private $patinhas_en_id;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetupInterface,
        ConfigResourceConfigInterface $configInterface,
        StoreRepositoryInterface $storeRepository
    )
    {
        $this->moduleDataSetup = $moduleDataSetupInterface;
        $this->configInterface = $configInterface;
        $this->storeRepository = $storeRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->patinhas_en_id = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId();

        $data = $this->getData();

        foreach ($data as $config) {
            $this->configInterface->saveConfig(
                $config['path'],
                $config['value'],
                $config['scope'],
                $config['scopeId']
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getData()
    {
        return [
            'bta' => [
                'path' => 'payment/banktransfer/active',
                'value' => true,
                'scope' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                'scopeId' => '0'
            ],
            'btt' => [
                'path' => 'payment/banktransfer/title',
                'value' => 'Transferência Bancária',
                'scope' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                'scopeId' => '0'
            ], 
            'btt_en' => [
                'path' => 'payment/banktransfer/title',
                'value' => 'Bank Transfer',
                'scope' => ScopeInterface::SCOPE_STORES,
                'scopeId' => $this->patinhas_en_id
            ],
            'cma' => [
                'path' => 'payment/checkmo/active',
                'value' => true,
                'scope' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                'scopeId' => '0'
            ],
            'cmt' => [
                'path' => 'payment/checkmo/title',
                'value' => 'Cheque ou Dinheiro',
                'scope' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                'scopeId' => '0'
            ],
            'cmt_en' => [
                'path' => 'payment/checkmo/title',
                'value' => 'Check/Money Order',
                'scope' => ScopeInterface::SCOPE_STORES,
                'scopeId' => $this->patinhas_en_id
            ],
            'poa' => [
                'path' => 'payment/purchaseorder/active',
                'value' => true,
                'scope' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                'scopeId' => '0'
            ],
            'pot' => [
                'path' => 'payment/purchaseorder/title',
                'value' => 'Ordem de Compra',
                'scope' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                'scopeId' => '0'
            ],
            'pot_en' => [
                'path' => 'payment/purchaseorder/title',
                'value' => 'Purchase Order',
                'scope' => ScopeInterface::SCOPE_STORES,
                'scopeId' => $this->patinhas_en_id
            ],
        ];
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
