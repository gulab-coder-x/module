<?php
namespace Gtech\Media\Controller\Adminhtml\AllMedia;
class NewAction extends \Magento\Backend\App\Action
{
    protected $resultForwardFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    )
    {
        $this->resultForwardFactory=$resultForwardFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Gtech_Media::save');
	}
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
  
?>

