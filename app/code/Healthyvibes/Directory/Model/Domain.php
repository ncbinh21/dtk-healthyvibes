<?php

namespace Healthyvibes\Directory\Model;

/**
 * Class Domain
 * @package Healthyvibes\Directory\Model
 */
class Domain extends \Magento\Framework\Model\AbstractModel
{
    const DOMAIN_ID = 'domain_id';
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Healthyvibes\Directory\Model\ResourceModel\Domain::class);
    }
}
