<?php
namespace Gtech\Media\Controller\Adminhtml\Allmedia;

use Magento\Backend\App\Action;
use Gtech\Media\Model\Allmedia;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Gtech\Media\Model\AllmediaFactory
     */
    private $allmediaFactory;

    /**
     * @var \Gtech\Media\Api\AllmediaRepositoryInterface
     */
    private $allmediaRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Gtech\Media\Model\AllmediaFactory $allmediaFactory
     * @param \Gtech\Media\Api\AllmediaRepositoryInterface $allmediaRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Gtech\Media\Model\AllmediaFactory $allmediaFactory = null,
        \Gtech\Media\Api\AllmediaRepositoryInterface $allmediaRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->allmediaFactory = $allmediaFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Gtech\Media\Model\AllmediaFactory::class);
        $this->allmediaRepository = $allmediaRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Gtech\Media\Api\AllmediaRepositoryInterface::class);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Gtech_Media::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Allmedia::STATUS_ENABLED;
            }
            if (empty($data['media_id'])) {
                $data['media_id'] = null;
            }

            /** @var \Gtech\Media\Model\Allmedia $model */
            $model = $this->allmediaFactory->create();

            $id = $this->getRequest()->getParam('media_id');
            if ($id) {
                try {
                    $model = $this->allmediaRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This media no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'media_allmedia_prepare_save',
                ['allmedia' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allmediaRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the media.'));
                $this->dataPersistor->clear('media_allmedia');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['media_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the media.'));
            }

            $this->dataPersistor->set('media_allmedia', $data);
            return $resultRedirect->setPath('*/*/edit', ['media_id' => $this->getRequest()->getParam('media_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
