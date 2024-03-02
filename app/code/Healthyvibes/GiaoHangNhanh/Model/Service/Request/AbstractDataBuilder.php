<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

use Healthyvibes\GiaoHangNhanh\Helper\Rate;
use Healthyvibes\GiaoHangNhanh\Model\Config;
use Healthyvibes\IntegrationBase\Model\Service\ConfigInterface;
use Healthyvibes\IntegrationBase\Model\Service\Request\BuilderInterface;
use Magento\Quote\Model\Quote\AddressFactory;
use Magento\Store\Model\Information;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Webapi\Rest\Request as ApiRequest;
use Healthyvibes\Directory\Model\ResourceModel\City;
use Healthyvibes\Directory\Model\ResourceModel\Ward;
use Psr\Log\LoggerInterface;
use Healthyvibes\InventoryAdminUi\Helper\Data as DataHelper;

/**
 * Class AbstractDataBuilder
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Request
 */
abstract class AbstractDataBuilder implements BuilderInterface
{
    const DEFAULT_WEIGHT_UNIT = 'kgs';
    const TOKEN = 'Token';
    const ORDER_CODE = 'order_code';
    const WEIGHT = 'weight';
    const FROM_DISTRICT = 'from_district';
    const TO_NAME = 'to_name';
    const TO_PHONE = 'to_phone';
    const TO_ADDRESS = 'to_address';
    const TO_DISTRICT = 'to_district';
    const TO_WARD_CODE = 'to_ward_code';
    const TO_DISTRICT_ID = 'to_district_id';
    const SHOP_ID = 'shop_id';
    const PAYMENT_TYPE_ID = 'payment_type_id';
    const REQUIRED_NOTE = 'required_note';
    const SERVICE_TYPE_ID = 'service_type_id';
    const SERVICE_ID = 'service_id';
    const LENGTH = 'length';
    const WIDTH = 'width';
    const HEIGHT = 'height';
    const COD_AMOUNT = 'cod_amount';
    const ITEMS = 'items';
    const NAME = 'name';
    const CODE = 'code';
    const QUANTITY = 'quantity';
    const INSURANCE_VALUE = 'insurance_value';
    const MAX_INSURANCE_VALUE = 990000;
    const DEDUCT_WEIGHT = 800;
    const ORIGIN_SETUP_WEIGHT = 2000;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Information
     */
    protected $storeInformation;

    /**
     * @var AddressFactory
     */
    protected $addressFactory;

    /**
     * @var Config
     */
    protected $baseConfig;

    /**
     * @var Rate
     */
    protected $helperRate;

    /**
     * @var ApiRequest
     */
    protected $request;

    /**
     * @var City
     */
    protected $city;

    /**
     * @var Ward
     */
    protected $ward;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * AbstractDataBuilder constructor.
     * @param ConfigInterface $config
     * @param StoreManagerInterface $storeManager
     * @param Information $storeInformation
     * @param AddressFactory $addressFactory
     * @param Config $baseConfig
     * @param Rate $helperRate
     * @param ApiRequest $request
     * @param City $city
     * @param Ward $ward
     * @param DataHelper $dataHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        ConfigInterface $config,
        StoreManagerInterface $storeManager,
        Information $storeInformation,
        AddressFactory $addressFactory,
        Config $baseConfig,
        Rate $helperRate,
        ApiRequest $request,
        City $city,
        Ward $ward,
        DataHelper $dataHelper,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->storeInformation = $storeInformation;
        $this->addressFactory = $addressFactory;
        $this->baseConfig = $baseConfig;
        $this->helperRate = $helperRate;
        $this->request = $request;
        $this->city = $city;
        $this->ward = $ward;
        $this->dataHelper = $dataHelper;
        $this->logger = $logger;
    }
}
