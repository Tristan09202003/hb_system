<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CardioWatch — Heart Rate History</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html[data-theme="light"] {
            --red:           #C93C3B;
            --red-soft:      rgba(201,60,59,.09);
            --red-border:    rgba(201,60,59,.25);
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

        body { font-family: 'Sora', sans-serif; color: var(--text); }

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
            position: sticky; top: 0; z-index: 100;
            width: 100%; background: var(--bg-topbar);
            border-bottom: 1px solid var(--border);
            padding: 0 36px; height: 60px;
            display: flex; align-items: center; justify-content: space-between;
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

        .divider { width: 1px; height: 18px; background: var(--border-md); margin: 0 2px; }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 6px;
            background: transparent; border: 1px solid var(--border-md);
            border-radius: 8px; padding: 0 13px; height: 32px;
            font-size: 12px; font-weight: 500; color: var(--text-2);
            cursor: pointer; transition: all .15s;
            font-family: 'Sora', sans-serif; text-decoration: none;
        }
        .btn-outline:hover { color: var(--text); border-color: var(--red); }

        .btn-danger { background: var(--red-soft); border-color: var(--red-border); color: var(--red); }
        .btn-danger:hover { background: rgba(201,60,59,.16); border-color: var(--red); color: var(--red); }
        html[data-theme="dark"] .btn-danger:hover { background: rgba(226,75,74,.16); }

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
        .shell { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; padding: 28px 36px; }

        /* ── Page header ── */
        .page-header { margin-bottom: 20px; }
        .page-title-main { font-size: 20px; font-weight: 600; color: var(--text); }
        .page-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }

        /* ── Metrics ── */
        .metrics {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 12px; margin-bottom: 16px;
        }

        .metric {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 18px 20px; box-shadow: var(--shadow);
        }
        .metric.main { border-color: var(--red-border); }

        .metric-label { font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
        .metric-value { font-family: var(--mono); font-size: 30px; color: var(--text); line-height: 1; }
        .metric-value span { font-size: 11px; color: var(--muted2); margin-left: 3px; }
        .metric-sub { font-size: 11px; color: var(--muted2); margin-top: 5px; }

        /* ── Content grid ── */
        .content-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 14px; align-items: start; }

        /* ── Filter bar ── */
        .filter-bar {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 12px; padding: 12px 18px; margin-bottom: 14px;
            display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
            box-shadow: var(--shadow);
        }

        .filter-label { font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); flex-shrink: 0; }
        .filter-btns { display: flex; gap: 6px; flex-wrap: wrap; }

        .filter-btn {
            background: var(--bg-inset); border: 1px solid var(--border-md);
            border-radius: 7px; padding: 5px 14px; font-size: 11px; font-weight: 600;
            color: var(--text); cursor: pointer; transition: all .15s;
            font-family: 'Sora', sans-serif; text-decoration: none;
        }
        .filter-btn:hover { border-color: var(--red); color: var(--red); }
        .filter-btn.active { background: var(--red-soft); border-color: var(--red-border); color: var(--red); }

        /* ── Chart card ── */
        .chart-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 18px 20px; margin-bottom: 14px; box-shadow: var(--shadow);
        }

        .chart-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .chart-title { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); }

        .chart-legend { display: flex; gap: 14px; }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: 10px; color: var(--muted); }
        .legend-dot { width: 8px; height: 8px; border-radius: 50%; }

        .chart-wrap { position: relative; height: 200px; }
        canvas { width: 100% !important; }

        /* ── Log card ── */
        .log-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; overflow: hidden; box-shadow: var(--shadow);
        }

        .log-head {
            padding: 13px 18px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
        }

        .log-title { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); flex-shrink: 0; }

        .search-wrap {
            display: flex; align-items: center; gap: 6px;
            background: var(--bg-inset); border: 1px solid var(--border-md);
            border-radius: 7px; padding: 5px 10px;
            transition: border-color .15s; flex: 1; max-width: 260px;
        }
        .search-wrap:focus-within { border-color: var(--red-border); }
        .search-icon { color: var(--muted); flex-shrink: 0; }

        .search-input {
            background: none; border: none; outline: none;
            font-family: 'Sora', sans-serif; font-size: 12px;
            color: var(--text); width: 100%;
        }
        .search-input::placeholder { color: var(--muted); opacity: .7; }

        .log-count {
            font-family: var(--mono); font-size: 10px; color: var(--muted);
            background: var(--bg-inset); border: 1px solid var(--border);
            border-radius: 5px; padding: 2px 8px; flex-shrink: 0;
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

        tr:hover td { background: rgba(0,0,0,.02); }
        html[data-theme="dark"] tr:hover td { background: rgba(255,255,255,.02); }
        tr.hidden-row { display: none; }

        .empty { padding: 32px; text-align: center; color: var(--muted2); font-size: 12px; font-family: 'Sora', sans-serif; }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 5px;
            font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
            font-family: 'DM Sans', sans-serif;
        }
        .badge.normal  { background: rgba(46,130,40,.1);  color: #2a6e24; border: 1px solid rgba(46,130,40,.22); }
        .badge.warning { background: rgba(166,100,0,.1);  color: #7a4a00; border: 1px solid rgba(166,100,0,.22); }
        .badge.danger  { background: rgba(180,30,30,.1);  color: #8a1818; border: 1px solid rgba(180,30,30,.22); }

        html[data-theme="dark"] .badge.normal  { color: #97C459; background: rgba(99,153,34,.12);  border-color: rgba(99,153,34,.28); }
        html[data-theme="dark"] .badge.warning { color: #EF9F27; background: rgba(186,117,23,.12); border-color: rgba(186,117,23,.28); }
        html[data-theme="dark"] .badge.danger  { color: #E24B4A; background: rgba(226,75,74,.12);  border-color: rgba(226,75,74,.28); }

        /* ── Pagination ── */
        .pagination {
            display: flex; justify-content: center; gap: 6px;
            padding: 14px 18px; border-top: 1px solid var(--border);
        }
        .page-btn {
            background: var(--bg-inset); border: 1px solid var(--border-md);
            border-radius: 7px; padding: 5px 12px; font-size: 11px; font-weight: 600;
            color: var(--muted); cursor: pointer; transition: all .15s;
            font-family: 'Sora', sans-serif; text-decoration: none;
        }
        .page-btn:hover, .page-btn.active { border-color: var(--red-border); color: var(--red); background: var(--red-soft); }

        /* ── Insight / Side cards ── */
        .side-panel { display: flex; flex-direction: column; gap: 14px; }

        .insight-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 18px 20px; box-shadow: var(--shadow);
        }
        .insight-title { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 14px; }

        .insight-row {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 10px 0; border-top: 1px solid var(--border);
        }
        .insight-row:first-of-type { border-top: none; }
        .insight-icon { font-size: 18px; width: 28px; text-align: center; flex-shrink: 0; }
        .insight-text { font-size: 12px; color: var(--muted); line-height: 1.55; }
        .insight-text strong { color: var(--text); font-weight: 600; }

        /* ── No results ── */
        #noResults { display: none; }
        #noResults td { color: var(--muted); text-align: center; font-family: 'DM Sans', sans-serif; font-size: 12px; }

        /* ── Responsive ── */
        @media (max-width: 1000px) {
            .content-grid { grid-template-columns: 1fr; }
            .metrics { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 600px) {
            .topbar { padding: 0 20px; }
            .shell  { padding: 20px 20px; }
            .metrics { grid-template-columns: 1fr 1fr; gap: 8px; }
        }

        @media (max-width: 420px) {
            .metrics { grid-template-columns: 1fr 1fr; }
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
        <button id="themeBtn" class="theme-toggle" aria-label="Toggle theme">
            <svg id="themeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"/>
                <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
        </button>
        <div class="divider"></div>
        <form method="POST" action="/logout" style="margin:0">
            @csrf
            <button type="submit" class="btn-outline btn-danger">⏻ Logout</button>
        </form>
    </div>
</div>

<!-- Main -->
<div class="shell">

    <div class="page-header">
        <div class="page-title-main">Heart Rate History</div>
        <div class="page-sub">{{ session('full_name') }} — all recorded readings</div>
    </div>

    <!-- Metrics -->
    <div class="metrics">
        <div class="metric main">
            <div class="metric-label">Total Logs</div>
            <div class="metric-value">{{ $totalLogs }}<span>entries</span></div>
            <div class="metric-sub">all time</div>
        </div>
        <div class="metric">
            <div class="metric-label">Avg BPM</div>
            <div class="metric-value">{{ $avgBpm }}<span>bpm</span></div>
            <div class="metric-sub">average</div>
        </div>
        <div class="metric">
            <div class="metric-label">Highest</div>
            <div class="metric-value">{{ $maxBpm }}<span>bpm</span></div>
            <div class="metric-sub">peak recorded</div>
        </div>
        <div class="metric">
            <div class="metric-label">Lowest</div>
            <div class="metric-value">{{ $minBpm }}<span>bpm</span></div>
            <div class="metric-sub">floor recorded</div>
        </div>
    </div>

    <!-- Content grid -->
    <div class="content-grid">

        <!-- Left: filter + chart + log -->
        <div>
            <!-- Filter bar -->
            <div class="filter-bar">
                <div class="filter-label">Filter</div>
                <div class="filter-btns">
                    <a href="{{ route('history') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">All</a>
                    <a href="{{ route('history', ['status' => 'Normal']) }}" class="filter-btn {{ request('status') === 'Normal' ? 'active' : '' }}">Normal</a>
                    <a href="{{ route('history', ['status' => 'Warning']) }}" class="filter-btn {{ request('status') === 'Warning' ? 'active' : '' }}">Warning</a>
                    <a href="{{ route('history', ['status' => 'Danger']) }}" class="filter-btn {{ request('status') === 'Danger' ? 'active' : '' }}">Danger</a>
                </div>
            </div>

            <!-- Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">BPM Trend (last 30 logs)</div>
                    <div class="chart-legend">
                        <div class="legend-item"><div class="legend-dot" style="background:#97C459"></div> Normal</div>
                        <div class="legend-item"><div class="legend-dot" style="background:#EF9F27"></div> Warning</div>
                        <div class="legend-item"><div class="legend-dot" style="background:#E24B4A"></div> Danger</div>
                    </div>
                </div>
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>

            <!-- Log table -->
            <div class="log-card">
                <div class="log-head">
                    <div class="log-title">Reading Log</div>
                    <div class="search-wrap">
                        <svg class="search-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input class="search-input" id="logSearch" type="text" placeholder="Search BPM, status, date…" oninput="filterLog(this.value)" autocomplete="off" />
                    </div>
                    <div class="log-count" id="logCount">{{ $logs->total() }} records</div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>BPM</th>
                            <th>Status</th>
                            <th>Recorded At</th>
                        </tr>
                    </thead>
                    <tbody id="logBody">
                        @forelse($logs as $index => $log)
                        <tr class="log-row">
                            <td>{{ $logs->firstItem() + $index }}</td>
                            <td>{{ $log->bpm }}</td>
                            <td><span class="badge {{ strtolower($log->status) }}">{{ $log->status }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($log->recorded_at)->format('M d, Y h:i:s A') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="empty">No heart rate logs found.</td></tr>
                        @endforelse
                        <tr id="noResults"><td colspan="4" class="empty">No results match your search.</td></tr>
                    </tbody>
                </table>

                @if($logs->hasPages())
                <div class="pagination">
                    @if($logs->onFirstPage())
                        <span class="page-btn" style="opacity:.4">← Prev</span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="page-btn">← Prev</a>
                    @endif

                    @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="page-btn {{ $page == $logs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="page-btn">Next →</a>
                    @else
                        <span class="page-btn" style="opacity:.4">Next →</span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Right: insights -->
        <div class="side-panel">
            @if($totalLogs >= 5)
            <div class="insight-card">
                <div class="insight-title">Improvement Insights</div>
                <div class="insight-row">
                    <div class="insight-icon">📈</div>
                    <div class="insight-text">
                        Your average BPM is <strong>{{ $avgBpm }} bpm</strong>.
                        @if($avgBpm >= 60 && $avgBpm <= 100)
                            This is within the <strong>normal resting range (60–100 bpm)</strong>. Keep it up!
                        @elseif($avgBpm < 60)
                            This is <strong>below normal range</strong>. Consider consulting a doctor if you feel symptoms.
                        @else
                            This is <strong>above normal range</strong>. Try to rest more and reduce stress.
                        @endif
                    </div>
                </div>
                <div class="insight-row">
                    <div class="insight-icon">🎯</div>
                    <div class="insight-text">
                        Out of <strong>{{ $totalLogs }} readings</strong>,
                        <strong>{{ $normalCount }}</strong> were Normal,
                        <strong>{{ $warningCount }}</strong> Warning, and
                        <strong>{{ $dangerCount }}</strong> Danger.
                    </div>
                </div>
                <div class="insight-row">
                    <div class="insight-icon">📅</div>
                    <div class="insight-text">
                        Latest reading recorded on
                        <strong>{{ $latestLog ? \Carbon\Carbon::parse($latestLog->recorded_at)->format('M d, Y h:i A') : 'N/A' }}</strong>.
                    </div>
                </div>
            </div>
            @endif

            <div class="insight-card">
                <div class="insight-title">BPM Reference</div>
                <div class="insight-row">
                    <div class="insight-icon">🔴</div>
                    <div class="insight-text"><strong>Critical Low</strong> — below 40 bpm. Emergency attention required.</div>
                </div>
                <div class="insight-row">
                    <div class="insight-icon">🟡</div>
                    <div class="insight-text"><strong>Warning Low (Bradycardia)</strong> — 40 to 59 bpm. Rest and monitor.</div>
                </div>
                <div class="insight-row">
                    <div class="insight-icon">🟢</div>
                    <div class="insight-text"><strong>Normal Range</strong> — 60 to 100 bpm. Healthy resting heart rate.</div>
                </div>
                <div class="insight-row">
                    <div class="insight-icon">🟡</div>
                    <div class="insight-text"><strong>Warning High (Tachycardia)</strong> — 101 to 140 bpm. Rest and breathe.</div>
                </div>
                <div class="insight-row">
                    <div class="insight-icon">🔴</div>
                    <div class="insight-text"><strong>Critical High</strong> — above 140 bpm. Seek immediate medical help.</div>
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
    });

    const savedTheme = localStorage.getItem('cw-theme');
    if (savedTheme && savedTheme !== 'light') {
        html.setAttribute('data-theme', savedTheme);
        themeIco.innerHTML = moonSVG;
    }

    /* ── Chart ── */
    const chartData  = @json($chartData);
    const dateLabels = chartData.map(d => {
        const date = new Date(d.time);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });

    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dateLabels,
            datasets: [{
                data: chartData.map(d => d.bpm),
                borderColor: '#C93C3B',
                backgroundColor: 'rgba(201,60,59,.07)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: chartData.map(d =>
                    d.status === 'Normal'  ? '#2a6e24' :
                    d.status === 'Warning' ? '#7a4a00' : '#C93C3B'
                ),
                pointBorderColor: 'transparent',
                pointBorderWidth: 0,
                tension: .35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 400 },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a1f', borderColor: '#2a2a32', borderWidth: 1,
                    titleColor: '#6b6b7a', bodyColor: '#e8e8ec',
                    callbacks: {
                        title: c => chartData[c[0].dataIndex].time,
                        label: c => `${c.raw} BPM`
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    ticks: { color: '#9098a8', font: { size: 10 }, maxRotation: 45, autoSkip: true, maxTicksLimit: 10 },
                    grid: { display: false },
                    border: { display: false }
                },
                y: {
                    min: 30, max: 160,
                    grid: { color: 'rgba(0,0,0,.06)' },
                    ticks: { color: '#9098a8', font: { size: 10 }, stepSize: 20 },
                    border: { display: false }
                }
            }
        }
    });

    /* ── Search ── */
    function filterLog(query) {
        const rows  = document.querySelectorAll('#logBody .log-row');
        const noRes = document.getElementById('noResults');
        const count = document.getElementById('logCount');
        const q     = query.trim().toLowerCase();
        let visible = 0;

        rows.forEach(row => {
            const show = q === '' || row.innerText.toLowerCase().includes(q);
            row.classList.toggle('hidden-row', !show);
            if (show) visible++;
        });

        noRes.style.display = (visible === 0) ? 'table-row' : 'none';
        count.textContent   = q === ''
            ? `{{ $logs->total() }} records`
            : `${visible} result${visible !== 1 ? 's' : ''}`;
    }
</script>
</body>
</html>