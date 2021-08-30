<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\CatalogRule\Api\Data\RuleInterfaceFactory as RuleFactory;
use Magento\Customer\Model\Group;

class InstallCatalogRule implements DataPatchInterface
{
    private $moduleDataSetup;
    private $ruleFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleFactory $ruleFactory)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $rule5 = $this->ruleFactory->create(['setup' => $this->moduleDataSetup]);

        $rule5
            ->setName('discount of 5% for guest users')
            ->setDescription('this discount is applied for guest users that will enter in first website ')
            ->setIsActive(1)
            ->setWebsiteIds('1')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setSimpleAction('by_percent')
            ->setDiscountAmount(5)
            ->setStopRulesProcessing(0)
            ->save();

        $rule10 = $this->ruleFactory->create(['setup' => $this->moduleDataSetup]);

        $rule10
            ->setName('discount of 10% for guest users')
            ->setDescription('this discount is applied for gues users that will enter in secound website')
            ->setIsActive(1)
            ->setWebsiteIds('2')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setSimpleAction('by_percent')
            ->setDiscountAmount(10)
            ->setStopRulesProcessing(0)
            ->save();

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
