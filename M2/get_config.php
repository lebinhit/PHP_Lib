<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use \Magento\Framework\App\Bootstrap;
require 'app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('base');
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$config = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');
echo $config->getValue('carriers/shipper/api_key').'<br/>';
$pass = $config->getValue('carriers/shipper/password');

$_encryptor = $objectManager->create('\Magento\Framework\Encryption\EncryptorInterface');
$_encryptor->decrypt($pass);