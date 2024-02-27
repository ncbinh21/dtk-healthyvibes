<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

use Healthyvibes\GiaoHangNhanh\Model\Config;
use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Healthyvibes\Directory\Model\City;
use Healthyvibes\Directory\Model\Ward;

/**
 * Class ShippingDetailsDataBuilder
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Request
 */
class ShippingDetailsDataBuilder extends AbstractDataBuilder
{
    /**
     * @param array $buildSubject
     * @return array
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $rateRequest = SubjectReader::readRateRequest($buildSubject);
        $cityId = $wardId = '';
        $cityData = $wardData = [];
        $address = json_decode($this->request->getContent(), true);
        if (isset($address['address']['custom_attributes']) && is_array($address['address']['custom_attributes'])) {
            foreach ($address['address']['custom_attributes'] as $data) {
                if (isset($data['attribute_code']) && $data['attribute_code'] == City::CITY_ID) {
                    $cityId = $data['value'];
                }
                if (isset($data['attribute_code']) && $data['attribute_code'] == Ward::WARD_ID) {
                    $wardId = $data['value'];
                }
            }
        }
        if (!$cityId && !$wardId) {
            $cityId = $rateRequest->getShippingAddress()->getCityId();
            $wardId = $rateRequest->getShippingAddress()->getWardId();
        }
        if ($cityId && $wardId) {
            $cityData = $this->city->loadById($cityId);
            $wardData = $this->ward->loadById($wardId);
        } else {
            throw new LocalizedException(__('City or ward is null'));
        }

        $rate = $this->baseConfig->getWeightUnit() == self::DEFAULT_WEIGHT_UNIT ? Config::KGS_G : Config::LBS_G;
        $regionId = isset($address['address']['regionId']) ? $address['address']['regionId'] : $rateRequest->getShippingAddress()->getRegionId();
        $shopData = $this->dataHelper->getSourceFromRegion($regionId);
        $weightCurrent = $rateRequest->getShippingAddress()->getWeight() * $rate;
        if ($weightCurrent > self::ORIGIN_SETUP_WEIGHT) {
            $weightCurrent = $weightCurrent - self::DEDUCT_WEIGHT;
        }
        $data = [
            self::SHOP_ID => isset($shopData['shop_id_ghn']) ? (string)$shopData['shop_id_ghn'] : '',
            self::TO_WARD_CODE => isset($wardData['code']) ? (string)$wardData['code'] : '',
            self::TO_DISTRICT_ID => isset($cityData['ghn_code']) ? (int)$cityData['ghn_code'] : 0,
            self::WEIGHT => $weightCurrent,
            self::SERVICE_TYPE_ID => 2 //2: E-commerce Delivery, 5: Traditional Delivery
        ];
        return $data;
    }
}
