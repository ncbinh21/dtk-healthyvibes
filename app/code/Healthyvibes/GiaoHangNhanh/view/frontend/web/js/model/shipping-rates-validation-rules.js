define([
    'Magento_Customer/js/model/customer'
], function (customer) {
    'use strict';

    return {
        /**
         * @return {Object}
         */
        getRules: function () {
            let rules = {};
            if (!customer.isLoggedIn()) {
                rules = {
                    'city_id': {
                        'required': true
                    },
                    'ward_id': {
                        'required': true
                    }
                };
            }

            return rules;
        }
    };
});
