<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\ResourceModel\Group as GroupResourceModel;

class ReInstallCategories implements DataPatchInterface
{
    private $moduleDataSetup;

    private $categoryRepository;

    private $categoryFactory;

    private $groupResourceModel;

    private $groupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepositoryInterface $categoryRepository,
        CategoryInterfaceFactory $categoryFactory,
        GroupResourceModel $group,
        GroupFactory $groupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
        $this->groupResourceModel = $group;
        $this->groupFactory = $groupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $categories = [];
        $categories[] = \Magento\Catalog\Model\Category::TREE_ROOT_ID;

        $data = $this->getData();

        foreach ($data as $key) {
            $category = $this->categoryFactory->create();
            $category->setName($key['name'])
                ->setIsActive(true)
                ->setParentId($categories[$key['parent_ref']])
                ->setMetaTitle($key['meta']);
            
            $this->categoryRepository->save($category);

            $categories[] = $category->getId();
        }

        $patinhas = $this->groupFactory->create();
        $this->groupResourceModel->load($patinhas, InstallWGS::PATINHAS_GROUP_CODE, 'code');
        $patinhas->setRootCategoryId($categories[1]);
        $this->groupResourceModel->save($patinhas);
        
        $fanon = $this->groupFactory->create();
        $this->groupResourceModel->load($fanon, InstallWGS::FANON_GROUP_CODE, 'code');
        $fanon->setRootCategoryId($categories[13]);
        $this->groupResourceModel->save($fanon);
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getData()
    {
        return [
            // Patinhas' root category
            [
                'name' => 'Patinhas',
                'parent_ref' => 0,
                'meta' => ''
            ],
            // from here: Patinhas' categories
            [
                'name' => 'Cães',
                'parent_ref' => 1,
                'meta' => 'Patinhas | Cães'
            ],
            [
                'name' => 'Gatos',
                'parent_ref' => 1,
                'meta' => 'Patinhas | Gatos'
            ],
            [
                'name' => 'Pássaros',
                'parent_ref' => 1,
                'meta' => 'Patinhas | Pássaros'
            ],
            // from here: Patinhas Cães' subcategories
            [
                'name' => 'Brinquedos para Cães',
                'parent_ref' => 2,
                'meta' => 'Patinhas | Cães - Brinquedos'
            ],
            [
                'name' => 'Beleza e Limpeza para Cães',
                'parent_ref' => 2,
                'meta' => 'Patinhas | Cães - Beleza'
            ],
            [
                'name' => 'Acessórios para Cães',
                'parent_ref' => 2,
                'meta' => 'Patinhas | Cães - Acessórios'
            ],
            // from here: Patinhas Gatos' subcategories
            [
                'name' => 'Brinquedos para Gatos',
                'parent_ref' => 3,
                'meta' => 'Patinhas | Gatos - Brinquedos'
            ],
            [
                'name' => 'Beleza e Limpeza para Gatos',
                'parent_ref' => 3,
                'meta' => 'Patinhas | Gatos - Beleza'
            ],
            [
                'name' => 'Acessórios para Gatos',
                'parent_ref' => 3,
                'meta' => 'Patinhas | Gatos - Acessórios'
            ],
            // from here: Patinhas Pássaros' subcategories
            [
                'name' => 'Brinquedos para Aves',
                'parent_ref' => 4,
                'meta' => 'Patinhas | Pássaros - Brinquedos'
            ],
            [
                'name' => 'Acessórios para Aves',
                'parent_ref' => 4,
                'meta' => 'Patinhas | Pássaros - Banho'
            ],
            // Fanon's root category ref: 13
            [
                'name' => 'Fanon',
                'parent_ref' => 0,
                'meta' => ''
            ],
            // from here: Fanon's categories
            [
                'name' => 'Lançamentos',
                'parent_ref' => 13,
                'meta' => 'Fanon | Lançamentos'
            ],
            [
                'name' => 'Masculino',
                'parent_ref' => 13,
                'meta' => 'Fanon | Masculino'
            ],
            [
                'name' => 'Feminino',
                'parent_ref' => 13,
                'meta' => 'Fanon | Feminino'
            ],
            // from here: Fanon Masculinos' subcategories
            [
                'name' => 'Casual',
                'parent_ref' => 15,
                'meta' => 'Fanon | Masculino - Casual'
            ],
            [
                'name' => 'Corrida',
                'parent_ref' => 15,
                'meta' => 'Fanon | Masculino - Corrida'
            ],
            [
                'name' => 'Skate',
                'parent_ref' => 15,
                'meta' => 'Fanon | Masculino - Skate'
            ],
            [
                'name' => 'Chuteiras',
                'parent_ref' => 15,
                'meta' => 'Fanon | Masculino - Chuteiras'
            ],
            [
                'name' => 'Basquete',
                'parent_ref' => 15,
                'meta' => 'Fanon | Masculino - Basquete'
            ],
            // from here: Fanon Femininos' subcategories
            [
                'name' => 'Casual',
                'parent_ref' => 16,
                'meta' => 'Fanon | Feminino - Casual'
            ],
            [
                'name' => 'Corrida',
                'parent_ref' => 16,
                'meta' => 'Fanon | Feminino - Corrida'
            ],
            [
                'name' => 'Skate',
                'parent_ref' => 16,
                'meta' => 'Fanon | Feminino - Skate'
            ],
            [
                'name' => 'Chuteiras',
                'parent_ref' => 16,
                'meta' => 'Fanon | Feminino - Chuteiras'
            ],
        ];
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [
            InstallWGS::class
        ];
    }
}
