<?php
namespace Gtech\Media\Block;

Class SingleMedia extends \Magento\Framework\View\Element\Template
{
	protected $allMediaFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Gtech\Media\Model\AllmediaFactory $allMediaFactory
	){
		parent::__construct($context);
		$this->allMediaFactory = $allMediaFactory;
	}
	
    public function getMedia()
    {
        $id=$this->getRequest()->getParam('id');
        $media=$this->allMediaFactory->create()->load($id);
        return  $media;
    }
    protected function _prepareLayout()
    {
        parent ::_prepareLayout();
        $media=$this->getMedia();
        $this->pageConfig->getTitle()->set($media->getTitle());

        return $media;
    }
}
?>
