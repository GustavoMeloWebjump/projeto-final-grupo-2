<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryFactory as ModelCategoryFactory;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

/**
 * Class InstallCategories data patch.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InstallCategories implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * @var ModelCategoryFactory
     */
    private $categoryFactory;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     * @param ModelCategoryFactory $categoryFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory,
        ModelCategoryFactory $categoryFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $rootCategoryId = \Magento\Catalog\Model\Category::TREE_ROOT_ID;

        $category = $this->categoryFactory->create();
        $categoryId = $category->getId();
        
        //Root category
        $categorySetup->createCategory()
            ->load($rootCategoryId)
            ->setStoreId(0)
            ->setPath($rootCategoryId)
            ->setLevel(0)
            ->setPosition(0)
            ->setChildrenCount(0)
            ->setName('Root')
            ->setInitialSetupFlag(true)
            ->save();
        
        //Pet category and its subs
        $category = $categorySetup->createCategory();
        $category->load(2)
            ->setId(2)
            ->setPath($rootCategoryId . '/' . 2)
            ->setStoreId(1)
            ->setName('Pet')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(2)
            ->setId(3)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 3)
            ->setStoreId(1)
            ->setName('Category 1')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category = $categorySetup->createCategory();
        $category->load(2)
            ->setId(4)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 4)
            ->setStoreId(1)
            ->setName('Category 2')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(2)
            ->setId(5)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 5)
            ->setStoreId(1)
            ->setName('Category 3')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(2)
            ->setId(6)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 6)
            ->setStoreId(1)
            ->setName('Category 4')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(2)
            ->setId(7)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 7)
            ->setStoreId(1)
            ->setName('Category 5')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
        
        //Sneakers category and its subs
        $category = $categorySetup->createCategory();
        $category->load(10)
            ->setId(10)
            ->setPath($rootCategoryId . '/' . 10)
            ->setStoreId(8)
            ->setName('Sneakers')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category = $categorySetup->createCategory();
        $category->load(10)
            ->setId(11)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 11)
            ->setStoreId(8)
            ->setName('Category 11')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category = $categorySetup->createCategory();
        $category->load(10)
            ->setId(12)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 12)
            ->setStoreId(8)
            ->setName('Category 12')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category = $categorySetup->createCategory();
        $category->load(10)
            ->setId(13)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 13)
            ->setStoreId(8)
            ->setName('Category 13')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category = $categorySetup->createCategory();
        $category->load(10)
            ->setId(14)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 14)
            ->setStoreId(8)
            ->setName('Category 14')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category = $categorySetup->createCategory();
        $category->load(10)
            ->setId(15)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 15)
            ->setStoreId(8)
            ->setName('Category 15')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
        
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
    public static function getVersion()
    {
        return '2.0.0';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}

