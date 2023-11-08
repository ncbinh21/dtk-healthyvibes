<?php

namespace Healthyvibes\Magicmenu\Model;

class Magicmenu extends \Magento\Framework\Model\AbstractModel
{

    protected $_magicmenuCollectionFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Healthyvibes\Magicmenu\Model\ResourceModel\Magicmenu\CollectionFactory $magicmenuCollectionFactory,
        \Healthyvibes\Magicmenu\Model\ResourceModel\Magicmenu $resource,
        \Healthyvibes\Magicmenu\Model\ResourceModel\Magicmenu\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_magicmenuCollectionFactory = $magicmenuCollectionFactory;
    }

}
