<?php
//Edit link canical
namespace Forix\Vesa\Plugin;
class ManipulateCanonical
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;
    protected $_urlInterface;
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->registry = $registry;
        $this->request = $request;
        $this->_urlInterface = $urlInterface;
    }
    public function beforeAddRemotePageAsset(
        \Magento\Framework\View\Page\Config $subject,
        $url,
        $contentType,
        $properties = [],
        $name = null
    ) {
        if($contentType == 'canonical') {
            if ($this->request->getFullActionName() == 'vesa_index_index') {
                $url = $this->_urlInterface->getUrl('vesa');
            }elseif ($this->request->getFullActionName() == 'tooltip_page_view') {
                $url = $this->_urlInterface->getUrl('components-guide/product-line-colors');
            }
        }
        return [$url, $contentType, $properties, $name];
    }
}