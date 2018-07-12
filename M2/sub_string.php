<?php
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$this->filter = $objectManager->create('\Magento\Framework\Filter\FilterManager');
return $this->filter->truncate(rtrim($name, ', '), ['length' => 20, 'etc' => '...']);