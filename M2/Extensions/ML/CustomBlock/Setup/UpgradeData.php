<?php
namespace ML\CustomBlock\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->removeAttribute(Product::ENTITY, 'colour_box');
            $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'colour_box', [
                'type' => 'text',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'frontend' => '',
                'label' => 'Colour Box',
                'input' => 'multiselect',
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'used_in_product_listing' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
                'option' => ['value' =>
                    [
                        'option_1' => [
                            0 => 'Chocolate to make you smile'
                        ],
                        'option_2' => [
                            0 => 'Best sellers & exclusive flavours',
                        ],
                        'option_3' => [
                            0 => 'Monthly letterbox delivery',
                        ],
                        'option_4' => [
                            0 => 'Perfect gift',
                        ],
                        'option_5' => [
                            0 => '500g of chocolate',
                        ],
                        'option_6' => [
                            0 => 'Best sellers',
                        ],
                        'option_7' => [
                            0 => 'Perfect for sharing',
                        ],
                        'option_8' => [
                            0 => '1000g of chocolate',
                        ],
                        'option_9' => [
                            0 => '8 new flavours',
                        ],
                        'option_10' => [
                            0 => 'Quarterly letterbox delivery',
                        ],
                        'option_11' => [
                            0 => 'Perfect gift for the chocolate connoisseur',
                        ],
                        'option_12' => [
                            0 => '250g of chocolate',
                        ],
                        'option_13' => [
                            0 => 'Vegan',
                        ],
                        'option_14' => [
                            0 => 'Gluten free',
                        ],
                        'option_15' => [
                            0 => 'Organic',
                        ],

                    ],
                    'order' =>
                        [
                            'option_1' => 1,
                            'option_2' => 2,
                            'option_3' => 3,
                            'option_4' => 4,
                            'option_5' => 5,
                            'option_6' => 6,
                            'option_7' => 7,
                            'option_8' => 8,
                            'option_9' => 9,
                            'option_10' => 10,
                            'option_11' => 11,
                            'option_12' => 12,
                            'option_13' => 13,
                            'option_14' => 14,
                            'option_15' => 15,

                        ]
                ],
            ]);
            $entityTypeId = $eavSetup->getEntityTypeId(Product::ENTITY);
            $attributeSetIds = $eavSetup->getAllAttributeSetIds($entityTypeId);
            foreach ($attributeSetIds as $attributeSetId) {
                $groupId = $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, "General");
                $eavSetup->addAttributeToGroup(
                    $entityTypeId,
                    $attributeSetId,
                    $groupId,
                    'colour_box',
                    null
                );
            }
            $setup->endSetup();
        }

    }
}