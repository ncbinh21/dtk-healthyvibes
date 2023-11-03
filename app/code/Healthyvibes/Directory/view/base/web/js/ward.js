define([
    'jquery',
    'mage/translate',
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select',
    'Magento_Ui/js/form/element/region',
    'domReady!'
], function ($,$t,_, registry, Select) {
    'use strict';

    let isEvent = true;

    return Select.extend({
        defaults: {
            imports: {
                update: '${ $.parentName }.city_id:value'
            },
            exports: {
                wardValue: '${ $.parentName }.ward:value',
            },
            visible: true,
            wardValue: null,
            tracks: {
                wardValue: true,
                value: true,
            },
        },

        initialize: function () {
            this._super();
            this.resetFields();
            return this;
        },

        resetRegion: function () {
            registry.get((this.parentName + '.' + 'region_id'), function (regionId) { //customName == custom Entry??
                $('select[name=ward_id]').html(`<option value="0000">${$t("Please select a ward.")}</option>`);
            });
        },

        onUpdate: function (value) {
            //this._super(); remove because required when load page

            if ( this.indexedOptions[value] && this.indexedOptions[value] !== '0000') {
                this.wardValue = this.indexedOptions[value]['title'];
            }

            if (isEvent) {
                var self = this;
                self.resetRegion();
                window.addEventListener("load", self.resetRegion());

                window.removeEventListener("load", self.resetRegion());
                isEvent = false;
            }
        },

        update: function (value) {
            var city = registry.get(this.parentName + '.' + 'city_id'), options = city.indexedOptions, option;
            this.currentCity = value;
            option = options[value]; //value: city_id

            if (typeof option === 'undefined') {
                return;
            } else {
                $('select[name=ward_id]').find('option:not([value])').remove();
                registry.get((this.parentName + '.' + 'ward_id'), function (wardId) {
                    wardId.value($('select[name=ward_id]').find('option:selected').val());
                });
            }
        },

        hideOrigWard: function () {
            registry.get((this.parentName + '.' + 'ward'), function (ward) {
                ward.validation['required-entry'] = false;
                ward.visible(false);
            });
            registry.get((this.parentName + '.' + 'ward_id'), function (wardId) {
                wardId.validation['required-entry'] = true;
            });
        },

        resetFields: function () {
            this.hideOrigWard();
        }
    });
});
