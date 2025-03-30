function selectTabFromUrlFragment() {
    const fragment = window.location.hash;
    if (fragment.length > 1) {
        const tab = document.querySelector(fragment);
        if (tab) {
            const tabHeaderId = tab.getAttribute("aria-labelledby");
            if (tabHeaderId) {
                document
                    .getElementById(tabHeaderId)
                    .setAttribute("aria-selected", "true");
            }
        }
    }
}

function initTabs() {
    selectTabFromUrlFragment();
    document.querySelectorAll('[data-tabs-toggle]').forEach(function (parentEl) {
        const tabItems = [];
        const activeClasses = parentEl.getAttribute('data-tabs-active-classes') || 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500';
        const inactiveClasses = parentEl.getAttribute('data-tabs-inactive-classes') || 'dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300';
        let defaultTabId = null;

        parentEl.querySelectorAll('[role="tab"]').forEach(function (triggerEl) {
            const isActive = triggerEl.getAttribute('aria-selected') === 'true';
            const targetSelector = triggerEl.getAttribute('data-tabs-target');
            const targetEl = document.querySelector(targetSelector);
            tabItems.push({
                id: targetSelector,
                triggerEl: triggerEl,
                targetEl: targetEl
            });
            if (isActive) {
                defaultTabId = targetSelector;
            }
        });

        tabItems.forEach(function (tab) {
            tab.triggerEl.addEventListener('click', function (e) {
                e.preventDefault();
                // Deactivate all tabs
                tabItems.forEach(function (t) {
                    t.triggerEl.setAttribute('aria-selected', 'false');
                    t.triggerEl.classList.remove(...activeClasses.split(' '));
                    t.triggerEl.classList.add(...inactiveClasses.split(' '));
                    if (t.targetEl) {
                        t.targetEl.classList.add('hidden');
                    }
                });
                // Activate clicked tab
                tab.triggerEl.setAttribute('aria-selected', 'true');
                tab.triggerEl.classList.add(...activeClasses.split(' '));
                tab.triggerEl.classList.remove(...inactiveClasses.split(' '));
                if (tab.targetEl) {
                    tab.targetEl.classList.remove('hidden');
                }
            });
        });

        // Activate default tab if set, otherwise activate the first tab
        if (defaultTabId) {
            const defaultTab = tabItems.find(function (tab) {
                return tab.id === defaultTabId;
            });
            if (defaultTab) {
                defaultTab.triggerEl.click();
            }
        } else if (tabItems.length > 0) {
            tabItems[0].triggerEl.click();
        }
    });
}

export const Tabs = {
    init: initTabs
};
