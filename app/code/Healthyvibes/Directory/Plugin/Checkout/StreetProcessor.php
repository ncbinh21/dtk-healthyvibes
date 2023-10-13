<?php

namespace Healthyvibes\Directory\Plugin\Checkout;

class StreetProcessor
{
    public function afterProcess($subject, $jsLayout)
    {
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['street']['label'] = 'Address';

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['street']['sortOrder'] = 85;

        return $jsLayout;
    }
}
