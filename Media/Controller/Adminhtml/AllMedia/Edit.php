<?php

namespace Gtech\Media\Controller\Adminhtml\Allmedia;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
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
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Allmedia
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allmedia $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Gtech_Media::media_allmedia')
            ->addBreadcrumb(__('Media'), __('Media'))
            ->addBreadcrumb(__('Manage All Media'), __('Manage All Media'));
        return $resultPage;
    }

    /**
     * Edit Allmedia
     *
     * @return \Magento\Backend\Model\View\Result\Allmedia|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('media_id');
        $model = $this->_objectManager->create(\Gtech\Media\Model\Allmedia::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This media no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('media_allmedia', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allmedia $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Media') : __('Add Media'),
            $id ? __('Edit Media') : __('Add Media')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Allmedia'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Media'));

        return $resultPage;
    }
}
