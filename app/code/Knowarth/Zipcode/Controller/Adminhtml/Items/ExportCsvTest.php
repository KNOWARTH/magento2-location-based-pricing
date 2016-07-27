<?php
namespace Knowarth\Zipcode\Controller\Adminhtml\Items;
// error_reporting(E_ALL ^ E_DEPRECATED);

// use Magento\Framework\App\ResponseInterface;
// use Magento\Framework\App\Filesystem\DirectoryList;
// use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
// use Magento\Framework\App\Response\Http\FileFactory;
// use Magento\Ui\Component\MassAction\Filter;
// use Magento\Sales\Model\Order\Pdf\Shipment;
// use Magento\Framework\Stdlib\DateTime\DateTime;
// use Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory as ShipmentCollectionFactory;
// use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

use Magento\Framework\App\Response\Http\FileFactory;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Magento\Backend\App\Action
{
    /**
     * Export data grid to CSV format
     *
     * @return ResponseInterface
     */
     
         /**
     * @var FileFactory
     */
    // protected $fileFactory;

    // /**
     // * @var DateTime
     // */
    // protected $dateTime;

    // /**
     // * @var Shipment
     // */
    // protected $pdfShipment;

    // /**
     // * @var ShipmentCollectionFactory
     // */
    // protected $shipmentCollectionFactotory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param DateTime $dateTime
     * @param FileFactory $fileFactory
     * @param Shipment $shipment
     * @param ShipmentCollectionFactory $shipmentCollectionFactory
     */
     protected $_coreRegistry;
     protected $fileFactory;
     protected $resultForwardFactory;
     // public function __construct(
        // \Magento\Backend\App\Action\Context $context, 
         // \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        // \Magento\Framework\Registry $coreRegistry, 
        // \Magento\Framework\App\Response\Http\FileFactory $fileFactory
        
    // ) {
         // $this->resultForwardFactory = $resultForwardFactory;
        // $this->_coreRegistry = $coreRegistry;
        // $this->fileFactory = $fileFactory;
        // parent::__construct($context, $coreRegistry,$resultForwardFactory);
    // }
    public function __construct(
        Context $context,
        // Filter $filter,
        // CollectionFactory $collectionFactory,
        // DateTime $dateTime,
        FileFactory $fileFactory
        // Shipment $shipment,
        // ShipmentCollectionFactory $shipmentCollectionFactory
    ) {
        $this->fileFactory = $fileFactory;
        // $this->dateTime = $dateTime;
        // $this->pdfShipment = $shipment;
        // $this->collectionFactory = $collectionFactory;
        // $this->shipmentCollectionFactotory = $shipmentCollectionFactory;
        parent::__construct($context,$fileFactory);
    }

    public function execute()
    {
    $conn = mysql_connect("localhost","root","");
    mysql_select_db("3mag",$conn);

    $filename = "toy_csv.csv";
    $fp = fopen('php://output', 'w');

    $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='3mag' AND TABLE_NAME='knowarth_zipcode_items'";
    $result = mysql_query($query);
    while ($row = mysql_fetch_row($result)) {
        $header[] = $row[0];
    }	
    print_r($header);exit;
    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    fputcsv($fp, $header);

    $num_column = count($header);		
    $query = "SELECT * FROM knowarth_zipcode_items";
    $result = mysql_query($query);
    while($row = mysql_fetch_row($result)) {
        fputcsv($fp, $row);
    }
    exit;
        // $this->_view->loadLayout();
        // $fileName = 'sample_data.csv';
        // $content = $this->_view->getLayout()->getChildBlock('knowarth.zipcode.import.container', 'knowarth.zipcode.import');
        // var_dump($content);exit;

        // return $this->fileFactory->create(
            // $fileName,
            // $content->getCsvFile($fileName),
            // DirectoryList::VAR_DIR
        // );
    }
}


// <?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
// namespace Magento\TaxImportExport\Controller\Adminhtml\Rate;
// namespace Knowarth\Zipcode\Controller\Adminhtml\Import;

// use Magento\Framework\Controller\ResultFactory;
// use Magento\ImportExport\Controller\Adminhtml\Export as ExportController;
// use Magento\Backend\App\Action\Context;
// use Magento\Framework\App\Response\Http\FileFactory;
// use Magento\ImportExport\Model\Export as ExportModel;
// use Magento\Framework\App\Filesystem\DirectoryList;
// use Magento\Framework\Exception\LocalizedException;

// use Magento\Framework\App\ResponseInterface;
// // use Magento\Framework\App\Filesystem\DirectoryList;
// // use Magento\Framework\Controller\ResultFactory;

// class ExportCsv extends  \Magento\Backend\App\Action
// {
    /**
     * Export rates grid to CSV format
     *
     * @return ResponseInterface
     */
         // protected $fileFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     */
    // public function __construct(
        // Context $context,
        // FileFactory $fileFactory
    // ) {
        // $this->fileFactory = $fileFactory;
        // parent::__construct($context);
    // }

    // public function execute()
    // {
        // /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        // $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        // $content = $resultLayout->getLayout()->getChildBlock('knowarth.zipcode.import.container', 'knowarth.zipcode.import');

        // return $this->fileFactory->create(
            // 'rates.csv',
            // $content->getCsvFile(),
            // DirectoryList::VAR_DIR
        // );
    // }
        // public function execute()
    // {
        // // if ($this->getRequest()->getPost(ExportModel::FILTER_ELEMENT_GROUP)) {
            // try {
                // /** @var $model \Magento\ImportExport\Model\Export */
                // $model = $this->_objectManager->create('Magento\ImportExport\Model\Export');
                // $data = [
                    // [
                        // 'title' => 'How to create a simple module',
                        // 'summary' => 'The summary',
                        // 'description' => 'The description',
                        // 'created_at' => date('Y-m-d H:i:s'),
                        // 'status' => 1
                    // ],
                    // [
                        // 'title' => 'Create a module with custom database table',
                        // 'summary' => 'The summary',
                        // 'description' => 'The description',
                        // 'created_at' => date('Y-m-d H:i:s'),
                        // 'status' => 1
                    // ]
                // ];
                // $model->setData($data);
                // // $model->setData($this->getRequest()->getParams());
// // echo "dv";
// // exit;
                // return $this->fileFactory->create(
                    // $model->getTitle(),
                    // $model->export(),
                    // DirectoryList::VAR_DIR,
                    // $model->getContentType()
                // );
                
            // } catch (LocalizedException $e) {
                // $this->messageManager->addError($e->getMessage());
            // } catch (\Exception $e) {
                // $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                // $this->messageManager->addError(__('Please correct the data sent value.'));
            // }
            // // echo "dv";
            // // exit;
        // // } else {
            // // $this->messageManager->addError(__('Please correct the data sent value.'));
        // // }
        // /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // $resultRedirect->setPath('adminhtml/*/index');
        // return $resultRedirect;
    // }
    // public function execute()
    // {
        // /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        // $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        // $content = $resultLayout->getLayout()->getChildBlock('adminhtml.tax.rate.grid', 'grid.export');

        // return $this->fileFactory->create(
            // 'rates.csv',
            // $content->getCsvFile(),
            // DirectoryList::VAR_DIR
        // );
    // }


// }