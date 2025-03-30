/* eslint-disable no-empty-function */

import {
    Datepicker as FlowbiteDatepicker,
    DateRangePicker as FlowbiteDateRangePicker,
} from "flowbite-datepicker";

const Default = {
    defaultDatepickerId: null,
    autohide: false,
    format: "mm/dd/yyyy",
    maxDate: null,
    minDate: null,
    orientation: "bottom",
    buttons: false,
    autoSelectToday: 0,
    title: null,
    language: "en",
    rangePicker: false,
    onShow: () => {},
    onHide: () => {},
};

class Datepicker {
    constructor(datepickerEl = null, options = {}) {
        this._datepickerEl = datepickerEl;
        this._datepickerInstance = null;
        this._options = Object.assign({}, Default, options);
        this._initialized = false;
        this.init();
    }

    init() {
        if (this._datepickerEl && !this._initialized) {
            if (this._options.rangePicker) {
                this._datepickerInstance = new FlowbiteDateRangePicker(
                    this._datepickerEl,
                    this._getDatepickerOptions(this._options),
                );
            } else {
                this._datepickerInstance = new FlowbiteDatepicker(
                    this._datepickerEl,
                    this._getDatepickerOptions(this._options),
                );
            }
            this._initialized = true;
        }
    }

    destroy() {
        if (this._initialized) {
            this._initialized = false;
            this._datepickerInstance.destroy();
        }
    }

    getDatepickerInstance() {
        return this._datepickerInstance;
    }

    getDate() {
        if (
            this._options.rangePicker &&
            this._datepickerInstance instanceof FlowbiteDateRangePicker
        ) {
            return this._datepickerInstance.getDates();
        }
        if (
            !this._options.rangePicker &&
            this._datepickerInstance instanceof FlowbiteDatepicker
        ) {
            return this._datepickerInstance.getDate();
        }
    }

    setDate(date) {
        if (
            this._options.rangePicker &&
            this._datepickerInstance instanceof FlowbiteDateRangePicker
        ) {
            return this._datepickerInstance.setDates(date);
        }
        if (
            !this._options.rangePicker &&
            this._datepickerInstance instanceof FlowbiteDatepicker
        ) {
            return this._datepickerInstance.setDate(date);
        }
    }

    show() {
        this._datepickerInstance.show();
        this._options.onShow(this);
    }

    hide() {
        this._datepickerInstance.hide();
        this._options.onHide(this);
    }

    _getDatepickerOptions(options) {
        const datepickerOptions = {};

        if (options.buttons) {
            datepickerOptions.todayBtn = true;
            datepickerOptions.clearBtn = true;
            if (options.autoSelectToday) {
                datepickerOptions.todayBtnMode = 1;
            }
        }

        if (options.autohide) {
            datepickerOptions.autohide = true;
        }

        if (options.format) {
            datepickerOptions.format = options.format;
        }

        if (options.maxDate) {
            datepickerOptions.maxDate = options.maxDate;
        }

        if (options.minDate) {
            datepickerOptions.minDate = options.minDate;
        }

        if (options.orientation) {
            datepickerOptions.orientation = options.orientation;
        }

        if (options.title) {
            datepickerOptions.title = options.title;
        }

        if (options.language) {
            datepickerOptions.language = options.language;
        }

        return datepickerOptions;
    }

    updateOnShow(callback) {
        this._options.onShow = callback;
    }

    updateOnHide(callback) {
        this._options.onHide = callback;
    }
}

export function initDatepickers() {
    document
        .querySelectorAll(
            "[datepicker], [inline-datepicker], [date-rangepicker]",
        )
        .forEach(function (datepickerEl) {
            if (datepickerEl) {
                const buttons = datepickerEl.hasAttribute("datepicker-buttons");
                const autoselectToday = datepickerEl.hasAttribute(
                    "datepicker-autoselect-today",
                );
                const autohide = datepickerEl.hasAttribute(
                    "datepicker-autohide",
                );
                const format = datepickerEl.getAttribute("datepicker-format");
                const maxDate = datepickerEl.getAttribute(
                    "datepicker-max-date",
                );
                const minDate = datepickerEl.getAttribute(
                    "datepicker-min-date",
                );
                const orientation = datepickerEl.getAttribute(
                    "datepicker-orientation",
                );
                const title = datepickerEl.getAttribute("datepicker-title");
                const language = datepickerEl.getAttribute(
                    "datepicker-language",
                );
                const rangePicker =
                    datepickerEl.hasAttribute("date-rangepicker");
                new Datepicker(datepickerEl, {
                    buttons: buttons || Default.buttons,
                    autoSelectToday: autoselectToday || Default.autoSelectToday,
                    autohide: autohide || Default.autohide,
                    format: format || Default.format,
                    maxDate: maxDate || Default.maxDate,
                    minDate: minDate || Default.minDate,
                    orientation: orientation || Default.orientation,
                    title: title || Default.title,
                    language: language || Default.language,
                    rangePicker: rangePicker || Default.rangePicker,
                });
            } else {
                console.error(
                    "The datepicker element does not exist. Please check the datepicker attribute.",
                );
            }
        });
}

export const DatePickers = {
    init: initDatepickers,
};
