<?php
namespace Gtech\Media\Block;

Class ListMedia extends \Magento\Framework\View\Element\Template
{
	protected $allMediaFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Gtech\Media\Model\AllmediaFactory $allMediaFactory
	){
		parent::__construct($context);
		$this->allMediaFactory = $allMediaFactory;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListMedia()
	{
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 2;
		
		$collection = $this->allMediaFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		$collection->setCurPage($page);
	
		return $collection;
	}
	
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$this->pageConfig->getTitle()->set(__('Latest Media'));
		
		if ($this->getListMedia()){
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'gtech.media.pager')
									->setAvailableLimit(array(2=>2,10=>10,15=>15,20=>20))
									->setShowPerPage(true)
									->setCollection($this->getListMedia());

			$this->setChild('pager', $pager);
			$this->getListMedia()->load();
		}
        return $this;
	}
	
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
}
?>
