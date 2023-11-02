<?php

namespace Healthyvibes\Directory\Rewrite\Quote\Model;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\EstimateAddressInterface;
use Magento\Quote\Api\Data\ShippingMethodInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\TotalsCollector;
use Magento\Quote\Model\Cart\ShippingMethodConverter;
use Magento\Quote\Model\ResourceModel\Quote\Address as QuoteAddressResource;
use Magento\Quote\Model\ShippingMethodManagement as OriginShippingMethodManagement;

/**
 * Class ShippingMethodManagement
 * @package Healthyvibes\Directory\Rewrite\Quote\Model
 */
class ShippingMethodManagement extends OriginShippingMethodManagement
{
    /**
     * @var DataObjectProcessor $dataProcessor
     */
    protected $dataProcessor;

    /**
     * @var CustomerSession|mixed
     */
    protected $customerSession;

    /**
     * ShippingMethodManagement constructor.
     * @param CartRepositoryInterface $quoteRepository
     * @param ShippingMethodConverter $converter
     * @param AddressRepositoryInterface $addressRepository
     * @param TotalsCollector $totalsCollector
     * @param AddressInterfaceFactory|null $addressFactory
     * @param QuoteAddressResource|null $quoteAddressResource
     * @param CustomerSession|null $customerSession
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        ShippingMethodConverter $converter,
        AddressRepositoryInterface $addressRepository,
        TotalsCollector $totalsCollector,
        AddressInterfaceFactory $addressFactory = null,
        QuoteAddressResource $quoteAddressResource = null,
        CustomerSession $customerSession = null
    ) {
        $this->customerSession = $customerSession ?? ObjectManager::getInstance()->get(CustomerSession::class);
        parent::__construct($quoteRepository, $converter, $addressRepository, $totalsCollector, $addressFactory, $quoteAddressResource, $customerSession);
    }

    /**
     * @inheritDoc
     */
    public function estimateByAddressId($cartId, $addressId)
    {
        /** @var Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        // no methods applicable for empty carts or carts with virtual products
        if ($quote->isVirtual() || 0 == $quote->getItemsCount()) {
            return [];
        }
        $address = $this->addressRepository->getById($addressId);

        return $this->getShippingMethods($quote, $address);
    }

    /**
     * Get list of available shipping methods
     *
     * @param Quote $quote
     * @param ExtensibleDataInterface $address
     * @return ShippingMethodInterface[]
     */
    private function getShippingMethods(Quote $quote, $address)
    {
        $output = [];
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->addData($this->extractAddressData($address));
        //start custom
        if ($address->getCustomAttribute('city_id')) {
            $shippingAddress->setCityId($address->getCustomAttribute('city_id')->getValue());
        }
        if ($address->getCustomAttribute('ward')) {
            $shippingAddress->setWard($address->getCustomAttribute('ward')->getValue());
        }
        if ($address->getCustomAttribute('ward_id')) {
            $shippingAddress->setWardId($address->getCustomAttribute('ward_id')->getValue());
        }
        //end custom
        $shippingAddress->setCollectShippingRates(true);

        $this->totalsCollector->collectAddressTotals($quote, $shippingAddress);
        $quoteCustomerGroupId = $quote->getCustomerGroupId();
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        $isCustomerGroupChanged = $quoteCustomerGroupId !== $customerGroupId;
        if ($isCustomerGroupChanged) {
            $quote->setCustomerGroupId($customerGroupId);
        }
        $shippingRates = $shippingAddress->getGroupedAllShippingRates();
        foreach ($shippingRates as $carrierRates) {
            foreach ($carrierRates as $rate) {
                $output[] = $this->converter->modelToDataObject($rate, $quote->getQuoteCurrencyCode());
            }
        }
        if ($isCustomerGroupChanged) {
            $quote->setCustomerGroupId($quoteCustomerGroupId);
        }
        return $output;
    }

    /**
     * Get transform address interface into Array
     *
     * @param ExtensibleDataInterface $address
     * @return array
     */
    private function extractAddressData($address)
    {
        $className = \Magento\Customer\Api\Data\AddressInterface::class;
        if ($address instanceof AddressInterface) {
            $className = AddressInterface::class;
        } elseif ($address instanceof EstimateAddressInterface) {
            $className = EstimateAddressInterface::class;
        }

        $addressData = $this->getDataObjectProcessor()->buildOutputDataArray(
            $address,
            $className
        );
        unset($addressData[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY]);

        return $addressData;
    }

    /**
     * Gets the data object processor
     *
     * @return DataObjectProcessor
     * @deprecated 101.0.0
     */
    private function getDataObjectProcessor()
    {
        if ($this->dataProcessor === null) {
            $this->dataProcessor = ObjectManager::getInstance()
                ->get(DataObjectProcessor::class);
        }
        return $this->dataProcessor;
    }
}
