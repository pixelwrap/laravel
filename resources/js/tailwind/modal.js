const Default = {
    placement: "center",
    backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40",
    backdrop: "dynamic",
    closable: true,
    onHide: () => {},
    onShow: () => {},
    onToggle: () => {},
};

class Modal {
    constructor(el, options = Default) {
        this._el = el;
        this._options = Object.assign({}, Default, options);
        this._isHidden = true;
        this._backdrop = null;
        this._init();
    }

    _init() {
        // Add placement classes
        this._el.classList.add(...this._getPlacementClasses());
        // Hide modal initially
        this._el.classList.add("hidden");
    }

    _getPlacementClasses() {
        const placement = this._options.placement;
        switch (placement) {
            case "top-left":
                return ["justify-start", "items-start"];
            case "top-center":
                return ["justify-center", "items-start"];
            case "top-right":
                return ["justify-end", "items-start"];
            case "center-left":
                return ["justify-start", "items-center"];
            case "center":
                return ["justify-center", "items-center"];
            case "center-right":
                return ["justify-end", "items-center"];
            case "bottom-left":
                return ["justify-start", "items-end"];
            case "bottom-center":
                return ["justify-center", "items-end"];
            case "bottom-right":
                return ["justify-end", "items-end"];
            default:
                return ["justify-center", "items-center"];
        }
    }

    toggle() {
        this._isHidden ? this.show() : this.hide();
        this._options.onToggle(this);
    }

    show() {
        if (this._isHidden) {
            this._el.classList.remove("hidden");
            this._el.classList.add("flex");
            this._el.setAttribute("aria-modal", "true");
            this._el.setAttribute("role", "dialog");
            this._el.removeAttribute("aria-hidden");
            if (this._options.backdrop === "dynamic") {
                this._createBackdrop();
            }
            this._isHidden = false;
            if (this._options.closable) {
                this._addEventListeners();
            }
            document.body.classList.add("overflow-hidden");
            this._options.onShow(this);
        }
    }

    hide() {
        if (!this._isHidden) {
            this._el.classList.add("hidden");
            this._el.classList.remove("flex");
            this._el.setAttribute("aria-hidden", "true");
            this._el.removeAttribute("aria-modal");
            this._el.removeAttribute("role");
            this._destroyBackdrop();
            this._isHidden = true;
            document.body.classList.remove("overflow-hidden");
            if (this._options.closable) {
                this._removeEventListeners();
            }
            this._options.onHide(this);
        }
    }

    _createBackdrop() {
        if (!this._backdrop) {
            const backdrop = document.createElement("div");
            backdrop.className = this._options.backdropClasses;
            document.body.appendChild(backdrop);
            this._backdrop = backdrop;
        }
    }

    _destroyBackdrop() {
        if (this._backdrop) {
            this._backdrop.remove();
            this._backdrop = null;
        }
    }

    _handleOutsideClick = (ev) => {
        if (
            ev.target === this._el ||
            (ev.target === this._backdrop && !this._isHidden)
        ) {
            this.hide();
        }
    };

    _handleKeyDown = (ev) => {
        if (ev.key === "Escape") {
            this.hide();
        }
    };

    _addEventListeners() {
        this._el.addEventListener("click", this._handleOutsideClick, true);
        document.body.addEventListener("keydown", this._handleKeyDown, true);
    }

    _removeEventListeners() {
        this._el.removeEventListener("click", this._handleOutsideClick, true);
        document.body.removeEventListener("keydown", this._handleKeyDown, true);
    }
}

function setupTriggers() {
    // Set up toggle triggers
    document.querySelectorAll("[data-modal-toggle]").forEach((trigger) => {
        const modalId = trigger.getAttribute("data-modal-toggle");
        const modalEl = document.getElementById(modalId);
        if (modalEl && modalEl._modalInstance) {
            trigger.addEventListener("click", () => {
                modalEl._modalInstance.toggle();
            });
        } else {
            console.error(`Modal with id ${modalId} is not initialized.`);
        }
    });

    // Set up show triggers
    document.querySelectorAll("[data-modal-show]").forEach((trigger) => {
        const modalId = trigger.getAttribute("data-modal-show");
        const modalEl = document.getElementById(modalId);
        if (modalEl && modalEl._modalInstance) {
            trigger.addEventListener("click", () => {
                modalEl._modalInstance.show();
            });
        } else {
            console.error(`Modal with id ${modalId} is not initialized.`);
        }
    });

    // Set up hide triggers
    document.querySelectorAll("[data-modal-hide]").forEach((trigger) => {
        const modalId = trigger.getAttribute("data-modal-hide");
        const modalEl = document.getElementById(modalId);
        if (modalEl && modalEl._modalInstance) {
            trigger.addEventListener("click", () => {
                modalEl._modalInstance.hide();
            });
        } else {
            console.error(`Modal with id ${modalId} is not initialized.`);
        }
    });
}

function initModals() {
    // Initialize modals based on data-modal-target attribute
    document.querySelectorAll("[data-modal-target]").forEach((trigger) => {
        const modalId = trigger.getAttribute("data-modal-target");
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
            const placement =
                modalEl.getAttribute("data-modal-placement") ||
                Default.placement;
            const backdrop =
                modalEl.getAttribute("data-modal-backdrop") || Default.backdrop;
            // Create a new Modal instance and attach it to the element for later reference
            modalEl._modalInstance = new Modal(modalEl, {
                placement,
                backdrop,
            });
        } else {
            console.error(`Modal with id ${modalId} not found.`);
        }
    });

    // Set up triggers for toggle, show, and hide actions
    setupTriggers();
}

export const Modals = {
    init: initModals,
};
