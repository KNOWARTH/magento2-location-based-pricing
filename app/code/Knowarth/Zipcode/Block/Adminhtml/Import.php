<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */
namespace Knowarth\Zipcode\Block\Adminhtml;

class Import extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'import';
        $this->_headerText = __('Zipcode');
        $this->_addButtonLabel = __('Add New Zipcode');
        parent::_construct();
    }
}
