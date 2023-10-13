<?php

namespace Healthyvibes\Directory\Model\ResourceModel\Address\Backend;


class Ward extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * @var \Healthyvibes\Directory\Model\WardFactory
     */
    private $wardFactory;
    /**
     * @var \Healthyvibes\Directory\Model\ResourceModel\Ward
     */
    private $wardResource;

    public function __construct(
        \Healthyvibes\Directory\Model\WardFactory $wardFactory,
        \Healthyvibes\Directory\Model\ResourceModel\Ward $wardResource
    ) {
        $this->WardFactory = $wardFactory;
        $this->WardResource = $wardResource;
    }

    public function beforeSave($object)
    {
        $ward = $object->getData('ward');
        if (is_numeric($ward)) {
            $wardModel = $this->WardFactory->create();
            $this->WardResource->load($wardModel,$ward);
            if ($wardModel->getId() && $object->getRegionId() == $wardModel->getRegionId()) {
                $object->setWardId($wardModel->getWardId())->setWard($wardModel->getName());
            }
        }
        return $this;

    }

}
