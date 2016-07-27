<?php
/**
 * Copyright © 2015 Pagseguro. All rights reserved.
 */

// @codingStandardsIgnoreFile

namespace Knowarth\Zipcode\Block\Adminhtml\Import\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;



class Main extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Zipcode Information');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Zipcode Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_knowarth_zipcode_import');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('import_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Zipcode Information')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $fieldset->addField(
            'name',
            'file',
            ['name' => 'name', 'label' => __('Choose File'), 'title' => __('Choose File'), 'required' => true]
        );
        // $fieldset->addField(
            // 'zipcode',
            // 'text',
            // ['name' => 'zipcode', 'label' => __('Zipcode Name'), 'title' => __('Zipcode Name'), 'required' => true]
        // );
        // $fieldset->addField(
            // 'status',
            // 'select',
            // ['name' => 'status', 'label' => __('Status'), 'title' => __('Status'), 'required' => true, 'options'   => array("Active"=>"Active","Dective"=>"Dective")]
        // );

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
