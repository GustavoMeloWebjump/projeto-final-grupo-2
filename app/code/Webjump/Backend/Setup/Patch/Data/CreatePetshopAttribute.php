<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Catalog\Model\Product;

class CreatePetshopAttribute implements DataPatchInterface, PatchRevertableInterface
{
    const PETSHOP_ANIMAL = 'petshop_product_tag';

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
        EavSetupFactory $eavSetupFactory
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
            self::PETSHOP_ANIMAL,
            [
                'group' => 'Attribute',
                'type' => 'varchar',
				'label' => 'Tags de produtos (patinhas)',
				'input' => 'select',
				'required' => false,
                'sort_order' => 35,
				'source' => '',
				'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
				'filterable' => false,
				'comparable' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filtrable_in_grid' => true,
                'used_in_product_listing' => true,
                'default' => 0,
                'system' => false,
				'visible' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => false,
                'option' => ['values' => ['Ração', 'Coleiras', 'Brinquedos', 'Remédio']],
                'attribute_set' => CreatePetshopProductAttribute::PETSHOP_ATTRIBUTE_NAME
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
            CreatePetshopProductAttribute::class
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
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::PETSHOP_ANIMAL
        );
    }

}
