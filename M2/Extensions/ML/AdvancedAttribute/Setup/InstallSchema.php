<?php
/**
 * ML_BannerAttribute extension
 *                     NOTICE OF LICENSE
 * 
 *                     This source file is subject to the MIT License
 *                     that is bundled with this package in the file LICENSE.txt.
 *                     It is also available through the world-wide-web at this URL:
 *                     http://opensource.org/licenses/mit-license.php
 * 
 *                     @category  ML
 *                     @package   ML_BannerAttribute
 *                     @copyright Copyright (c) 2016
 *                     @license   http://opensource.org/licenses/mit-license.php MIT License
 */
namespace ML\AdvancedAttribute\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * install tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('ml_attribute_option_banner')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('ml_attribute_option_banner')
            )
            ->addColumn(
                'banner_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Banner Attribute ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_INTEGER,
                10,
                ['nullable => false'],
                'Banner Attribute Id'
            )
            ->addColumn(
                'option_id',
                Table::TYPE_INTEGER,
                10,
                ['nullable => false'],
                'Banner Attribute Option Label'
            )
            ->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                [],
                'Banner Attribute Upload Image'
            )
            ->addColumn(
                'icon_normal',
                Table::TYPE_TEXT,
                255,
                [],
                'Upload Image Icon Nomal'
            ) ->addColumn(
                'icon_hover',
                Table::TYPE_TEXT,
                255,
                [],
                '\'Upload Image Icon Hover'
            ) ->addColumn(
                'logo_attribute',
                Table::TYPE_TEXT,
                255,
                [],
                'Upload Image Logo'
            )
            ->addColumn(
                'content',
                Table::TYPE_TEXT,
                '64k',
                [],
                'Banner Attribute Content'
            )

            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [],
                'Banner Attribute Created At'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                [],
                'Banner Attribute Updated At'
            )
            ->setComment('Banner Attribute Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
