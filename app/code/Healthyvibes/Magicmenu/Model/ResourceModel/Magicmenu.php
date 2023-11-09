<?php

namespace Healthyvibes\Magicmenu\Model\ResourceModel;

class Magicmenu extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('healthyvibes_magicmenu', 'magicmenu_id');
    }
}
