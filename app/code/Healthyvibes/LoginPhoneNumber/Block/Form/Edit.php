<?php

namespace Healthyvibes\LoginPhoneNumber\Block\Form;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Newsletter\Model\SubscriberFactory;
use Healthyvibes\LoginPhoneNumber\Helper\Data as HelperData;

/**
 * Customer edit form block
 *
 * @api
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 * @since 100.0.2
 */
class Edit extends \Magento\Customer\Block\Form\Edit
{
    /**
     * @var \Healthyvibes\LoginPhoneNumber\Helper\Data
     */
    private $helperData;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param SubscriberFactory $subscriberFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $customerAccountManagement
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        HelperData $helperData,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $data
        );
        $this->helperData = $helperData;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helperData->isActive();
    }

    /**
     * Get customer custom phone number attribute as value.
     *
     * @return string Customer phone number value.
     */
    public function getPhoneNumber()
    {
        $phoneAttribute = $this->getCustomer()
            ->getCustomAttribute(HelperData::PHONE_NUMBER);
        return $phoneAttribute ? (string) $phoneAttribute->getValue() : '';
    }
}
