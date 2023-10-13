/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/checkout-data',
    'uiRegistry'
], function ($, wrapper, quote, checkoutData, uiRegistry) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            var billingAddress = quote.billingAddress();

            if(shippingAddress && shippingAddress.hasOwnProperty("street")) {
                let streetComponent = uiRegistry.get("checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.street.0");
                if(streetComponent && streetComponent.value()) {
                    shippingAddress.street.pop();
                    shippingAddress.street.push(streetComponent.value());
                    if(billingAddress && billingAddress.hasOwnProperty("street")) {
                        billingAddress.street.pop();
                        billingAddress.street.push(streetComponent.value());
                    }
                }
            }

            if (shippingAddress.customAttributes) {
                if (shippingAddress['extension_attributes'] === undefined) {
                    shippingAddress['extension_attributes'] = {};
                }

                var cityId = shippingAddress.customAttributes.find(
                    function (element) {
                        return element.attribute_code === 'city_id';
                    }
                );
                var wardId = shippingAddress.customAttributes.find(
                    function (element) {
                        return element.attribute_code === 'ward_id';
                    }
                );
                var ward = shippingAddress.customAttributes.find(
                    function (element) {
                        return element.attribute_code === 'ward';
                    }
                );

                if (cityId) {
                    shippingAddress['extension_attributes']['city_id'] = cityId.value;
                }
                if (wardId) {
                    shippingAddress['extension_attributes']['ward_id'] = wardId.value;
                }
                if (ward) {
                    shippingAddress['extension_attributes']['ward'] = ward.value;
                }

                shippingAddress['extension_attributes']['comments'] = $('#sparsh_order_comments').val();
            }

            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };
});
