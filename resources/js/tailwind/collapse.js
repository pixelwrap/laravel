const Default = {
    onCollapse: () => {
    },
    onExpand: () => {
    },
    onToggle: () => {
    },
};

class Collapse {
    constructor(targetEl = null, triggerEl = null, options = Default) {
        this._targetEl = targetEl;
        this._triggerEl = triggerEl;
        this._options = Object.assign({}, Default, options);
        this._visible = false;
        this._initialized = false;
        this.init();
    }

    init() {
        if (this._triggerEl && this._targetEl && !this._initialized) {
            if (this._triggerEl.hasAttribute("aria-expanded")) {
                this._visible =
                    this._triggerEl.getAttribute("aria-expanded") === "true";
            } else {
                this._visible = !this._targetEl.classList.contains("hidden");
            }

            // Set initial state
            if (!this._visible) {
                this._targetEl.classList.add("hidden", "max-h-0", "opacity-0");
                this._triggerEl
                    .querySelector(".chevron")
                    ?.classList.remove("rotate-180");
            } else {
                this._targetEl.classList.add("max-h-screen", "opacity-100");
                this._triggerEl
                    .querySelector(".chevron")
                    ?.classList.add("rotate-180");
            }

            this._clickHandler = () => {
                this.toggle();
            };

            this._triggerEl.addEventListener("click", this._clickHandler);
            this._initialized = true;
        }
    }

    destroy() {
        if (this._triggerEl && this._initialized) {
            this._triggerEl.removeEventListener("click", this._clickHandler);
            this._initialized = false;
        }
    }

    collapse() {
        // Prepare for collapse animation
        this._targetEl.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';
        this._targetEl.classList.remove("max-h-screen", "opacity-100");
        this._targetEl.classList.add("max-h-0", "opacity-0");
        this._triggerEl
            .querySelector(".chevron")
            ?.classList.remove("rotate-180");

        const transitionEndHandler = () => {
            if (!this._visible) {
                this._targetEl.classList.add("hidden");
            }
            this._targetEl.removeEventListener(
                "transitionend",
                transitionEndHandler,
            );
        };

        this._targetEl.addEventListener("transitionend", transitionEndHandler);

        if (this._triggerEl) {
            this._triggerEl.setAttribute("aria-expanded", "false");
        }
        this._visible = false;
        this._options.onCollapse(this);
    }

    expand() {
        // Prepare element for expansion
        this._targetEl.classList.remove("hidden");
        this._targetEl.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';

        // Force a reflow before applying the transition classes
        void this._targetEl.offsetHeight;

        // Apply expanding classes
        this._targetEl.classList.remove("max-h-0", "opacity-0");
        this._targetEl.classList.add("max-h-screen", "opacity-100");
        this._triggerEl.querySelector(".chevron")?.classList.add("rotate-180");

        // Clean up after expansion
        const transitionEndHandler = () => {
            if (this._visible) {
                // Ensure classes are in correct state
                this._targetEl.classList.remove("max-h-0", "opacity-0");
            }
            this._targetEl.removeEventListener(
                "transitionend",
                transitionEndHandler,
            );
        };

        this._targetEl.addEventListener("transitionend", transitionEndHandler);

        if (this._triggerEl) {
            this._triggerEl.setAttribute("aria-expanded", "true");
        }
        this._visible = true;
        this._options.onExpand(this);
    }

    toggle() {
        if (this._visible) {
            this.collapse();
        } else {
            this.expand();
        }
        this._options.onToggle(this);
    }

    updateOnCollapse(callback) {
        this._options.onCollapse = callback;
    }

    updateOnExpand(callback) {
        this._options.onExpand = callback;
    }

    updateOnToggle(callback) {
        this._options.onToggle = callback;
    }
}

function setupCollapseTriggers() {
    document.querySelectorAll("[data-collapse-toggle]").forEach((triggerEl) => {
        const targetId = triggerEl.getAttribute("data-collapse-toggle");
        const targetEl = document.getElementById(targetId);
        if (targetEl) {
            new Collapse(targetEl, triggerEl);
        } else {
            console.error(
                `The target element with id "${targetId}" does not exist. Please check the data-collapse-toggle attribute.`,
            );
        }
    });
}

function initCollapses() {
    setupCollapseTriggers();
}

export const Collapses = {
    init: initCollapses,
};
