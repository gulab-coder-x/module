<?php
namespace Gtech\Media\Model;
use Gtech\Media\Api\Data\AllmediaInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Allmedia extends AbstractModel implements AllmediaInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const CACHE_TAG= 'gtech_media';
    protected $_cacheTag= self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init('Gtech\Media\Model\ResourceModel\Allmedia');
    }

    public function getIdentities()
    {
        return[self::CACHE_TAG.'_'. $this->getId()];
    }
    public function getDefaultValues()
    {
        $values=[];
        return $values;
    }
    public function getAvailableStatuses()
    {
        return[self::STATUS_ENABLED => __('Enabled'),self::STATUS_DISABLED => __('Disabled')];
    }

    public function getId()
    {
        return parent::getData(self::MEDIA_ID);
    }

    public function getTitle()
    {
        return parent::getData(self::TITLE);
    }

    public function getDescription()
    {
        return parent::getData(self::DESCRIPTION);
    }

    public function getStatus()
    {
        return parent::getData(self::STATUS);
    }

    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }  

    
    public function setId($id)
    {
        return $this->getData(self::MEDIA_ID,$id);
    }

    public function setTitle($title)
    {
        return $this->getData(self::TITLE,$title);
    }


    public function setDescription($description)
    {
        return $this->getData(self::DESCRIPTION,$description);
    }


    public function setStatus($status)
    {
        return $this->getData(self::STATUS,$status);
    }

    public function setCreatedAt($created_at)
    {
        return $this->getData(self::CREATED_AT,$created_at);
    }

    public function setUpdatedAt($updated_at)
    {
        return $this->getData(self::UPDATED_AT,$updated_at);
    }

}
?>