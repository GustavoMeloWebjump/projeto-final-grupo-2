<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Rule\Model\ConditionFactory;
use Magento\SalesRule\Model\RuleFactory;
use Magento\SalesRule\Model\Rule\Condition\CombineFactory;
use Magento\SalesRule\Model\ResourceModel\Rule as ResourceModelRule;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;

class InstallCartRule implements DataPatchInterface
{

    private $ruleFactory;
    private $moduleDataSetup;
    private $combineFactory;
    private $resourceModelRule;
    private $state;

    public function __construct(RuleFactory $ruleFactory, ModuleDataSetupInterface $moduleDataSetup, CombineFactory $combineFactory, ResourceModelRule $resourceModelRule, State $state)
    {
        $this->ruleFactory = $ruleFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->combineFactory = $combineFactory;
        $this->resourceModelRule = $resourceModelRule;
        $this->state = $state;
    }

    public function apply()
    {
        $this->state->setAreaCode(Area::AREA_GLOBAL);

        $this->moduleDataSetup->getConnection()->startSetup();

        $combine = $this->combineFactory->create();
        $combineCondtions = $this->combineFactory->create();

        $combine
            ->setData('value', '1')
            ->addCondition($combineCondtions
                ->setData('attribute', 'total_qty')
                ->setData('operator', '>=')
                ->setData('value', '5')
            );

        $cartRule = $this->ruleFactory->create();

        $cartRule->setName('discount for 5 itens or more in cart');
        $cartRule->setDescription('This discount will be aplied when the cart has 5 itens or more');
        $cartRule->setIsActive(1);
        $cartRule->setConditions($combine);

        $this->resourceModelRule->save($cartRule);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases() {
        return [];
    }

    public static function getDependencies () {
        return [];
    }
}
