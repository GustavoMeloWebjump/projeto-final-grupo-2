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
class FooterSneakers implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'footer-sneakers';
    /**
     * @var string TITLE
     */
    const TITLE = 'Footer Sneakers';
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
        <style>#html-body [data-pb-style=B6SL3II],#html-body [data-pb-style=JQ7X0HF],#html-body [data-pb-style=SB8440N],#html-body [data-pb-style=URUL669]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=B6SL3II],#html-body [data-pb-style=JQ7X0HF],#html-body [data-pb-style=SB8440N]{width:33.3333%;align-self:stretch}#html-body [data-pb-style=B6SL3II],#html-body [data-pb-style=JQ7X0HF]{width:25%}#html-body [data-pb-style=JQ7X0HF]{width:41.6667%}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="URUL669"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="SB8440N"><div data-content-type="text" data-appearance="default" data-element="main"><p><strong>Links</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="politicas_de_privacidade">Política de Privacidade</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Termos de Pesquisa</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Pesquisa Avançada</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Pedidos e Devoluções</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Fale Conosco</p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="B6SL3II"><div data-content-type="text" data-appearance="default" data-element="main"><p><strong>Categorias</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="lancamentos.html">Lançamentos</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="masculino.html">Masculino</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="feminino.html">Feminino</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="JQ7X0HF"><div data-content-type="text" data-appearance="default" data-element="main"><p><strong>Contato</strong></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Email: <a tabindex="0" href="mailto:patinhas@petshop.com">fanon@sneakers.com</a></p>
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
            ->setStores(['3'])
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