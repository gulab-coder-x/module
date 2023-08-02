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
  {
    $data =
      [
        'media_id'=>'1',
        'title' => '1',
        'description' => '1',
        'status' => 'logn description put here'
      ];
    $tableName = 'gtech_media';

    if ($data){
     // $this->logger->debug($data['media_id']);
      if($data['media_id']) {
        $id = $data['media_id'];
        $query = "SELECT title FROM `" . $tableName . "` WHERE media_id = $id ";
        $result = $this->resourceConnection->getConnection()->fetchAll($query);
       // $this->logger->debug(print_r($result));
     
        if (count($result) >0) {
          //$this->logger->debug(print_r(count($result)));
          $where = ["media_id = ?" => $data['media_id']];
          $this->resourceConnection->getConnection()->update($tableName, $data, $where);
        } 
        else{
          unset($data['media_id']);
          $this->resourceConnection->getConnection()->insert($this->resourceConnection->getConnection()->getTableName("gtech_media"), $data);
        }
      }
      if($data['media_id']=="")
      {
        $this->resourceConnection->getConnection()->insert($this->resourceConnection->getConnection()->getTableName("gtech_media"), $data);
      }
    }
  }
}
