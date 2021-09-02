<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;

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
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryRepository $categoryRepository
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepository       $categoryRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
        $this->storeRepository = $storeRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $patinhas_en_id = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId();

        $category1 = $this->categoryRepository->get(3, $patinhas_en_id);
        $category1->setName('Dogs')->save();

        $category2 = $this->categoryRepository->get(4, $patinhas_en_id);
        $category2->setName('Cats')->save();

        $category3 = $this->categoryRepository->get(5, $patinhas_en_id);
        $category3->setName('Toys')->save();

        $category4 = $this->categoryRepository->get(6, $patinhas_en_id);
        $category4->setName('Birds')->save();

        $category5 = $this->categoryRepository->get(7, $patinhas_en_id);
        $category5->setName('Bath')->save();

        $category6 = $this->categoryRepository->get(8, $patinhas_en_id);
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
