<?php
require_once dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR . 'abstract.php';

class Cache_Scheduler_Shell_Scheduler extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     * @return void
     */
    public function run()
    {
        Mage::app()->loadArea('adminhtml');
        $deals = Mage::getModel("peexl_dailydeals/deals")->getCollection();
        foreach ($deals as $deal) {

            $dealData = Mage::getModel("peexl_dailydeals/deals")
                ->getCollection()
                ->addFieldToSelect('*')
                ->addSalesData()
                ->setDealProductFilter($deal->getProductId())
                ->getFirstItem();
            echo $dealData->getId() . "\n";
            echo $dealData->getDateStart() . "\n";
            echo $dealData->getDateEnd() . "\n";
            $dateNow = date('Y-m-d H:i') . ":00";
            echo $dateNow . "\n";
            if ($dateNow == $dealData->getDateEnd() || $dateNow == $dealData->getDateStart()) {
                umask(0);
                $types = array('full_page','amfpc','block_html');
                foreach($types as $type) {
                    $tags = Mage::app()->getCacheInstance()->cleanType($type);
                    echo $type."\n";
                    Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => $type));
                }
                break;
            }

        }
    }
}
$shell = new Cache_Scheduler_Shell_Scheduler();
$shell->run();
