<?php

namespace Healthyvibes\Magicmenu\Block\Adminhtml\Menu\Edit;

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
        $this->setTitle(__('Menu Information'));
    }
}
