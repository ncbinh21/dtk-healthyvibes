<?php

namespace Healthyvibes\Directory\Model\ResourceModel\Address\Source;


use Healthyvibes\Directory\Model\ResourceModel\City\CollectionFactory;

class City extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    /**
     * @var CollectionFactory
     */
    private $cityCollectionFactory;

    public function __construct(
        \Healthyvibes\Directory\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
    ) {
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
        $this->cityCollectionFactory = $cityCollectionFactory;
    }

    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        if (!$this->_options) {
            $this->_options = $this->cityCollectionFactory->create()
                ->load()->toOptionArray();
        }
        return $this->_options;
    }

}
