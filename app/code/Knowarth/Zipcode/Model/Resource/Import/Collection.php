<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Model\Resource\Import;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    // protected $_idFieldName = \Knowarth\Zipcode\Model\Items::ITEMS_ID;
    protected function _construct()
    {
        $this->_init('Knowarth\Zipcode\Model\Import', 'Knowarth\Zipcode\Model\Resource\Import');
    }
}
