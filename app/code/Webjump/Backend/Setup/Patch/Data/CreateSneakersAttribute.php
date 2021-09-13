<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeManagementInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Setup\EavSetup;

class CreateSneakersAttribute implements DataPatchInterface, PatchRevertableInterface
{

    const SNEAKERS_TYPE = 'sneakers_type';

    const SNEAKERS_SHOK = 'sneakers_type_shock_absorber';

    const SNEAKERS_COLORS = 'color';

    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory $eavSetupFactory;
     */
    private $eavSetupFactory;

    /**
     * @var ProductAttributeManagementInterface
     */
    private $productAttributeManagement;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        ProductAttributeManagementInterface $productAttributeManagement,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->productAttributeManagement = $productAttributeManagement;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup =  $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $this->createAttributeSneakers($eavSetup);
        $this->moduleDataSetup->getConnection()->endSetup();
    }


    private function createAttributeSneakers(EavSetup $eavSetup)
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::SNEAKERS_TYPE,
            [
                'attribute_set' => 'Sneakers',
                'user_defined' => true,
                'type' => 'varchar',
				'label' => 'Masculino ou Feminino (fanon)',
				'input' => 'select',
				'required' => false,
                'sort_order' => 150,
				'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
				'filterable' => false,
				'comparable' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filtrable_in_grid' => true,
                'used_in_product_listing' => true,
                'system' => false,
				'visible' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => true,
                'option' => ['values' => ['Masculino', 'Feminino']],
            ]
        );

        $attributeSetId = $eavSetup->getAttributeSetId(Product::ENTITY, CreateSneakersProductAttribute::SNEAKERS_ATTRIBUTE_NAME);
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::SNEAKERS_TYPE, $sortOrder);

            $eavSetup->addAttribute(
                Product::ENTITY,
                self::SNEAKERS_SHOK,
                [
                    'attribute_set' => 'Sneakers',
                    'user_defined' => true,
                    'type' => 'text',
                    'label' => 'Tipo de amortecedor (fanon)',
                    'input' => 'select',
                    'required' => false,
                    'sort_order' => 150,
                    'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                    'filterable' => false,
                    'comparable' => false,
                    'is_used_in_grid' => false,
                    'is_visible_in_grid' => false,
                    'is_filtrable_in_grid' => true,
                    'used_in_product_listing' => true,
                    'system' => false,
                    'visible' => true,
                    'is_html_allowed_on_front' => false,
                    'visible_on_front' => true,
                    'option' => ['values' => ['Boost', 'Gel', 'espuma em EVA', 'U4icX']],
                ]
            );




        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::SNEAKERS_SHOK, $sortOrder);


        $eavSetup->addAttribute(
            Product::ENTITY,
            self::SNEAKERS_COLORS,
            [
                'attribute_set' => 'Sneakers',
                'user_defined' => true,
                'type' => 'text',
                'label' => 'Cor',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'filterable' => false,
                'comparable' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filtrable_in_grid' => true,
                'used_in_product_listing' => true,
                'system' => false,
                'visible' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => true
            ]
        );

        $sortOrderColor = 54;
        $this->productAttributeManagement
         ->assign($attributeSetId, $attributeGroupId, self::SNEAKERS_COLORS, $sortOrderColor);

    }


    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
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

    public function revert()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::SNEAKERS_TYPE
        );
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::SNEAKERS_SHOK
        );
    }

}
