'use strict';

var PsIncrementDecrement = {
    // Configuration
    SELECTOR_ACTION: '[data-ps-action]',
    SELECTOR_CONTAINER: '.ps-input-group',
    SELECTOR_INPUT: 'input[name^="quantity"]',

    // Core helpers
    toInteger: function (value, fallback, validator) {
        var num = parseFloat(value);
        if (isNaN(num)) return fallback;
        var intVal = Math.floor(num);
        return (validator && !validator(intVal)) ? fallback : intVal;
    },

    getBounds: function (input) {
        var minAttr = input.getAttribute('min');
        var maxAttr = input.getAttribute('max');

        var min = this.toInteger(minAttr, 1, function (n) { return n >= 0; });
        var max = this.toInteger(maxAttr, Infinity, function (n) { return n >= min; });

        return { min: min, max: max };
    },

    clampAndWrite: function (input, value, min, max) {
        var clamped = Math.min(Math.max(value, min), max);
        if (String(input.value) !== String(clamped)) {
            input.value = clamped;
        }
    },

    getCurrentValue: function (input, bounds) {
        var raw = input.value;
        var numeric = this.toInteger(raw, bounds.min);
        if (numeric < bounds.min) numeric = bounds.min;
        if (numeric > bounds.max) numeric = bounds.max;
        return numeric;
    },

    getQuantityValue: function (productId) {
        var container = document.querySelector('[data-input-group="' + productId + '"]');
        if (!container) return null;
        var input = container.querySelector(this.SELECTOR_INPUT);
        if (!input) return null;
        var bounds = this.getBounds(input);
        return this.getCurrentValue(input, bounds);
    },

    // Event handlers (bound to the object)
    onClickHandler: function (e) {
        var button = e.target.closest(this.SELECTOR_ACTION);
        if (!button) return;

        var container = button.closest(this.SELECTOR_CONTAINER);
        if (!container) return;

        var input = container.querySelector(this.SELECTOR_INPUT);
        if (!input) return;

        e.preventDefault();

        var bounds = this.getBounds(input);
        var current = this.getCurrentValue(input, bounds);
        var action = button.dataset.psAction;
        var nextValue = current;

        if (action === 'increment') {
            nextValue = Math.min(current + 1, bounds.max);
        } else if (action === 'decrement') {
            nextValue = Math.max(current - 1, bounds.min);
        } else {
            return;
        }

        this.clampAndWrite(input, nextValue, bounds.min, bounds.max);
    },

    onChangeHandler: function (e) {
        var input = e.target.closest(this.SELECTOR_INPUT);
        if (!input) return;

        var bounds = this.getBounds(input);
        var current = this.getCurrentValue(input, bounds);
        this.clampAndWrite(input, current, bounds.min, bounds.max);
    },

    // Initialization
    init: function () {
        if (this._isAttached) return;
        document.addEventListener('click', this.onClickHandler.bind(this));
        document.addEventListener('change', this.onChangeHandler.bind(this));
        this._isAttached = true;
    }
};

PsIncrementDecrement.init();
