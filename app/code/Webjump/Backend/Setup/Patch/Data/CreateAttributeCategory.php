<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CreateAttributeCategory implements DataPatchInterface
{

    const CATEGORY_ATTRIBUTE_CODE_ONE = 'category_attribute_code_one';

    const CATEGORY_ATTRIBUTE_CODE_TWO = 'category_attribute_code_two';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Create Attribute Set
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavConfig = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavConfig->addAttribute(Category::ENTITY, self::CATEGORY_ATTRIBUTE_CODE_ONE, [
            'type' => 'varchar',
            'label' => 'Produtos (patinhas)',
            'input' => 'text',
            'source' => '',
            'user_defined' => true,
            'visible' => true,
            'default' => '',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'group' => 'General'
        ]);


        $eavConfig->addAttribute(Category::ENTITY, self::CATEGORY_ATTRIBUTE_CODE_TWO, [
            'type' => 'varchar',
            'label' => 'Produtos (fanon)',
            'input' => 'text',
            'source' => '',
            'user_defined' => true,
            'visible' => true,
            'default' => '',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'group' => 'General'
        ]);

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
