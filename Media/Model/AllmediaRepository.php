<?php

namespace Gtech\Media\Model;

use Gtech\Media\Api\Data;
use Gtech\Media\Api\AllmediaRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Gtech\Media\Model\ResourceModel\Allmedia as ResourceAllmedia;
use Gtech\Media\Model\ResourceModel\Allmedia\CollectionFactory as AllmediaCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AllmediaRepository implements AllmediaRepositoryInterface
{
    protected $resource;

    protected $allmediaFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllmediaFactory;

    private $storeManager;

    public function __construct(
        ResourceAllmedia $resource,
        AllmediaFactory $allmediaFactory,
        Data\AllmediaInterfaceFactory $dataAllmediaFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->allmediaFactory = $allmediaFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllmediaFactory = $dataAllmediaFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Gtech\Media\Api\Data\AllmediaInterface $media)
    {
        if ($media->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $media->setStoreId($storeId);
        }
        try {
            $this->resource->save($media);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the media: %1', $exception->getMessage()),
                $exception
            );
        }
        return $media;
    }

    public function getById($mediaId)
    {
		$media = $this->allmediaFactory->create();
        $media->load($mediaId);
        if (!$media->getId()) {
            throw new NoSuchEntityException(__('Media with id "%1" does not exist.', $mediaId));
        }
        return $media;
    }
	
    public function delete(\Gtech\Media\Api\Data\AllmediaInterface $media)
    {
        try {
            $this->resource->delete($media);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the media: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($mediaId)
    {
        return $this->delete($this->getById($mediaId));
    }
}
