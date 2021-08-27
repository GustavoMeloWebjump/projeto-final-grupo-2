<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\CatalogRule\Api\Data\RuleInterfaceFactory as RuleFactory;
use Magento\CatalogRule\Model\CatalogRuleRepository;
use Magento\Customer\Model\Group;

class InstallCatalogRule implements DataPatchInterface
{
    private $moduleDataSetup;
    private $ruleFactory;
    private $catalogRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup, 
        RuleFactory $ruleFactory, 
        CatalogRuleRepository $catalogRepository)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->catalogRepository = $catalogRepository;
    }

    public function apply()
    {
        $rule5 = $this->ruleFactory->create();

        $rule5->setName('discount of 5% for guest users')
            ->setDescription('this discount is applied for guest users that will enter in first website ')
            ->setIsActive(1)
            ->setDiscountAmount(5)
            ->setSimpleAction('by_percent')
            ->setWebsiteIds('1')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setStopRulesProcessing(0);

        $this->catalogRepository->save($rule5);

        $rule10 = $this->ruleFactory->create();

        $rule10->setName('discount of 10% for guest users')
            ->setDescription('this discount is applied for gues users that will enter in secound website')
            ->setIsActive(1)
            ->setDiscountAmount(10)
            ->setSimpleAction('by_percent')
            ->setWebsiteIds('2')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setStopRulesProcessing(0);

        $this->catalogRepository->save($rule10);
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
