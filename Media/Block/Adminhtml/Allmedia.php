<?php
 namespace Gtech\Media\Block\Adminhtml;

 class AllMedia extends \Magento\Backend\Block\Widget\Grid\Container
 {
    protected function __construct()
    {
        $this->_controller ='adminhtml_allmedia';
        $this->_blockGroup ='Gtech_Media';
        $this->_header= __('Manage Media');

        parent:: _construct();

        if($this->isAllowedAction('Gtech::save'))
        {
            $this->buttonList->update('add','label',__('Add Media'));
        }
        else
        {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        $this->_authorization->isAllowed($resourceId);
    }
 }
?>
                                                             
                                                             