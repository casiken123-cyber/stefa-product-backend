(function () {
    var EYE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    var EYE_OFF = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.94 17.94A10.9 10.9 0 0 1 12 19c-7 0-11-7-11-7a19.8 19.8 0 0 1 5.06-5.94"></path><path d="M9.9 4.24A10.9 10.9 0 0 1 12 5c7 0 11 7 11 7a19.9 19.9 0 0 1-3.17 4.19"></path><path d="M14.12 14.12A3 3 0 1 1 9.88 9.88"></path><path d="M1 1l22 22"></path></svg>';

    var style = document.createElement('style');
    style.textContent =
        '.pw-wrap{position:relative;display:block;width:100%}' +
        '.pw-wrap > input.pw-input{width:100%;padding-right:48px}' +
        '.pw-wrap > input.pw-input::-ms-reveal{display:none}' +
        '.pw-toggle{position:absolute;top:50%;right:8px;transform:translateY(-50%);width:34px;height:34px;' +
            'display:flex;align-items:center;justify-content:center;padding:0;border:none;border-radius:8px;' +
            'background:transparent;color:#5F5A53;cursor:pointer;transition:background .15s ease,color .15s ease}' +
        '.pw-toggle:hover{background:rgba(17,17,17,.07);color:#111}' +
        '.pw-toggle:focus-visible{outline:3px solid rgba(255,122,41,.55);outline-offset:1px}' +
        '.pw-toggle svg{width:19px;height:19px}';
    document.head.appendChild(style);

    var all = [];

    function enhance(input) {
        if (input.dataset.pwToggle) return;
        input.dataset.pwToggle = '1';

        var wrap = document.createElement('div');
        wrap.className = 'pw-wrap';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);
        input.classList.add('pw-input');

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pw-toggle';
        btn.setAttribute('aria-label', 'Show password');
        btn.setAttribute('aria-pressed', 'false');
        btn.innerHTML = EYE;
        wrap.appendChild(btn);

        function setVisible(visible) {
            input.type = visible ? 'text' : 'password';
            btn.innerHTML = visible ? EYE_OFF : EYE;
            btn.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
            btn.setAttribute('aria-pressed', visible ? 'true' : 'false');
        }

        // Keep focus in the input when the eye is clicked
        btn.addEventListener('mousedown', function (e) { e.preventDefault(); });
        btn.addEventListener('click', function () {
            setVisible(input.type === 'password');
            input.focus();
        });

        // Always go back to hidden after submit/reset, or when the tab is hidden
        if (input.form) {
            input.form.addEventListener('submit', function () { setVisible(false); });
            input.form.addEventListener('reset', function () { setVisible(false); });
        }
        all.push(setVisible);
    }

    function init() {
        document.querySelectorAll('input[type="password"]').forEach(enhance);
    }

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) all.forEach(function (fn) { fn(false); });
    });
    window.addEventListener('pagehide', function () { all.forEach(function (fn) { fn(false); }); });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();