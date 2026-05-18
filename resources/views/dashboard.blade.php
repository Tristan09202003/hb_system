<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CardioWatch — Heart Rate Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/tabler-icons.min.css" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html[data-theme="light"] {
            --red:           #C93C3B;
            --red-soft:      rgba(201,60,59,.09);
            --red-border:    rgba(201,60,59,.25);
            --red-a10:       rgba(201,60,59,.10);
            --red-a20:       rgba(201,60,59,.20);
            --bg-page:       #FAFAF8;
            --bg-topbar:     #FFFFFF;
            --bg-card:       #FFFFFF;
            --bg-card2:      #F5F5F2;
            --bg-inset:      #F5F5F2;
            --bg-table-head: #F5F5F2;
            --border:        #E8E8E4;
            --border-md:     #D4D4CE;
            --text:          #111110;
            --text-2:        #5C5C56;
            --muted:         #A0A09A;
            --muted2:        #B8B8B2;
            --grid-color:    rgba(0,0,0,.04);
            --shadow:        0 0 0 1px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
            --mono:          'Share Tech Mono', monospace;
        }

        html[data-theme="dark"] {
            --red:           #E24B4A;
            --red-soft:      rgba(226,75,74,.09);
            --red-border:    rgba(226,75,74,.25);
            --red-a10:       rgba(226,75,74,.10);
            --red-a20:       rgba(226,75,74,.22);
            --bg-page:       #0E0E0D;
            --bg-topbar:     #191918;
            --bg-card:       #191918;
            --bg-card2:      #222220;
            --bg-inset:      #222220;
            --bg-table-head: #1A1A18;
            --border:        #2C2C2A;
            --border-md:     #3C3C38;
            --text:          #F0F0EC;
            --text-2:        #9A9A92;
            --muted:         #5A5A54;
            --muted2:        #4A4A44;
            --grid-color:    rgba(255,255,255,.03);
            --shadow:        0 0 0 1px rgba(255,255,255,.06), 0 4px 16px rgba(0,0,0,.25);
            --mono:          'Share Tech Mono', monospace;
        }

        html, body {
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
            position: fixed; inset: 0;
            background-image:
                linear-gradient(var(--grid-color) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none; z-index: 0;
        }

        /* ── Topbar ── */
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

        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .wm-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--red);
            display: flex; align-items: center; justify-content: center;
        }
        .brand { font-size: 13.5px; font-weight: 700; letter-spacing: -.01em; color: var(--text); }
        .brand span { color: var(--red); }

        .topbar-right { display: flex; align-items: center; gap: 8px; }

        .live-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0 12px; height: 28px; border-radius: 99px;
            font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
            background: var(--red-soft); border: 1px solid var(--red-border); color: var(--red);
            font-family: 'Share Tech Mono', monospace;
        }

        .pulse-dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--red);
            animation: blink 1.1s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }

        .divider { width: 1px; height: 18px; background: var(--border-md); margin: 0 2px; }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 6px;
            background: transparent; border: 1px solid var(--border-md);
            border-radius: 8px; padding: 0 13px; height: 32px;
            font-size: 12px; font-weight: 500; color: var(--text-2); letter-spacing: .01em;
            cursor: pointer; transition: all .15s;
            font-family: 'Sora', sans-serif; text-decoration: none;
        }
        .btn-outline:hover { color: var(--text); border-color: var(--red); }
        .btn-outline i { font-size: 14px; }

        .btn-danger {
            background: var(--red-soft); border-color: var(--red-border); color: var(--red);
        }
        .btn-danger:hover { background: var(--red-a20); border-color: var(--red); color: var(--red); }

        .theme-toggle {
            display: inline-flex; align-items: center; gap: 6px;
            background: transparent; border: 1px solid var(--border-md);
            border-radius: 8px; padding: 0 12px; height: 32px;
            font-size: 12px; font-weight: 500; color: var(--text-2);
            cursor: pointer; transition: all .15s;
            font-family: 'Sora', sans-serif;
        }
        .theme-toggle:hover { color: var(--text); border-color: var(--red); }
        .theme-toggle svg { width: 13px; height: 13px; }

        /* ── Shell ── */
        .shell {
            position: relative; z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px 36px;
        }

        /* ── Patient bar ── */
        .patient-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .patient-name {
            font-size: 20px;
            font-weight: 600;
            color: var(--text);
        }

        .patient-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── Metrics ── */
        .metrics {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .metric {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: var(--shadow);
        }

        .metric.main {
            background: var(--bg-card);
            border-color: var(--red-border);
            position: relative;
            overflow: hidden;
        }

        .metric.main::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            background: radial-gradient(circle, var(--red-soft) 0%, transparent 70%);
            pointer-events: none;
        }

        .metric-label {
            font-size: 10px; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: var(--muted); margin-bottom: 10px;
        }

        .metric-value {
            font-family: var(--mono); font-size: 38px; color: var(--text); line-height: 1;
        }

        .metric-value span { font-size: 13px; color: var(--muted2); margin-left: 3px; }

        .metric-sub { font-size: 11px; color: var(--muted2); margin-top: 6px; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700;
            letter-spacing: .07em; text-transform: uppercase; margin-top: 10px;
        }
        .status-badge i { font-size: 12px; }

        /* Light theme statuses */
        .status-badge.normal  { background: rgba(46,130,40,.09);  color: #2a6e24; border: 1px solid rgba(46,130,40,.22); }
        .status-badge.warning { background: rgba(166,100,0,.09);  color: #7a4a00; border: 1px solid rgba(166,100,0,.22); }
        .status-badge.danger  { background: rgba(180,30,30,.09);  color: #8a1818; border: 1px solid rgba(180,30,30,.22); animation: pulse-border 1s ease-in-out infinite; }

        /* Dark theme statuses */
        html[data-theme="dark"] .status-badge.normal  { color: #97C459; background: rgba(99,153,34,.1);  border-color: rgba(99,153,34,.25); }
        html[data-theme="dark"] .status-badge.warning { color: #EF9F27; background: rgba(186,117,23,.1); border-color: rgba(186,117,23,.25); }
        html[data-theme="dark"] .status-badge.danger  { color: #E24B4A; background: rgba(226,75,74,.1);  border-color: rgba(226,75,74,.3); }

        @keyframes pulse-border { 0%,100%{border-color:rgba(180,30,30,.22)} 50%{border-color:rgba(180,30,30,.6)} }

        /* ── Main content grid ── */
        .content-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 14px;
            align-items: start;
        }

        /* ── Alerts ── */
        .alert-box {
            border-radius: 12px; margin-bottom: 14px;
            overflow: hidden; display: none;
        }
        .alert-box.show { display: block; }

        .warning-box {
            border: 1px solid rgba(166,100,0,.22); background: rgba(166,100,0,.04);
        }
        .danger-box {
            border: 1px solid rgba(180,30,30,.28); background: rgba(180,30,30,.04);
            animation: pulse-box 1.2s ease-in-out infinite;
        }

        html[data-theme="dark"] .warning-box { border-color: rgba(186,117,23,.28); background: rgba(186,117,23,.05); }
        html[data-theme="dark"] .danger-box  { border-color: rgba(226,75,74,.32);  background: rgba(226,75,74,.05); }

        @keyframes pulse-box {
            0%,100% { border-color: rgba(180,30,30,.28); }
            50%      { border-color: rgba(180,30,30,.65); }
        }
        html[data-theme="dark"] .danger-box { animation: pulse-box-dk 1.2s ease-in-out infinite; }
        @keyframes pulse-box-dk {
            0%,100% { border-color: rgba(226,75,74,.32); }
            50%      { border-color: rgba(226,75,74,.75); }
        }

        .alert-top { display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; }
        .alert-icon-wrap {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 17px;
        }

        .warning-box .alert-icon-wrap { background: rgba(166,100,0,.1);  color: #7a4a00; }
        .danger-box  .alert-icon-wrap { background: rgba(180,30,30,.1);  color: #8a1818; }
        html[data-theme="dark"] .warning-box .alert-icon-wrap { color: #EF9F27; background: rgba(186,117,23,.12); }
        html[data-theme="dark"] .danger-box  .alert-icon-wrap { color: #E24B4A; background: rgba(226,75,74,.12); }

        .alert-main { flex: 1; }
        .alert-title { font-size: 13px; font-weight: 700; letter-spacing: .02em; color: var(--text); }
        .alert-desc { font-size: 12px; color: var(--text-2); margin-top: 2px; line-height: 1.5; }

        .alert-tips { border-top: 1px solid var(--border); padding: 12px 16px; display: flex; flex-direction: column; gap: 8px; }

        .tip-row { display: flex; align-items: flex-start; gap: 10px; font-size: 12px; color: var(--text-2); line-height: 1.6; }
        .tip-bullet { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; margin-top: 6px; background: var(--text-2); }
        .tip-row strong { font-weight: 600; color: var(--text); }

        /* ── Chart card ── */
        .chart-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 18px 20px; box-shadow: var(--shadow);
        }

        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }

        .card-title {
            font-size: 11px; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: var(--muted);
        }

        .chart-wrap { position: relative; height: 180px; }
        canvas { width: 100% !important; }

        /* ── Log card ── */
        .log-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; overflow: hidden; box-shadow: var(--shadow);
        }

        .log-head {
            padding: 14px 18px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }

        .log-count {
            font-family: var(--mono); font-size: 11px;
            background: var(--bg-inset); border: 1px solid var(--border);
            border-radius: 5px; padding: 2px 8px; color: var(--muted);
        }

        table { width: 100%; border-collapse: collapse; font-size: 12px; }

        th {
            text-align: left; padding: 9px 18px; font-size: 10px; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase; color: var(--muted2);
            background: var(--bg-table-head);
        }

        td {
            padding: 10px 18px; border-top: 1px solid var(--border);
            font-family: var(--mono); color: var(--text);
        }

        td.st-normal  { color: #2a6e24; }
        td.st-warning { color: #7a4a00; }
        td.st-danger  { color: #8a1818; }

        html[data-theme="dark"] td.st-normal  { color: #97C459; }
        html[data-theme="dark"] td.st-warning { color: #EF9F27; }
        html[data-theme="dark"] td.st-danger  { color: #E24B4A; }

        tr:hover td { background: rgba(0,0,0,.02); }
        html[data-theme="dark"] tr:hover td { background: rgba(255,255,255,.02); }

        .empty {
            padding: 32px; text-align: center; color: var(--muted2);
            font-size: 12px; font-family: 'Sora', sans-serif;
        }

        /* ── Side panel ── */
        .side-panel { display: flex; flex-direction: column; gap: 14px; }

        .info-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 18px 20px; box-shadow: var(--shadow);
        }

        .info-card-title {
            font-size: 11px; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: var(--muted); margin-bottom: 14px;
        }

        .info-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 8px 0; border-top: 1px solid var(--border);
            font-size: 12px;
        }
        .info-row:first-of-type { border-top: none; }
        .info-row-label { color: var(--muted); }
        .info-row-value { font-family: var(--mono); color: var(--text); font-weight: 500; }

        .range-bar {
            margin-top: 4px;
            height: 4px;
            border-radius: 99px;
            background: var(--bg-inset);
            position: relative;
            overflow: hidden;
        }
        .range-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--red);
            transition: width .4s ease;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .content-grid { grid-template-columns: 1fr; }
            .metrics { grid-template-columns: 1fr 1fr; }
            .metric.main { grid-column: span 2; }
        }

        @media (max-width: 600px) {
            .topbar { padding: 0 20px; }
            .shell  { padding: 20px 20px; }
            .metrics { grid-template-columns: 1fr 1fr; gap: 8px; }
        }

        @media (max-width: 420px) {
            .live-badge { display: none; }
            .btn-outline span { display: none; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <a class="logo" href="/">
        <div class="wm-icon">
            <svg width="16" height="16" viewBox="0 0 28 28" fill="none">
                <path d="M2 14h5l3-8 4 16 3-10 3 6 2-4h4" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="brand"><span>Cardio</span>Watch</div>
    </a>

    <div class="topbar-right">
        <div class="live-badge"><div class="pulse-dot"></div>Live</div>
        <div class="divider"></div>

        <button id="themeBtn" class="theme-toggle" aria-label="Toggle theme">
            <svg id="themeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"/>
                <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
        </button>

        <a href="/history" class="btn-outline">
            <i class="ti ti-history"></i><span>History</span>
        </a>

        <form method="POST" action="/logout" style="margin:0">
            @csrf
            <button type="submit" class="btn-outline btn-danger">
                <i class="ti ti-power"></i><span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Main content -->
<div class="shell">

    <div class="patient-bar">
        <div>
            <div class="patient-name">{{ session('full_name', 'Patient Dashboard') }}</div>
            <div class="patient-sub">Real-time heart rate monitoring</div>
        </div>
    </div>

    <!-- Metrics -->
    <div class="metrics">
        <div class="metric main">
            <div class="metric-label">Current BPM</div>
            <div class="metric-value" id="bpmVal">--<span>bpm</span></div>
            <div id="statusBadge" class="status-badge normal" style="display:none"></div>
        </div>
        <div class="metric">
            <div class="metric-label">Session High</div>
            <div class="metric-value" id="highVal">--<span>bpm</span></div>
            <div class="metric-sub">Peak recorded</div>
        </div>
        <div class="metric">
            <div class="metric-label">Session Low</div>
            <div class="metric-value" id="lowVal">--<span>bpm</span></div>
            <div class="metric-sub">Floor recorded</div>
        </div>
    </div>

    <!-- Alert boxes -->
    <div class="alert-box warning-box" id="warnBox">
        <div class="alert-top">
            <div class="alert-icon-wrap"><i class="ti ti-alert-triangle"></i></div>
            <div class="alert-main">
                <div class="alert-title" id="warnTitle">Warning</div>
                <div class="alert-desc" id="warnDesc">Heart rate is outside the normal resting range.</div>
            </div>
        </div>
        <div class="alert-tips" id="warnTips"></div>
    </div>

    <div class="alert-box danger-box" id="dangerBox">
        <div class="alert-top">
            <div class="alert-icon-wrap"><i class="ti ti-alert-circle"></i></div>
            <div class="alert-main">
                <div class="alert-title" id="dangerTitle">Critical Alert</div>
                <div class="alert-desc" id="dangerDesc">Heart rate has reached a critical level. Immediate action required.</div>
            </div>
        </div>
        <div class="alert-tips" id="dangerTips"></div>
    </div>

    <!-- Content grid -->
    <div class="content-grid">
        <!-- Left: chart + log -->
        <div>
            <div class="chart-card" style="margin-bottom:14px">
                <div class="card-header">
                    <div class="card-title">Live BPM Readings</div>
                </div>
                <div class="chart-wrap"><canvas id="bpmChart"></canvas></div>
            </div>

            <div class="log-card">
                <div class="log-head">
                    <div class="card-title">Reading Log</div>
                    <span class="log-count" id="logCount">0 entries</span>
                </div>
                <table>
                    <thead>
                        <tr><th>#</th><th>BPM</th><th>Status</th><th>Time</th></tr>
                    </thead>
                    <tbody id="logBody">
                        <tr><td colspan="4" class="empty">Waiting for device data…</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: info panel -->
        <div class="side-panel">
            <div class="info-card">
                <div class="info-card-title">Session Summary</div>
                <div class="info-row">
                    <span class="info-row-label">Readings collected</span>
                    <span class="info-row-value" id="totalReadings">0</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Session average</span>
                    <span class="info-row-value" id="avgBpm">--</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Normal range</span>
                    <span class="info-row-value">60–100 bpm</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">BPM range</span>
                    <div style="flex:1;margin-left:16px">
                        <div class="range-bar"><div class="range-fill" id="rangeFill" style="width:0%"></div></div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-title">Reference Guide</div>
                <div class="info-row">
                    <span class="info-row-label">Critical Low</span>
                    <span class="info-row-value" style="color:#8a1818"> &lt; 40</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Warning Low</span>
                    <span class="info-row-value" style="color:#7a4a00">40–59</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Normal</span>
                    <span class="info-row-value" style="color:#2a6e24">60–100</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Warning High</span>
                    <span class="info-row-value" style="color:#7a4a00">101–140</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label">Critical High</span>
                    <span class="info-row-value" style="color:#8a1818">&gt; 140</span>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    /* ── Theme ── */
    const html     = document.documentElement;
    const themeBtn = document.getElementById('themeBtn');
    const themeIco = document.getElementById('themeIcon');

    const moonSVG = `<circle cx="12" cy="12" r="5.5" fill="currentColor" stroke="none"/><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" stroke="none"/>`;
    const sunSVG  = `<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>`;

    themeBtn.addEventListener('click', () => {
        const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', next);
        themeIco.innerHTML = next === 'light' ? sunSVG : moonSVG;
        localStorage.setItem('cw-theme', next);
        if (chart) updateChartColors();
    });

    const savedTheme = localStorage.getItem('cw-theme');
    if (savedTheme && savedTheme !== 'light') {
        html.setAttribute('data-theme', savedTheme);
        themeIco.innerHTML = moonSVG;
    }

    /* ── Alert data ── */
    const ALERTS = {
        warn_low: {
            title: 'Warning — Low Heart Rate (Bradycardia)',
            desc: 'BPM is below the normal resting range of 60–100 bpm.',
            tips: [
                ['Stay calm', 'Sit or lie down and rest. Avoid sudden movements.'],
                ['Breathe slowly', 'Take deep, steady breaths to help stabilize your heart rate.'],
                ['Stay hydrated', 'Drink water — dehydration can contribute to a low heart rate.'],
                ['Monitor closely', 'If BPM continues to drop or you feel dizzy, seek medical attention immediately.'],
            ]
        },
        warn_high: {
            title: 'Warning — Elevated Heart Rate (Tachycardia)',
            desc: 'BPM is above the normal resting range of 60–100 bpm.',
            tips: [
                ['Rest immediately', 'Stop any physical activity and sit or lie down.'],
                ['Breathe deeply', 'Try slow, controlled breaths — inhale 4s, hold 4s, exhale 4s.'],
                ['Avoid stimulants', 'Avoid caffeine, energy drinks, or strenuous activity.'],
                ['Stay hydrated', 'Drink water and remain calm. Stress can elevate heart rate.'],
            ]
        },
        danger_low: {
            title: 'Critical — Severely Low Heart Rate',
            desc: 'BPM has dropped below 40 bpm. Immediate medical attention is required.',
            tips: [
                ['Call emergency services', 'Alert someone nearby or call emergency services immediately.'],
                ['Do not leave alone', 'The patient should not be left unattended at this BPM level.'],
                ['Lie flat', 'Help the person lie down and elevate their legs slightly if possible.'],
                ['Nothing by mouth', 'Avoid giving food or water until medical help arrives.'],
            ]
        },
        danger_high: {
            title: 'Critical — Severely Elevated Heart Rate',
            desc: 'BPM has exceeded 140 bpm. Immediate medical attention is required.',
            tips: [
                ['Call emergency services', 'Alert someone nearby or call emergency services immediately.'],
                ['Stop all activity', 'Ensure the person is resting completely — no movement.'],
                ['Cool down', 'Apply a cool damp cloth to the neck and wrists.'],
                ['Keep calm', 'Keep the patient calm — anxiety can worsen a high heart rate episode.'],
            ]
        }
    };

    function buildTips(tips, id) {
        document.getElementById(id).innerHTML = tips.map(([l, t]) =>
            `<div class="tip-row"><div class="tip-bullet"></div><div><strong>${l}:</strong> ${t}</div></div>`
        ).join('');
    }

    function classify(bpm) {
        if (bpm < 40)  return 'danger_low';
        if (bpm > 140) return 'danger_high';
        if (bpm < 60)  return 'warn_low';
        if (bpm > 100) return 'warn_high';
        return 'normal';
    }

    function statusLabel(k) { return k === 'normal' ? 'Normal' : k.startsWith('warn') ? 'Warning' : 'Critical'; }
    function statusClass(k) { return k === 'normal' ? 'normal' : k.startsWith('warn') ? 'warning' : 'danger'; }
    function statusIcon(k)  { return k === 'normal' ? 'ti-circle-check' : k.startsWith('warn') ? 'ti-alert-triangle' : 'ti-alert-circle'; }

    function updateAlerts(key) {
        document.getElementById('warnBox').classList.remove('show');
        document.getElementById('dangerBox').classList.remove('show');
        if (key === 'normal') return;
        const d = ALERTS[key];
        if (key.startsWith('warn')) {
            document.getElementById('warnTitle').textContent = d.title;
            document.getElementById('warnDesc').textContent  = d.desc;
            buildTips(d.tips, 'warnTips');
            document.getElementById('warnBox').classList.add('show');
        } else {
            document.getElementById('dangerTitle').textContent = d.title;
            document.getElementById('dangerDesc').textContent  = d.desc;
            buildTips(d.tips, 'dangerTips');
            document.getElementById('dangerBox').classList.add('show');
        }
    }

    /* ── Chart ── */
    let chart, readings = [], counter = 0;

    function getChartColors() {
        const dark = html.getAttribute('data-theme') === 'dark';
        return {
            line: dark ? '#E24B4A' : '#C93C3B',
            fill: dark ? 'rgba(226,75,74,.08)' : 'rgba(201,60,59,.06)',
            grid: dark ? 'rgba(255,255,255,.04)' : 'rgba(0,0,0,.06)',
            tick: dark ? '#6b6b7a' : '#9098a8',
        };
    }

    function updateChartColors() {
        const c = getChartColors();
        chart.data.datasets[0].borderColor     = c.line;
        chart.data.datasets[0].backgroundColor = c.fill;
        chart.options.scales.y.grid.color      = c.grid;
        chart.options.scales.y.ticks.color     = c.tick;
        chart.update('none');
    }

    function initChart() {
        const c   = getChartColors();
        const ctx = document.getElementById('bpmChart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    borderColor: c.line, backgroundColor: c.fill,
                    borderWidth: 1.5, pointRadius: 2.5,
                    pointBackgroundColor: c.line, pointBorderColor: 'transparent',
                    tension: .4, fill: true
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, animation: { duration: 250 },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a1f', borderColor: '#2a2a32', borderWidth: 1,
                        titleColor: '#6b6b7a', bodyColor: '#e8e8ec',
                        callbacks: { label: c => `${c.raw} BPM` }
                    }
                },
                scales: {
                    x: { display: false },
                    y: {
                        min: 30, max: 160,
                        grid: { color: c.grid },
                        ticks: { color: c.tick, font: { size: 10 }, stepSize: 20 },
                        border: { display: false }
                    }
                }
            }
        });
    }

    function addReading(bpm) {
        const key  = classify(bpm);
        const lbl  = statusLabel(key);
        const cls  = statusClass(key);
        const ic   = statusIcon(key);
        const time = new Date().toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        counter++;
        readings.unshift({ id: counter, bpm, lbl, cls, time });
        if (readings.length > 50) readings.pop();

        const bpms = readings.map(r => r.bpm);
        const avg  = Math.round(bpms.reduce((a, b) => a + b, 0) / bpms.length);
        const pct  = Math.min(100, Math.max(0, ((bpm - 30) / 130) * 100));

        document.getElementById('bpmVal').innerHTML = `${bpm}<span>bpm</span>`;
        document.getElementById('totalReadings').textContent = readings.length;
        document.getElementById('avgBpm').textContent = `${avg} bpm`;
        document.getElementById('rangeFill').style.width = pct + '%';

        const badge = document.getElementById('statusBadge');
        badge.style.display = 'inline-flex';
        badge.className = 'status-badge ' + cls;
        badge.innerHTML = `<i class="ti ${ic}"></i> ${lbl}`;

        document.getElementById('highVal').innerHTML = `${Math.max(...bpms)}<span>bpm</span>`;
        document.getElementById('lowVal').innerHTML  = `${Math.min(...bpms)}<span>bpm</span>`;

        updateAlerts(key);

        const last20 = readings.slice(0, 20).reverse();
        chart.data.labels           = last20.map(r => r.time);
        chart.data.datasets[0].data = last20.map(r => r.bpm);
        chart.update('none');

            document.getElementById('logBody').innerHTML = readings.slice(0, 20).map(r => `
      <tr><td>#${r.id}</td><td>${r.bpm}</td><td class="st-${r.cls}">${r.label}</td><td>${r.time}</td></tr>`).join('');
        }

        // ── Poll your ESP32 API every 2.5 seconds ──
        function fetchLatest() {
            fetch('/api/get_data.php')
                .then(r => r.json())
                .then(data => {
                    if (data && data.bpm) addReading(data.bpm);
                })
                .catch(() => {}); // silently fail if device not connected
        }

        initChart();
        setInterval(fetchLatest, 2500);
    </script>
</body>
</html>