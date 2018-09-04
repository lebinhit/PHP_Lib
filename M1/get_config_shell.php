<?php
require_once dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR . 'abstract.php';

class Cache_Scheduler_Shell_Config extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     * @return void
     */
    public function run()
    {
        echo Mage::getStoreConfig('payment/authorizenet_directpost/login')."\n";
        echo Mage::getStoreConfig('payment/authorizenet_directpost/trans_key')."\n";
        echo Mage::getStoreConfig('payment/authorizenet_directpost/trans_md5')."\n";

    }
}
$shell = new Cache_Scheduler_Shell_Config();
$shell->run();
