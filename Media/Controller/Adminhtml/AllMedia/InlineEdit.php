<?php
    namespace Gtech\Media\Controller\Adminhtml\Allmedia;

    use Magento\Backend\App\Action\Context;
    use Gtech\Media\Api\AllmediaRepositoryInterface as AllmediaRepository;
    use Magento\Framework\Controller\Result\JsonFactory;
    use Gtech\Media\Api\Data\AllmediaInterface;

    class InlineEdit extends \Magento\Backend\App\Action
    {

        protected $allmediaRespository;
        protected $jsonFactory;
        public function __construct(
            Context $context,
            AllmediaRepository $allmediaRepository,
            JsonFactory $jsonFactory
        ) {
            parent::__construct($context);
            $this->allmediaRepository = $allmediaRepository;
            $this->jsonFactory = $jsonFactory;
        }


        protected function _isAllowed()
        {
            return $this->_authorization->isAllowed('Gtech_Media::save');
        }
        

        public function execute(){
             
            $resultJson = $this->jsonFactory->create();
            $error = False;
            $messages = [];
            
            $postItems = $this->getRequest()->getParam('items',[]);

            if(!($this->getRequest()->getParam('isAjax') && count($postItems))){

                return $resultJson->setData([
                    'messages'=>[__('Please correct data sent')],
                    'error'=>true,
                ]);
            }

            foreach(array_keys($postItems) as $mediaId){
                $media = $this->allmediaRepository->getById($mediaId);
                try {

                    $mediaData = $postItems[$mediaId];
                    $extendedmediaData = $media->getData();
                    $this->setmediaData($media,$extendedmediaData,$mediaData);
                    $this->allmediaRepository->save($media);
                } Catch(\Magento\Framework\Exception\LocalizedException $e){

                    $messages[]=$this->getErrorWithmediaId($media,$e->getMessage());
                    $error = true;
                } Catch(\RuntimeException $e){
                    $messages[] = $this->getErrorWithmediaId($media,$e->getMessage());
                    $error = true;
                } Catch(\Exception $e){
                    $messages[] = $this->getErrorWithId(
                        $media,
                        __('Something went wrong while saving media')
                    );
                    $error = true;
                }
            }
            return $resultJson->setData([

                'messages'=>$messages,
                'error'=>$error,
            ]);
        }
            protected function getErrorWithmediaId(AllmediaInterFace $media,$errorText)
            {
                return '[media ID:'-$media->getId().']'.$errorText;
            }

            public function setmediaData(\Gtech\media\Model\Allmedia $media,array $extendedmediaData,array $mediaData){      

                $media->setData(array_merge($media->getData(),$extendedmediaData,$mediaData));
                return $this;
            }
    }

?>