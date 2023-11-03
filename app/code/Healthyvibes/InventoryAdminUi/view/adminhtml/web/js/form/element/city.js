/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Healthyvibes_InventoryAdminUi/js/form/element/update/city'
], function (City) {
    'use strict';

    return City.extend({
        defaults: {
            cityScope: 'data.general.city'
        },

        /**
         * Set city to source form
         *
         * @param {String} value - city
         */
        setDifferedFromDefault: function (value) {
            this._super();

            if (parseFloat(value)) {
                this.source.set(this.cityScope, this.indexedOptions[value].label);
            }
        }
    });
});
