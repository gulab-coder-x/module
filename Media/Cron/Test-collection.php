<?php

namespace Gtech\Media\Cron;

use Gtech\Media\Model\Allmedia;
use \Psr\Log\LoggerInterface;

class Test
{

  protected $logger;

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
    \Gtech\Media\Model\AllmediaFactory $allmediaFactory = null,
    \Gtech\Media\Api\AllmediaRepositoryInterface $allmediaRepository = null

  ) {

    $this->allmediaFactory = $allmediaFactory
      ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Gtech\Media\Model\AllmediaFactory::class);
    $this->allmediaRepository = $allmediaRepository
      ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Gtech\Media\Api\AllmediaRepositoryInterface::class);
    $this->logger = $logger;
  }

  public function execute()
  {
    $data = [
      [
        'media_id' => '2',
        'title' => 'Hello 2',
        'description' => 'Hello world! 2',
        'status' => 'logn description put here'
      ],
      [
        'title' => 'new title ',
        'description' => 'new description',
        'status' => 'logn description put here'
      ],
      [
        'media_id' => '5',
        'title' => 'Hello 6',
        'description' => 'Hello world! 5',
        'status' => 'logn description put here'
      ],
      [
        'title' => 'new title ',
        'description' => 'new description',
        'status' => 'logn description put here'
      ]
    ];
    $post = $this->allmediaFactory->create();
    $collection = $post->getCollection();

    //Logic To Update
    foreach ($collection as $item) {
      // $this->logger->debug($item->getData('media_id'). $data['media_id']); 
      if (isset($data['media_id'])) {
        if ($item->getData('media_id') == $data['media_id']) {
          $item->setData('title', $data['title']);
          $item->setData('description', $data['description']);
          $item->save();
        }
      }
    }

    //Logic To Insert New Row In DB
    if (!isset($data['media_id'])) {

      foreach ($data as $media) {
        $this->allmediaFactory->create()->setData($media)->save();
      }
    }

    $this->logger->info('Cron Works');
  }
}
