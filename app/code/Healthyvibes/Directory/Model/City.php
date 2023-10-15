<?php

namespace Healthyvibes\Directory\Model;

/**
 * Class City
 * @package Healthyvibes\Directory\Model
 */
class City extends \Magento\Framework\Model\AbstractModel
{
    const CITY_ID = 'city_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Healthyvibes\Directory\Model\ResourceModel\City::class);
    }

    /**
     * Retrieve City Name
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

    /**
     * @param $code
     * @param $regionId
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function loadByCode($code, $regionId)
    {
        if ($code) {
            $this->_getResource()->loadByCode($this, $code, $regionId);
        }
        return $this;
    }
}
