(function () {
    if (typeof quickTopDarkMode === 'undefined') {
        return;
    }

    var storageKey = quickTopDarkMode.storageKey || 'quick_top_dark_mode';
    var defaultMode = quickTopDarkMode.defaultMode || 'light';
    var html = document.documentElement;

    function systemPrefersDark() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    function resolveMode(mode) {
        if (mode === 'system') {
            return systemPrefersDark() ? 'dark' : 'light';
        }
        return mode === 'dark' ? 'dark' : 'light';
    }

    function getSavedMode() {
        try {
            var saved = localStorage.getItem(storageKey);
            if (saved === 'dark' || saved === 'light' || saved === 'system') {
                return saved;
            }
        } catch (e) {}
        return defaultMode;
    }

    function setDark(isDark) {
        html.classList.toggle('quick-top-dark-mode', !!isDark);

        var toggleBtn = document.getElementById('quick-top-dark-toggle');
        if (!toggleBtn) {
            return;
        }

        toggleBtn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        var label = isDark
            ? (quickTopDarkMode.labels && quickTopDarkMode.labels.disable) || 'Disable dark mode'
            : (quickTopDarkMode.labels && quickTopDarkMode.labels.enable) || 'Enable dark mode';
        toggleBtn.setAttribute('aria-label', label);
        toggleBtn.setAttribute('title', label);
    }

    function applyMode(mode, persist) {
        var resolved = resolveMode(mode);
        setDark(resolved === 'dark');

        if (persist) {
            try {
                localStorage.setItem(storageKey, mode);
            } catch (e) {}
        }
    }

    function currentPersistedMode() {
        try {
            var saved = localStorage.getItem(storageKey);
            if (saved === 'dark' || saved === 'light') {
                return saved;
            }
        } catch (e) {}
        return html.classList.contains('quick-top-dark-mode') ? 'dark' : 'light';
    }

    function bindToggle() {
        var btn = document.getElementById('quick-top-dark-toggle');
        if (!btn || btn.dataset.quickTopBound === '1') {
            return;
        }

        btn.dataset.quickTopBound = '1';
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            var next = html.classList.contains('quick-top-dark-mode') ? 'light' : 'dark';
            applyMode(next, true);
        });
    }

    function init() {
        bindToggle();
        applyMode(getSavedMode(), false);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Footer scripts may run before the toggle markup; retry shortly.
    setTimeout(init, 0);

    if (window.matchMedia) {
        var media = window.matchMedia('(prefers-color-scheme: dark)');
        var onChange = function () {
            var saved = getSavedMode();
            if (saved === 'system' || (!localStorage.getItem(storageKey) && defaultMode === 'system')) {
                applyMode('system', false);
            }
        };

        if (typeof media.addEventListener === 'function') {
            media.addEventListener('change', onChange);
        } else if (typeof media.addListener === 'function') {
            media.addListener(onChange);
        }
    }

    window.QuickTopDarkMode = {
        enable: function () { applyMode('dark', true); },
        disable: function () { applyMode('light', true); },
        toggle: function () {
            applyMode(currentPersistedMode() === 'dark' ? 'light' : 'dark', true);
        },
        isDark: function () {
            return html.classList.contains('quick-top-dark-mode');
        }
    };
})();
