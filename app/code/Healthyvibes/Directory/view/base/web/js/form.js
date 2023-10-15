/**
 * Copyright © Wedo, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* eslint-disable strict */
define(["prototype", "mage/adminhtml/events"], function () {
    window.InputSelectUpdater = Class.create();
    InputSelectUpdater.prototype = {
        /**
         * @param {HTMLElement} triggerEl
         * @param {HTMLElement} textEl
         * @param {HTMLElement} selectEl
         * @param {Object} optionsData
         * @param {*} disableAction
         * @param {*} clearValueOnDisable
         */
        initialize: function (
            triggerEl,
            textEl,
            selectEl,
            optionsData,
            disableAction,
            clearValueOnDisable
        ) {
            this.selectElId = selectEl;
            this.triggerEl = $(triggerEl);
            this.textEl = $(textEl);
            this.selectEl = $(selectEl);
            this.optionsData = optionsData;
            this.disableAction =
                typeof disableAction === "undefined" ? "hide" : disableAction;
            this.clearValueOnDisable =
                typeof clearValueOnDisable === "undefined"
                    ? false
                    : clearValueOnDisable;

            if (this.selectEl.options.length <= 1) {
                this.updateSelect();
            } else {
                this.lastTriggerValue = this.triggerEl.value;
                this.lastSelectValue = this.selectEl.value;
            }

            this.triggerEl.changeUpdater = this.updateSelect.bind(this);

            Event.observe(
                this.triggerEl,
                "change",
                this.updateSelect.bind(this)
            );
            Event.observe(this.selectEl, "change", this.updateInput.bind(this));

            var self = this;
            varienGlobalEvents.attachEventHandler(
                "address_country_changed",
                function () {
                    self.updateSelect();
                }
            );
            document.observe("form:field:update:" + triggerEl, function () {
                self.updateSelect();
            });
        },

        /**
         * Update Select Element.
         */
        updateSelect: function () {
            var option, selectValueOption, def, selectValue;

            if (this.optionsData[this.triggerEl.value] && !this.triggerEl.disabled) {
                if (this.lastTriggerValue != this.triggerEl.value) {
                    //eslint-disable-line eqeqeq
                    def = this.selectEl.getAttribute("defaultValue");

                    if (this.textEl) {
                        if (!def) {
                            def = this.textEl.value.toLowerCase();
                        }
                    }

                    this.selectEl.options.length = 1;

                    for (selectValue in this.optionsData[
                        this.triggerEl.value
                    ]) {
                        //eslint-disable-line guard-for-in
                        selectValueOption =
                            this.optionsData[this.triggerEl.value][selectValue];

                        option = document.createElement("OPTION");
                        option.value = selectValue;
                        option.text = selectValueOption.name.stripTags();
                        option.title = selectValueOption.name;

                        if (this.selectEl.options.add) {
                            this.selectEl.options.add(option);
                        } else {
                            this.selectEl.appendChild(option);
                        }

                        if (
                            selectValue == def ||
                            selectValueOption.name.toLowerCase() == def
                        ) {
                            //eslint-disable-line
                            this.selectEl.value = selectValue;
                            this.textEl.value = selectValueOption.name;
                        }
                    }
                }

                if (this.disableAction == "hide") {
                    //eslint-disable-line eqeqeq
                    if (this.textEl) {
                        this.textEl.style.display = "none";
                        this.textEl.style.disabled = true;
                    }
                    this.selectEl.style.display = "";
                    this.selectEl.disabled = false;
                } else if (this.disableAction == "disable") {
                    //eslint-disable-line eqeqeq
                    if (this.textEl) {
                        this.textEl.disabled = true;
                    }
                    this.selectEl.disabled = false;
                }
                this.setMarkDisplay(this.selectEl, true);

                this.lastTriggerValue = this.triggerEl.value;
                this.lastSelectValue = this.selectEl.value;

                if ($$(".field.field-suburb #" + this.selectElId).length > 0) {
                    $$(".field.field-suburb")[0].show();
                }
            } else {
                if (this.disableAction == "hide") {
                    //eslint-disable-line eqeqeq
                    if (this.textEl) {
                        this.textEl.style.display = "";
                        this.textEl.style.disabled = false;
                    }
                    this.selectEl.style.display = "none";
                    this.selectEl.disabled = true;
                    this.selectEl.value = "";
                } else if (this.disableAction == "disable") {
                    //eslint-disable-line eqeqeq
                    if (this.textEl) {
                        this.textEl.disabled = false;
                    }
                    this.selectEl.disabled = true;

                    if (this.clearValueOnDisable) {
                        this.selectEl.value = "";
                    }
                } else if (this.disableAction == "nullify") {
                    //eslint-disable-line eqeqeq
                    this.selectEl.options.length = 1;
                    this.selectEl.value = "";
                    this.selectEl.selectedIndex = 0;
                    this.lastTriggerValue = "";
                    this.lastSelectValue = "";
                }
                this.setMarkDisplay(this.selectEl, false);
            }

            if (this.lastTriggerValue == "") {
                this.selectEl.style.display = "none";
                this.textEl.style.display = "none";
            }
            document.fire("form:field:update:" + this.selectEl.getAttribute("id"));
        },

        /**
         * Update input element.
         */
        updateInput: function (event) {
            var selectOption,
                selectOptionValue,
                selectedSelectId,
                selectedTriggerValue;
            selectedSelectId = event.target.value;
            selectedTriggerValue = this.triggerEl.value;
            if (this.optionsData[selectedTriggerValue]) {
                if (this.lastSelectValue != selectedSelectId) {
                    for (selectOptionValue in this.optionsData[
                        selectedTriggerValue
                    ]) {
                        selectOption =
                            this.optionsData[selectedTriggerValue][
                                selectedSelectId
                            ];

                        if (
                            this.textEl &&
                            selectOptionValue == selectedSelectId
                        ) {
                            this.textEl.value = selectOption.name;
                        }
                    }
                }
            }
        },

        /**
         * @param {HTMLElement} elem
         * @param {*} display
         */
        setMarkDisplay: function (elem, display) {
            var marks;

            if (elem.parentNode.parentNode) {
                marks = Element.select(elem.parentNode.parentNode, ".required");

                if (marks[0]) {
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        },
    };

    window.inputSelectUpdater = InputSelectUpdater;
});
