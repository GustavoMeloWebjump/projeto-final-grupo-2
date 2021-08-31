<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\ResourceModel\Group;

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
     * @var GroupFactory
     */
    private $groupFactory;

    /**
     * @var Group
     */
    private $groupResourceModel;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     * @param GroupFactory $groupFactory
     * @param Group $group
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory,
        GroupFactory $groupFactory,
        Group $group
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $group;
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
            ->setName('Patinhas')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category1 = $categorySetup->createCategory();
        $category1->load(3)
            ->setParentId($categoryPet->getId())
            ->setId(3)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 3)
            ->setStoreId(1)
            ->setName('Cachorros')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category2 = $categorySetup->createCategory();
        $category2->load(4)
            ->setParentId($categoryPet->getId())
            ->setId(4)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 4)
            ->setStoreId(1)
            ->setName('Gatos')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category3 = $categorySetup->createCategory();
        $category3->load(5)
            ->setParentId($categoryPet->getId())
            ->setId(5)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 5)
            ->setStoreId(1)
            ->setName('Brinquedos')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category4 = $categorySetup->createCategory();
        $category4->load(6)
            ->setParentId($categoryPet->getId())
            ->setId(6)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 6)
            ->setStoreId(1)
            ->setName('Pássaros')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category5 = $categorySetup->createCategory();
        $category5->load(7)
            ->setParentId($categoryPet->getId())
            ->setId(7)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 7)
            ->setStoreId(1)
            ->setName('Banho')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category6 = $categorySetup->createCategory();
        $category6->load(8)
            ->setParentId($categoryPet->getId())
            ->setId(8)
            ->setPath($rootCategoryId . '/' . 2 . '/' . 8)
            ->setStoreId(1)
            ->setName('Acessórios')
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
            ->setPath($rootCategoryId . '/' . $categorySneakers->getId())
            ->setStoreId(3)
            ->setName('Fanon')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category11 = $categorySetup->createCategory();
        $category11->load(11)
            ->setParentId($categorySneakers->getId())
            ->setId(11)
            ->setPath($rootCategoryId . '/' . $categorySneakers->getId() . '/' . $category11->getId())
            ->setStoreId(3)
            ->setName('Lançamentos')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category12 = $categorySetup->createCategory();
        $category12->load(12)
            ->setParentId($categorySneakers->getId())
            ->setId(12)
            ->setPath($rootCategoryId . '/' . $categorySneakers->getId() . '/' . $category12->getId())
            ->setStoreId(3)
            ->setName('Masculino')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category121 = $categorySetup->createCategory();
        $category121->load(121)
            ->setParentId($category12->getId())
            ->setId(121)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category12->getId() . '/' . $category121->getId()
            )
            ->setStoreId(3)
            ->setName('Casual')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category122 = $categorySetup->createCategory();
        $category122->load(122)
            ->setParentId($category12->getId())
            ->setId(122)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category12->getId() . '/' . $category122->getId()
            )
            ->setStoreId(3)
            ->setName('Corrida')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category123 = $categorySetup->createCategory();
        $category123->load(123)
            ->setParentId($category12->getId())
            ->setId(123)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category12->getId() . '/' . $category123->getId()
            )
            ->setStoreId(3)
            ->setName('Skate')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category124 = $categorySetup->createCategory();
        $category124->load(124)
            ->setParentId($category12->getId())
            ->setId(124)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category12->getId() . '/' . $category124->getId()
            )
            ->setStoreId(3)
            ->setName('Chuteiras')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category125 = $categorySetup->createCategory();
        $category125->load(125)
            ->setParentId($category12->getId())
            ->setId(125)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category12->getId() . '/' . $category125->getId()
            )
            ->setStoreId(3)
            ->setName('Basquete')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category13 = $categorySetup->createCategory();
        $category13->load(13)
            ->setParentId($categorySneakers->getId())
            ->setId(13)
            ->setPath($rootCategoryId . '/' . 10 . '/' . 13)
            ->setStoreId(3)
            ->setName('Feminino')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category131 = $categorySetup->createCategory();
        $category131->load(131)
            ->setParentId($category13->getId())
            ->setId(131)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category13->getId() . '/' . $category131->getId()
            )
            ->setStoreId(3)
            ->setName('Casual')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category132 = $categorySetup->createCategory();
        $category132->load(132)
            ->setParentId($category13->getId())
            ->setId(132)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category13->getId() . '/' . $category132->getId()
            )
            ->setStoreId(3)
            ->setName('Corrida')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category133 = $categorySetup->createCategory();
        $category133->load(133)
            ->setParentId($category13->getId())
            ->setId(133)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category13->getId() . '/' . $category133->getId()
            )
            ->setStoreId(3)
            ->setName('Skate')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category134 = $categorySetup->createCategory();
        $category134->load(134)
            ->setParentId($category13->getId())
            ->setId(134)
            ->setPath(
                $rootCategoryId . '/' . $categorySneakers->getId() .
                    '/' . $category13->getId() . '/' . $category134->getId()
            )
            ->setStoreId(3)
            ->setName('Chuteiras')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(3)
            ->setInitialSetupFlag(true)
            ->save();

        $group = $this->groupFactory->create();
        $group->load(2)->setRootCategoryId(10);
        $this->groupResourceModel->save($group);

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
        return '3.1.0';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
