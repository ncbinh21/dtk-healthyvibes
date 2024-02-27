<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

use Healthyvibes\GiaoHangNhanh\Model\Config;
use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order;
use Magento\OfflinePayments\Model\Cashondelivery;

/**
 * Class SynchronizeOrderDataBuilder
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Request
 */
class SynchronizeOrderDataBuilder extends AbstractDataBuilder
{
    /**
     * @param array $buildSubject
     * @return array
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function build(array $buildSubject)
    {
        $order = SubjectReader::readOrder($buildSubject);
        $weightRate = $this->baseConfig->getWeightUnit() == self::DEFAULT_WEIGHT_UNIT ? Config::KGS_G : Config::LBS_G;
        $cityData = $this->city->loadById($order->getShippingAddress()->getCityId());
        $wardData = $this->ward->loadById($order->getShippingAddress()->getWardId());
        $regionId = $order->getShippingAddress()->getRegionId();
        $shopData = $this->dataHelper->getSourceFromRegion($regionId);
        $amount = (int)$order->getGrandTotal();
        return [
            self::SHOP_ID => isset($shopData['shop_id_ghn']) ? (string)$shopData['shop_id_ghn'] : '',
            self::TO_NAME => $order->getShippingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname(),
            self::TO_PHONE => $order->getShippingAddress()->getTelephone(),
            self::TO_ADDRESS => $order->getShippingAddress()->getStreetLine(1),
            self::TO_WARD_CODE => isset($wardData['code']) ? (string)$wardData['code'] : '',
            self::TO_DISTRICT_ID => isset($cityData['ghn_code']) ? (int)$cityData['ghn_code'] : 0,
            self::WEIGHT => $order->getWeight() * $weightRate,
            self::SERVICE_TYPE_ID => 2, //2: E-commerce Delivery, 5: Traditional Delivery
            self::PAYMENT_TYPE_ID => (int)$this->config->getValue('payment_type'),
            self::REQUIRED_NOTE => $this->config->getValue('note_code'),
            self::COD_AMOUNT => $order->getPayment()->getMethod() == Cashondelivery::PAYMENT_METHOD_CASHONDELIVERY_CODE ? $amount : 0,
            self::ITEMS => $this->getListItems($order),
            self::INSURANCE_VALUE => $amount <= self::MAX_INSURANCE_VALUE ? $amount : self::MAX_INSURANCE_VALUE
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    protected function getListItems($order)
    {
        $listItem = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $itemData[self::NAME] = $item->getName();
            $itemData[self::CODE] = $item->getSku();
            $itemData[self::QUANTITY] = (int)$item->getQtyOrdered();
            $listItem[] = $itemData;
        }
        return $listItem;
    }
}
