<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\CatalogRule\Api\Data\RuleInterfaceFactory as RuleFactory;
use Magento\CatalogRule\Model\CatalogRuleRepository;

class InstallCatalogRule implements DataPatchInterface
{

    private $moduleDataSetup;
    private $ruleFactory;
    private $catalogRepository;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, RuleFactory $ruleFactory, CatalogRuleRepository $catalogRepository) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->catalogRepository = $catalogRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $rule5Percent = $this->ruleFactory->create();

        $rule5Percent->setName('discount of 5% for guess users');
        $rule5Percent->setDescription('this discount is aplied for guess users that will enter in first website ');
        $rule5Percent->setIsActive(1);
        $rule5Percent->setDiscountAmount(5.0);
        $rule5Percent->setWebsiteIds('1');
        $rule5Percent->setCustomerGroupIds('0');

        $this->catalogRepository->save($rule5Percent);

        $rule10Percent = $this->ruleFactory->create();

        $rule10Percent->setName('discount of 10% for guess users');
        $rule10Percent->setDescription('this discount is aplied for guess users that will enter in secound website');
        $rule10Percent->setIsActive(1);
        $rule10Percent->setDiscountAmount(10.0);
        $rule10Percent->setWebsiteIds('2');
        $rule10Percent->setCustomerGroupIds('0');


        $this->catalogRepository->save($rule10Percent);

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
