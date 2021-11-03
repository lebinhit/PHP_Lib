<?php

namespace ML\AdvancedAttribute\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '2.0.1') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'conditions_serialized',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Attribute conditions'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.2') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'hex_color_code',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Hex Color Code'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.3') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'page_title',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Page Title'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'meta_keywords',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Meta Keywords'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'meta_description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Meta Description'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.4') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'is_active',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'comment' => 'Is Active'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.5') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'html_title',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Html Title'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.6') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'sort_order',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    '1M',
                    'nullable' => true,
                    'comment' => 'Position'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.0.7') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'url_key',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Url Key'
                ]
            );
            $installer->getConnection()->query('ALTER TABLE `ml_attribute_option_banner` ADD UNIQUE(`url_key`)');
        }

        if (version_compare($context->getVersion(), '2.0.8') < 0) {
            $installer->getConnection()->addColumn(
                $installer->getTable('ml_attribute_option_banner'),
                'color_code',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Color Code'
                ]
            );
        }

        $installer->endSetup();
    }
}