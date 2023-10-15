<?php

namespace Healthyvibes\Directory\Model\ResourceModel;


class City extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('healthyvibes_directory_region_city', 'city_id');
    }

    /**
     * @param \Healthyvibes\Directory\Model\City $city
     * @param $cityCode
     * @param $regionId
     * @return $this
     */
    public function loadByCode(\Healthyvibes\Directory\Model\City $city, $cityCode, $regionId)
    {
        return $this->loadByRegion($city, $regionId, (string)$cityCode, 'code');
    }

    /**
     * @param $object
     * @param $regionId
     * @param $value
     * @param $field
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function loadByRegion($object, $regionId, $value, $field)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            ['city' => $this->getMainTable()]
        )->where(
            'city.region_id = ?',
            $regionId
        )->where(
            "city.{$field} = ?",
            $value
        );

        $data = $connection->fetchRow($select);
        if ($data) {
            $object->setData($data);
        }

        $this->_afterLoad($object);

        return $this;
    }
}
