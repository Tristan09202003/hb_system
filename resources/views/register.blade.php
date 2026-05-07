<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register — CardioWatch</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{
            --red:#E24B4A;--bg:#0d0d0f;--bg2:#141417;--bg3:#1a1a1f;
            --border:#2a2a32;--text:#e8e8ec;--muted:#6b6b7a;
            --mono:'Share Tech Mono',monospace;
        }
        body{
            background:var(--bg);
            font-family:'DM Sans',sans-serif;
            color:var(--text);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:24px;
        }
        .auth-card{
            width:100%;
            max-width:500px;
            background:var(--bg2);
            border:1px solid var(--border);
            border-radius:12px;
            padding:26px;
        }
        .logo{
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:24px;
            padding-bottom:16px;
            border-bottom:1px solid var(--border);
        }
        .brand{
            font-size:13px;
            font-weight:600;
            letter-spacing:.08em;
            text-transform:uppercase;
        }
        .brand span{color:var(--red)}
        .title{
            font-family:var(--mono);
            font-size:30px;
            margin-bottom:6px;
        }
        .subtitle{
            color:var(--muted);
            font-size:13px;
            margin-bottom:20px;
        }
        .grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px;
        }
        label{
            display:block;
            font-size:11px;
            color:var(--muted);
            text-transform:uppercase;
            letter-spacing:.08em;
            margin-bottom:7px;
        }
        input, select{
            width:100%;
            padding:12px 14px;
            background:var(--bg3);
            border:1px solid var(--border);
            border-radius:8px;
            color:var(--text);
            margin-bottom:14px;
            font-family:'DM Sans',sans-serif;
        }
        input:focus, select:focus{
            outline:none;
            border-color:var(--red);
        }
        button{
            width:100%;
            padding:12px;
            background:var(--red);
            border:none;
            border-radius:8px;
            color:white;
            font-weight:700;
            cursor:pointer;
            margin-top:4px;
        }
        .link{
            text-align:center;
            margin-top:16px;
            font-size:13px;
            color:var(--muted);
        }
        .link a{color:var(--red);text-decoration:none}
        .alert{
            background:rgba(226,75,74,.12);
            border:1px solid rgba(226,75,74,.3);
            color:var(--red);
            padding:10px 12px;
            border-radius:8px;
            font-size:12px;
            margin-bottom:14px;
        }
        @media(max-width:600px){
            .grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="logo">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
            <path d="M2 14h5l3-8 4 16 3-10 3 6 2-4h4" stroke="#E24B4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div class="brand"><span>Cardio</span>Watch</div>
    </div>

    <div class="title">Register</div>
    <div class="subtitle">Create a patient account for heart rate history monitoring.</div>

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <div class="grid">
            <div>
                <label>Age</label>
                <input type="number" name="age">
            </div>

            <div>
                <label>Gender</label>
                <select name="gender">
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <label>Contact Number</label>
        <input type="text" name="contact_number">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <div class="grid">
            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <div class="link">
        Already have an account? <a href="/index">Login</a>
    </div>
</div>

</body>
</html>