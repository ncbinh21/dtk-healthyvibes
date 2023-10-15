<?php

namespace Healthyvibes\Directory\Plugin\Quote\Model;

use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\AddressInterface;

class QuotePlugin
{
    /**
     * @param Quote $subject
     * @param AddressInterface|null $address
     * @return AddressInterface[]|null[]
     */
    public function beforeSetBillingAddress(Quote $subject, AddressInterface $address = null)
    {
        if ($cityId = $address->getExtensionAttributes()->getCityId()) {
            $address->setCityId((int)$cityId);
        }
        if ($ward = $address->getExtensionAttributes()->getWard()) {
            $address->setWard($ward);
        }
        if ($wardId = $address->getExtensionAttributes()->getWardId()) {
            $address->setWardId((int)$wardId);
        }
        return [$address];
    }
}
