<?php

namespace Gtech\Media\Cron;

use Gtech\Media\Model\Allmedia;
use \Psr\Log\LoggerInterface;

class Test
{

  protected $logger;
  protected $resourceConnection;

  /**
   * @var \Gtech\Media\Model\AllmediaFactory
   */
  private $allmediaFactory;

  /**
   * @var \Gtech\Media\Api\AllmediaRepositoryInterface
   */
  private $allmediaRepository;

  public function __construct(
    LoggerInterface $logger,
    \Magento\Framework\App\ResourceConnection $resourceConnection,
    \Gtech\Media\Model\AllmediaFactory $allmediaFactory,
    \Gtech\Media\Api\AllmediaRepositoryInterface $allmediaRepository

  ) {
    $this->logger = $logger;
    $this->resourceConnection = $resourceConnection;
    $this->allmediaFactory = $allmediaFactory
      ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Gtech\Media\Model\AllmediaFactory::class);
    $this->allmediaRepository = $allmediaRepository
      ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Gtech\Media\Api\AllmediaRepositoryInterface::class);
  }

  public function insertMultiple($table, $data)
  {
    try {
      $tableName = $this->resourceConnection->getConnection()->getTableName($table);
      return $this->resourceConnection->getConnection()->insertMultiple($tableName, $data);
    } catch (\Exception $e) {
      //$this->messageManager->addException($e, __('Cannot insert data.'));
    }
  }

  public function execute()
  {/**
	 * Get the resource model
	 */
	$resource =$this->resourceConnection;
	
	/**
	 * Retrieve the read connection
	 */
	$readConnection = $resource->getConnection('core_read');
	$tableName = 'catalog_product_entity';
	
 // $query = "SELECT sku FROM `" . $tableName . "` ";
	
  $productId = 8;

  $query = 'SELECT sku FROM ' . $tableName. ' WHERE entity_id = '
			 . (int)$productId;
	/**
	 * Execute the query and store the results in $results
	 */
	$results = $readConnection->fetchone($query);
	
	/**
	 * Print out the results
	 */
	
   $this->logger->debug(print_r($results,true));
  }
}
