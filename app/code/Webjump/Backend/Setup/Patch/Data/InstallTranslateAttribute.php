<?php
namespace Webjump\Backend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeFrontendLabelInterfaceFactory as AttributeFrontendLabelFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\Backend\Setup\Patch\Data\CreatePetshopAttribute;
use Magento\Store\Model\StoreRepository;

class InstallTranslateAttribute implements DataPatchInterface
{

    private ModuleDataSetupInterface $moduleDataSetupInterface;
    private ProductAttributeRepositoryInterface $productAttributeRepository;
    private AttributeFrontendLabelFactory $attributeFrontendLabel;
    private StoreRepository $storeRepository;

    public function __construct(ModuleDataSetupInterface $moduleDataSetupInterface,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        AttributeFrontendLabelFactory $attributeFrontendLabel,
        StoreRepository $storeRepository
    )
    {
        $this->moduleDataSetupInterface = $moduleDataSetupInterface;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->attributeFrontendLabel = $attributeFrontendLabel;
        $this->storeRepository = $storeRepository;
    }

    public function setProductTag () {
        $attribute = $this->productAttributeRepository->get(CreatePetshopAttribute::PETSHOP_ANIMAL);

        $labels = [
            $this->attributeFrontendLabel
                ->create()
                ->setStoreId(
                    $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId()
                )->setLabel('Product Tag (Product type)')
        ];

        $attribute->setFrontendLabels($labels);
        $this->productAttributeRepository->save($attribute);
    }

    public function setAnimalSize () {
        $attribute = $this->productAttributeRepository->get(CreatePetshopAttribute::PETSHOP_SHAPE);

        $labels = [
            $this->attributeFrontendLabel
                ->create()
                ->setStoreId(
                    $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId()
                )->setLabel('Size ')
        ];

        $attribute->setFrontendLabels($labels);
        $this->productAttributeRepository->save($attribute);
    }

    public function apply() {
        $this->moduleDataSetupInterface->getConnection()->startSetup();

        $this->setProductTag();
        $this->setAnimalSize();

        $this->moduleDataSetupInterface->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies() {
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
