<?php
namespace Knowarth\Zipcode\Model\Import;

// use Knowarth\Zipcode\Model\Import\Zipcode\RowValidatorInterface as ValidatorInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\Framework\App\ResourceConnection;

class Zipcode extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{

    const ID = 'id';
    const EVENTNAME = 'name';
    const EVENTZIPCODE = 'zipcode';
    const EVENTSTATUS = 'status';

    const TABLE_Entity = 'knowarth_zipcode_items';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = [
    // ValidatorInterface::ERROR_TITLE_IS_EMPTY => 'TITLE is empty',
    ];

     protected $_permanentAttributes = [self::ID];
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
    self::ID,
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
    \Magento\Framework\Json\Helper\Data $jsonHelper,
    \Magento\ImportExport\Helper\Data $importExportData,
    \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
    \Magento\Framework\App\ResourceConnection $resource,
    \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
    \Magento\Framework\Stdlib\StringUtils $string,
    ProcessingErrorAggregatorInterface $errorAggregator,
    \Magento\Customer\Model\GroupFactory $groupFactory
    ) {
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
    // BEHAVIOR_DELETE use specific validation logic
       // if (\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE == $this->getBehavior()) {
        if (!isset($rowData[self::ID]) || empty($rowData[self::ID])) {
            // $this->addRowError(ValidatorInterface::ERROR_TITLE_IS_EMPTY, $rowNum);
            return false;
        }

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
    public function deleteEntity()
    {
    $listTitle = [];
    while ($bunch = $this->_dataSourceModel->getNextBunch()) {
        foreach ($bunch as $rowNum => $rowData) {
            $this->validateRow($rowData, $rowNum);
            if (!$this->getErrorAggregator()->isRowInvalid($rowNum)) {
                $rowTtile = $rowData[self::ID];
                $listTitle[] = $rowTtile;
            }
            if ($this->getErrorAggregator()->hasToBeTerminated()) {
                $this->getErrorAggregator()->addRowToSkip($rowNum);
            }
        }
    }
    if ($listTitle) {
        $this->deleteEntityFinish(array_unique($listTitle),self::TABLE_Entity);
    }
    return $this;
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
        $delimiter=',';
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
                
        $this-> saveAndReplaceEntity($data);
    }
    
    public function saveAndReplaceEntity($data)
    {
        $behavior = $this->getBehavior();
        $listTitle = [];
        $bunch = $data;
            $entityList = [];
            foreach ($bunch as $rowNum => $rowData) {
                $rowTtile= $rowNum;
                // print_r($rowData);
                $ExrowData = explode(";",$rowData["id;name;zipcode;status"]);
                // print_r($ExrowData);
                // $rowTtile= 'name';
                $listTitle[] = $rowTtile;
                $entityList[$rowTtile][] = [
                  self::EVENTNAME => $ExrowData[1],
                  self::EVENTZIPCODE => $ExrowData[2],
                  self::EVENTSTATUS => $ExrowData[3],
                ];
            }
            // exit;
            if (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $behavior) {
                if ($listTitle) {
                    if ($this->deleteEntityFinish(array_unique(  $listTitle), self::TABLE_Entity)) {
                        $this->saveEntityFinish($entityList, self::TABLE_Entity);
                    }
                }
            } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $behavior) {
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
                self::ID,
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