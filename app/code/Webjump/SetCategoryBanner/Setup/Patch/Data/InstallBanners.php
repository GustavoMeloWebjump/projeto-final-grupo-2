<?php
declare(strict_types=1);
namespace Webjump\SetCategoryBanner\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\Backend\App\GetCategoriesByName;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;
use Webjump\Backend\Setup\Patch\Data\ReInstallCategories;

/**
 * Patch to apply creation of the block Charges and fees
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InstallBanners implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'teste-banner';
    /**
     * @var string TITLE
     */
    const TITLE = 'Teste Banner';
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;
    /**
     * @var GetCategoriesByName
     */
    private $getCategoriesByName;
      /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepositoryInterface;
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StoreRepositoryInterface $storeRepository,
        GetCategoriesByName $getCategoriesByName,
        CategoryRepositoryInterface $categoryRepositoryInterface
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeRepository = $storeRepository;
        $this->getCategoriesByName = $getCategoriesByName;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;

    }
    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();

        $patinhas_en = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE)->getId();
        $fanon = $this->storeRepository->get(InstallWGS::FANON_STORE_CODE)->getId();

        $dogCategoryId = $this->getCategoriesByName->getCategoryId('Cães');
        $dogCategory = $this->categoryRepositoryInterface->get($dogCategoryId);
        $dogCategory->setImage('caes.png')->save();

        $dogCategory = $this->categoryRepositoryInterface->get($dogCategoryId, $patinhas_en);
        $dogCategory->setImage('dogs.png')->save();

        $catCategoryId = $this->getCategoriesByName->getCategoryId('Gatos');
        $catCategory = $this->categoryRepositoryInterface->get($catCategoryId);
        $catCategory->setImage('gatos.png')->save();

        $catCategory = $this->categoryRepositoryInterface->get($catCategoryId, $patinhas_en);
        $catCategory->setImage('cats.png')->save();

        $birdCategoryId = $this->getCategoriesByName->getCategoryId('Pássaros');
        $birdCategory = $this->categoryRepositoryInterface->get($birdCategoryId);
        $birdCategory->setImage('passaros.png')->save();

        $birdCategory = $this->categoryRepositoryInterface->get($birdCategoryId, $patinhas_en);
        $birdCategory->setImage('birds.png')->save();

        $lancamentoCategoryId = $this->getCategoriesByName->getCategoryId('Lançamentos');
        $lancamentoCategory = $this->categoryRepositoryInterface->get($lancamentoCategoryId, $fanon);
        $lancamentoCategory->setImage('lancamentos.png')->save();

        $femininoCategoryId = $this->getCategoriesByName->getCategoryId('Feminino');
        $femininoCategory = $this->categoryRepositoryInterface->get($femininoCategoryId, $fanon);
        $femininoCategory->setImage('feminino.png')->save();

        $masculinoCategoryId = $this->getCategoriesByName->getCategoryId('Masculino');
        $masculinoCategory = $this->categoryRepositoryInterface->get($masculinoCategoryId, $fanon);
        $masculinoCategory->setImage('masculino.png')->save();

        $this->moduleDataSetup->endSetup();
    }

  /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            InstallWGS::class,
            ReInstallCategories::class
        ];
    }
}