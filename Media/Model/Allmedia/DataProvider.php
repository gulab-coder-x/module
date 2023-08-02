<?php
namespace Gtech\Media\Model\Allmedia;

use Gtech\Media\Model\ResourceModel\Allmedia\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Gtech\Media\Model\ResourceModel\Allmedia\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $allmediaCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $allmediaCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $allmediaCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta 
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $media \Gtech\Media\Model\Allmedia */
        foreach ($items as $media) {
            $this->loadedData[$media->getId()] = $media->getData();
        }

        $data = $this->dataPersistor->get('media_allmedia');
        if (!empty($data)) {
            $media = $this->collection->getNewEmptyItem();
            $media->setData($data);
            $this->loadedData[$media->getId()] = $media->getData();
            $this->dataPersistor->clear('media_allmedia');
        }

        return $this->loadedData;
    }
}
