<?php
namespace ML\CustomBlock\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ProgressBar
 * @package Mageplaza\ImageOptimizer\Block\Adminhtml
 */
class CustomBlock extends Template
{

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    protected $storeManager;

    /**
     * ProgressBar constructor.
     *
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Data $helperData
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }
    public function getHowItWorkData(){
        $store = $this->storeManager->getStore();
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter($store);
        $collection->addFieldToFilter('is_active', ['in' => 1]);
        $collection->addFieldToFilter('identifier', array('like' => 'how_it_work_%'));
        return $collection;
    }
    public function getMoreInformation(){
        $store = $this->storeManager->getStore();
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter($store);
        $collection->addFieldToFilter('is_active', ['in' => 1]);
        $collection->addFieldToFilter('identifier', array('like' => 'more_information_%'))->setOrder('`order`', 'asc');
        return $collection;
    }
    public function getImageUrl($image_name){
        $media_url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $media_url."customblock/feature/".$image_name;
    }

}
