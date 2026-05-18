<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — CardioWatch</title>
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
            --line-color: rgba(201,60,59,.18);
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
            --line-color: rgba(226,75,74,.22);
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

        /* ── ECG Background grid ── */
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

        /* ── Nav ── */
        nav {
            position: relative; z-index: 10;
            padding: 20px 36px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .wordmark {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }

        .wm-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--red);
            display: flex; align-items: center; justify-content: center;
        }

        .wm-icon svg { display: block; }

        .wm-text {
            font-size: 13.5px; font-weight: 700;
            letter-spacing: -.01em; color: var(--text);
        }
        .wm-text em { font-style: normal; color: var(--red); }


        /* ── Main ── */
        main {
            position: relative; z-index: 1;
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 16px 24px 40px;
        }

        .layout {
            width: 100%;
            max-width: 840px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: var(--bg-card);
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        /* ── Left visual panel ── */
        .visual-panel {
            background: var(--red);
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            min-height: 420px;
        }

        /* Subtle radial vignette on red panel */
        .visual-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 110% 110%, rgba(0,0,0,.18) 0%, transparent 60%);
            pointer-events: none;
        }

        .vp-top { position: relative; z-index: 2; }

        .vp-label {
            font-family: 'Share Tech Mono', monospace;
            font-size: 10px; letter-spacing: .14em; text-transform: uppercase;
            color: rgba(255,255,255,.55); margin-bottom: 16px;
        }

        .vp-title {
            font-size: 26px; font-weight: 700;
            letter-spacing: -.03em; line-height: 1.2;
            color: #fff;
        }

        .vp-sub {
            font-size: 13px; font-weight: 400; line-height: 1.6;
            color: rgba(255,255,255,.65);
            margin-top: 10px; max-width: 220px;
        }

        /* ── Heartbeat SVG ── */
        .heartbeat-wrap {
            position: relative; z-index: 2;
        }

        .heartbeat-svg {
            width: 100%;
            display: block;
            overflow: visible;
        }

        /* Animated draw */
        .ecg-line {
            stroke-dasharray: 600;
            stroke-dashoffset: 600;
            animation: draw 2.2s cubic-bezier(.4,0,.2,1) forwards,
                       pulse 2.2s ease-in-out 2.2s infinite;
        }

        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .65; }
        }

        /* Blinking dot at end of line */
        .ecg-dot {
            animation: dotFade 2.2s ease forwards, dotBlink 1.4s ease-in-out 2.2s infinite;
            opacity: 0;
        }

        @keyframes dotFade { 0%,80%{opacity:0} 100%{opacity:1} }
        @keyframes dotBlink { 0%,100%{opacity:1} 50%{opacity:.2} }

        /* Heart icon */
        .heart-wrap {
            position: absolute;
            bottom: 44px; right: 30px;
            z-index: 2;
            animation: heartbeat 1.4s ease-in-out 2.4s infinite;
        }

        .heart-wrap svg {
            width: 36px; height: 36px;
            opacity: .22;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            14% { transform: scale(1.18); }
            28% { transform: scale(1); }
            42% { transform: scale(1.12); }
            56% { transform: scale(1); }
        }

        /* BPM badge */
        .bpm-badge {
            position: absolute;
            top: 36px; right: 28px;
            z-index: 2;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 10px;
            padding: 7px 14px;
            display: flex; flex-direction: column; align-items: center;
        }

        .bpm-label {
            font-size: 9px; letter-spacing: .12em; text-transform: uppercase;
            color: rgba(255,255,255,.55); margin-top: 3px;
        }

        /* ── Right form panel ── */
        .form-panel {
            padding: 44px 40px;
            display: flex; flex-direction: column; justify-content: center;
        }

        .form-head { margin-bottom: 28px; }

        .form-eyebrow {
            font-family: 'Share Tech Mono', monospace;
            font-size: 10px; letter-spacing: .12em; text-transform: uppercase;
            color: var(--red); margin-bottom: 10px;
        }

        h1 {
            font-size: 24px; font-weight: 700;
            letter-spacing: -.03em; line-height: 1.2;
            color: var(--text); margin-bottom: 6px;
        }

        .form-sub {
            font-size: 13px; color: var(--text-2); line-height: 1.5;
        }

        /* Alerts */
        .alert {
            padding: 10px 13px; border-radius: 8px;
            font-size: 12.5px; line-height: 1.45; margin-bottom: 20px;
        }
        .alert-err { background: var(--red-a10); border: 1px solid var(--red-a20); color: var(--red); }
        .alert-ok  { background: rgba(30,110,55,.07); border: 1px solid rgba(30,110,55,.2); color: #1a6634; }
        html[data-theme="dark"] .alert-ok { color: #5ccb7e; }

        /* Fields */
        .field { margin-bottom: 12px; }

        label {
            display: block; font-size: 11px; font-weight: 600;
            color: var(--text-2); letter-spacing: .03em;
            text-transform: uppercase; margin-bottom: 6px;
        }

        input {
            width: 100%; padding: 11px 13px;
            background: var(--input-bg); border: 1px solid var(--border-md);
            border-radius: 9px; color: var(--text);
            font-family: 'Sora', sans-serif; font-size: 13.5px;
            outline: none; transition: border-color .15s, box-shadow .15s;
        }
        input:focus { border-color: var(--red); box-shadow: 0 0 0 3px var(--red-a10); }
        input::placeholder { color: var(--muted); }

        .sep { height: 1px; background: var(--border); margin: 20px 0; }

        .btn-submit {
            width: 100%; padding: 12px;
            background: var(--red); border: none; border-radius: 9px;
            color: #fff; font-family: 'Sora', sans-serif;
            font-size: 13.5px; font-weight: 600; letter-spacing: .01em;
            cursor: pointer; transition: filter .15s, transform .1s;
        }
        .btn-submit:hover { filter: brightness(1.07); }
        .btn-submit:active { transform: scale(.99); }

        .form-foot {
            text-align: center; margin-top: 16px;
            font-size: 12.5px; color: var(--text-2);
        }
        .form-foot a { color: var(--red); text-decoration: none; font-weight: 600; }
        .form-foot a:hover { text-decoration: underline; }

        /* ── Bottom ── */
        footer {
            position: relative; z-index: 1;
            padding: 16px 36px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }

        .foot-copy { font-size: 11.5px; color: var(--muted); }

        /* ── Responsive ── */
        @media (max-width: 680px) {
            .layout { grid-template-columns: 1fr; }
            .visual-panel { min-height: 200px; padding: 28px 28px 32px; }
            .heart-wrap { display: none; }
            .bpm-badge { top: 24px; right: 20px; }
            nav { padding: 16px 20px; }
            footer { padding: 14px 20px; }
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
    <div class="layout">

        <!-- Left: Visual / branding panel -->
        <div class="visual-panel">
            <!-- BPM readout -->
            <div class="bpm-badge">
                <div class="bpm-label">BPM</div>
            </div>

            <div class="vp-top">
                <div class="vp-label">Patient Portal</div>
                <div class="vp-title">Monitor.<br>Detect.<br>Protect.</div>
                <div class="vp-sub">Real-time heart rate monitoring, right from your dashboard.</div>
            </div>

            <!-- Animated ECG lifeline -->
            <div class="heartbeat-wrap">
                <svg class="heartbeat-svg" viewBox="0 0 260 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Flat line → spike → flat -->
                    <polyline class="ecg-line"
                        points="0,45 40,45 50,45 58,12 65,58 72,5 80,50 88,45 130,45 138,45 146,28 152,52 158,20 166,48 174,45 260,45"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        fill="none"
                    />
                    <!-- Blinking dot at end -->
                    <circle class="ecg-dot" cx="260" cy="45" r="3.5" fill="white"/>
                </svg>
            </div>
        </div>

        <!-- Right: Login form -->
        <div class="form-panel">
            <div class="form-head">
                <div class="form-eyebrow">Sign in</div>
                <h1>Welcome back.</h1>
                <p class="form-sub">Access your monitoring dashboard.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-ok">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-err">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-err">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" autocomplete="email" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
                </div>
                <div class="sep"></div>
                <button type="submit" class="btn-submit">Sign in to CardioWatch</button>
            </form>

            <div class="form-foot">
                No account? <a href="/register">Create one</a>
            </div>
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
</script>

</body>
</html>