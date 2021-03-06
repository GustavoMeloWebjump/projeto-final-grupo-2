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
                'name' => 'C??es',
                'parent_ref' => 1,
                'meta' => 'Patinhas | C??es'
            ],
            [
                'name' => 'Gatos',
                'parent_ref' => 1,
                'meta' => 'Patinhas | Gatos'
            ],
            [
                'name' => 'P??ssaros',
                'parent_ref' => 1,
                'meta' => 'Patinhas | P??ssaros'
            ],
            // from here: Patinhas C??es' subcategories
            [
                'name' => 'Brinquedos para C??es',
                'parent_ref' => 2,
                'meta' => 'Patinhas | C??es - Brinquedos'
            ],
            [
                'name' => 'Beleza e Limpeza para C??es',
                'parent_ref' => 2,
                'meta' => 'Patinhas | C??es - Beleza'
            ],
            [
                'name' => 'Acess??rios para C??es',
                'parent_ref' => 2,
                'meta' => 'Patinhas | C??es - Acess??rios'
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
                'name' => 'Acess??rios para Gatos',
                'parent_ref' => 3,
                'meta' => 'Patinhas | Gatos - Acess??rios'
            ],
            // from here: Patinhas P??ssaros' subcategories
            [
                'name' => 'Brinquedos para Aves',
                'parent_ref' => 4,
                'meta' => 'Patinhas | P??ssaros - Brinquedos'
            ],
            [
                'name' => 'Acess??rios para Aves',
                'parent_ref' => 4,
                'meta' => 'Patinhas | P??ssaros - Banho'
            ],
            // Fanon's root category ref: 13
            [
                'name' => 'Fanon',
                'parent_ref' => 0,
                'meta' => ''
            ],
            // from here: Fanon's categories
            [
                'name' => 'Lan??amentos',
                'parent_ref' => 13,
                'meta' => 'Fanon | Lan??amentos'
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
