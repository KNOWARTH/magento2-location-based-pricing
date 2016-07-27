<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Items;
 
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
 
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;
 
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
 
 
    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    // public function execute()
    // {
        // $collection = $this->filter->getCollection($this->collectionFactory->create());
        // $collectionSize = $collection->getSize();
        // foreach ($collection as $item) {
            // $item->delete();
        // }
 
        // $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
 
        // /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // return $resultRedirect->setPath('*/*/');
    // }
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('item');
        if (! is_array($itemIds)) {
            $this->messageManager->addError(__('Please select one or more Affiliate.'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $itemId = $this->_objectManager->create('Knowarth\Zipcode\Model\Items')->load($itemIds);
                    $itemId->delete();
                }
                $this->messageManager->addSuccess(__('Total of %1 record(s) were deleted.', count($itemIds)));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        
        $this->_redirect('*/*/index');
    }

}