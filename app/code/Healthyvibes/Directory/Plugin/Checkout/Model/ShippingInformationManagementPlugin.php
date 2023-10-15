<?php

namespace Healthyvibes\Directory\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement;

class ShippingInformationManagementPlugin
{
    /**
     * @param ShippingInformationManagement $subject
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return array
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        if ($cityId = $addressInformation->getShippingAddress()->getExtensionAttributes()->getCityId()) {
            $addressInformation->getShippingAddress()->setCityId((int)$cityId);
        }
        if ($ward = $addressInformation->getShippingAddress()->getExtensionAttributes()->getWard()) {
            $addressInformation->getShippingAddress()->setWard($ward);
        }
        if ($wardId = $addressInformation->getShippingAddress()->getExtensionAttributes()->getWardId()) {
            $addressInformation->getShippingAddress()->setWardId((int)$wardId);
        }
        return [$cartId, $addressInformation];
    }
}
