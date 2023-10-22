<?php

namespace Healthyvibes\LoginPhoneNumber\Block\Form;

use Magento\Framework\View\Element\Template\Context;
use Magento\Directory\Helper\Data;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory as RegionFactory;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryFactory;
use Magento\Framework\Module\Manager;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Healthyvibes\LoginPhoneNumber\Helper\Data as HelperData;

/**
 * Customer register form block
 *
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Register extends \Magento\Customer\Block\Form\Register
{
    /**
     * @var \Healthyvibes\LoginPhoneNumber\Helper\Data
     */
    private $helperData;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Data $directoryHelper
     * @param EncoderInterface $jsonEncoder
     * @param Config $configCacheType
     * @param RegionFactory $regionCollectionFactory
     * @param CountryFactory $countryCollectionFactory
     * @param Manager $moduleManager
     * @param Session $customerSession
     * @param Url $customerUrl
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Data $directoryHelper,
        EncoderInterface $jsonEncoder,
        Config $configCacheType,
        RegionFactory $regionCollectionFactory,
        CountryFactory $countryCollectionFactory,
        Manager $moduleManager,
        Session $customerSession,
        Url $customerUrl,
        HelperData $helperData,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $directoryHelper,
            $jsonEncoder,
            $configCacheType,
            $regionCollectionFactory,
            $countryCollectionFactory,
            $moduleManager,
            $customerSession,
            $customerUrl,
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
}
