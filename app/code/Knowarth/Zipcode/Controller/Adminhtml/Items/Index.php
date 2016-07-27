<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Items;

class Index extends \Knowarth\Zipcode\Controller\Adminhtml\Items
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
        $resultPage->addBreadcrumb(__('Items'), __('Items'));
        return $resultPage;
    }
}
