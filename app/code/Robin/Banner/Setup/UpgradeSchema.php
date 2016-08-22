<?php
namespace Robin\Banner\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('banner');

        // Check if the table is not exists
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
            )->addColumn(
                'sort_order',
                Table::TYPE_SMALLINT,
                255,
                ['nullable' => false, 'default' => 0]
            )->addColumn(
                'status',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => false]
            )->setOption('charset', 'utf8');

            $connection->createTable($table);
        } else {
            // Add column "sort_order" and "status"
            $setup->run("ALTER TABLE " . $tableName . " ADD COLUMN sort_order SMALLINT, ADD COLUMN status BOOLEAN;");
        }

        $setup->endSetup();
    }
}