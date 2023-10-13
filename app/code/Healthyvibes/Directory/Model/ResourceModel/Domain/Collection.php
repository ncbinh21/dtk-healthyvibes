<?php

namespace Healthyvibes\Directory\Model\ResourceModel\Domain;

use Magento\Store\Model\ScopeInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Healthyvibes\Directory\Model\Domain::class, \Healthyvibes\Directory\Model\ResourceModel\Domain::class);
    }
}
