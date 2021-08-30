<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class TranslateCategoriesNames implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepository       $categoryRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $category1 = $this->categoryRepository->get(3, 2);
        $category1->setName('Dogs')->save();

        $category2 = $this->categoryRepository->get(4, 2);
        $category2->setName('Cats')->save();

        $category3 = $this->categoryRepository->get(5, 2);
        $category3->setName('Toys')->save();

        $category4 = $this->categoryRepository->get(6, 2);
        $category4->setName('Birds')->save();

        $category5 = $this->categoryRepository->get(7, 2);
        $category5->setName('Bath')->save();

        $category6 = $this->categoryRepository->get(8, 2);
        $category6->setName('Accessories')->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [InstallCategories::class];
    }
}
