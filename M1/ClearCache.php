<?php
/**
 * Created by PhpStorm.
 * User: johnny
 * Date: 12/07/2018
 * Time: 20:30
 */
Mage::app()->loadArea('adminhtml');
umask(0);
$types = array('full_page','amfpc','block_html');
foreach($types as $type) {
    $tags = Mage::app()->getCacheInstance()->cleanType($type);
    echo $type."\n";
    Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => $type));
}