<?php

namespace Healthyvibes\InventoryAdminUi\Model\OptionSource;

use Healthyvibes\Directory\Model\ResourceModel\Domain\Collection as DomainCollection;

/**
 * Class Domain
 * @package Healthyvibes\InventoryAdminUi\Model\Config\Source
 */
class Domain implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var DomainCollection
     */
    protected DomainCollection $domainCollection;

    /**
     * Options array
     *
     * @var array
     */
    protected $_options;

    /**
     * Domain constructor.
     * @param DomainCollection $domainCollection
     */
    public function __construct(
        DomainCollection $domainCollection
    ) {
        $this->domainCollection = $domainCollection;
    }

    /**
     * Return options array
     *
     * @param boolean $isMultiselect
     * @param string|array $foregroundCountries
     * @return array
     */
    public function toOptionArray($isMultiselect = false, $foregroundCountries = '')
    {
        if (!$this->_options) {
            $optionList = [];
            foreach ($this->domainCollection as $domain) {
                $optionList[] = [
                    'value' => $domain->getDomainId(),
                    'label' => $domain->getDefaultName()
                ];
            }
            $this->_options = $optionList;
        }

        $options = $this->_options;
        if (!$isMultiselect) {
            array_unshift($options, ['value' => '', 'label' => __('--Please Select--')]);
        }

        return $options;
    }
}
