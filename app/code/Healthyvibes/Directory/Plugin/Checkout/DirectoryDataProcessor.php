<?php

namespace Healthyvibes\Directory\Plugin\Checkout;

use Healthyvibes\Directory\Model\ResourceModel\City\CollectionFactory as CityCollectionFactory;
use Magento\Checkout\Block\Checkout\DirectoryDataProcessor as CheckoutDirectoryDataProcessor;

class DirectoryDataProcessor
{
    /**
     * @var
     */
    private $cityOptions;

    /**
     * @var CityCollectionFactory
     */
    private $cityCollectionFactory;

    /**
     * DirectoryDataProcessor constructor.
     * @param CityCollectionFactory $cityCollectionFactory
     */
    public function __construct(
        CityCollectionFactory $cityCollectionFactory
    ) {
        $this->cityCollectionFactory = $cityCollectionFactory;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\DirectoryDataProcessor $subject
     * @param $result
     * @param $jsLayout
     * @return mixed
     */
    public function afterProcess(CheckoutDirectoryDataProcessor $subject, $result, &$jsLayout)
    {
        if (isset($result['components']['checkoutProvider']['dictionaries'])) {
            $dictionariesPassed = $result['components']['checkoutProvider']['dictionaries'];
            $cityOptions = ['city_id' => $this->getCityOptions()];
            $result['components']['checkoutProvider']['dictionaries'] = array_merge($dictionariesPassed, $cityOptions);
        }
        $result['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['city_id']['validation']['required-entry'] = true;
        $result['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['ward_id']['validation']['required-entry'] = true;
        return $result;
    }

    /**
     * @return array
     */
    private function getCityOptions()
    {
        if (!isset($this->cityOptions)) {
            $this->cityOptions = $this->cityCollectionFactory->create()->addAllowedCountriesFilter()->toOptionArray();
        }
        return $this->cityOptions;
    }
}
