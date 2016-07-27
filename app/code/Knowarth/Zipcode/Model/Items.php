<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Model;

class Items extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Knowarth\Zipcode\Model\Resource\Items');
    }
}
