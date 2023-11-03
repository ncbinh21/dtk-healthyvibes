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
                cityOptions: '${ $.parentName }.city_id:indexedOptions',
                update: '${ $.parentName }.city_id:value'
            }
        },

        /**
         * {@inheritdoc}
         */
        initialize: function () {
            var option;

            this._super();

            option = _.find(this.cityOptions, function (row) {
                return row['is_default'] === true;
            });
            this.hideWard(option);

            return this;
        },

        /**
         * Method called every time city selector's value gets changed.
         * Updates all validations and requirements for certain ward.
         * @param {String} value - Selected ward ID.
         */
        update: function (value) {
            var isWardRequired,
                option;

            if (!value) {
                return;
            }

            option = _.isObject(this.cityOptions) && this.cityOptions[value];

            if (!option) {
                return;
            }

            this.hideWard(option);
            isWardRequired = !this.skipValidation && !!option['is_ward_required'];

            if (!isWardRequired) {
                this.error(false);
            }

            this.required(isWardRequired);
            this.validation['required-entry'] = isWardRequired;

            registry.get(this.customName, function (input) {
                input.required(isWardRequired);
                input.validation['required-entry'] = isWardRequired;
                input.validation['validate-not-number-first'] = !this.options().length;
            }.bind(this));
        },

        /**
         * Hide select and corresponding text input field if ward must not be shown for selected city.
         *
         * @private
         * @param {Object}option
         */
        hideWard: function (option) {
            if (!option || option['is_ward_visible'] !== false) {
                return;
            }

            this.setVisible(false);

            if (this.customEntry) {
                this.toggleInput(false);
            }
        }
    });
});
