const defaultOptions = {
    transition: "transition-all",
    duration: 300,
    timing: "ease-in",
    onHide: function () {},
};

function hideDismiss(targetEl, options) {
    options = options || defaultOptions;
    targetEl.classList.add(
        options.transition,
        "duration-" + options.duration,
        options.timing,
        "opacity-0",
    );
    setTimeout(function () {
        targetEl.classList.add("hidden");
    }, options.duration);
    options.onHide(targetEl);
}

function initDismisses() {
    document
        .querySelectorAll("[data-dismiss-target]")
        .forEach(function (triggerEl) {
            var targetId = triggerEl.getAttribute("data-dismiss-target");
            var targetEl = document.querySelector(targetId);
            if (targetEl) {
                triggerEl.addEventListener("click", function (e) {
                    e.preventDefault();
                    hideDismiss(targetEl);
                });
            } else {
                console.error(
                    'The dismiss element with id "' +
                        targetId +
                        '" does not exist. Please check the data-dismiss-target attribute.',
                );
            }
        });
}

export const Dismiss = {
    init: initDismisses,
};
