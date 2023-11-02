define([
    'Magento_Checkout/js/model/resource-url-manager',
    'Magento_Checkout/js/model/quote',
    'mage/storage',
    'Magento_Checkout/js/model/shipping-service',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'Magento_Checkout/js/model/error-processor'
], function (resourceUrlManager, quote, storage, shippingService, rateRegistry, errorProcessor) {
    'use strict';

    return {
        /**
         * Get shipping rates for specified address.
         * @param {Object} address
         */
        getRates: function (address) {
            var cache, serviceUrl, payload;
            var district = '', ward = '', ward_id = '', city_id = '';

            shippingService.isLoading(true);
            cache = rateRegistry.get(address.getCacheKey());
            serviceUrl = resourceUrlManager.getUrlForEstimationShippingMethodsForNewAddress(quote);

            if (typeof address.customAttributes === "undefined") {
                district = jQuery('[name="district"]').val();
                ward_id = jQuery('[name="ward_id"]').val();
                ward = jQuery('[name="ward"]').val();
                city_id = jQuery('[name="city_id"]').val();
            } else {
                jQuery.each(address.customAttributes, function (k, v) {
                    if (v.attribute_code == 'district') {
                        district = v.value;
                    }
                    if (v.attribute_code == 'ward_id') {
                        ward_id = v.value;
                    }
                    if (v.attribute_code == 'ward') {
                        ward = v.value;
                    }
                    if (v.attribute_code == 'city_id') {
                        city_id = v.value;
                    }
                });
            }

            payload = JSON.stringify({
                    address: {
                        'street': address.street,
                        'city': address.city,
                        'region_id': address.regionId,
                        'region': address.region,
                        'country_id': address.countryId,
                        'postcode': address.postcode,
                        'email': address.email,
                        'customer_id': address.customerId,
                        'firstname': address.firstname,
                        'lastname': address.lastname,
                        'middlename': address.middlename,
                        'prefix': address.prefix,
                        'suffix': address.suffix,
                        'vat_id': address.vatId,
                        'company': address.company,
                        'telephone': address.telephone,
                        'fax': address.fax,
                        'custom_attributes': address.customAttributes,
                        'extension_attributes': {
                            'district': district,
                            'ward': ward,
                            'ward_id': ward_id,
                            'city_id': city_id
                        },
                        'save_in_address_book': address.saveInAddressBook
                    }
                }
            );

            if (cache) {
                shippingService.setShippingRates(cache);
                shippingService.isLoading(false);
            } else {
                storage.post(
                    serviceUrl, payload, false
                ).done(function (result) {
                    rateRegistry.set(address.getCacheKey(), result);
                    shippingService.setShippingRates(result);
                }).fail(function (response) {
                    shippingService.setShippingRates([]);
                    errorProcessor.process(response);
                }).always(function () {
                    shippingService.isLoading(false);
                });
            }
        }
    };
});
