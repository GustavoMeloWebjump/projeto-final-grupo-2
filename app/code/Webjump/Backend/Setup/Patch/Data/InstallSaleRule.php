<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\SalesRule\Model\RuleFactory;
use Magento\SalesRule\Model\ResourceModel\Rule as RuleResourceModelSale;
use Magento\SalesRule\Model\Rule\Condition\CombineFactory;
use Magento\SalesRule\Model\Rule\Condition\AddressFactory;
use Magento\SalesRule\Model\Rule\Condition\Address;
use Magento\CatalogRule\Model\Rule\Condition\ProductFactory;

class InstallCartRule implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private RuleFactory $ruleFactory;
    private RuleResourceModelSale $ruleResourceModelSale;
    private CombineFactory $combineFactory;
    private AddressFactory $addressFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleFactory $ruleFactory,
        RuleResourceModelSale $ruleResourceModelSale,
        CombineFactory $combineFactory,
        AddressFactory $addressFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->ruleResourceModelSale = $ruleResourceModelSale;
        $this->combineFactory = $combineFactory;
        $this->addressFactory = $addressFactory;
    }
    /**
     *  {@inheritDoc}
     */
    public function apply()
    {
        // $this->state->setAreaCode(Area::AREA_ADMINHTML);

        $this->moduleDataSetup->getConnection()->startSetup();

        $condition1 = $this->combineFactory->create();
        $condition2 = $this->addressFactory->create();

        $condition2
            ->setData('attribute', 'total_qty')
            ->setData('operator', '>=')
            ->setData('value', '5')
            ->setData("is_value_processed", "false");

        $condition1
            ->setData('attribute', null)
            ->setData('operator', null)
            ->setData('value', '1')
            ->setData('is_value_processed', null)
            ->setData('aggregator', 'all')
            ->setConditions([$condition2->settype(Address::class)]);

        $cartRule = $this->ruleFactory->create();
        $cartRule
            ->setName('5% of discount when have 5 items in cart')
            ->setDescription('5% of discount when have 5 items in cart')
            ->setWebsiteIds(['1', '2'])
            ->setCustomerGroupIds(['0', '1', '2', '3'])
            ->setIsActive(1)
            ->setConditions($condition1)
            ->setDiscountAmount(10);

        $this->ruleResourceModelSale->save($cartRule);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  {@inheritDoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     *  {@inheritDoc}
     */
    public function getAliases()
    {
        return [];
    }
}
