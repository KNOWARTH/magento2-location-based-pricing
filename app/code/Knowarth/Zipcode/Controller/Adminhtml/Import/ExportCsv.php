<?php
namespace Knowarth\Zipcode\Controller\Adminhtml\Import;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Knowarth\Zipcode\Model\ItemsFactory;

class ExportCsv extends \Magento\Backend\App\Action
{
    protected $_modelKnowarthZipcode;
    protected $_coreRegistry;
    protected $fileFactory;
    protected $resultForwardFactory;
    public function __construct(
        Context $context,
        ItemsFactory $modelKnowarthZipcode,
        FileFactory $fileFactory
    ) {
        $this->_modelKnowarthZipcode = $modelKnowarthZipcode;
        $this->fileFactory = $fileFactory;
        parent::__construct($context,$fileFactory);
    }

    public function execute()
    {
   
        $newsModel = $this->_modelKnowarthZipcode->create();
 
        // Load the item with ID is 1
        $item = $newsModel->load(1);
 
        // Get news collection
        $newsCollection = $newsModel->getCollection();
        // Load all data of collection

        $filename = "Zipcode_csv.csv";
        $fp = fopen('php://output', 'w');

        $header= Array ( "id" => "id", "name" => "name", "zipcode" => "zipcode", "status" => "status" );
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        fputcsv($fp, $header);
        $table = 'knowarth_zipcode_items';

        foreach($newsCollection->getData() as $rowd){ 
                fputcsv($fp, $rowd);
        }
        exit;
       }
}