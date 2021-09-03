<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class CreatePetshopProductAttribute implements DataPatchInterface
{

    const PETSHOP_ATTRIBUTE_NAME = 'Petshop';


    private $attributeSetFactory;

    private $categorySetupFactory;
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * AttributeSetData constructor.
     * @
     */
    public function __construct(
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Create Attribute Set
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        $attributeSet = $this->attributeSetFactory->create();
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $data = [
            'attribute_set_name' => self::PETSHOP_ATTRIBUTE_NAME,
            'entity_type_id' => $entityTypeId,
            'sort_order' => 199,
        ];

        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }


}
