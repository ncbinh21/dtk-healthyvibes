<?php

namespace Healthyvibes\Directory\Model;

/**
 * Class Ward
 *
 */
class Ward extends \Magento\Framework\Model\AbstractModel
{
    const WARD_ID = 'ward_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Healthyvibes\Directory\Model\ResourceModel\Ward::class);
    }

    /**
     * Retrieve Ward Name
     *
     * @return string
     */
    public function getName()
    {
        $name = $this->getData('name');
        if ($name === null) {
            $name = $this->getData('default_name');
        }
        return $name;
    }
}
