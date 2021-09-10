<?php
declare(strict_types=1);
namespace Webjump\SetFooter\Setup\Patch\Data;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;

/**
 * Patch to apply creation of the block Charges and fees
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FooterPet implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'footer-pet';
    /**
     * @var string TITLE
     */
    const TITLE = 'Footer Pet';
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;
    /**
     * @var BlockRepositoryInterface $blockRepository
     */
    private $blockRepository;
    /**
     * @var BlockInterfaceFactory $blockFactory
     */
    private $blockFactory;
    /**
     * @var StoreRepositoryInterface $storeRepository
     */
    private $storeRepository;
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
        $this->storeRepository = $storeRepository;

    }
    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();
        $content = <<<HTML
<style>#html-body [data-pb-style=DIQLHLI],#html-body [data-pb-style=EFXJC8O],#html-body [data-pb-style=MC961KC],#html-body [data-pb-style=TTYFYEU]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=DIQLHLI],#html-body [data-pb-style=MC961KC],#html-body [data-pb-style=TTYFYEU]{width:33.3333%;align-self:stretch}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="EFXJC8O"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="TTYFYEU"><div data-content-type="text" data-appearance="default" data-element="main"><p id="C51R373"><strong>Links</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a id="VW60JEA" tabindex="0" href="politicas_de_privacidade">Política de Privacidade</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="AAN0BT8"><a tabindex="0" href="about">Quem Somos</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="MC961KC"><div data-content-type="text" data-appearance="default" data-element="main"><p id="AAQJYYI"><strong>Categories</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="c-es.html">Cães</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="O7KUHNA"><a tabindex="0" href="gatos.html">Gatos</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="D3QX5J7"><a tabindex="0" href="passaros.html">Pássaros</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="DIQLHLI"><div data-content-type="text" data-appearance="default" data-element="main"><p id="HHWAXFR"><strong>Contact</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="NW1UJJN">E-mail: patinhas@pet.com</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Telefone: (11)99999-9999</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Atendimento de segunda à sexta</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="D9HNB2M">Das 8:00 às 18:00</p></div></div></div></div></div>
HTML;
        $this->blockRepository->save($this->getCmsBlock($content));
        $this->moduleDataSetup->endSetup();
    }
    /**
     * Method create CMS block
     *
     * @return \Magento\Cms\Api\Data\BlockInterface
     */
    private function getCmsBlock($content): \Magento\Cms\Api\Data\BlockInterface
    {
        $patinhas = $this->storeRepository->get(InstallWGS::PATINHAS_STORE_CODE);
        $patinhas_en = $this->storeRepository->get(InstallWGS::PATINHAS_EN_STORE_CODE);

        return $this->blockFactory->create()
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$patinhas->getId()])
            ->setContent($content);
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
            InstallWGS::class
        ];
    }
}