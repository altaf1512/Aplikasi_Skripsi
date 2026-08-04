<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Investasi Emas') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --gold:#c9a84c; --gold-light:#e8cc7a; --bg:#080c14; --panel:#0f1520; --border:#1e2d40; --muted:#6b7a99; }
        *{box-sizing:border-box;} html,body{margin:0;font-family:'Inter',sans-serif;background:var(--bg);color:#e8eaf0;}
        .auth-wrap{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;}
        .auth-hero{display:flex;flex-direction:column;justify-content:space-between;padding:48px 56px;background:radial-gradient(ellipse at 80% 0%,rgba(201,168,76,.12) 0%,transparent 60%),var(--panel);border-right:1px solid var(--border);}
        .auth-hero h1{font-size:52px;font-weight:900;letter-spacing:-2.5px;line-height:1.1;color:#fff;margin:20px 0 12px;}
        .auth-hero h1 span{color:var(--gold);}
        .auth-hero p{color:var(--muted);line-height:1.7;max-width:440px;font-size:15px;}
        .auth-form-col{display:flex;align-items:center;justify-content:center;padding:40px;}
        .auth-form-box{width:100%;max-width:420px;}
        .auth-form-box h2{font-size:28px;font-weight:900;letter-spacing:-1px;color:#fff;margin:0 0 6px;}
        .auth-form-box>p{color:var(--muted);margin-bottom:28px;font-size:14px;}
        .field-label{display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:6px;letter-spacing:.3px;}
        .field-input{width:100%;padding:12px 14px;border-radius:12px;background:rgba(15,21,32,.8);border:1px solid var(--border);color:#e8eaf0;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s;}
        .field-input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.12);}
        .btn-gold{display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:13px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:linear-gradient(135deg,#e8cc7a,#c9a84c);color:#000;transition:all .2s;}
        .btn-gold:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(201,168,76,.35);}
        .error-text{font-size:12px;color:#ef4444;margin-top:4px;}
        .badge-logo{display:inline-flex;align-items:center;gap:10px;}
        .badge-logo-mark{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,#e8cc7a,#c9a84c);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:20px;color:#000;}
        .badge-logo-text{font-size:20px;font-weight:900;color:#fff;letter-spacing:-.5px;}.badge-logo-text span{color:var(--gold);}
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-hero">
            <div>
                <div class="badge-logo">
                    <div class="badge-logo-mark">E</div>
                    <div class="badge-logo-text">Investasi<span>Emas</span></div>
                </div>
            </div>
            <div>
                <p style="font-size:11px;font-weight:700;letter-spacing:2px;color:var(--gold);text-transform:uppercase;margin:0 0 12px;">SISTEM PAKAR CERDAS</p>
                <h1>Amankan Masa <span>Depan Finansial</span> Anda.</h1>
                <p>Dapatkan rekomendasi investasi emas yang akurat berbasis algoritma <strong style="color:var(--gold-light)">Certainty Factor</strong> dari pakar keuangan terpercaya.</p>
            </div>
            <p style="font-size:12px;color:var(--muted);margin:0;">&copy; {{ date('Y') }} Investasi Emas. Sistem Pakar Investasi.</p>
        </div>

        <div class="auth-form-col">
            <div class="auth-form-box">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
