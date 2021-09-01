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

/**
 * Class RegisterThemes
 * @package Magento\Theme\Setup\Patch
 */
class RegisterThemesPet2 implements DataPatchInterface
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
        ThemeResourceModel $themeResourceModel,
        ThemeFactory $themeFactory
    ) {
        
        $this->storeManager = $storeManager;
        $this->configInterface = $configInterface;
        $this->themeResourceModel = $themeResourceModel;
        $this->themeFactory = $themeFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $patinhas = $this->themeFactory->create();
        $this->themeResourceModel->load($patinhas, 'projetofinal_temas/tema_patinhas', 'theme_path');

        $pet2StoreId = $this->storeManager->getStore('petshop_en_view_code')->getId();
        $this->configInterface->saveConfig(
            'design/theme/theme_id', 
            $patinhas->getThemeId(), 
            ScopeInterface::SCOPE_STORES, 
            $pet2StoreId
        );
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}