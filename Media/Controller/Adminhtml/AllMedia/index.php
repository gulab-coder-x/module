<?php
namespace Gtech\Media\Controller\Adminhtml\AllMedia;
class Index extends \Magento\Backend\App\Action
{
         protected $resultPageFactory;  
        protected $helperData;
         public function __construct(
                 \Magento\Backend\App\Action\Context $context,
                 \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                 \Gtech\Media\Helper\Data $helperData
         ) {
                 parent::__construct($context);
                 $this->resultPageFactory = $resultPageFactory;
                 $this->helperData=$helperData;
         } 
         public function execute()
         {
                // $this->helperData->RandomFunc();
                // echo $this->helperData->getGenralConfig('social_link');
                // exit();
                  $resultPage = $this->resultPageFactory->create();
                  $resultPage->getConfig()->getTitle()->prepend(__('All Media'));
                  return $resultPage;
         }
}
?>


