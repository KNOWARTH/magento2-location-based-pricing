<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

namespace Knowarth\Zipcode\Controller\Adminhtml\Items;

class NewAction extends \Knowarth\Zipcode\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
