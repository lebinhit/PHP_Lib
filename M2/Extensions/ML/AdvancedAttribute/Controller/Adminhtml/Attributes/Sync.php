<?php
namespace ML\AdvancedAttribute\Controller\Adminhtml\Attributes;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class Sync extends Action
{
    protected $_optionHelper;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(\Magento\Backend\App\Action\Context $context,
                                \ML\AdvancedAttribute\Helper\Option $optionHelper
    )
    {
        parent::__construct($context);
        $this->_optionHelper = $optionHelper;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $attributeId = $this->getRequest()->getParam('attrid');
        $attributeCode = $this->getRequest()->getParam('attrcode');
        if (!$attributeId || !$attributeCode) {
            $this->messageManager->addError(
                __('Attribute not exist!!!')
            );
            return $this->_redirect('*/*/manage', ['_current' => true]);
        }
        
        try {
            $existBannerOptions = $this->_optionHelper->getExistBannerOptionsByAttributeId($attributeId);
            $attributeOptions = $this->_optionHelper->getAllOptionAttribute($attributeCode);
            if (empty($attributeOptions)) {
                if (!empty($existBannerOptions)) {
                    foreach ($existBannerOptions as $value) {
                        $model = $this->_objectManager->create('ML\AdvancedAttribute\Model\Option');
                        $model->load($value, 'option_id');
                        if ($model->getBannerId()) {
                            $model->delete();
                        }
                    }
                    $this->messageManager->addSuccess(__('Sync successfully!!!'));
                } else {
                    $this->messageManager->addError(
                        __('Attribute Options not exist!!!')
                    );
                }
                return $this->_redirect('*/*/manage', ['_current' => true]);
            }
            $attributeOptionValues = array_keys($attributeOptions);
            $newOptions = array_diff($attributeOptionValues, $existBannerOptions);
            if (!empty($newOptions)) {
                foreach ($newOptions as $value) {
                    $model = $this->_objectManager->create('ML\AdvancedAttribute\Model\Option');
                    $model->setData('attribute_id', $attributeId);
                    $model->setData('option_id', $value);
                    $model->setData('is_active', \ML\AdvancedAttribute\Block\Adminhtml\Options\Edit\Tab\Main::IS_ACTIVE_YES);
                    $model->save();
                }
            }
            $deletedOptions = array_diff($existBannerOptions, $attributeOptionValues);
            if (!empty($deletedOptions)) {
                foreach ($deletedOptions as $value) {
                    $model = $this->_objectManager->create('ML\AdvancedAttribute\Model\Option');
                    $model->load($value, 'option_id');
                    if ($model->getBannerId()) {
                        $model->delete();
                    }
                }
            }
            $this->messageManager->addSuccess(__('Sync successfully!!!'));

        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('Something went wrong while Sync. Please try again!!!')
            );
            return $this->_redirect('*/*/manage', ['_current' => true]);
        }

        return $this->_redirect('*/*/manage', ['_current' => true]);
    }
}