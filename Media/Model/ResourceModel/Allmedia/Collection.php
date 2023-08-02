<?php
namespace Gtech\Media\Model\ResourceModel\Allmedia;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName='media_id';
    protected $_eventPrefix='media_allmedia_collection';
    protected $_eventObject='allmedia_collection';

    protected function _construct()
    {
        $this->_init('Gtech\Media\Model\Allmedia','Gtech\Media\Model\ResourceModel\Allmedia');
    }
}
?>


