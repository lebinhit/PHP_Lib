<?php

namespace ML\CustomBlock\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        $connection->addColumn('cms_block','base_image',['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,'comment' => 'Base Image']);
        $connection->addColumn('cms_block','order',['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,'comment' => 'Order']);
        $installer->endSetup();
    }
}
