<?php

namespace Healthyvibes\Directory\Model\ResourceModel;


class Domain extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('healthyvibes_directory_region_domain', 'domain_id');
    }
}
