<?php
namespace Forix\Custom\Model;
use Magento\CatalogSearch\Model\Indexer\Fulltext;
use Magento\Framework\App\ResourceConnection;
class Observer
{
    protected $_productCollectionFactory;
    protected $_productAction;
    protected $_logger;
    protected $_storeManager;
    protected $_configurableType;
    protected $_productFactory;
    /**
     * Application Cache Manager
     *
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $_cacheManager;
    /**
     * @var \Magento\Framework\EntityManager\MetadataPool
     */
    protected $metadataPool;
    /**
     * @var \Magento\Framework\App\Resource
     */
    protected $resource;
    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $_connection;
    protected $eavAttributeIndexerProcessor;
    protected $flatIndexerProcessor;
    protected $indexerRegistry;
    protected $cacheContext;
    protected $eventManager;
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\Product\Action $productAction,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $configurableType,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Catalog\Model\Indexer\Product\Eav\Processor $eavAttributeIndexerProcessor,
        \Magento\Catalog\Model\Indexer\Product\Flat\Processor $flatIndexerProcessor,
        \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry,
        \Magento\Framework\Indexer\CacheContext $cacheContext,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        ResourceConnection $resource
    ) {
        $this->resource = $resource;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productAction = $productAction;
        $this->_logger = $logger;
        $this->_storeManager = $storeManager;
        $this->_configurableType = $configurableType;
        $this->_productFactory = $productFactory;
        $this->_connection = $resourceConnection->getConnection();
        $this->eavAttributeIndexerProcessor = $eavAttributeIndexerProcessor;
        $this->indexerRegistry = $indexerRegistry;
        $this->cacheContext = $cacheContext;
        $this->eventManager = $eventManager;
        $this->flatIndexerProcessor = $flatIndexerProcessor;
        $this->_cacheManager = $context->getCacheManager();
    }
    /**
     * @return \Magento\Framework\EntityManager\MetadataPool
     */
    protected function getMetadataPool()
    {
        if (null === $this->metadataPool) {
            $this->metadataPool = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magento\Framework\EntityManager\MetadataPool');
        }
        return $this->metadataPool;
    }
    /**
     * Get real table name for db table, validated by db adapter
     *
     * @param string $tableName
     * @return string
     * @api
     */
    public function getTable($tableName)
    {
        return $this->resource->getTableName($tableName);
    }
    /**
     * @param $productIds
     * @param bool|true $clearCache
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateProduct($productIds, $clearCache = true)
    {
        $clearCache = true;
        $productCollection = $this->_productCollectionFactory->create();
        $connection = $productCollection->getConnection();
        $productIndexIds = $productIds;
        $getParent = $connection->select()
            ->from(['parent' => $this->getTable('catalog_product_entity')], '')
            ->joinInner(
                ['link' => $this->getTable('catalog_product_relation')],
                "link.parent_id = parent.entity_id",
                ['parent_id']
            )->group('parent_id')->where('link.child_id IN(?)', $productIds);
        $parents = $connection->fetchCol($getParent);
        foreach ($parents as $parent){
            $productIndexIds[] = $parent;
        }
        // Reindex and clean cache
        if (count($productIndexIds)) {
            $productIndexIds = array_unique($productIndexIds);
            $this->flatIndexerProcessor->reindexList($productIndexIds);
            $this->eavAttributeIndexerProcessor->reindexList($productIndexIds);
//            $this->reindexFullTextSearchList($productIndexIds);
            //$this->_cacheManager->clean();
            if ($clearCache) {
                // Clear cache
                $this->cacheContext->registerEntities(\Magento\Catalog\Model\Product::CACHE_TAG, $productIndexIds);
                $select = $connection->select()
                    ->distinct(true)
                    ->from($connection->getTableName('catalog_category_product'), ['category_id'])
                    ->where('product_id IN(?)', $productIndexIds);
                $affectedCategories = $connection->fetchCol($select);
                $cats = array();
                foreach ($affectedCategories as $cat){
                    $cats[] = $cat;
                    $this->_cacheManager->clean('catalog_category_' . $cat);
                }
                $this->cacheContext->registerEntities(\Magento\Catalog\Model\Category::CACHE_TAG, $cats);
                $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $this->cacheContext]);
            }
        }
        return $this;
    }
    /**
     * Reindex by product if indexer is not scheduled
     *
     * @param int[] $productIds
     * @param $fetchSameColor
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function reindexFullTextSearchList(array $productIds)
    {
        $indexer = $this->indexerRegistry->get(Fulltext::INDEXER_ID);
        if (!$indexer->isScheduled()) {
            $neiCollection = $this->_productCollectionFactory->create();
            if ($this->_storeManager->isSingleStoreMode()) {
                $neiCollection->setStoreId(0);
            }
            $neiCollection->getSelect()
                ->reset('columns')
                ->columns('e.entity_id')
                ->where('e.entity_id in (?)', $productIds);
            $neiCollection->addAttributeToFilter('visibility', array('in' => array(
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH,
            )));
            $productIds = $neiCollection->getConnection()->fetchCol($neiCollection->getSelect());
            if ($productIds) {
                $productIds = array_unique($productIds);
                $indexer->reindexList($productIds);
            }
        }
    }
}