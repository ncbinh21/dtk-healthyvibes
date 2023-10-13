<?php

namespace Healthyvibes\Directory\Model\ResourceModel\Address\Backend;


class City extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * @var \Healthyvibes\Directory\Model\CityFactory
     */
    private $cityFactory;
    /**
     * @var \Healthyvibes\Directory\Model\ResourceModel\City
     */
    private $cityResource;

    public function __construct(
        \Healthyvibes\Directory\Model\CityFactory $cityFactory,
        \Healthyvibes\Directory\Model\ResourceModel\City $cityResource
    ) {
        $this->cityFactory = $cityFactory;
        $this->cityResource = $cityResource;
    }

    public function beforeSave($object)
    {
        $city = $object->getData('city');
        if (is_numeric($city)) {
            $cityModel = $this->cityFactory->create();
            $this->cityResource->load($cityModel,$city);
            if ($cityModel->getId() && $object->getRegionId() == $cityModel->getRegionId()) {
                $object->setCityId($cityModel->getCityId())->setCity($cityModel->getName());
            }
        }
        return $this;

    }

}
