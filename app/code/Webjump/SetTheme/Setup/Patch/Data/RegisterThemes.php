<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webjump\SetTheme\Setup\Patch\Data;

use Magento\Theme\Model\Theme\Registration;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class RegisterThemes
 * @package Magento\Theme\Setup\Patch
 */
class RegisterThemes implements DataPatchInterface
{

    private WriterInterface $writer;
    
    private StoreManagerInterface $storeManager;


    /**
     * RegisterThemes constructor.
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param Registration $themeRegistration
     */
    public function __construct(
        StoreManagerInterface $storeManager, 
        WriterInterface $writer
    ) {
        $this->writer = $writer;
        $this->storeManager = $storeManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $fanonStoreId = $this->storeManager->getStore('sneakers_view_code')->getId();

        $this->writer->save(
            'design/theme/theme_id',
            4,
            'stores',
            $fanonStoreId
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
