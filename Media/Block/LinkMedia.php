<?php
namespace Gtech\Media\Block;

Class LinkMedia extends \Magento\Framework\View\Element\Template
{
	protected $dataHelper;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Gtech\Media\Helper\Data $dataHelper
	){
		parent::__construct($context);
		$this->dataHelper = $dataHelper;
	}
	
	public function getMediaLink()
	{
		$mediaLink = $this->dataHelper->getStorefrontConfig('media_link');
		
		return $mediaLink;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
?>
