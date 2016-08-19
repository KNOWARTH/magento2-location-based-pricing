<?php
namespace Knowarth\Zipcode\Model\Import;

use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\Framework\App\ResourceConnection;

class Zipcode extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{

    const EVENTNAME = 'name';
    const EVENTZIPCODE = 'zipcode';
    const EVENTSTATUS = 'status';
    const TABLE_Entity = 'knowarth_zipcode_items';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageManager;
    protected $_messageTemplates = [
    ];

    /**
     * If we should check column names
     *
     * @var bool
     */
    protected $needColumnCheck = true;
    protected $groupFactory;
    /**
     * Valid column names
     *
     * @array
     */
    protected $validColumnNames = [
    self::EVENTNAME,
    self::EVENTZIPCODE,
    self::EVENTSTATUS,
    
    ];

    /**
     * Need to log in import history
     *
     * @var bool
     */
    protected $logInHistory = true;

    protected $_validators = [];


    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_connection;
    protected $_resource;

    /**
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
    \Magento\Framework\Message\ManagerInterface $messageManager,
    \Magento\Framework\Json\Helper\Data $jsonHelper,
    \Magento\ImportExport\Helper\Data $importExportData,
    \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
    \Magento\Framework\App\ResourceConnection $resource,
    \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
    \Magento\Framework\Stdlib\StringUtils $string,
    ProcessingErrorAggregatorInterface $errorAggregator,
    \Magento\Customer\Model\GroupFactory $groupFactory
    ) {
    $this->_messageManager = $messageManager;
    $this->jsonHelper = $jsonHelper;
    $this->_importExportData = $importExportData;
    $this->_resourceHelper = $resourceHelper;
    $this->_dataSourceModel = $importData;
    $this->_resource = $resource;
    $this->_connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
    $this->errorAggregator = $errorAggregator;
    $this->groupFactory = $groupFactory;
    }
    public function getValidColumnNames()
    {
    return $this->validColumnNames;
    }

    /**
     * Entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
    return 'knowarth_zipcode_items';
    }

    /**
     * Row validation.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    public function validateRow(array $rowData, $rowNum)
    {

    $title = false;

    if (isset($this->_validatedRows[$rowNum])) {
        return !$this->getErrorAggregator()->isRowInvalid($rowNum);
    }

    $this->_validatedRows[$rowNum] = true;

    return !$this->getErrorAggregator()->isRowInvalid($rowNum);
    }

    /**
     * Create Advanced price data from raw data.
     *
     * @throws \Exception
     * @return bool Result of operation.
     */
    protected function _importData()
    {
        if (\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            $this->deleteEntity();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $this->getBehavior()) {
            $this->replaceEntity();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $this->getBehavior()) {
            $this->saveEntity();
        }

        return true;
    }
    /**
     * Save newsletter subscriber
     *
     * @return $this
     */
    public function saveEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }
    /**
     * Replace newsletter subscriber
     *
     * @return $this
     */
    public function replaceEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }
    /**
     * Deletes newsletter subscriber data from raw data.
     *
     * @return $this
     */
    public function checkExistingZipcode()
    {
        $zipItemName = [];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $productCollection = $objectManager->create('Knowarth\Zipcode\Model\Resource\Items\CollectionFactory');

        $collection = $productCollection->create()
                    ->load();

        foreach ($collection as $zipItem){
            if(!empty($zipItem->getZipcode())){
                $zipItemName[$zipItem->getZipcode()]  =  $zipItem->getZipcode();
            }
        }  
        
        return $zipItemName;
    } 
    public function wayToFindDelimeter($file)
    {
        $delimiters = array(
            'semicolon' => ";",
            'tab'       => "\t",
            'comma'     => ",",
        );

        //Load the csv file into a string
        $csv = file_get_contents($file);
        foreach ($delimiters as $key => $delim) {
            $res[$key] = substr_count($csv, $delim);
        }

        //reverse sort the values, so the [0] element has the most occured delimiter
        arsort($res);

        reset($res);
        $first_key = key($res);

        return $delimiters[$first_key]; 
    }
 /**
     * Save and replace newsletter subscriber
     *
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function csvToArray($data,$filename)
    {
        $delimiter = $this->wayToFindDelimeter($filename);
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        $tempZipData = $this->checkExistingZipcode();
        $this-> saveAndReplaceEntity($data, $tempZipData);
    }
    
    public function saveAndReplaceEntity($data, $tempZipData)
    {
        $behavior = $this->getBehavior();
        $listTitle = [];
        $bunch = $data;
            $entityList = [];
            foreach ($bunch as $rowNum => $rowData) {
                if(!in_array($rowData[self::EVENTZIPCODE], $tempZipData) && !empty($rowData[self::EVENTZIPCODE]))
                {
                    $rowTtile= $rowNum;
                    $listTitle[] = $rowTtile;
                    $entityList[$rowTtile][] = [
                      self::EVENTNAME => $rowData[self::EVENTNAME],
                      self::EVENTZIPCODE => $rowData[self::EVENTZIPCODE],
                      self::EVENTSTATUS => $rowData[self::EVENTSTATUS],
                    ];
                    // $entityListIn[] = [
                      // self::EVENTNAME => $rowData[self::EVENTNAME],
                      // self::EVENTZIPCODE => $rowData[self::EVENTZIPCODE],
                      // self::EVENTSTATUS => $rowData[self::EVENTSTATUS],
                    // ];
                    // $table = self::TABLE_Entity;
                    // $tableName = $this->_connection->getTableName($table);
                    // $this->_connection->insertOnDuplicate($tableName, $entityListIn,[
                    // self::EVENTNAME,
                    // self::EVENTZIPCODE,
                    // self::EVENTSTATUS,
                // ]);


                }
                elseif(!empty($rowData[self::EVENTZIPCODE]))
                {   
                    $table = self::TABLE_Entity;
                    $tableName = $this->_connection->getTableName($table);
                    $bind =[
                      self::EVENTNAME => $rowData[self::EVENTNAME],
                      self::EVENTZIPCODE => $rowData[self::EVENTZIPCODE],
                      self::EVENTSTATUS => $rowData[self::EVENTSTATUS],
                    ];
                    print_r($bind);
                    $where  = $this->_connection->quoteInto('zipcode LIKE (?)', $rowData[self::EVENTZIPCODE]);
                    // $where = "zipcode"." = $rowData['zipcode']";
                    $this->_connection->update($table, $bind, $where);
                    $rowTtile= $rowNum;
                    $listTitle[] = $rowTtile;
                    $entityUpdateList[$rowTtile][] = [
                      self::EVENTNAME => $rowData[self::EVENTNAME],
                      self::EVENTZIPCODE => $rowData[self::EVENTZIPCODE],
                      self::EVENTSTATUS => $rowData[self::EVENTSTATUS],
                    ];
                }
            }
            if (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $behavior) {
                $this->saveEntityFinish($entityList, self::TABLE_Entity);
            }
        return $this;
    }
    /**
     * Save product prices.
     *
     * @param array $priceData
     * @param string $table
     * @return $this
     */
    public function saveEntityFinish(array $entityData, $table)
    {
        if ($entityData) {
            $tableName = $this->_connection->getTableName($table);
            $entityIn = [];
            foreach ($entityData as $id => $entityRows) {
                    foreach ($entityRows as $row) {
                        $entityIn[] = $row;
                    }
            }
            if ($entityIn) {
                $this->_connection->insertOnDuplicate($tableName, $entityIn,[
                    self::EVENTNAME,
                    self::EVENTZIPCODE,
                    self::EVENTSTATUS,
                ]);
            }
        }
        return $this;
    }
    protected function deleteEntityFinish(array $listTitle, $table)
    {
    if ($table && $listTitle) {
            try {
                return true;
            } catch (\Exception $e) {
                return false;
            }

    } else {
        return false;
    }
    }
}