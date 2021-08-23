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
        $categoryPet = $categorySetup->createCategory();
        $categoryPet->load(2)
            ->setParentId($rootCategoryId)
            ->setId(2)
            ->setPath($rootCategoryId . '/' . 2)
            ->setStoreId(1)
            ->setName('Pet')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category1 = $categorySetup->createCategory();
        $category1->load(2)
            ->setParentId($categoryPet->getId())
            ->setId(3)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 3)
            ->setStoreId(1)
            ->setName('Category 1')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category2 = $categorySetup->createCategory();
        $category2->load(2)
            ->setParentId($categoryPet->getId())
            ->setId(4)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 4)
            ->setStoreId(1)
            ->setName('Category 2')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category3 = $categorySetup->createCategory();
        $category3->load(2)
            ->setParentId($categoryPet->getId())
            ->setId(5)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 5)
            ->setStoreId(1)
            ->setName('Category 3')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category4 = $categorySetup->createCategory();
        $category4->load(2)
            ->setParentId($categoryPet->getId())
            ->setId(6)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 6)
            ->setStoreId(1)
            ->setName('Category 4')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category5 = $categorySetup->createCategory();
        $category5->load(2)
            ->setParentId($categoryPet->getId())
            ->setId(7)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 7)
            ->setStoreId(1)
            ->setName('Category 5')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
        
        //Sneakers category and its subs
        $categorySneakers = $categorySetup->createCategory();
        $categorySneakers->load(10)
            ->setParentId($rootCategoryId)
            ->setId(10)
            ->setPath($rootCategoryId . '/' . 10)
            ->setStoreId(3)
            ->setName('Sneakers')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category11 = $categorySetup->createCategory();
        $category11->load(10)
            ->setParentId($categorySneakers->getId())
            ->setId(11)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 11)
            ->setStoreId(3)
            ->setName('Category 11')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category12 = $categorySetup->createCategory();
        $category12->load(10)
            ->setParentId($categorySneakers->getId())
            ->setId(12)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 12)
            ->setStoreId(3)
            ->setName('Category 12')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category13 = $categorySetup->createCategory();
        $category13->load(10)
            ->setParentId($categorySneakers->getId())
            ->setId(13)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 13)
            ->setStoreId(3)
            ->setName('Category 13')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category14 = $categorySetup->createCategory();
        $category14->load(10)
            ->setParentId($categorySneakers->getId())
            ->setId(14)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 14)
            ->setStoreId(3)
            ->setName('Category 14')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
            
        $category15 = $categorySetup->createCategory();
        $category15->load(10)
            ->setParentId($categorySneakers->getId())
            ->setId(15)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 15)
            ->setStoreId(3)
            ->setName('Category 15')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
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

