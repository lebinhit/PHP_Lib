<?php
$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sw.log');
$logger = new \Zend\Log\Logger();
$logger->addWriter($writer);
$logger->info($e->getMessage());
$logger->info(print_r($exportedShippingAddress, true));