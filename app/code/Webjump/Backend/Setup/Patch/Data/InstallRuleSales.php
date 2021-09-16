<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\SalesRule\Model\RuleFactory;
use Magento\SalesRule\Model\ResourceModel\Rule as RuleResourceModelSale;
use Magento\SalesRule\Model\Rule\Condition\CombineFactory;
use Magento\SalesRule\Model\Rule\Condition\AddressFactory;
use Magento\SalesRule\Model\Rule\Condition\Address;
<<<<<<< HEAD
use Magento\CatalogRule\Model\Rule\Condition\ProductFactory;
=======
use Magento\Store\Api\WebsiteRepositoryInterface;
use Webjump\Backend\App\CustomState;
>>>>>>> release/v1.0

class InstallRuleSales implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private RuleFactory $ruleFactory;
    private RuleResourceModelSale $ruleResourceModelSale;
    private CombineFactory $combineFactory;
    private AddressFactory $addressFactory;
<<<<<<< HEAD
=======
    private WebsiteRepositoryInterface $websiteRepository;
    private CustomState $customState;
>>>>>>> release/v1.0

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleFactory $ruleFactory,
        RuleResourceModelSale $ruleResourceModelSale,
        CombineFactory $combineFactory,
<<<<<<< HEAD
        AddressFactory $addressFactory
=======
        AddressFactory $addressFactory,
        WebsiteRepositoryInterface $websiteRepository,
        CustomState $customState
>>>>>>> release/v1.0
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->ruleResourceModelSale = $ruleResourceModelSale;
        $this->combineFactory = $combineFactory;
        $this->addressFactory = $addressFactory;
<<<<<<< HEAD
=======
        $this->websiteRepository = $websiteRepository;
        $this->customState = $customState;

        if (!$this->customState->validateAreaCode()) {
            $this->customState->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        }
>>>>>>> release/v1.0
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
            ->settype(Address::class)
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
            ->setConditions([$condition2]);

        $cartRule = $this->ruleFactory->create();
        $cartRule
            ->setName('5% of discount when have 5 items in cart')
            ->setDescription('5% of discount when have 5 items in cart')
            ->setWebsiteIds(['1', '2'])
            ->setCustomerGroupIds(['0', '1', '2', '3'])
            ->setIsActive(1)
            ->setSimpleAction('by_percent')
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
