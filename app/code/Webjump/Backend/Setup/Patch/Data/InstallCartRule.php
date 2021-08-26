<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\SalesRule\Model\RuleFactory;
use Magento\SalesRule\Model\Rule\Condition\CombineFactory;
use Magento\SalesRule\Model\ResourceModel\Rule as ResourceModelRule;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\SalesRule\Model\Rule\Condition\Address;
use Magento\SalesRule\Model\Rule\Condition\AddressFactory;
class InstallCartRule implements DataPatchInterface
{

    private $ruleFactory;
    private $moduleDataSetup;
    private $combineFactory;
    private $resourceModelRule;
    private $state;
    private $addressFactory;

    public function __construct(RuleFactory $ruleFactory, ModuleDataSetupInterface $moduleDataSetup, CombineFactory $combineFactory, ResourceModelRule $resourceModelRule, State $state, AddressFactory $addressFactory)
    {
        $this->ruleFactory = $ruleFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->combineFactory = $combineFactory;
        $this->resourceModelRule = $resourceModelRule;
        $this->state = $state;
        $this->addressFactory = $addressFactory;
    }

    public function apply()
    {
        $this->state->setAreaCode(Area::AREA_GLOBAL);

        $this->moduleDataSetup->getConnection()->startSetup();
        $address = $this->addressFactory->create();

        $combine = $this->combineFactory->create();
        $combineCondtions = $this->combineFactory->create();


        $address->settype(Address::class);
        $address->setData('attribute', 'total_qty');
        $address->setData('operator', '>=');
        $address->setData('value', '5');

        $combine->setData('attribute', 'null');
        $combine->setData('operator', 'null');
        $combine->setData('value', '1');
        $combine->setData('aggregator', 'all');
        $combine->setConditions([$address]);

        $cartRule = $this->ruleFactory->create();

        $cartRule->setId(1);
        $cartRule->setName('discount for 5 itens or more in cart');
        $cartRule->setDescription('This discount will be aplied when the cart has 5 itens or more');
        $cartRule->setIsActive(1);
        $cartRule->setWebsiteIds([1, 2]);
        $cartRule->setCustomerGroupIds([0, 1, 2, 3]);
        $cartRule->setConditions($combine);
        $cartRule->setDiscountAmount(10);

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
