import { DarkMode } from "./darkmode.js";
import { TypeAhead } from "./typeahead.js";
import { Tabs } from "./tabs.js";
import { Modals } from "./modal.js";
import { Collapses } from "./collapse.js";
import { Dismiss } from "./dismiss.js";
import { Dropdowns } from "./dropdown.js";
import { DatePickers } from "./datepicker.js";

export const Interactions = {
    init: () => {
        DarkMode.init();
        TypeAhead.init();
        Tabs.init();
        Modals.init();
        Collapses.init();
        Dismiss.init();
        Dropdowns.init();
        DatePickers.init();
        window.toggleDarkMode = DarkMode.toggle;
    },
};
