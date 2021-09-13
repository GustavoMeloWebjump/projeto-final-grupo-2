<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeManagementInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class CreatePetshopAttribute implements DataPatchInterface, PatchRevertableInterface
{
    const PETSHOP_ANIMAL = 'petshop_product_tag';

    const PETSHOP_SHAPE = 'petshop_shape';

    const PETSHOP_COLOR = 'color';

    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var ProductAttributeManagementInterface
     */
    private $productAttributeManagement;


    /**
     * @var EavSetupFactory $eavSetupFactory;
     */
    private $eavSetupFactory;

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
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $this->createAttributePetshop($eavSetup);
        $this->moduleDataSetup->getConnection()->endSetup();
    }


    private function createAttributePetshop(EavSetup $eavSetup)
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::PETSHOP_ANIMAL,
            [
                'attribute_set' => CreatePetshopProductAttribute::PETSHOP_ATTRIBUTE_NAME,
                'type' => 'varchar',
				'label' => 'Tags de produtos (patinhas)',
                'user_defined' => true,
				'input' => 'select',
				'required' => false,
                'sort_order' => 35,
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
                'visible_on_front' => true
            ]
        );

        $attributeSetId = $eavSetup->getAttributeSetId(Product::ENTITY, CreatePetshopProductAttribute::PETSHOP_ATTRIBUTE_NAME);
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::PETSHOP_ANIMAL, $sortOrder);

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::PETSHOP_SHAPE,
            [

                'attribute_set' => CreatePetshopProductAttribute::PETSHOP_ATTRIBUTE_NAME,
                'type' => 'varchar',
                'label' => 'Porte (patinhas)',
                'user_defined' => true,
                'input' => 'select',
                'required' => false,
                'sort_order' => 35,
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
                'visible_on_front' => true
            ]
        );

        $sortOrder = 52;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::PETSHOP_SHAPE, $sortOrder);

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::PETSHOP_COLOR,
            [
                'attribute_set' => CreatePetshopProductAttribute::PETSHOP_ATTRIBUTE_NAME,
                'user_defined' => true,
                'type' => 'text',
                'label' => 'Cor',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => true
            ]
        );

        $sortOrder = 52;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::PETSHOP_COLOR, $sortOrder);


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
            CreatePetshopProductAttribute::class
        ];
    }
    public function revert()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::PETSHOP_ANIMAL
        );
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::PETSHOP_SHAPE
        );
    }

}
