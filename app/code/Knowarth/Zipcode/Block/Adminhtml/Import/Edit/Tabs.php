<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */
namespace Knowarth\Zipcode\Block\Adminhtml\Import\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('knowarth_zipcode_import_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('knowarth'));
    }
}
