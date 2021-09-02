<?php
declare(strict_types=1);
namespace Webjump\SetFooter\Setup\Patch\Data;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\Store;
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
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
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
        <style>#html-body [data-pb-style=MQQPN21],#html-body [data-pb-style=N87XM81],#html-body [data-pb-style=TJRO6B5],#html-body [data-pb-style=XA70HEN]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=MQQPN21],#html-body [data-pb-style=N87XM81],#html-body [data-pb-style=TJRO6B5]{width:33.3333%;align-self:stretch}#html-body [data-pb-style=MQQPN21],#html-body [data-pb-style=N87XM81]{width:25%}#html-body [data-pb-style=MQQPN21]{width:41.6667%}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="XA70HEN"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="TJRO6B5"><div data-content-type="text" data-appearance="default" data-element="main"><p><strong>Links</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="politicas_de_privacidade">Política de Privacidade</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="YQDTPY2"><a tabindex="0" href="about">Quem Somos</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="N87XM81"><div data-content-type="text" data-appearance="default" data-element="main"><p><strong>Categorias</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="cachorros.html">Cachorros</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="gatos.html">Gatos</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="brinquedos.html">Brinquedos</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="passaros.html">Pássaros</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a id="AM1E1Q1" tabindex="0" href="banho.html">Banho</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a id="U0HB988" tabindex="0" href="acessorios.html">Acessórios</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="MQQPN21"><div data-content-type="text" data-appearance="default" data-element="main"><p><strong>Contato</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Email: <a tabindex="0" href="mailto:patinhas@petshop.com">patinhas@pet.com</a></p>
        <p>Telefone: (11)99999-9999</p>
        <p>Atendimento de segunda à sexta</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Das 8:00 às 18:00</p></div></div></div></div></div>
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
        return $this->blockFactory->create()
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores(['1'])
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
        return [];
    }
}