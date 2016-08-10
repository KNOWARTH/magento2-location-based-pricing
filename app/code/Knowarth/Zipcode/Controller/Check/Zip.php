<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Check;

class Zip extends \Magento\Framework\App\Action\Action
{
    public function __construct(
		\Magento\Framework\App\Action\Context $context
		,\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	) {
		parent::__construct($context);
		$this->resultJsonFactory = $resultJsonFactory;
	}

    public function checkZipcode()
    {
        $cookieName = '';
        $PostDataZipcode = $this->getRequest()->getParam('zipcode');
        if(!empty($PostDataZipcode))
        {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $itemCollection = $objectManager->create('Knowarth\Zipcode\Model\Resource\Items\CollectionFactory');

            $collection = $itemCollection->create()
                        ->addFieldToFilter('zipcode',$PostDataZipcode)
                        // ->addAttributeToSelect('*')
                        ->load();

            foreach ($collection as $item){
                  $cookieName  =  $item->getName();
                  break;
            }  
                return $cookieName;
        }
    }
    public function execute()
    {
        if(!empty($this->checkZipcode())){
            $result = $this->resultJsonFactory->create();
            return $result->setData(['success' => true]);
        }else{
            $result = $this->resultJsonFactory->create();
            return $result->setData(['success' => false]);

        }
    }
}
