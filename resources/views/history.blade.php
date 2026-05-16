<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CardioWatch — Heart Rate History</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0 }

        :root {
            --red: #E24B4A;
            --bg: #0d0d0f;
            --bg2: #141417;
            --bg3: #1a1a1f;
            --bg4: #222228;
            --border: #2a2a32;
            --text: #e8e8ec;
            --muted: #6b6b7a;
            --mono: 'Share Tech Mono', monospace;
        }

        body { background: var(--bg); font-family: 'DM Sans', sans-serif; color: var(--text); padding: 0; min-height: 100vh }

        .shell { padding: 24px; max-width: 760px; margin: 0 auto }

        /* ── Header ── */
        .header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border)
        }

        .logo { display: flex; align-items: center; gap: 10px }

        .brand { font-size: 13px; font-weight: 600; letter-spacing: .08em; color: var(--text); text-transform: uppercase }
        .brand span { color: var(--red) }

        .header-right { display: flex; align-items: center; gap: 10px }

        .nav-pill {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--bg3); border: 1px solid var(--border); border-radius: 99px;
            padding: 5px 14px; font-size: 11px; font-weight: 600; color: var(--muted);
            letter-spacing: .06em; text-transform: uppercase; text-decoration: none; transition: all .15s
        }
        .nav-pill:hover { border-color: var(--red); color: var(--red) }

        .logout-btn {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(226,75,74,.1); border: 1px solid rgba(226,75,74,.3);
            border-radius: 99px; padding: 5px 14px; font-size: 11px; font-weight: 600;
            color: var(--red); letter-spacing: .06em; text-transform: uppercase;
            cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif
        }
        .logout-btn:hover { background: rgba(226,75,74,.2); border-color: var(--red) }

        /* ── Page title ── */
        .page-title { font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 14px }

        /* ── Metrics ── */
        .metrics { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 10px; margin-bottom: 14px }

        .metric { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px }
        .metric.main { background: var(--bg3) }

        .metric-label { font-size: 10px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 6px }
        .metric-value { font-family: var(--mono); font-size: 28px; color: var(--text); line-height: 1 }
        .metric-value span { font-size: 11px; color: var(--muted); margin-left: 3px }
        .metric-sub { font-size: 11px; color: var(--muted); margin-top: 4px }

        /* ── Filter bar ── */
        .filter-bar {
            background: var(--bg3); border: 1px solid var(--border); border-radius: 10px;
            padding: 12px 16px; margin-bottom: 14px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap
        }
        .filter-label { font-size: 11px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); flex-shrink: 0 }
        .filter-btns { display: flex; gap: 6px; flex-wrap: wrap }

        .filter-btn {
            background: var(--bg4); border: 1px solid var(--border); border-radius: 6px;
            padding: 5px 12px; font-size: 11px; font-weight: 600; color: var(--text);
            cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif; text-decoration: none
        }
        .filter-btn:hover { border-color: var(--red); color: var(--red) }
        .filter-btn.active { background: rgba(226,75,74,.15); border-color: var(--red); color: var(--red) }

        /* ── Chart ── */
        .chart-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; margin-bottom: 14px }

        .chart-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px }

        .chart-title { font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted) }

        .chart-legend { display: flex; gap: 12px }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: 10px; color: var(--muted) }
        .legend-dot { width: 8px; height: 8px; border-radius: 50% }

        .chart-wrap { position: relative; height: 190px }
        canvas { width: 100% !important }

        /* ── Log card ── */
        .log-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; margin-bottom: 14px }

        .log-head {
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px
        }

        .log-title { font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); flex-shrink: 0 }

        /* ── Search bar ── */
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 4px 10px;
            transition: border-color .15s;
            flex: 1;
            max-width: 240px
        }
        .search-wrap:focus-within { border-color: rgba(226,75,74,.5) }

        .search-icon { color: var(--muted); font-size: 12px; flex-shrink: 0 }

        .search-input {
            background: none;
            border: none;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            color: var(--text);
            width: 100%;
            placeholder-color: var(--muted)
        }
        .search-input::placeholder { color: var(--muted) }

        .log-count {
            font-size: 10px; font-family: var(--mono); color: var(--muted);
            background: var(--bg4); border: 1px solid var(--border);
            border-radius: 4px; padding: 2px 8px; flex-shrink: 0
        }

        table { width: 100%; border-collapse: collapse; font-size: 12px }

        th {
            text-align: left; padding: 8px 16px; font-size: 10px; font-weight: 600;
            letter-spacing: .08em; text-transform: uppercase; color: var(--muted); background: var(--bg3)
        }

        td { padding: 9px 16px; border-top: 1px solid var(--border); font-family: var(--mono); color: var(--text) }
        td.st-normal  { color: #97C459 }
        td.st-warning { color: #EF9F27 }
        td.st-danger  { color: #E24B4A }
        tr:hover td { background: rgba(255,255,255,.02) }
        tr.hidden-row { display: none }

        .empty { padding: 32px; text-align: center; color: var(--muted); font-size: 12px; font-family: 'DM Sans', sans-serif }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 4px;
            font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; font-family: 'DM Sans', sans-serif
        }
        .badge.normal  { background: rgba(99,153,34,.15);  color: #97C459; border: 1px solid rgba(99,153,34,.3) }
        .badge.warning { background: rgba(186,117,23,.15); color: #EF9F27; border: 1px solid rgba(186,117,23,.3) }
        .badge.danger  { background: rgba(226,75,74,.18);  color: #E24B4A; border: 1px solid rgba(226,75,74,.35) }

        /* ── Insight ── */
        .insight-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; margin-bottom: 14px }
        .insight-title { font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 10px }
        .insight-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-top: 1px solid var(--border) }
        .insight-row:first-of-type { border-top: none }
        .insight-icon { font-size: 16px; width: 28px; text-align: center; flex-shrink: 0 }
        .insight-text { font-size: 12px; color: var(--muted); line-height: 1.5 }
        .insight-text strong { color: var(--text); font-weight: 600 }

        /* ── No results row ── */
        #noResults { display: none }
        #noResults td { color: var(--muted); text-align: center; font-family: 'DM Sans', sans-serif; font-size: 12px }

        /* ── Pagination ── */
        .pagination { display: flex; justify-content: center; gap: 6px; padding: 14px 16px; border-top: 1px solid var(--border) }
        .page-btn { background: var(--bg4); border: 1px solid var(--border); border-radius: 6px; padding: 5px 12px; font-size: 11px; font-weight: 600; color: var(--muted); cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif; text-decoration: none }
        .page-btn:hover, .page-btn.active { border-color: var(--red); color: var(--red); background: rgba(226,75,74,.1) }
    </style>
</head>

<body>
    <div class="shell">

        {{-- ── Header ── --}}
        <div class="header">
            <div class="logo">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path d="M2 14h5l3-8 4 16 3-10 3 6 2-4h4" stroke="#E24B4A" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="brand"><span>Cardio</span>Watch</div>
            </div>
            <div class="header-right">
                <a href="/dashboard" class="nav-pill">← Dashboard</a>
                <form method="POST" action="/logout" style="margin:0">
                    @csrf
                    <button type="submit" class="logout-btn">⏻ Logout</button>
                </form>
            </div>
        </div>

        {{-- ── Page title ── --}}
        <div class="page-title">Heart Rate History — {{ session('full_name') }}</div>

        {{-- ── Summary metrics ── --}}
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

        {{-- ── Filter bar ── --}}
        <div class="filter-bar">
            <div class="filter-label">Filter</div>
            <div class="filter-btns">
                <a href="{{ route('history') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('history', ['status' => 'Normal']) }}"
                    class="filter-btn {{ request('status') === 'Normal' ? 'active' : '' }}">Normal</a>
                <a href="{{ route('history', ['status' => 'Warning']) }}"
                    class="filter-btn {{ request('status') === 'Warning' ? 'active' : '' }}">Warning</a>
                <a href="{{ route('history', ['status' => 'Danger']) }}"
                    class="filter-btn {{ request('status') === 'Danger' ? 'active' : '' }}">Danger</a>
            </div>
        </div>

        {{-- ── BPM Trend Chart ── --}}
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">BPM Trend (last 30 logs)</div>
                <div class="chart-legend">
                    <div class="legend-item"><div class="legend-dot" style="background:#97C459"></div> Normal</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#EF9F27"></div> Warning</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#E24B4A"></div> Danger</div>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- ── Improvement Insight ── --}}
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
                    <strong>{{ $warningCount }}</strong> were Warning, and
                    <strong>{{ $dangerCount }}</strong> were Danger.
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

        {{-- ── Log Table ── --}}
        <div class="log-card">
            <div class="log-head">
                <div class="log-title">Reading Log</div>

                {{-- Search bar --}}
                <div class="search-wrap">
                    <svg class="search-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input
                        class="search-input"
                        id="logSearch"
                        type="text"
                        placeholder="Search BPM, status, date..."
                        oninput="filterLog(this.value)"
                        autocomplete="off"
                    />
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
                    <tr>
                        <td colspan="4" class="empty">No heart rate logs found.</td>
                    </tr>
                    @endforelse
                    <tr id="noResults">
                        <td colspan="4" class="empty">No results match your search.</td>
                    </tr>
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($logs->hasPages())
            <div class="pagination">
                @if($logs->onFirstPage())
                    <span class="page-btn" style="opacity:.4">← Prev</span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="page-btn">← Prev</a>
                @endif

                @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-btn {{ $page == $logs->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        // ── Chart ──
        const chartData = @json($chartData);

        // Format chart labels safely
        const dateLabels = chartData.map(d => {
            const safeDate = new Date(d.time.replace(' ', 'T'));

            return safeDate.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit'
            });
        });

        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dateLabels,
                datasets: [{
                    data: chartData.map(d => d.bpm),
                    borderColor: '#E24B4A',
                    backgroundColor: 'rgba(226,75,74,.08)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: chartData.map(d =>
                        d.status === 'Normal' ? '#97C459' :
                        d.status === 'Warning' ? '#EF9F27' : '#E24B4A'
                    ),
                    pointBorderColor: '#0d0d0f',
                    pointBorderWidth: 2,
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
                            // Show full datetime in tooltip title
                            title: c => chartData[c[0].dataIndex].time,
                            label: c => `${c.raw} BPM`
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        ticks: {
                            color: '#6b6b7a',
                            font: { size: 10 },
                            maxRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 10
                        },
                        grid: { display: false },
                        border: { display: false }
                    },
                    y: {
                        min: 30, max: 160,
                        grid: { color: 'rgba(255,255,255,.04)' },
                        ticks: { color: '#6b6b7a', font: { size: 10 }, stepSize: 20 },
                        border: { display: false }
                    }
                }
            }
        });

        // ── Search / filter ──
        function filterLog(query) {
            const rows   = document.querySelectorAll('#logBody .log-row');
            const noRes  = document.getElementById('noResults');
            const count  = document.getElementById('logCount');
            const q      = query.trim().toLowerCase();
            let visible  = 0;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const show = q === '' || text.includes(q);
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