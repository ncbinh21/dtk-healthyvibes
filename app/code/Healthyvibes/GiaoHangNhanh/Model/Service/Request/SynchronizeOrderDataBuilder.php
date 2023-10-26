<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

use Healthyvibes\GiaoHangNhanh\Model\Config;
use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order;

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

        return [
            self::SHOP_ID => 885,//todo get from store
            self::TO_NAME => $order->getCustomerName(),
            self::TO_PHONE => $order->getShippingAddress()->getTelephone(),
            self::TO_ADDRESS => $order->getShippingAddress()->getStreetLine(1),
            self::TO_WARD_CODE => isset($wardData['code']) ? (string)$wardData['code'] : '',
            self::TO_DISTRICT_ID => isset($cityData['ghn_code']) ? (int)$cityData['ghn_code'] : 0,
            self::WEIGHT => $order->getWeight() * $weightRate,
            self::LENGTH => (int)$this->config->getValue('default_length'),
            self::WIDTH => (int)$this->config->getValue('default_width'),
            self::HEIGHT => (int)$this->config->getValue('default_height'),
            self::SERVICE_TYPE_ID => 2, //2: E-commerce Delivery, 5: Traditional Delivery
            self::PAYMENT_TYPE_ID => (int)$this->config->getValue('payment_type'),
            self::REQUIRED_NOTE => $this->config->getValue('note_code'),
            self::COD_AMOUNT => (int)$order->getGrandTotal(),
            self::ITEMS => $this->getListItems($order)
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
