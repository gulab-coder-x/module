<?php
namespace Gtech\Media\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		/** gtech_media is the table name **/
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('gtech_media')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('gtech_media')
			)
      ->addColumn(
        'media_id',
        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        null,
        ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
        'Media ID'
    )
    ->addColumn(
        'title',
        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
        255,
        ['nullable' => false, 'default' => ''],
          'Title'
    )
    ->addColumn(
        'description',
        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
        null,
        ['nullable' => false, 'default' => ''],
          'Description'
    )
    ->addColumn(
        'status',
        \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
        null,
        ['nullable' => false, 'unsigned' => true],
          'Status'
    )
    ->addColumn(
      'created_at',
      \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
      null,
      ['nullable' => false, 
      'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
      'Created At'
    )->addColumn(
      'updated_at',
      \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
      null,
      ['nullable' => false, 
      'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
      'Updated At')
			->setComment('Media Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('gtech_media'),
				$setup->getIdxName(
					$installer->getTable('gtech_media'),
					['title','description'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['title','description'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}
?>