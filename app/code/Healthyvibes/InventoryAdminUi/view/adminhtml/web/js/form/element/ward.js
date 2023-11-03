/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Healthyvibes_InventoryAdminUi/js/form/element/update/ward'
], function (Ward) {
    'use strict';

    return Ward.extend({
        defaults: {
            wardScope: 'data.general.ward'
        },

        /**
         * Set ward to source form
         *
         * @param {String} value - ward
         */
        setDifferedFromDefault: function (value) {
            this._super();

            if (parseFloat(value)) {
                this.source.set(this.wardScope, this.indexedOptions[value].label);
            }
        }
    });
});
