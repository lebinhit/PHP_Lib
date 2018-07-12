<?php
namespace Forix\Custom\Observer;
use Magento\Framework\Event\ObserverInterface;
class ProductSaveCommitAfter implements ObserverInterface
{
    protected $indexObserver;
    protected $registry;
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Forix\Custom\Model\Observer $indexObserver
    ) {
        $this->indexObserver = $indexObserver;
        $this->registry = $registry;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productIds = [$product->getId()];// $this->registry->registry('updateSimpleProductVisibility');
        if ($productIds) {
            $this->indexObserver->updateProduct($productIds, true);
        }
    }
}