<?php
/**
 * @author Johnny
 */
/** @var Amasty_Brands_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

/**
 *  Create CMS Page
 */
$identifier = 'block_header_before_nav_dropdown';
if (!Mage::getModel('cms/block')->load($identifier, 'identifier')->getId()) {
    $cmsBlockData = array(
        'title' => 'Brands',
        'identifier' => $identifier,
        'is_active' => 1,
        'content' =>'
        {{block type="ambrands/slider" template="amasty/ambrands/slidermenu.phtml"}}
        {{block type="ambrands/list" template="amasty/ambrands/listmenu.phtml"}}',
        'stores' => array(0),//available for all store views
    );
    Mage::getModel('core/config')->saveConfig('ambrands/brands_landing/display_type', 'vertical');
    Mage::getModel('core/config')->saveConfig('ambrands/brands_landing/columns_num', 7);
    Mage::getModel('cms/block')->setData($cmsBlockData)->save();
}

$installer->endSetup();
