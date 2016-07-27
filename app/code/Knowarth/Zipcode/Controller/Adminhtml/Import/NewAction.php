<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Import;

class NewAction extends \Knowarth\Zipcode\Controller\Adminhtml\Import
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
