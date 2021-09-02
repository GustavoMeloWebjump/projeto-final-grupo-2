<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\ResourceModel\Group as GroupResourceModel;
use Magento\Store\Model\ResourceModel\Store as StoreResourceModel;
use Magento\Store\Model\ResourceModel\Website as WebsiteResourceModel;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\WebsiteFactory;

class InstallWGS implements DataPatchInterface
{
    private $moduleDataSetup;
    private $websiteFactory;
    private $websiteResourceModel;
    private $groupFactory;
    private $groupResourceModel;
    private $storeFactory;
    private $storeResourceModel;

    const PATINHAS_WEBSITE_CODE = 'petshop_code';

    const PATINHAS_GROUP_CODE = 'petshop_code_group';

    const PATINHAS_STORE_CODE = 'petshop_view_code';

    const PATINHAS_EN_STORE_CODE = 'petshop_en_view_code';

    const FANON_WEBSITE_CODE = 'sneakers_code';

    const FANON_GROUP_CODE = 'sneakers_code_group';
    
    const FANON_STORE_CODE = 'sneakers_view_code';

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WebsiteFactory $websiteFactory,
        WebsiteResourceModel $websiteResourceModel,
        GroupFactory $groupFactory,
        GroupResourceModel $groupResourceModel,
        StoreFactory $storeFactory,
        StoreResourceModel $storeResourceModel
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->websiteFactory = $websiteFactory;
        $this->websiteResourceModel = $websiteResourceModel;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $groupResourceModel;
        $this->storeFactory = $storeFactory;
        $this->storeResourceModel = $storeResourceModel;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $data = $this->getData();

        foreach ($data as $value) {
            $website = $this->websiteFactory->create();
            $this->websiteResourceModel->load($website, $value['website']['code'], 'code');

            if (!$website->getId()) {
                // setting and saving website
                $website->setCode($value['website']['code'])
                    ->setName($value['website']['name'])
                    ->setSortOrder($value['website']['sort_order'])
                    ->setDefaultGroupId(0)
                    ->setIsDefault($value['website']['is_default']);

                $this->websiteResourceModel->save($website);

                // setting and saving group
                $group = $this->groupFactory->create();
                $group->setWebsiteId($website->getId())
                    ->setName($value['group']['name'])
                    ->setRootCategoryId($value['group']['root_category_id'])
                    ->setDefaultStoreId($value['group']['default_store_id'])
                    ->setCode($value['group']['code']);

                $this->groupResourceModel->save($group);

                // adding default group id to website
                $this->websiteResourceModel->load($website, $value['website']['code'], 'code');
                $website->setDefaultGroupId($group->getId());
                $this->websiteResourceModel->save($website);
                
                // setting and saving store(s)
                // these variables will be used to save the ids of the stores, in order to retrieve the first one
                $aux = [];
                $i = 0;
                
                foreach ($value['store'] as $storeIterator) {
                    $store = $this->storeFactory->create();
                    $store->setCode($storeIterator['code'])
                        ->setWebsiteId($website->getId())
                        ->setGroupId($group->getId())
                        ->setName($storeIterator['name'])
                        ->setSortOrder($storeIterator['sort_order'])
                        ->setIsActive($storeIterator['is_active']);

                    $this->storeResourceModel->save($store);

                    $aux[$i] = $store->getId();
                    $i++;
                }
                
                // adding default store id to group 
                // note: the default store id will always be the id of the first store added
                $this->groupResourceModel->load($group, $value['group']['code'], 'code');
                $group->setDefaultStoreId($aux[0]);
                $this->groupResourceModel->save($group);
            }
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getData(): array
    {
        return [
            'patinhas' => [
                'website' => [
                    'code' => self::PATINHAS_WEBSITE_CODE,
                    'name' => 'Patinhas',
                    'sort_order' => '1',
                    'is_default' => '1'
                ],
                'group' => [
                    'name' => 'Petshop',
                    'root_category_id' => '2',
                    'code' => self::PATINHAS_GROUP_CODE,
                    'default_store_id' => 0
                ],
                'store' => [
                    'pt' => [
                        'code' => self::PATINHAS_STORE_CODE,
                        'name' => 'Patinhas',
                        'sort_order' => '1',
                        'is_active' => '1'
                    ],
                    'en' => [
                        'code' => self::PATINHAS_EN_STORE_CODE,
                        'name' => 'Patinhas en',
                        'sort_order' => '2',
                        'is_active' => '1'
                    ]
                ]
            ],
            'fanon' => [
                'website' => [
                    'code' => self::FANON_WEBSITE_CODE,
                    'name' => 'Fanon',
                    'sort_order' => '2',
                    'is_default' => '0'
                ], 
                'group' => [
                    'name' => 'Sneakers',
                    'root_category_id' => '2',
                    'code' => self::FANON_GROUP_CODE,
                    'default_store_id' => 0
                ],
                'store' => [
                    'pt' => [
                        'code' => self::FANON_STORE_CODE,
                        'name' => 'Fanon',
                        'sort_order' => '2',
                        'is_active' => '1'
                    ]
                ]
            ]
        ];
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
