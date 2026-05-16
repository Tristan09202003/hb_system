<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CardioWatch — Heart Rate Dashboard</title>
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

        .header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border)
        }

        .logo { display: flex; align-items: center; gap: 10px }

        .brand { font-size: 13px; font-weight: 600; letter-spacing: .08em; color: var(--text); text-transform: uppercase }
        .brand span { color: var(--red) }

        .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--red); animation: blink 1.1s ease-in-out infinite
        }

        @keyframes blink { 0%, 100% { opacity: 1 } 50% { opacity: .2 } }

        .metrics { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 14px }

        .metric { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px }
        .metric.main { background: var(--bg3) }

        .metric-label { font-size: 10px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin-bottom: 6px }
        .metric-value { font-family: var(--mono); font-size: 32px; color: var(--text); line-height: 1 }
        .metric-value span { font-size: 12px; color: var(--muted); margin-left: 3px }
        .metric-sub { font-size: 11px; color: var(--muted); margin-top: 4px }

        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase; margin-top: 8px
        }
        .status-badge.normal  { background: rgba(99,153,34,.15); color: #97C459; border: 1px solid rgba(99,153,34,.3) }
        .status-badge.warning { background: rgba(186,117,23,.15); color: #EF9F27; border: 1px solid rgba(186,117,23,.3) }
        .status-badge.danger  { background: rgba(226,75,74,.18); color: #E24B4A; border: 1px solid rgba(226,75,74,.35); animation: pulse-border 1s ease-in-out infinite }

        @keyframes pulse-border { 0%, 100% { border-color: rgba(226,75,74,.35) } 50% { border-color: rgba(226,75,74,.8) } }

        .alert-box { border-radius: 10px; margin-bottom: 14px; overflow: hidden; display: none }
        .alert-box.show { display: block }
        .alert-box.warning-box { border: 1px solid rgba(186,117,23,.4); background: rgba(186,117,23,.07) }
        .alert-box.danger-box  { border: 1px solid rgba(226,75,74,.45); background: rgba(226,75,74,.08); animation: pulse-border-box 1s ease-in-out infinite }

        @keyframes pulse-border-box { 0%, 100% { border-color: rgba(226,75,74,.45) } 50% { border-color: rgba(226,75,74,.9) } }

        .alert-top { display: flex; align-items: center; gap: 10px; padding: 10px 14px }
        .alert-icon { font-size: 15px; flex-shrink: 0 }
        .alert-main { flex: 1 }

        .alert-title { font-size: 12px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase }
        .warning-box .alert-title { color: #EF9F27 }
        .danger-box .alert-title  { color: #E24B4A }

        .alert-desc { font-size: 11px; margin-top: 2px; color: var(--muted) }

        .alert-tips { border-top: 1px solid rgba(255,255,255,.06); padding: 10px 14px; display: flex; flex-direction: column; gap: 6px }

        .tip-row { display: flex; align-items: flex-start; gap: 8px; font-size: 11px; color: var(--muted); line-height: 1.5 }
        .tip-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; margin-top: 5px }
        .warning-box .tip-dot { background: #EF9F27 }
        .danger-box .tip-dot  { background: #E24B4A }
        .tip-row strong { font-weight: 600 }
        .warning-box .tip-row strong { color: #EF9F27 }
        .danger-box .tip-row strong  { color: #E24B4A }

        .chart-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; margin-bottom: 14px }

        .chart-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px }

        .chart-title { font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted) }

        .pill-group { display: flex; align-items: center; gap: 6px }

        .pill {
            display: inline-flex; align-items: center; gap: 6px;
            border-radius: 99px; padding: 4px 12px;
            font-size: 11px; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            text-decoration: none; font-family: 'DM Sans', sans-serif;
            transition: all .15s; white-space: nowrap
        }

        .pill-history { background: var(--bg4); border: 1px solid var(--border); color: var(--text) }
        .pill-history:hover { background: rgba(226,75,74,.12); border-color: rgba(226,75,74,.3); color: var(--red) }

        .pill-live { background: rgba(226,75,74,.12); border: 1px solid rgba(226,75,74,.3); color: var(--red); cursor: default }

        .chart-wrap { position: relative; height: 140px }
        canvas { width: 100% !important }

        .log-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; overflow: hidden }
        .log-head { padding: 12px 16px; border-bottom: 1px solid var(--border) }
        .log-title { font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted) }

        table { width: 100%; border-collapse: collapse; font-size: 12px }
        th { text-align: left; padding: 8px 16px; font-size: 10px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); background: var(--bg3) }
        td { padding: 9px 16px; border-top: 1px solid var(--border); font-family: var(--mono); color: var(--text) }
        td.st-normal  { color: #97C459 }
        td.st-warning { color: #EF9F27 }
        td.st-danger  { color: #E24B4A }
        tr:hover td { background: rgba(255,255,255,.02) }

        .empty { padding: 24px; text-align: center; color: var(--muted); font-size: 12px; font-family: 'DM Sans', sans-serif }

        .logout-btn {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(226,75,74,.1); border: 1px solid rgba(226,75,74,.3);
            border-radius: 99px; padding: 5px 14px; font-size: 11px; font-weight: 600;
            color: var(--red); letter-spacing: .06em; text-transform: uppercase;
            cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif
        }
        .logout-btn:hover { background: rgba(226,75,74,.2); border-color: var(--red) }
    </style>
</head>

<body>
    <div class="shell">
        <div class="header">
            <div class="logo">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path d="M2 14h5l3-8 4 16 3-10 3 6 2-4h4" stroke="#E24B4A" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="brand"><span>Cardio</span>Watch</div>
            </div>
            <div class="header-right">
                <form method="POST" action="/logout" style="margin:0">
                    @csrf
                    <button type="submit" class="logout-btn">⏻ Logout</button>
                </form>
            </div>
        </div>

        <div class="metrics">
            <div class="metric main">
                <div class="metric-label">Current BPM</div>
                <div class="metric-value" id="bpmVal">--<span>bpm</span></div>
                <div id="statusBadge" class="status-badge normal" style="display:none"></div>
            </div>
            <div class="metric">
                <div class="metric-label">Session High</div>
                <div class="metric-value" id="highVal">--<span>bpm</span></div>
                <div class="metric-sub">peak recorded</div>
            </div>
            <div class="metric">
                <div class="metric-label">Session Low</div>
                <div class="metric-value" id="lowVal">--<span>bpm</span></div>
                <div class="metric-sub">floor recorded</div>
            </div>
        </div>

        <div class="alert-box warning-box" id="warnBox">
            <div class="alert-top">
                <span class="alert-icon">⚠</span>
                <div class="alert-main">
                    <div class="alert-title" id="warnTitle">Warning</div>
                    <div class="alert-desc" id="warnDesc">Heart rate is outside the normal range.</div>
                </div>
            </div>
            <div class="alert-tips" id="warnTips"></div>
        </div>

        <div class="alert-box danger-box" id="dangerBox">
            <div class="alert-top">
                <span class="alert-icon">🚨</span>
                <div class="alert-main">
                    <div class="alert-title" id="dangerTitle">Danger</div>
                    <div class="alert-desc" id="dangerDesc">Heart rate is at a critical level.</div>
                </div>
            </div>
            <div class="alert-tips" id="dangerTips"></div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">BPM Readings</div>
                <div class="pill-group">
                    <a href="/history" class="pill pill-history">History</a>
                    <span class="pill pill-live"><div class="dot"></div>Live</span>
                </div>
            </div>
            <div class="chart-wrap"><canvas id="bpmChart"></canvas></div>
        </div>

        <div class="log-card">
            <div class="log-head">
                <div class="log-title">Reading Log</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th><th>BPM</th><th>Status</th><th>Time</th>
                    </tr>
                </thead>
                <tbody id="logBody">
                    <tr>
                        <td colspan="4" class="empty">Waiting for device data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        let chart, readings = [], counter = 0;

        const ALERTS = {
            warn_low: {
                title: 'Warning — Low Heart Rate (Bradycardia)',
                desc: 'BPM is below the normal resting range (60–100 bpm).',
                tips: [
                    ['Stay calm','Sit or lie down and rest. Avoid sudden movements.'],
                    ['Breathe slowly','Take deep, steady breaths to help stabilize your heart rate.'],
                    ['Stay hydrated','Drink water — dehydration can contribute to a low heart rate.'],
                    ['Monitor closely','If BPM continues to drop or you feel dizzy, seek medical help immediately.'],
                ]
            },
            warn_high: {
                title: 'Warning — Elevated Heart Rate (Tachycardia)',
                desc: 'BPM is above the normal resting range (60–100 bpm).',
                tips: [
                    ['Rest immediately','Stop any physical activity and sit or lie down.'],
                    ['Breathe deeply','Try slow, controlled breaths — inhale 4s, hold 4s, exhale 4s.'],
                    ['Avoid stimulants','Avoid caffeine, energy drinks, or strenuous activity.'],
                    ['Stay hydrated','Drink water and remain calm. Stress can elevate heart rate.'],
                ]
            },
            danger_low: {
                title: 'Danger — Critically Low Heart Rate',
                desc: 'BPM has dropped to a critical level (below 40 bpm). Immediate action required.',
                tips: [
                    ['Call for help','Alert someone nearby or call emergency services immediately.'],
                    ['Do not leave alone','The patient should not be left unattended at this BPM level.'],
                    ['Lie flat','Help the person lie down and elevate their legs slightly if possible.'],
                    ['Do not give food or water','Avoid anything by mouth until medical help arrives.'],
                ]
            },
            danger_high: {
                title: 'Danger — Critically High Heart Rate',
                desc: 'BPM has exceeded a critical level (above 140 bpm). Immediate action required.',
                tips: [
                    ['Call for help','Alert someone nearby or call emergency services immediately.'],
                    ['Stop all activity','Ensure the person is resting completely — no movement.'],
                    ['Cool down','Apply a cool damp cloth to the neck and wrists to help lower stress response.'],
                    ['Keep calm','Keep the patient calm — anxiety can worsen a high heart rate episode.'],
                ]
            }
        };

        function buildTips(tips, containerId) {
            document.getElementById(containerId).innerHTML = tips.map(([label, text]) => `
      <div class="tip-row"><div class="tip-dot"></div><div><strong>${label}:</strong> ${text}</div></div>`).join('');
        }

        function classify(bpm) {
            if (bpm < 40) return 'danger_low';
            if (bpm > 140) return 'danger_high';
            if (bpm < 60) return 'warn_low';
            if (bpm > 100) return 'warn_high';
            return 'normal';
        }

        function statusLabel(k) { return k === 'normal' ? 'Normal' : k.startsWith('warn') ? 'Warning' : 'Danger' }
        function statusClass(k)  { return k === 'normal' ? 'normal' : k.startsWith('warn') ? 'warning' : 'danger' }

        function updateAlerts(key) {
            document.getElementById('warnBox').classList.remove('show');
            document.getElementById('dangerBox').classList.remove('show');
            if (key === 'normal') return;
            const data = ALERTS[key];
            if (key.startsWith('warn')) {
                document.getElementById('warnTitle').textContent = data.title;
                document.getElementById('warnDesc').textContent = data.desc;
                buildTips(data.tips, 'warnTips');
                document.getElementById('warnBox').classList.add('show');
            } else {
                document.getElementById('dangerTitle').textContent = data.title;
                document.getElementById('dangerDesc').textContent = data.desc;
                buildTips(data.tips, 'dangerTips');
                document.getElementById('dangerBox').classList.add('show');
            }
        }

        function initChart() {
            const ctx = document.getElementById('bpmChart').getContext('2d');
            chart = new Chart(ctx, {
                type: 'line',
                data: { labels: [], datasets: [{ data: [], borderColor: '#E24B4A', backgroundColor: 'rgba(226,75,74,.08)', borderWidth: 2, pointRadius: 3, pointBackgroundColor: '#E24B4A', pointBorderColor: '#0d0d0f', pointBorderWidth: 2, tension: .35, fill: true }] },
                options: {
                    responsive: true, maintainAspectRatio: false, animation: { duration: 300 },
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1a1a1f', borderColor: '#2a2a32', borderWidth: 1, titleColor: '#6b6b7a', bodyColor: '#e8e8ec', callbacks: { label: c => `${c.raw} BPM` } } },
                    scales: { x: { display: false }, y: { min: 30, max: 160, grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#6b6b7a', font: { size: 10 }, stepSize: 20 }, border: { display: false } } }
                }
            });
        }

        function addReading(bpm) {
            const key = classify(bpm), label = statusLabel(key), cls = statusClass(key);
            const time = new Date().toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            counter++;
            readings.unshift({ id: counter, bpm, label, cls, time });
            if (readings.length > 50) readings.pop();

            document.getElementById('bpmVal').innerHTML = `${bpm}<span>bpm</span>`;
            const badge = document.getElementById('statusBadge');
            badge.style.display = 'inline-flex';
            badge.className = 'status-badge ' + cls;
            badge.textContent = label;

            const bpms = readings.map(r => r.bpm);
            document.getElementById('highVal').innerHTML = `${Math.max(...bpms)}<span>bpm</span>`;
            document.getElementById('lowVal').innerHTML = `${Math.min(...bpms)}<span>bpm</span>`;
            updateAlerts(key);

            const last20 = readings.slice(0, 20).reverse();
            chart.data.labels = last20.map(r => r.time);
            chart.data.datasets[0].data = last20.map(r => r.bpm);
            chart.update('none');

            document.getElementById('logBody').innerHTML = readings.slice(0, 20).map(r => `
      <tr><td>#${r.id}</td><td>${r.bpm}</td><td class="st-${r.cls}">${r.label}</td><td>${r.time}</td></tr>`).join('');
        }

    let lastRecordId = null;

    function fetchLatest() {
        fetch('/heart-rate/latest')
            .then(r => r.json())
            .then(data => {
                if (!data || !data.bpm) return;

                // prevent adding the same database record again and again
                if (lastRecordId === data.id) return;
                lastRecordId = data.id;

                addReading(parseInt(data.bpm));
            })
            .catch(error => {
                console.error('Live fetch error:', error);
            });
    }

    initChart();
    fetchLatest();
    setInterval(fetchLatest, 2500);

    </script>
</body>
</html>