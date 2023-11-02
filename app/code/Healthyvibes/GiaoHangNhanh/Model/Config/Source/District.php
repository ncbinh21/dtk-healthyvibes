<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Config\Source;

use Healthyvibes\GiaoHangNhanh\Model\Config;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\Information;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class District
 * @package Healthyvibes\GiaoHangNhanh\Model\Config\Source
 */
class District implements ArrayInterface
{
    /**
     * @var Information
     */
    private $storeInformation;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Config
     */
    private $config;

    /**
     * District constructor.
     * @param Config $config
     * @param Information $storeInformation
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Config $config,
        Information $storeInformation,
        StoreManagerInterface $storeManager
    ) {
        $this->storeInformation = $storeInformation;
        $this->storeManager = $storeManager;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $store = $this->storeManager->getStore();
        $storeInfo = $this->storeInformation->getStoreInformationObject($store);
        $districts = $this->config->getDistricts();
        $data = [];
        foreach ($districts as $district) {
            if ($district['region_id'] == $storeInfo->getRegionId()) {
                $data[] = [
                    'label' => $district['district_name'],
                    'value' => $district['district_id']
                ];
            }
        }

        if ($data) {
            return $data;
        }

        return [['value' => '', 'label' => __('No district to select.')],];
    }
}
