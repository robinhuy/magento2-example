<?php
namespace Robin\Banner\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('banner');

        // Check if the table already exists
        if ($connection->isTableExists($tableName) != true) {
            // Create table
            $table = $connection->newTable($tableName)->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => '']
            )->addColumn(
                'link',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => '']
            )->setOption('charset', 'utf8');

            $connection->createTable($table);
        }

        $setup->endSetup();
    }
}