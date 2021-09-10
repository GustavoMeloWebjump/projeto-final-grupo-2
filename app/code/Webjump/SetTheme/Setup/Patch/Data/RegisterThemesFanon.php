<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Webjump\SetTheme\Setup\Patch\Data;

use Magento\Theme\Model\Theme\Registration;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Theme\Model\ResourceModel\Theme as ThemeResourceModel;
use Magento\Theme\Model\ThemeFactory;
use Webjump\Backend\Setup\Patch\Data\InstallWGS;

/**
 * Class RegisterThemes
 * @package Magento\Theme\Setup\Patch
 */
class RegisterThemesFanon implements DataPatchInterface
{
    /**
    * @var ConfigInterface
    */
    private $configInterface;
    
    private StoreManagerInterface $storeManager;

    private $themeResourceModel;

    private $themeFactory;

    /**
     * RegisterThemes constructor.
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param Registration $themeRegistration
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ConfigInterface $configInterface,
        ThemeFactory $themeFactory,
        ThemeResourceModel $themeResourceModel
    ) {
        $this->storeManager = $storeManager;
        $this->configInterface = $configInterface;
        $this->themeFactory = $themeFactory;
        $this->themeResourceModel = $themeResourceModel;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $fanon = $this->themeFactory->create();
        $this->themeResourceModel->load($fanon, 'projetofinal_temas/tema_fanon', 'theme_path');

        $fanonStoreId = $this->storeManager->getStore(InstallWGS::FANON_STORE_CODE)->getId();
        $this->configInterface->saveConfig(
            'design/theme/theme_id', 
            $fanon->getThemeId(), 
            ScopeInterface::SCOPE_STORES,
            $fanonStoreId
        );
       
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

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}