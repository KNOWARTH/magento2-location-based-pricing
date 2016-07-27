<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Import;

class Edit extends \Knowarth\Zipcode\Controller\Adminhtml\Import
{

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Knowarth\Zipcode\Model\Import');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $this->_redirect('knowarth_zipcode/*');
                return;
            }
        }
        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->_coreRegistry->register('current_knowarth_zipcode_import', $model);
        $this->_initAction();
        $this->_view->getLayout()->getBlock('import_import_edit');
        $this->_view->renderLayout();
    }
}
