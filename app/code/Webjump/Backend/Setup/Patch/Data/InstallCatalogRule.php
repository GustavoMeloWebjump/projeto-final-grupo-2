<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\CatalogRule\Model\RuleFactory;
use Magento\CatalogRule\Model\ResourceModel\Rule as ResourceModelRule;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;

class InstallCatalogRule implements DataPatchInterface
{

    private $moduleDataSetup;
    private $ruleFactory;
    private $resourceModelRule;
    private $state;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, RuleFactory $ruleFactory, ResourceModelRule $resourceModelRule, State $state) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->resourceModelRule = $resourceModelRule;
        $this->state = $state;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->state->setAreaCode(Area::AREA_GLOBAL);

        $rule5Percent = $this->ruleFactory->create();

        $this->resourceModelRule->load($rule5Percent, 2);

        $rule5Percent
            ->setName('discount of 5% for guess users')
            ->setDescription('this discount is aplied for guess users that will enter in first website ')
            ->setIsActive(1)
            ->setDiscountAmount(5.0)
            ->setWebsiteIds('1')
            ->setCustomerGroupIds('0');

        $this->resourceModelRule->save($rule5Percent);

        $rule10Percent = $this->ruleFactory->create();

        $this->resourceModelRule->load($rule10Percent, 3);

        $rule10Percent
            ->setId(3)
            ->setName('discount of 10% for guess users')
            ->setDescription('this discount is aplied for guess users that will enter in secound website')
            ->setIsActive(1)
            ->setDiscountAmount(10.0)
            ->setWebsiteIds('2')
            ->setCustomerGroupIds('0');


        $this->resourceModelRule->save($rule10Percent);

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
