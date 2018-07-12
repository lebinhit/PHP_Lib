<?php

$object_manager = \Magento\Framework\App\ObjectManager::getInstance();
$helper = $object_manager->get('\Magento\CustomerBalance\Helper\Data');


$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$product = $objectManager->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory')
    ->create()->addFieldToSelect('*')
    ->addFieldToFilter('entity_id', $alert->getProductId())->getFirstItem();