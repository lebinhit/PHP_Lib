<?php
namespace ML\AdvancedAttribute\Block\Adminhtml\Options\Edit\Tab;

use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    const IS_ACTIVE_YES = 1;
    const IS_ACTIVE_NO = 2;

    protected $objectManager;
    protected $_request;
    protected $_optionModel;
    protected $_existBannerOptions = array();
    protected $_optionHelper;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        WysiwygConfig $wysiwygConfig,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Eav\Api\AttributeRepositoryInterface $eavAttributeRepository,
        \Magento\Framework\App\Request\Http $request,
        \ML\AdvancedAttribute\Model\OptionFactory $optionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute,
        \ML\AdvancedAttribute\Helper\Option $optionHelper,

        array $data = []
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->objectManager = $eavAttributeRepository;
        $this->_request = $request;
        $this->wysiwygConfig = $wysiwygConfig;
        $this->_optionModel = $optionFactory;
        $this->_registry = $registry;
        $this->_optionHelper = $optionHelper;

    }

    /**
     * Add fields to base fieldset which are general to sales reports
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $htmlIdPrefix = 'rule_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $form->setFieldNameSuffix('options');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Option Form')]);
        $_attributeCode = $this->_request->getParam('attrcode');
        $_attributeId = $this->_request->getParam('attrid');

        $fieldset->addField('attribute_code', 'hidden', ['name' => 'attribute_code', 'value' => $_attributeCode]);
        $fieldset->addField('attribute_id', 'hidden', ['name' => 'attribute_id', 'value' => $_attributeId]);
        $fieldset->addType('image', 'ML\AdvancedAttribute\Block\Adminhtml\Options\Helper\Image');

        $fieldset->addField(
            'option_id',
            'select',
            [
                'name' => 'option_id',
                'options' => $this->getAllOptionAttribute($_attributeCode),
                'label' => __('Select Option'),
                'required' => true
            ]
        );

       /* $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Upload Banner'),
                'title' => __('Upload Banner'),
                'note' => 'Use for main image background filter in homepage.'
            ]
        );*/
        $fieldset->addField(
            'icon_normal',
            'image',
            [
                'name' => 'icon_normal',
                'label' => __('Icon'),
                'title' => __('Icon'),
                'note' => 'Use for thumbnail background filter in homepage.'
            ]
        );
        /*$fieldset->addField(
            'icon_hover',
            'image',
            [
                'name' => 'icon_hover',
                'label' => __('Icon hover'),
                'title' => __('Icon hover'),
            ]
        );
        $fieldset->addField(
            'logo_attribute',
            'image',
            [
                'name' => 'logo_attribute',
                'label' => __('Logo'),
                'title' => __('Logo'),
            ]
        );*/

        $fieldset->addField(
            'hex_color_code',
            'text',
            [
                'name' => 'hex_color_code',
                'label' => __('Hex Color Code'),
                'title' => __('Hex Color Code'),
                'note' => 'Hex Color Code. Not include #'
            ]
        );

        /*$fieldset->addField(
            'color_code',
            'text',
            [
                'name' => 'color_code',
                'label' => __('Color Code'),
                'title' => __('Color Code'),
                'note' => 'Color Code. Not include #'
            ]
        );*/

        /*$fieldset->addField(
            'url_key',
            'text',
            [
                'name' => 'url_key',
                'label' => __('Url Key'),
                'title' => __('Url Key'),
                'note' => 'Not Duplicate. Maximum 250 chars'
            ]
        );
        
        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Content'),
                'title' => __('Content'),
                'config' => $this->wysiwygConfig->getConfig()
            ]
        );*/

        /*$fieldset->addField(
            'html_title',
            'editor',
            [
                'name' => 'html_title',
                'label' => __('Html Title'),
                'title' => __('Html Title'),
                'config' => $this->wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Content'),
                'title' => __('Content'),
                'config' => $this->wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            'page_title',
            'text',
            [
                'name' => 'page_title',
                'label' => __('Page Title'),
                'title' => __('Page Title')
            ]
        );
        $fieldset->addField(
            'meta_keywords',
            'textarea',
            [
                'name' => 'meta_keywords',
                'label' => __('Meta Keywords'),
                'title' => __('Meta Keywords')
            ]
        );
        $fieldset->addField(
            'meta_description',
            'textarea',
            [
                'name' => 'meta_description',
                'label' => __('Meta Description'),
                'title' => __('Meta Description')
            ]
        );
        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Position'),
                'title' => __('Position')
            ]
        );*/

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'options' => array(self::IS_ACTIVE_YES => 'Yes', self::IS_ACTIVE_NO => 'No'),
                'label' => __('Active'),
                'title' => __('Active')
            ]
        );

        $bannerId = (int)$this->getRequest()->getParam('id');
        if ($bannerId > 0) {
            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id', 'value' => $bannerId]);
            $optionBanner = $this->_registry->registry('current_banner_option');
            $form->addValues($optionBanner->getData());
        } else {
            $optionBanner = $this->_optionModel->create();
            $form->addValues($optionBanner->getDefaultValues());
        }


        //$form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Get option for attribute
     *
     * @param string attribute code
     * @return array
     */
    protected function getAllOptionAttribute($attributeCode)
    {
        // Access to the attribute interface
        $attribute = $this->objectManager->get(\Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE, $attributeCode);

        $result = array();
        // Get an array of options
        $options = $attribute->getOptions();
        $bannerOptionId = $this->_request->getParam('id');
        if (!empty($bannerOptionId)) {
            $currentOption = $this->_registry->registry('current_banner_option');
            if ($currentOption->getOptionId()) {
                $optionId = $currentOption->getOptionId();
            }
        }
        if (!empty($optionId)) {
            foreach ($options as $option) {
                if ($optionId == $option->getValue()) {
                    $result[$option->getValue()] = $option->getLabel();
                    break;
                }
            }
        } else {
            $this->_existBannerOptions = $this->_optionHelper->getExistBannerOptionsByAttributeId($this->_request->getParam('attrid'));
            foreach ($options as $option) {
                if (in_array($option->getValue(), $this->_existBannerOptions)) {
                    continue;
                }
                $result[$option->getValue()] = $option->getLabel();

            }
        }

        return $result;
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Main');
    }
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Main');
    }
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

}