<?php

namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\Backend\App\GetCategoriesByName;

class TranslateCategoriesNames implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var GetCategoriesByName
     */
    private $getCategories;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryRepositoryInterface $categoryRepository
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepositoryInterface $categoryRepository,
        StoreRepositoryInterface $storeRepository,
        GetCategoriesByName $getCategoriesByName
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
        $this->storeRepository = $storeRepository;
        $this->getCategories = $getCategoriesByName;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $patinhas_en_id = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId();

        $data = $this->getData();
        
        $parentsId[] = $this->getCategories->getCategoryId('Cães');
        $parentsId[] = $this->getCategories->getCategoryId('Gatos');
        $parentsId[] = $this->getCategories->getCategoryId('Pássaros');

        foreach ($data as $key) {
            $categoryId = $this->getCategories->getCategoryId($key['original-name']);

            $category = $this->categoryRepository->get($categoryId, $patinhas_en_id);
            $category->setName($key['name'])
                ->setMetaTitle($key['meta'])
                ->setUrlKey($key['url'])
                ->save();
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getData()
    {
        return [
            // from here: Patinhas' categories
            [
                'original-name' => 'Cães',
                'name' => 'Dogs',
                'parent' => null,
                'meta' => 'Patinhas | Dogs',
                'url' => 'dogs'
            ],
            [
                'original-name' => 'Gatos',
                'name' => 'Cats',
                'parent' => null,
                'meta' => 'Patinhas | Cats',
                'url' => 'cats'
            ],
            [
                'original-name' => 'Pássaros',
                'name' => 'Birds',
                'parent' => null,
                'meta' => 'Patinhas | Birds',
                'url' => 'birds'
            ],
            // from here: Patinhas Dogs' subcategories
            [
                'original-name' => 'Brinquedos para Cães',
                'name' => 'Dog Toys',
                'parent' => 0,
                'meta' => 'Patinhas | Dogs - Toys',
                'url' => 'dog/toys'
            ],
            [
                'original-name' => 'Beleza e Limpeza para Cães',
                'name' => 'Grooming for Dogs',
                'parent' => 0,
                'meta' => 'Patinhas | Dogs - Bath',
                'url' => 'dog/grooming'
            ],
            [
                'original-name' => 'Acessórios para Cães',
                'name' => 'Dog Accessories',
                'parent' => 0,
                'meta' => 'Patinhas | Dogs - Accessories',
                'url' => 'dog/accessories'
            ],
            // from here: Patinhas Cats' subcategories
            [
                'original-name' => 'Brinquedos para Gatos',
                'name' => 'Cat Toys',
                'parent' => 1,
                'meta' => 'Patinhas | Cats - Toys',
                'url' => 'cat/toys'
            ],
            [
                'original-name' => 'Beleza e Limpeza para Gatos',
                'name' => 'Grooming for Cats',
                'parent' => 1,
                'meta' => 'Patinhas | Cats - Bath',
                'url' => 'cat/grooming'
            ],
            [
                'original-name' => 'Acessórios para Gatos',
                'name' => 'Cat Accessories',
                'parent' => 1,
                'meta' => 'Patinhas | Cats - Accessories',
                'url' => 'cat/accessories'
            ],
            // from here: Patinhas Birds' subcategories
            [
                'original-name' => 'Brinquedos para Aves',
                'name' => 'Bird Toys',
                'parent' => 2,
                'meta' => 'Patinhas | Birds - Toys',
                'url' => 'bird/toys'
            ],
            [
                'original-name' => 'Acessórios para Aves',
                'name' => 'Bird Accessories',
                'parent' => 2,
                'meta' => 'Patinhas | Birds - Accessories',
                'url' => 'bird/accessories'
            ],
        ];
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
        return [ReInstallCategories::class];
    }
}
