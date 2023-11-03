/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function (_, registry, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            skipValidation: false,
            imports: {
                regionOptions: '${ $.parentName }.region_id:indexedOptions',
                update: '${ $.parentName }.region_id:value'
            }
        },

        /**
         * {@inheritdoc}
         */
        initialize: function () {
            var option;

            this._super();

            option = _.find(this.regionOptions, function (row) {
                return row['is_default'] === true;
            });
            this.hideCity(option);

            return this;
        },

        /**
         * Method called every time region selector's value gets changed.
         * Updates all validations and requirements for certain city.
         * @param {String} value - Selected region ID.
         */
        update: function (value) {
            var isCityRequired,
                option;

            if (!value) {
                return;
            }

            option = _.isObject(this.regionOptions) && this.regionOptions[value];

            if (!option) {
                return;
            }

            this.hideCity(option);
            isCityRequired = !this.skipValidation && !!option['is_city_required'];

            if (!isCityRequired) {
                this.error(false);
            }

            this.required(isCityRequired);
            this.validation['required-entry'] = isCityRequired;

            registry.get(this.customName, function (input) {
                input.required(isCityRequired);
                input.validation['required-entry'] = isCityRequired;
                input.validation['validate-not-number-first'] = !this.options().length;
            }.bind(this));
        },

        /**
         * Hide select and corresponding text input field if city must not be shown for selected region.
         *
         * @private
         * @param {Object}option
         */
        hideCity: function (option) {
            if (!option || option['is_city_visible'] !== false) {
                return;
            }

            this.setVisible(false);

            if (this.customEntry) {
                this.toggleInput(false);
            }
        }
    });
});
