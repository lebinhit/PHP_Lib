<?php
/**
 * Created by PhpStorm.
 * User: johnny
 * Date: 27/07/2018
 * Time: 16:15
 */
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
if($storeManager->getStore()->getCode() == '') {

}