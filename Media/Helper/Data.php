<?php
namespace Gtech\Media\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper{
    const XML_PATH_GTECH_MEDIA='gtech_media/';

    public function getConfigValue($field,$storeCode=null)
    {
       return $this->scopeConfig->getValue($field,ScopeInterface::SCOPE_STORE,$storeCode);
    }

    public function getGenralConfig($feildid,$storeCode=null)
    {
       return $this->getConfigValue(self::XML_PATH_GTECH_MEDIA.'general/'.$feildid,$storeCode);
    }

    public function getStorefrontConfig($feildid,$storeCode=null)
    {
       return $this->getConfigValue(self::XML_PATH_GTECH_MEDIA.'storefront/'.$feildid,$storeCode);
    }
    public function RandomFunc()
    {
            echo "This is Helper in Magento 2";
    }

}
?>


