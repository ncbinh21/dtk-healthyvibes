<?php

namespace Healthyvibes\Magicmenu\Model\ResourceModel\Magicmenu;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init('Healthyvibes\Magicmenu\Model\Magicmenu', 'Healthyvibes\Magicmenu\Model\ResourceModel\Magicmenu');
    }
}
