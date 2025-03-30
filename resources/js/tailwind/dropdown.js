import { createPopper } from "@popperjs/core";

const Default = {
    placement: "bottom",
    triggerType: "click",
    offsetSkidding: 0,
    offsetDistance: 10,
    delay: 300,
    ignoreClickOutsideClass: false,
    onShow: function () {},
    onHide: function () {},
    onToggle: function () {},
};

class Dropdown {
    constructor(
        targetElement = null,
        triggerElement = null,
        options = Default,
    ) {
        // In plain JS, assume targetElement and triggerElement are provided
        this._targetEl = targetElement;
        this._triggerEl = triggerElement;
        this._options = Object.assign({}, Default, options);
        this._popperInstance = null;
        this._visible = false;
        this._initialized = false;
        this.init();
    }

    init() {
        if (this._triggerEl && this._targetEl && !this._initialized) {
            this._popperInstance = this._createPopperInstance();
            this._setupEventListeners();
            this._initialized = true;
        }
    }

    destroy() {
        const triggerEvents = this._getTriggerEvents();
        if (this._options.triggerType === "click") {
            triggerEvents.showEvents.forEach((ev) => {
                this._triggerEl.removeEventListener(ev, this._clickHandler);
            });
        }
        if (this._options.triggerType === "hover") {
            triggerEvents.showEvents.forEach((ev) => {
                this._triggerEl.removeEventListener(
                    ev,
                    this._hoverShowTriggerElHandler,
                );
                this._targetEl.removeEventListener(
                    ev,
                    this._hoverShowTargetElHandler,
                );
            });
            triggerEvents.hideEvents.forEach((ev) => {
                this._triggerEl.removeEventListener(ev, this._hoverHideHandler);
                this._targetEl.removeEventListener(ev, this._hoverHideHandler);
            });
        }
        if (this._popperInstance) {
            this._popperInstance.destroy();
        }
        this._initialized = false;
    }

    _setupEventListeners() {
        const triggerEvents = this._getTriggerEvents();
        this._clickHandler = () => {
            this.toggle();
        };
        if (this._options.triggerType === "click") {
            triggerEvents.showEvents.forEach((ev) => {
                this._triggerEl.addEventListener(ev, this._clickHandler);
            });
        }
        this._hoverShowTriggerElHandler = (ev) => {
            if (ev.type === "click") {
                this.toggle();
            } else {
                setTimeout(() => {
                    this.show();
                }, this._options.delay);
            }
        };
        this._hoverShowTargetElHandler = () => {
            this.show();
        };
        this._hoverHideHandler = () => {
            setTimeout(() => {
                if (!this._targetEl.matches(":hover")) {
                    this.hide();
                }
            }, this._options.delay);
        };
        if (this._options.triggerType === "hover") {
            triggerEvents.showEvents.forEach((ev) => {
                this._triggerEl.addEventListener(
                    ev,
                    this._hoverShowTriggerElHandler,
                );
                this._targetEl.addEventListener(
                    ev,
                    this._hoverShowTargetElHandler,
                );
            });
            triggerEvents.hideEvents.forEach((ev) => {
                this._triggerEl.addEventListener(ev, this._hoverHideHandler);
                this._targetEl.addEventListener(ev, this._hoverHideHandler);
            });
        }
    }

    _createPopperInstance() {
        return createPopper(this._triggerEl, this._targetEl, {
            placement: this._options.placement,
            modifiers: [
                {
                    name: "offset",
                    options: {
                        offset: [
                            this._options.offsetSkidding,
                            this._options.offsetDistance,
                        ],
                    },
                },
            ],
        });
    }

    _setupClickOutsideListener() {
        this._clickOutsideEventListener = (ev) => {
            this._handleClickOutside(ev, this._targetEl);
        };
        document.body.addEventListener(
            "click",
            this._clickOutsideEventListener,
            true,
        );
    }

    _removeClickOutsideListener() {
        document.body.removeEventListener(
            "click",
            this._clickOutsideEventListener,
            true,
        );
    }

    _handleClickOutside(ev, targetEl) {
        var clickedEl = ev.target;
        var ignoreClickOutsideClass = this._options.ignoreClickOutsideClass;
        var isIgnored = false;
        if (ignoreClickOutsideClass) {
            var ignoredClickOutsideEls = document.querySelectorAll(
                "." + ignoreClickOutsideClass,
            );
            ignoredClickOutsideEls.forEach(function (el) {
                if (el.contains(clickedEl)) {
                    isIgnored = true;
                }
            });
        }
        if (
            clickedEl !== targetEl &&
            !targetEl.contains(clickedEl) &&
            !this._triggerEl.contains(clickedEl) &&
            !isIgnored &&
            this.isVisible()
        ) {
            this.hide();
        }
    }

    _getTriggerEvents() {
        switch (this._options.triggerType) {
            case "hover":
                return {
                    showEvents: ["mouseenter", "click"],
                    hideEvents: ["mouseleave"],
                };
            case "click":
                return { showEvents: ["click"], hideEvents: [] };
            case "none":
                return { showEvents: [], hideEvents: [] };
            default:
                return { showEvents: ["click"], hideEvents: [] };
        }
    }

    toggle() {
        if (this.isVisible()) {
            this.hide();
        } else {
            this.show();
        }
        this._options.onToggle(this);
    }

    isVisible() {
        return this._visible;
    }

    show() {
        this._targetEl.classList.remove("hidden");
        this._targetEl.classList.add("block");
        this._targetEl.removeAttribute("aria-hidden");
        if (this._popperInstance) {
            this._popperInstance.setOptions(function (options) {
                return Object.assign({}, options, {
                    modifiers: [
                        ...options.modifiers,
                        { name: "eventListeners", enabled: true },
                    ],
                });
            });
            this._popperInstance.update();
        }
        this._setupClickOutsideListener();
        this._visible = true;
        this._options.onShow(this);
    }

    hide() {
        this._targetEl.classList.remove("block");
        this._targetEl.classList.add("hidden");
        this._targetEl.setAttribute("aria-hidden", "true");
        if (this._popperInstance) {
            this._popperInstance.setOptions(function (options) {
                return Object.assign({}, options, {
                    modifiers: [
                        ...options.modifiers,
                        { name: "eventListeners", enabled: false },
                    ],
                });
            });
        }
        this._visible = false;
        this._removeClickOutsideListener();
        this._options.onHide(this);
    }

    updateOnShow(callback) {
        this._options.onShow = callback;
    }

    updateOnHide(callback) {
        this._options.onHide = callback;
    }

    updateOnToggle(callback) {
        this._options.onToggle = callback;
    }
}

function initDropdowns() {
    document
        .querySelectorAll("[data-dropdown-toggle]")
        .forEach(function (triggerEl) {
            var dropdownId = triggerEl.getAttribute("data-dropdown-toggle");
            var dropdownEl = document.getElementById(dropdownId);
            if (dropdownEl) {
                var placement = triggerEl.getAttribute(
                    "data-dropdown-placement",
                );
                var offsetSkidding = triggerEl.getAttribute(
                    "data-dropdown-offset-skidding",
                );
                var offsetDistance = triggerEl.getAttribute(
                    "data-dropdown-offset-distance",
                );
                var triggerType = triggerEl.getAttribute(
                    "data-dropdown-trigger",
                );
                var delay = triggerEl.getAttribute("data-dropdown-delay");
                var ignoreClickOutsideClass = triggerEl.getAttribute(
                    "data-dropdown-ignore-click-outside-class",
                );
                new Dropdown(dropdownEl, triggerEl, {
                    placement: placement ? placement : Default.placement,
                    triggerType: triggerType
                        ? triggerType
                        : Default.triggerType,
                    offsetSkidding: offsetSkidding
                        ? parseInt(offsetSkidding)
                        : Default.offsetSkidding,
                    offsetDistance: offsetDistance
                        ? parseInt(offsetDistance)
                        : Default.offsetDistance,
                    delay: delay ? parseInt(delay) : Default.delay,
                    ignoreClickOutsideClass: ignoreClickOutsideClass
                        ? ignoreClickOutsideClass
                        : Default.ignoreClickOutsideClass,
                });
            } else {
                console.error(
                    'The dropdown element with id "' +
                        dropdownId +
                        '" does not exist. Please check the data-dropdown-toggle attribute.',
                );
            }
        });
}

export const Dropdowns = {
    init: initDropdowns,
};
