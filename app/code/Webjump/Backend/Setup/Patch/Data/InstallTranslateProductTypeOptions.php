<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Webjump\Backend\Setup\Patch\Data\CreatePetshopAttribute;
use Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory;
use Magento\Store\Model\StoreRepository;
use Magento\Catalog\Model\Product;


class InstallTranslateProductTypeOptions implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private AttributeOptionLabelInterfaceFactory $attributeOptionsLabelFactory;
    private StoreRepository $storeRepository;
    private AttributeOptionInterfaceFactory $attributeOptionsFactory;
    private AttributeOptionManagementInterface $attributeOptionManager;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup,
    AttributeOptionLabelInterfaceFactory $attributeOptionsLabelFactory,
    StoreRepository $storeRepository,
    AttributeOptionInterfaceFactory $attributeOptionsFactory)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeOptionsLabelFactory = $attributeOptionsLabelFactory;
        $this->storeRepository = $storeRepository;
        $this->attributeOptionsFactory = $attributeOptionsFactory;
    }


    public function returnLabelDatasByProductType(): array
    {
        return [
            ['Ração', 'Pet food'],
            ['Coleiras', 'Collars'],
            ['Brinquedos', 'Toys'],
            ['Remedios', 'Medicines']
        ];
    }


    public function setProductType () {

        $contador = 0;
        foreach ($this->returnLabelDatasByProductType() as $productType) {
            $attributeEnglish = $this->attributeOptionsLabelFactory->create();
            $attributeEnglish->setStoreId($this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId());
            $attributeEnglish->setLabel($productType[0]);


            $attribute = $this->attributeOptionsFactory->create();

            $attribute->setLabel($productType[1]);
            $attribute->setStoreLabels($attributeEnglish);
            $attribute->setIsDefault(false);
            $attribute->setSortOrder($contador);

            $contador++;

            $this->attributeOptionManager->add(Product::ENTITY, CreatePetshopAttribute::PETSHOP_ANIMAL, $attribute);
        }
    }


    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->setProductType();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [
            InstallWGS::class,
            CreateAttributeCategory::class,
            CreatePetshopAttribute::class,
            CreatePetshopProductAttribute::class,
            CreateSneakersAttribute::class,
            CreateSneakersProductAttribute::class
        ];
    }
}
