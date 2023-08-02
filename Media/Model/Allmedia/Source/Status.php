<?php
namespace Gtech\Media\Model\Allmedia\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public function __construct(\Gtech\Media\Model\Allmedia $allMedia)
    {
        $this->allMedia= $allMedia;
    }

    public function toOptionArray()
    {
        $availableOptions=$this->allMedia->getAvailableStatuses();
        $options=[];
        foreach($availableOptions as $key=>$value)
        {
            $options[]=
            [
                'label'=>$value,
                'value'=>$key
            ];
        }
        return $options;
    }
}
?>

