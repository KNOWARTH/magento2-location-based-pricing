<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */
namespace Knowarth\Zipcode\Block;

class CheckZip extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Customer\Model\Session $customerSession,  
    \Magento\Framework\ObjectManagerInterface $objectManager,
    array $data = []
 ) {
    parent::__construct($context, $data);
    $this->_customerSession = $customerSession;
    $this->_objectManager = $objectManager;
  }
    public function getCustomerSession() 
    {
        return $this->_customerSession;
    }
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
    public function setSessionData($key, $value)
    {
        return $this->_customerSession->setData($key, $value);
    }

    public function getSessionData($key, $remove = false)
    {
        return $this->_customerSession->getData($key, $remove);
    }
    public function checkZipcode()
    {
        $PostDataZipcode = $this->getRequest()->getParam('zipcode');
        if(!empty($PostDataZipcode))
        {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $productCollection = $objectManager->create('Knowarth\Zipcode\Model\Resource\Items\CollectionFactory');

            $collection = $productCollection->create()
                        ->addFieldToFilter('zipcode',$PostDataZipcode)
                        // ->addAttributeToSelect('*')
                        ->load();

            foreach ($collection as $product){
                  $Name  =  $product->getName();
                  break;
            }  
            $this->setSessionData('zip','valid');
            return $Name;
            
        }
    }
    public function getTitle(){
        return "static block";
        }
}
