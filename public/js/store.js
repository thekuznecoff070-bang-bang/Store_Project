/* Store Project — PHP version */
/* Только тема + утилиты. Каталог и корзина работают через PHP. */

(function () {
    "use strict";

    const THEME_KEY = "store_project_theme_v1";

    // --- Тёмная тема ---
    initTheme();

    const btnTheme = document.getElementById("btnTheme");
    if (btnTheme) {
        btnTheme.addEventListener("click", toggleTheme);
    }

    function initTheme() {
        const saved = getSavedTheme();
        if (saved) {
            document.documentElement.dataset.theme = saved;
            return;
        }
        // Берём настройку из ОС
        const prefersDark = window.matchMedia
            && window.matchMedia("(prefers-color-scheme: dark)").matches;
        document.documentElement.dataset.theme = prefersDark ? "dark" : "light";
    }

    function toggleTheme() {
        const current = document.documentElement.dataset.theme === "dark" ? "dark" : "light";
        const next = current === "dark" ? "light" : "dark";
        document.documentElement.dataset.theme = next;
        try {
            localStorage.setItem(THEME_KEY, next);
        } catch (e) {
            // localStorage недоступен — игнорируем
        }
    }

    function getSavedTheme() {
        try {
            const t = localStorage.getItem(THEME_KEY);
            if (t === "dark" || t === "light") return t;
            return null;
        } catch (e) {
            return null;
        }
    }

})();