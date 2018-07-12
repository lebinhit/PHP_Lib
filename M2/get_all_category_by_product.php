<?php
/**
 * Created by PhpStorm.
 * User: johnny
 * Date: 12/07/2018
 * Time: 15:25
 */
if (!$product instanceof \Magento\Catalog\Model\Product) {
    return false;
}
$catIds = $product->getCategoryIds();
if (!count($catIds)) {
    return false;
}
$collection = $this->_categoryCollectionFactory->create()
    ->addFieldToFilter('entity_id', ['in' => $catIds])
    ->addFieldToFilter('is_active', 1)
    ->addFieldToFilter('url_key', 'deal-of-the-week')
    ->addAttributeToSelect('url_key')
    ->addAttributeToSelect(['name']);
if (!$collection->getSize()) {
    return false;
}
return true;