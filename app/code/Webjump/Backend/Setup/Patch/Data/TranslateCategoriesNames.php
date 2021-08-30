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
        $category1->setStoreId(2)
            ->setName('Dogs');

        $this->categoryRepository->save($category1);

        $category2 = $this->categoryRepository->get(4, 2);
        $category2->setStoreId(2)
            ->setName('Cats');

        $this->categoryRepository->save($category2);

        $category3 = $this->categoryRepository->get(5, 2);
        $category3->setStoreId(2)
            ->setName('Toys');

        $this->categoryRepository->save($category3);

        $category4 = $this->categoryRepository->get(6, 2);
        $category4->setStoreId(2)
            ->setName('Birds');

        $this->categoryRepository->save($category4);

        $category5 = $this->categoryRepository->get(7, 2);
        $category5->setStoreId(2)
            ->setName('Bath');

        $this->categoryRepository->save($category5);

        $category6 = $this->categoryRepository->get(8, 2);
        $category6->setStoreId(2)
            ->setName('Accessories');

        $this->categoryRepository->save($category6);

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
