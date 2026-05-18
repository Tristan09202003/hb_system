<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — CardioWatch</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html[data-theme="light"] {
            --red:        #C93C3B;
            --red-a10:    rgba(201,60,59,.10);
            --red-a20:    rgba(201,60,59,.20);
            --bg:         #FAFAF8;
            --bg-card:    #FFFFFF;
            --border:     #E8E8E4;
            --border-md:  #D4D4CE;
            --text:       #111110;
            --text-2:     #5C5C56;
            --muted:      #A0A09A;
            --input-bg:   #F5F5F2;
            --tinted:     #F8F8F5;
            --grid-color: rgba(0,0,0,.04);
            --shadow-card: 0 0 0 1px rgba(0,0,0,.06), 0 8px 32px rgba(0,0,0,.07);
        }

        html[data-theme="dark"] {
            --red:        #E24B4A;
            --red-a10:    rgba(226,75,74,.10);
            --red-a20:    rgba(226,75,74,.22);
            --bg:         #0E0E0D;
            --bg-card:    #191918;
            --border:     #2C2C2A;
            --border-md:  #3C3C38;
            --text:       #F0F0EC;
            --text-2:     #9A9A92;
            --muted:      #5A5A54;
            --input-bg:   #222220;
            --tinted:     #202020;
            --grid-color: rgba(255,255,255,.03);
            --shadow-card: 0 0 0 1px rgba(255,255,255,.06), 0 8px 32px rgba(0,0,0,.3);
        }

        html, body { height: 100%; }

        body {
            background: var(--bg);
            font-family: 'Sora', sans-serif;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background .25s, color .25s;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image:
                linear-gradient(var(--grid-color) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none; z-index: 0;
        }

        /* ── Nav ── */
        nav {
            position: relative; z-index: 10;
            padding: 20px 36px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .wordmark { display: flex; align-items: center; gap: 10px; text-decoration: none; }

        .wm-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--red);
            display: flex; align-items: center; justify-content: center;
        }

        .wm-text { font-size: 13.5px; font-weight: 700; letter-spacing: -.01em; color: var(--text); }
        .wm-text em { font-style: normal; color: var(--red); }



        /* ── Main ── */
        main {
            position: relative; z-index: 1;
            flex: 1;
            display: flex; align-items: flex-start; justify-content: center;
            padding: 16px 24px 48px;
        }

        /* ── Card ── */
        .card {
            width: 100%; max-width: 520px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            animation: rise .35s cubic-bezier(.22,.61,.36,1) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Hero header ── */
        .card-hero {
            background: var(--red);
            padding: 28px 32px 24px;
            position: relative;
            overflow: hidden;
        }

        /* Dark vignette corner */
        .card-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 120% 120%, rgba(0,0,0,.2) 0%, transparent 55%);
            pointer-events: none;
        }

        .hero-top {
            position: relative; z-index: 2;
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 20px;
        }

        .hero-text {}

        .hero-eyebrow {
            font-family: 'Share Tech Mono', monospace;
            font-size: 10px; letter-spacing: .14em; text-transform: uppercase;
            color: rgba(255,255,255,.55); margin-bottom: 8px;
        }

        .hero-title {
            font-size: 22px; font-weight: 700;
            letter-spacing: -.03em; color: #fff; line-height: 1.2;
        }

        .hero-sub {
            font-size: 12.5px; color: rgba(255,255,255,.65);
            margin-top: 5px; font-weight: 400; line-height: 1.5;
        }

        /* Heart icon in hero */
        .hero-heart {
            flex-shrink: 0;
            animation: hb 1.4s ease-in-out 0.8s infinite;
            opacity: .25;
        }

        .hero-heart svg { width: 44px; height: 44px; }

        @keyframes hb {
            0%, 100% { transform: scale(1); }
            14%       { transform: scale(1.2); }
            28%       { transform: scale(1); }
            42%       { transform: scale(1.13); }
            56%       { transform: scale(1); }
        }

        /* ECG lifeline in hero */
        .hero-ecg {
            position: relative; z-index: 2;
            width: 100%; display: block; overflow: visible;
        }

        .ecg-path {
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
            animation: drawEcg 1.8s cubic-bezier(.4,0,.2,1) .1s forwards;
        }

        @keyframes drawEcg {
            to { stroke-dashoffset: 0; }
        }

        .ecg-glow {
            opacity: 0;
            animation: glowIn .4s ease 1.8s forwards;
        }

        @keyframes glowIn { to { opacity: 1; } }

        /* BPM pill */
        .hero-bpm {
            position: absolute;
            top: 24px; right: 28px; z-index: 3;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 10px;
            padding: 6px 12px;
            display: flex; flex-direction: column; align-items: center;
        }

        .bpm-num {
            font-family: 'Share Tech Mono', monospace;
            font-size: 20px; color: #fff; line-height: 1;
        }

        .bpm-lbl {
            font-size: 8.5px; letter-spacing: .14em; text-transform: uppercase;
            color: rgba(255,255,255,.55); margin-top: 2px;
        }

        /* ── Form body ── */
        .card-body { padding: 28px 32px; }

        .alert {
            padding: 10px 13px; border-radius: 8px;
            font-size: 12.5px; line-height: 1.45; margin-bottom: 20px;
            background: var(--red-a10); border: 1px solid var(--red-a20); color: var(--red);
        }

        /* Section headings */
        .section {
            font-family: 'Share Tech Mono', monospace;
            font-size: 9.5px; letter-spacing: .14em; text-transform: uppercase;
            color: var(--muted);
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 14px; margin-top: 22px;
        }
        .section:first-child { margin-top: 0; }
        .section::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        /* Fields */
        .field { margin-bottom: 11px; }
        .field.no-mb { margin-bottom: 0; }

        label {
            display: block; font-size: 11px; font-weight: 600;
            color: var(--text-2); letter-spacing: .03em;
            text-transform: uppercase; margin-bottom: 6px;
        }

        input, select {
            width: 100%; padding: 11px 13px;
            background: var(--input-bg); border: 1px solid var(--border-md);
            border-radius: 9px; color: var(--text);
            font-family: 'Sora', sans-serif; font-size: 13.5px;
            outline: none; transition: border-color .15s, box-shadow .15s;
            appearance: none;
        }
        input:focus, select:focus {
            border-color: var(--red); box-shadow: 0 0 0 3px var(--red-a10);
        }
        input::placeholder { color: var(--muted); }

        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%23A0A09A' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 13px center;
            padding-right: 34px;
        }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 11px; }

        /* Password bars */
        .pass-bars { display: flex; gap: 4px; margin-top: 6px; }
        .pass-bar { flex: 1; height: 2.5px; border-radius: 99px; background: var(--border); transition: background .25s; }

        .sep { height: 1px; background: var(--border); margin: 22px 0; }

        .btn-submit {
            width: 100%; padding: 12px;
            background: var(--red); border: none; border-radius: 9px;
            color: #fff; font-family: 'Sora', sans-serif;
            font-size: 13.5px; font-weight: 600; letter-spacing: .01em;
            cursor: pointer; transition: filter .15s, transform .1s;
        }
        .btn-submit:hover { filter: brightness(1.07); }
        .btn-submit:active { transform: scale(.99); }

        /* ── Footer ── */
        .card-foot {
            background: var(--tinted);
            border-top: 1px solid var(--border);
            padding: 14px 32px;
            text-align: center; font-size: 12.5px; color: var(--text-2);
        }
        .card-foot a { color: var(--red); text-decoration: none; font-weight: 600; }
        .card-foot a:hover { text-decoration: underline; }

        footer {
            position: relative; z-index: 1;
            padding: 16px 36px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .foot-copy { font-size: 11.5px; color: var(--muted); }

        @media (max-width: 560px) {
            nav { padding: 16px 20px; }
            footer { padding: 14px 20px; }
            .card-hero, .card-body, .card-foot { padding-left: 22px; padding-right: 22px; }
            .grid-2 { grid-template-columns: 1fr; }
            .hero-heart { display: none; }
        }
    </style>
</head>
<body>

<nav>
    <a class="wordmark" href="/">
        <div class="wm-icon">
            <svg width="16" height="16" viewBox="0 0 28 28" fill="none">
                <path d="M2 14h5l3-8 4 16 3-10 3 6 2-4h4" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="wm-text"><em>Cardio</em>Watch</div>
    </a>
</nav>

<main>
    <div class="card">

        <!-- Hero -->
        <div class="card-hero">
            <div class="hero-top">
                <div class="hero-text">
                    <div class="hero-eyebrow">Patient Registration</div>
                    <div class="hero-title">Create your account.</div>
                    <div class="hero-sub">Your vitals, monitored 24/7.</div>
                </div>
                <div class="hero-heart">
                    <svg viewBox="0 0 24 24" fill="white" stroke="none">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
            </div>

            <!-- Animated ECG lifeline -->
            <svg class="hero-ecg" viewBox="0 0 456 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Thin glow duplicate -->
                <polyline class="ecg-glow"
                    points="0,36 60,36 72,36 82,10 90,48 98,4 108,40 118,36 180,36 192,36 202,22 210,44 218,16 228,40 238,36 300,36 312,36 322,18 330,46 338,8 348,42 358,36 420,36 432,36 440,28 444,40 448,36 456,36"
                    stroke="rgba(255,255,255,.25)" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"
                />
                <!-- Main animated line -->
                <polyline class="ecg-path"
                    points="0,36 60,36 72,36 82,10 90,48 98,4 108,40 118,36 180,36 192,36 202,22 210,44 218,16 228,40 238,36 300,36 312,36 322,18 330,46 338,8 348,42 358,36 420,36 432,36 440,28 444,40 448,36 456,36"
                    stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"
                />
            </svg>
        </div>

        <!-- Form body -->
        <div class="card-body">

            @if($errors->any())
                <div class="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/register">
                @csrf

                <div class="section">Personal info</div>

                <div class="field">
                    <label for="full_name">Full Name</label>
                    <input id="full_name" type="text" name="full_name" placeholder="Juan dela Cruz" required>
                </div>

                <div class="grid-2">
                    <div class="field no-mb">
                        <label for="age">Age</label>
                        <input id="age" type="number" name="age" placeholder="25" min="1" max="120">
                    </div>
                    <div class="field no-mb">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="field" style="margin-top:11px">
                    <label for="contact">Contact Number</label>
                    <input id="contact" type="text" name="contact_number" placeholder="+63 9XX XXX XXXX">
                </div>

                <div class="section">Account credentials</div>

                <div class="field">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" autocomplete="email" required>
                </div>

                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" placeholder="your_username" required>
                </div>

                <div class="grid-2">
                    <div class="field no-mb">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="••••••••" autocomplete="new-password" required oninput="checkStrength(this.value)">
                        <div class="pass-bars">
                            <div class="pass-bar" id="pb1"></div>
                            <div class="pass-bar" id="pb2"></div>
                            <div class="pass-bar" id="pb3"></div>
                            <div class="pass-bar" id="pb4"></div>
                        </div>
                    </div>
                    <div class="field no-mb">
                        <label for="pw_confirm">Confirm Password</label>
                        <input id="pw_confirm" type="password" name="password_confirmation" placeholder="••••••••" autocomplete="new-password" required>
                    </div>
                </div>

                <div class="sep"></div>
                <button type="submit" class="btn-submit">Create CardioWatch Account</button>
            </form>

        </div>

        <div class="card-foot">
            Already have an account? <a href="/index">Sign in</a>
        </div>

    </div>
</main>

<footer>
    <span class="foot-copy">© 2025 CardioWatch. All rights reserved.</span>
</footer>

<script>
    const html = document.documentElement;
    const btn  = document.getElementById('themeBtn');
    const ico  = document.getElementById('themeIcon');

    const MOON = `<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" stroke="none"/>`;
    const SUN  = `<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>`;

    function apply(t) {
        html.setAttribute('data-theme', t);
        ico.innerHTML = t === 'dark' ? MOON : SUN;
        localStorage.setItem('cw-theme', t);
    }

    btn.addEventListener('click', () => apply(html.getAttribute('data-theme') === 'light' ? 'dark' : 'light'));
    const saved = localStorage.getItem('cw-theme');
    if (saved === 'dark') apply('dark');

    function checkStrength(v) {
        const score = [/.{8,}/, /[A-Z]/, /[0-9]/, /[^A-Za-z0-9]/].filter(r => r.test(v)).length;
        const cols = ['', '#C93C3B', '#E5832A', '#EFB922', '#22994A'];
        [1,2,3,4].forEach(i => {
            document.getElementById('pb' + i).style.background = i <= score ? cols[score] : 'var(--border)';
        });
    }
</script>
</body>
</html>