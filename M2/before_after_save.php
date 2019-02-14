<?php
/**
 * @param Observer $observer
 * @return void
 */
public function execute(\Magento\Framework\Event\Observer $observer)
{
    $entity = $observer->getEvent()->getObject();
}