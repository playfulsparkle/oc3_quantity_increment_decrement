(function (global) {
    'use strict';

    const SELECTOR_ACTION = '[data-ps-action]';
    const ATTR_MINIMUM = 'data-ps-minimum';
    const SELECTOR_CONTAINER = '.ps-input-group';
    const SELECTOR_INPUT = 'input[name="quantity"]';

    const toInteger = (value, fallback, validator) => {
        const num = parseFloat(value);
        if (isNaN(num)) return fallback;
        const intVal = Math.floor(num);
        return (validator && !validator(intVal)) ? fallback : intVal;
    };

    const getBounds = (input) => {
        const min = toInteger(input.getAttribute(ATTR_MINIMUM), 1, n => n >= 0);
        return { min, max: Infinity };
    };

    const clampAndWrite = (input, value, min, max) => {
        const clamped = Math.min(Math.max(value, min), max);
        if (String(input.value) !== String(clamped)) {
            input.value = clamped;
        }
    };

    const getCurrentValue = (input, bounds) => {
        const raw = input.value;
        let numeric = toInteger(raw, bounds.min);
        // Ensure within bounds
        if (numeric < bounds.min) numeric = bounds.min;
        if (numeric > bounds.max) numeric = bounds.max;
        return numeric;
    };

    const getQuantityValue = (container) => {
        if (!container) return null;
        const input = container.querySelector(SELECTOR_INPUT);
        if (!input) return null;
        const bounds = getBounds(input);
        return getCurrentValue(input, bounds);
    };

    const onClickHandler = (e) => {
        const button = e.target.closest(SELECTOR_ACTION);
        if (!button) return;

        const container = button.closest(SELECTOR_CONTAINER);
        if (!container) return;

        const input = container.querySelector(SELECTOR_INPUT);
        if (!input) return;

        e.preventDefault();

        const bounds = getBounds(input);
        const current = getCurrentValue(input, bounds);
        const action = button.dataset.psAction;
        let nextValue = current;

        if (action === 'increment') {
            nextValue = Math.min(current + 1, bounds.max);
        } else if (action === 'decrement') {
            nextValue = Math.max(current - 1, bounds.min);
        } else {
            return;
        }

        clampAndWrite(input, nextValue, bounds.min, bounds.max);
    };

    const onChangeHandler = (e) => {
        const input = e.target.closest(SELECTOR_INPUT);
        if (!input) return;

        const bounds = getBounds(input);
        const current = getCurrentValue(input, bounds);
        clampAndWrite(input, current, bounds.min, bounds.max);
    };

    const PsIncrementDecrement = {
        toInteger,
        getBounds,
        clampAndWrite,
        getCurrentValue,
        getQuantityValue
    };

    let isAttached = false;

    if (!isAttached) {
        document.addEventListener('click', onClickHandler);
        document.addEventListener('change', onChangeHandler);
        isAttached = true;
    }

    // Expose globally and auto-initialize
    global.PsIncrementDecrement = PsIncrementDecrement;

})(typeof window !== 'undefined' ? window : this);
