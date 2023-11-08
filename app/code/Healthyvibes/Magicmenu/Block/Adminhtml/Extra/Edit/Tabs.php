<?php

namespace Healthyvibes\Magicmenu\Block\Adminhtml\Extra\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * construct.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('magicmenu_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Extra Menu Information'));
    }
}
