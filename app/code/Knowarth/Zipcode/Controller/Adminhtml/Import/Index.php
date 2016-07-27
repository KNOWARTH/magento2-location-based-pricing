<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Import;

class Index extends \Knowarth\Zipcode\Controller\Adminhtml\Import
{
    /**
     * Items list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Knowarth_Zipcode::zipcode');
        $resultPage->getConfig()->getTitle()->prepend(__('Zipcode'));
        $resultPage->addBreadcrumb(__('Zipcode'), __('Zipcode'));
        $resultPage->addBreadcrumb(__('Import'), __('Import'));
        return $resultPage;
    }
}
