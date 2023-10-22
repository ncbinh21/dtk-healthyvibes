<?php

namespace Healthyvibes\Banner\Block\Adminhtml;

class Banner extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */

    protected function _construct()
    {
        $this->_blockGroup = 'Healthyvibes_Banner';
        $this->_controller = 'adminhtml';
        $this->_headerText = __('Banner');
        $this->_addButtonLabel = __('Add New Banner');
        parent::_construct();
        if (!$this->_authorization->isAllowed('Healthyvibes_Banner::add_banner')) {
            $this->removeButton('add');
        }
    }
}
