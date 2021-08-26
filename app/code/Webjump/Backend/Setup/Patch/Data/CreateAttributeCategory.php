<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CreateAttributeCategory implements DataPatchInterface
{

    const CATEGORY_ATTRIBUTE = 'category_attribute';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        CategorySetupFactory $categorySetupFactory
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

        $eavConfig->addAttribute(Category::ENTITY, self::CATEGORY_ATTRIBUTE, [
            'type' => 'varchar',
            'label' => 'Category Test',
            'input' => 'text',
            'source' => '',
            'user_defined' => true,
            'visible' => true,
            'default' => '0',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Display Settings'
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
