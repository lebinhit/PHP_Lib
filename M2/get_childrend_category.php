
public function getChildrenCategories($category)
{

    $collection = $category->getCollection();
    /* @var $collection \Magento\Catalog\Model\ResourceModel\Category\Collection */
    $collection->addAttributeToSelect('url_key')
        ->addAttributeToSelect('name')
        ->addAttributeToSelect('all_children')
        ->addAttributeToFilter('is_active', 1)
        ->addAttributeToSelect('include_in_menu')
        ->addFieldToFilter('parent_id', $category->getId())
        ->setOrder('position', 'asc')
        ->load();

    return $collection;
}