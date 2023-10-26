<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Magento\Framework\Exception\NoSuchEntityException;
use Healthyvibes\Directory\Model\City;

/**
 * Class ServiceDetailsDataBuilder
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Request
 */
class ServiceDetailsDataBuilder extends AbstractDataBuilder
{
    /**
     * @param array $buildSubject
     * @return array
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $rateRequest = SubjectReader::readRateRequest($buildSubject);
        $cityId = '';
        $cityData = [];
        $address = json_decode($this->request->getContent(), true);
        if (isset($address['address']['custom_attributes']) && is_array($address['address']['custom_attributes'])) {
            foreach ($address['address']['custom_attributes'] as $data) {
                if (isset($data['attribute_code']) && $data['attribute_code'] == City::CITY_ID) {
                    $cityId = $data['value'];
                    break;
                }
            }
        }
        if (!$cityId) {
            $cityId = $rateRequest->getShippingAddress()->getCityId();
        }
        if ($cityId) {
            $cityData = $this->city->loadById($cityId);
        }
        $data = [
            self::SHOP_ID => 885, //todo get from store
            self::FROM_DISTRICT => 1447, //todo get from store
            self::TO_DISTRICT => isset($cityData['ghn_code']) ? (int)$cityData['ghn_code'] : 0
        ];

        if ($serviceId = SubjectReader::readServiceId($buildSubject)) {
            $data[self::SERVICE_ID] = $serviceId;
        }
        return $data;
    }
}
