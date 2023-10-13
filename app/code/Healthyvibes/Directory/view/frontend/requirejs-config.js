var config = {
    map: {
        '*': {
            cityUpdater: 'Healthyvibes_Directory/js/city-updater',
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Healthyvibes_Directory/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/model/address-converter': {
                'Healthyvibes_Directory/js/model/address-converter-mixin': true
            }
        }
    }
};
