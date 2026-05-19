<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password — CardioWatch</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Sora:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/tabler-icons.min.css" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html[data-theme="light"] {
            --red: #C93C3B;
            --red-soft: rgba(201, 60, 59, .09);
            --red-border: rgba(201, 60, 59, .25);
            --bg-page: #FAFAF8;
            --bg-topbar: #FFFFFF;
            --bg-card: #FFFFFF;
            --border: #E8E8E4;
            --border-md: #D4D4CE;
            --text: #111110;
            --text-2: #5C5C56;
            --muted: #A0A09A;
            --muted2: #B8B8B2;
            --grid-color: rgba(0, 0, 0, .04);
            --shadow: 0 0 0 1px rgba(0, 0, 0, .06), 0 4px 16px rgba(0, 0, 0, .06);
            --mono: 'Share Tech Mono', monospace;
        }

        html[data-theme="dark"] {
            --red: #E24B4A;
            --red-soft: rgba(226, 75, 74, .09);
            --red-border: rgba(226, 75, 74, .25);
            --bg-page: #0E0E0D;
            --bg-topbar: #191918;
            --bg-card: #191918;
            --border: #2C2C2A;
            --border-md: #3C3C38;
            --text: #F0F0EC;
            --text-2: #9A9A92;
            --muted: #5A5A54;
            --muted2: #4A4A44;
            --grid-color: rgba(255, 255, 255, .03);
            --shadow: 0 0 0 1px rgba(255, 255, 255, .06), 0 4px 16px rgba(0, 0, 0, .25);
            --mono: 'Share Tech Mono', monospace;
        }

        html,
        body {
            background: var(--bg-page);
            min-height: 100vh;
            transition: background .25s, color .25s;
        }

        body {
            font-family: 'Sora', sans-serif;
            color: var(--text);
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(var(--grid-color) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            background: var(--bg-topbar);
            border-bottom: 1px solid var(--border);
            padding: 0 36px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .wm-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand {
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: var(--text);
        }

        .brand span {
            color: var(--red);
        }

        .theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            border: 1px solid var(--border-md);
            border-radius: 8px;
            padding: 0 12px;
            height: 32px;
            font-size: 12px;
            color: var(--text-2);
            cursor: pointer;
            transition: all .15s;
            font-family: 'Sora', sans-serif;
        }

        .theme-toggle:hover {
            color: var(--text);
            border-color: var(--red);
        }

        .theme-toggle svg {
            width: 13px;
            height: 13px;
        }

        .page-wrap {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 60px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .form-wrap {
            width: 100%;
            max-width: 420px;
        }

        .form-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--red-soft);
            border: 1px solid var(--red-border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 22px;
            color: var(--red);
        }

        .form-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            box-shadow: var(--shadow);
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 7px;
        }

        .field input {
            width: 100%;
            height: 42px;
            background: var(--bg-page);
            border: 1px solid var(--border-md);
            border-radius: 9px;
            padding: 0 14px;
            font-size: 13px;
            color: var(--text);
            font-family: 'Sora', sans-serif;
            outline: none;
            transition: border-color .15s;
        }

        .field input:focus {
            border-color: var(--red);
        }

        .field input[readonly] {
            opacity: .55;
            cursor: default;
        }

        .pw-wrap {
            position: relative;
        }

        .pw-wrap input {
            padding-right: 42px;
        }

        .pw-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 16px;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .pw-eye:hover {
            color: var(--text-2);
        }

        .field-error {
            font-size: 11px;
            color: #8a1818;
            margin-top: 5px;
        }

        html[data-theme="dark"] .field-error {
            color: #E24B4A;
        }

        .strength {
            display: flex;
            gap: 4px;
            margin-top: 7px;
        }

        .strength-bar {
            height: 3px;
            flex: 1;
            border-radius: 99px;
            background: var(--border);
            transition: background .3s;
        }

        .strength-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--muted2);
            margin-top: 4px;
        }

        .match-hint {
            font-size: 11px;
            margin-top: 5px;
        }

        .btn-submit {
            width: 100%;
            height: 42px;
            background: var(--red);
            border: none;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: opacity .15s;
            font-family: 'Sora', sans-serif;
            margin-top: 8px;
        }

        .btn-submit:hover {
            opacity: .88;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--muted);
            text-decoration: none;
            margin-top: 20px;
            justify-content: center;
            transition: color .15s;
        }

        .back-link:hover {
            color: var(--text);
        }

        .alert-error {
            background: rgba(180, 30, 30, .07);
            border: 1px solid rgba(180, 30, 30, .22);
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .alert-error i {
            color: #8a1818;
            font-size: 18px;
            margin-top: 1px;
        }

        .alert-error p {
            font-size: 12.5px;
            color: #8a1818;
            line-height: 1.5;
            margin: 0;
        }

        html[data-theme="dark"] .alert-error {
            background: rgba(226, 75, 74, .08);
            border-color: rgba(226, 75, 74, .28);
        }

        html[data-theme="dark"] .alert-error i,
        html[data-theme="dark"] .alert-error p {
            color: #E24B4A;
        }
    </style>
</head>

<body>

    <!-- Topbar -->
    <div class="topbar">
        <a class="logo" href="/">
            <div class="wm-icon">
                <svg width="16" height="16" viewBox="0 0 28 28" fill="none">
                    <path d="M2 14h5l3-8 4 16 3-10 3 6 2-4h4" stroke="#fff" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div class="brand"><span>Cardio</span>Watch</div>
        </a>
    </div>

    <!-- Page -->
    <div class="page-wrap">
        <div class="form-wrap">

            <div class="form-icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 3 5 6v5c0 4.6 2.9 8.7 7 10 4.1-1.3 7-5.4 7-10V6l-7-3z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 12h6v5H9z" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10.5 12v-1.5a1.5 1.5 0 0 1 3 0V12" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="form-title">Set new password</div>
            <div class="form-sub">Choose a strong password for your account. You'll be redirected to login once it's
                reset.</div>

            <div class="card">

                @error('email')
                    <div class="alert-error">
                        <i class="ti ti-alert-circle"></i>
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="field">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}"
                            readonly>
                    </div>

                    <div class="field">
                        <label for="password">New password</label>
                        <div class="pw-wrap">
                            <input type="password" id="password" name="password" placeholder="Min. 8 characters"
                                required oninput="checkStrength(this.value)">
                            <button type="button" class="pw-eye" onclick="togglePw('password', this)"
                                aria-label="Toggle visibility">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                        <div class="strength">
                            <div class="strength-bar" id="s1"></div>
                            <div class="strength-bar" id="s2"></div>
                            <div class="strength-bar" id="s3"></div>
                            <div class="strength-bar" id="s4"></div>
                        </div>
                        <div class="strength-label" id="sLabel"></div>
                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm password</label>
                        <div class="pw-wrap">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Re-enter new password" required oninput="checkMatch()">
                            <button type="button" class="pw-eye" onclick="togglePw('password_confirmation', this)"
                                aria-label="Toggle visibility">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                        <div class="match-hint" id="matchHint"></div>
                    </div>

                    <button type="submit" class="btn-submit">Reset Password</button>
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="ti ti-arrow-left"></i> Back to login
                    </a>
                </form>
            </div>

        </div>
    </div>

    <script>
        /* Theme */
        const html = document.documentElement;
        const themeBtn = document.getElementById('themeBtn');
        const themeIco = document.getElementById('themeIcon');
        const moonSVG =
            `<circle cx="12" cy="12" r="5.5" fill="currentColor" stroke="none"/><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" stroke="none"/>`;
        const sunSVG =
            `<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>`;
        const saved = localStorage.getItem('cw-theme');
        if (saved && saved !== 'light') {
            html.setAttribute('data-theme', saved);
            themeIco.innerHTML = moonSVG;
        }
        themeBtn.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            themeIco.innerHTML = next === 'light' ? sunSVG : moonSVG;
            localStorage.setItem('cw-theme', next);
        });

        /* Password toggle */
        function togglePw(id, btn) {
            const inp = document.getElementById(id);
            const isText = inp.type === 'text';
            inp.type = isText ? 'password' : 'text';
            btn.querySelector('i').className = 'ti ' + (isText ? 'ti-eye' : 'ti-eye-off');
        }

        /* Strength meter */
        function checkStrength(v) {
            let score = 0;
            if (v.length >= 8) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^A-Za-z0-9]/.test(v)) score++;
            const colors = ['', '#C93C3B', '#BA7517', '#639922', '#0F6E56'];
            const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
            for (let i = 1; i <= 4; i++) {
                document.getElementById('s' + i).style.background = i <= score ? colors[score] : 'var(--border)';
            }
            const lbl = document.getElementById('sLabel');
            lbl.textContent = v.length ? labels[score] : '';
            lbl.style.color = v.length ? colors[score] : 'var(--muted2)';
            checkMatch();
        }

        /* Match hint */
        function checkMatch() {
            const pw = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;
            const hint = document.getElementById('matchHint');
            if (!conf) {
                hint.textContent = '';
                return;
            }
            const match = pw === conf;
            hint.textContent = match ? 'Passwords match' : 'Passwords do not match';
            hint.style.color = match ? '#2a6e24' : '#8a1818';
        }
    </script>
</body>

</html>
