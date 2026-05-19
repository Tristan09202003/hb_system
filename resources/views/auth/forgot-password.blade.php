<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password — CardioWatch</title>
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
            font-weight: 500;
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

        .alert-success {
            background: rgba(46, 130, 40, .07);
            border: 1px solid rgba(46, 130, 40, .22);
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .alert-success i {
            color: #2a6e24;
            font-size: 18px;
            margin-top: 1px;
        }

        .alert-success p {
            font-size: 12.5px;
            color: #2a6e24;
            line-height: 1.5;
            margin: 0;
        }

        html[data-theme="dark"] .alert-success {
            background: rgba(99, 153, 34, .08);
            border-color: rgba(99, 153, 34, .25);
        }

        html[data-theme="dark"] .alert-success i,
        html[data-theme="dark"] .alert-success p {
            color: #97C459;
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
                    <path d="M8 11V7a4 4 0 0 1 7.6-1.75" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 11h12v9H6z" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 15v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>
            <div class="form-title">Forgot your password?</div>
            <div class="form-sub">Enter the email address linked to your account and we'll send you a password reset
                link.</div>

            <div class="card">

                @if (session('status'))
                    <div class="alert-success">
                        <i class="ti ti-circle-check"></i>
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                @error('email')
                    <div class="alert-error">
                        <i class="ti ti-alert-circle"></i>
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="patient@example.com" required autofocus>
                    </div>
                    <button type="submit" class="btn-submit">Send Reset Link</button>
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="ti ti-arrow-left"></i> Back to login
                    </a>
                </form>
            </div>

        </div>
    </div>
</body>

</html>
