<?php

namespace Healthyvibes\LoginPhoneNumber\Plugin\Model\ResourceModel\Customer;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Customer as ResourceModel;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Healthyvibes\LoginPhoneNumber\Helper\Data as HelperData;

/**
 * Class ValidateUniquePhonenumber
 * @package Healthyvibes\LoginPhoneNumber\Plugin\Model\ResourceModel\Customer
 */
class ValidateUniquePhonenumber
{

    /**
     * @var CustomerCollectionFactory
     */
    private $customerCollectionFactory;

    /**
     * @var HelperData
     */
    private $config;

    /**
     * @param CustomerCollectionFactory $customerCollectionFactory
     * @param HelperData $config
     */
    public function __construct(
        CustomerCollectionFactory $customerCollectionFactory,
        HelperData $config
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->config = $config;
    }

    /**
     * Validates if the customer phone number is unique
     *
     * @param ResourceModel $subject
     * @param Customer $customer
     *
     * @throws LocalizedException
     */
    public function beforeSave(ResourceModel $subject, Customer $customer)
    {
        if (!$this->config->isActive()) {
            return;
        }

        $collection = $this->customerCollectionFactory
            ->create()
            ->addAttributeToFilter(HelperData::PHONE_NUMBER, $customer->getData(HelperData::PHONE_NUMBER));

        // If the customer already exists, exclude them from the query
        if ($customer->getId()) {
            $collection->addAttribuTeToFilter(
                'entity_id',
                [
                    'neq' => (int) $customer->getId(),
                ]
            );
        }

        if ($collection->getSize() > 0) {
            throw new LocalizedException(
                __('A customer with the same phone number already exists in an associated website.')
            );
        }
    }
}
