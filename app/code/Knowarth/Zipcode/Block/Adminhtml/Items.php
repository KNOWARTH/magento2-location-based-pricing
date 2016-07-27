<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */
namespace Knowarth\Zipcode\Block\Adminhtml;

class Items extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    // protected $_template='Knowarth_Zipcode::grid.phtml';
    // protected $_button='Knowarth_Zipcode::button.phtml';
    protected function _construct()
    {
        $this->_controller = 'items';
        $this->_headerText = __('Zipcode');
        $this->_addButtonLabel = __('Add New Zipcode');
        // $this->_addButtonLabel = __('Import Csv');
        $this->addButton(
            'import',
            [
                'label' => 'Import Zipcode',
                'onclick' => 'setLocation(\'' . $this->getImportUrl() . '\')',
                'class' => 'add primary'
            ]
        );
        parent::_construct();
    }
    
    private function getImportUrl()
    {
        return $this->getUrl('*/import/new');        
    }
}
