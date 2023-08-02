<?php
namespace Gtech\Media\Block\Adminhtml\Allmedia\Edit;

use Magento\Backend\Block\Widget\Context;
use Gtech\Media\Api\AllmediaRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allmediaRepository;
    
    public function __construct(
        Context $context,
        AllmediaRepositoryInterface $allmediaRepository
    ) {
        $this->context = $context;
        $this->allmediaRepository = $allmediaRepository;
    }

    public function getMediaId()
    {
        try {
            return $this->allmediaRepository->getById(
                $this->context->getRequest()->getParam('media_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
?>
