import { Interactions } from "./interactions";

// Initialize interactions once the DOM is loaded.
document.addEventListener("DOMContentLoaded", () => {
    Interactions.init();
    window.Interactions = Interactions;
});
