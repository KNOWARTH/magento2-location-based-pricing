<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Import;

class Save extends \Knowarth\Zipcode\Controller\Adminhtml\Import
{
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $model = $this->_objectManager->create('Knowarth\Zipcode\Model\Import');
                $modelZipcode = $this->_objectManager->create('Knowarth\Zipcode\Model\Import\Zipcode');                
                $data = $this->getRequest()->getPostValue();                
     
                $inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }
                $model->setData($data);
                $modelZipcode->csvToArray($data,$_FILES['name']['tmp_name']);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('knowarth_zipcode/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('knowarth_zipcode/items/index');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('knowarth_zipcode/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('knowarth_zipcode/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('knowarth_zipcode/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('knowarth_zipcode/items/index');
    }
}
