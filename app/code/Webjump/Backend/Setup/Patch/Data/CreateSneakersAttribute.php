<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateSneakersAttribute implements DataPatchInterface, PatchRevertableInterface
{

    const SNEKAERS_SIZE = 'sneakers_size';

    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;


    /**
     * @var EavSetupFactory $eavSetupFactory;
     */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }


    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup =  $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::SNEKAERS_SIZE,
            [
                'group' => 'General',
                'type' => 'varchar',
				'label' => 'Tamanho do tênis',
				'input' => 'select',
				'required' => false,
                'sort_order' => 30,
				'source' => '',
				'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
				'filterable' => false,
				'comparable' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filtrable_in_grid' => true,
                'used_in_product_listing' => true,
				'visible' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => false,
                'attribute_set_id' => 10
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();

    }


    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            CreateSneakersProductAttribute::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }


    public function revert()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::SNEKAERS_SIZE
        );
    }

}
