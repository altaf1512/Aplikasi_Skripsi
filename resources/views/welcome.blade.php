<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Pakar Investasi Emas berbasis Certainty Factor. Dapatkan rekomendasi Beli, Tahan, atau Jual emas sesuai profil investasi Anda.">
    <title>Investasi Emas — Sistem Pakar Cerdas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #c8a84b;
            --gold-light: #e5cf85;
            --gold-glow: rgba(200,168,75,0.15);
            --bg: #070b13;
            --surface: #0e1525;
            --border: #1c2b3d;
            --muted: #596780;
            --text: #dde3f0;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        /* NAV */
        .nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(7,11,19,0.85);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(16px);
        }
        .nav-inner {
            max-width: 1160px; margin: auto;
            height: 68px; padding: 0 28px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; }
        .nav-mark {
            width: 38px; height: 38px; border-radius: 12px;
            background: linear-gradient(135deg, #e5cf85, #c8a84b);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 900; color: #000;
            box-shadow: 0 4px 14px rgba(200,168,75,.3);
        }
        .nav-name { font-size: 17px; font-weight: 900; color: #fff; letter-spacing: -.4px; }
        .nav-name span { color: var(--gold); }
        .nav-links { display: flex; align-items: center; gap: 10px; }
        .nav-links a { font-size: 13.5px; font-weight: 600; color: var(--muted); padding: 8px 14px; border-radius: 10px; transition: color .18s; }
        .nav-links a:hover { color: #fff; }
        .nav-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 11px; font-size: 13.5px; font-weight: 700;
            background: linear-gradient(135deg, #e5cf85, #c8a84b); color: #000;
            transition: transform .18s, box-shadow .18s;
        }
        .nav-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(200,168,75,.35); }
        .nav-btn-ghost { background: transparent; border: 1px solid var(--border); color: var(--muted); }
        .nav-btn-ghost:hover { border-color: var(--gold); color: var(--gold); box-shadow: none; transform: none; }

        /* HERO */
        .hero {
            min-height: calc(100vh - 68px);
            display: flex; align-items: center;
            padding: 80px 28px;
            background:
                radial-gradient(ellipse at 80% 10%, rgba(200,168,75,.12) 0%, transparent 45%),
                radial-gradient(ellipse at 20% 90%, rgba(200,168,75,.06) 0%, transparent 40%),
                var(--bg);
        }
        .hero-inner { max-width: 1160px; margin: auto; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 5px 12px 5px 5px; border-radius: 99px;
            background: rgba(200,168,75,.1); border: 1px solid rgba(200,168,75,.2);
            font-size: 11px; font-weight: 800; color: var(--gold); letter-spacing: 1px;
            text-transform: uppercase; margin-bottom: 18px;
        }
        .hero-badge-dot { width: 22px; height: 22px; border-radius: 50%; background: linear-gradient(135deg, #e5cf85, #c8a84b); display: flex; align-items: center; justify-content: center; font-size: 11px; }
        .hero h1 { font-size: 58px; font-weight: 900; letter-spacing: -2.8px; line-height: 1.08; color: #fff; margin-bottom: 20px; }
        .hero h1 em { font-style: normal; color: var(--gold); }
        .hero p { font-size: 16px; color: var(--muted); line-height: 1.75; max-width: 500px; margin-bottom: 32px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 24px; border-radius: 12px; font-size: 14.5px; font-weight: 800;
            background: linear-gradient(135deg, #e5cf85, #c8a84b); color: #000;
            transition: transform .18s, box-shadow .18s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(200,168,75,.4); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 24px; border-radius: 12px; font-size: 14.5px; font-weight: 700;
            background: transparent; border: 1px solid var(--border); color: var(--muted);
            transition: all .18s;
        }
        .btn-secondary:hover { border-color: var(--gold); color: var(--gold); }

        /* HERO RIGHT - VISUAL CARD */
        .hero-visual {
            display: flex; flex-direction: column; gap: 14px;
        }
        .vis-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 18px; padding: 20px 22px;
            box-shadow: 0 8px 32px rgba(0,0,0,.3);
        }
        .vis-card-gold { border-color: rgba(200,168,75,.25); background: linear-gradient(135deg, rgba(200,168,75,.07), var(--surface)); }
        .vis-label { font-size: 10.5px; font-weight: 700; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px; }
        .vis-value { font-size: 28px; font-weight: 900; color: #fff; letter-spacing: -1px; }
        .vis-value span { color: var(--gold); font-size: 16px; }
        .vis-row { display: flex; gap: 12px; }
        .vis-row .vis-card { flex: 1; }
        .vis-bar-wrap { margin-top: 12px; display: flex; flex-direction: column; gap: 8px; }
        .vis-bar-row { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 600; }
        .vis-bar-label { width: 42px; color: var(--muted); }
        .vis-bar-bg { flex: 1; height: 8px; background: var(--border); border-radius: 99px; overflow: hidden; }
        .vis-bar-fill { height: 100%; border-radius: 99px; }
        .vis-bar-pct { width: 38px; text-align: right; color: var(--text); }

        /* STATS ROW */
        .stats-row { max-width: 1160px; margin: 0 auto 0; padding: 0 28px 60px; display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
        .stat-box { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 22px 24px; }
        .stat-box-num { font-size: 34px; font-weight: 900; color: #fff; letter-spacing: -1.5px; margin-bottom: 4px; }
        .stat-box-num span { color: var(--gold); }
        .stat-box-desc { font-size: 13px; color: var(--muted); }

        /* FEATURES */
        .features { max-width: 1160px; margin: auto; padding: 70px 28px; }
        .section-tag { font-size: 10.5px; font-weight: 800; letter-spacing: 2px; color: var(--gold); text-transform: uppercase; margin-bottom: 12px; }
        .section-title { font-size: 38px; font-weight: 900; letter-spacing: -1.5px; color: #fff; margin-bottom: 10px; }
        .section-sub { font-size: 15px; color: var(--muted); max-width: 560px; }
        .feature-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-top: 40px; }
        .f-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 18px;
            padding: 26px; position: relative; overflow: hidden;
            transition: transform .2s, border-color .2s, box-shadow .2s;
        }
        .f-card:hover { transform: translateY(-4px); border-color: rgba(200,168,75,.3); box-shadow: 0 12px 40px rgba(200,168,75,.08); }
        .f-num { position: absolute; right: 18px; top: 14px; font-size: 38px; font-weight: 900; color: var(--border); line-height: 1; }
        .f-icon {
            width: 44px; height: 44px; border-radius: 13px;
            background: rgba(200,168,75,.1); border: 1px solid rgba(200,168,75,.18);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); margin-bottom: 18px;
        }
        .f-card h3 { font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .f-card p { font-size: 13.5px; color: var(--muted); line-height: 1.65; }

        /* HOW IT WORKS */
        .how { background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 70px 28px; }
        .how-inner { max-width: 1160px; margin: auto; }
        .steps { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin-top: 40px; }
        .step { text-align: center; }
        .step-num { width: 48px; height: 48px; border-radius: 50%; background: var(--gold-glow); border: 1px solid rgba(200,168,75,.25); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: var(--gold); margin: 0 auto 14px; }
        .step h4 { font-size: 15px; font-weight: 800; color: #fff; margin-bottom: 6px; }
        .step p { font-size: 12.5px; color: var(--muted); line-height: 1.6; }

        /* CTA */
        .cta { padding: 80px 28px; }
        .cta-box {
            max-width: 760px; margin: auto; text-align: center;
            background: linear-gradient(135deg, rgba(200,168,75,.1), rgba(200,168,75,.04));
            border: 1px solid rgba(200,168,75,.2); border-radius: 24px; padding: 52px 40px;
        }
        .cta-box h2 { font-size: 38px; font-weight: 900; letter-spacing: -1.5px; color: #fff; margin-bottom: 12px; }
        .cta-box p { font-size: 15px; color: var(--muted); margin-bottom: 28px; }

        /* FOOTER */
        .footer { border-top: 1px solid var(--border); padding: 28px; text-align: center; }
        .footer p { font-size: 12.5px; color: var(--muted); }

        /* ANIMATIONS */
        @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        .hero-content > * { animation: fadeUp .6s ease both; }
        .hero-content > *:nth-child(1) { animation-delay: .05s; }
        .hero-content > *:nth-child(2) { animation-delay: .15s; }
        .hero-content > *:nth-child(3) { animation-delay: .25s; }
        .hero-content > *:nth-child(4) { animation-delay: .35s; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="nav">
    <div class="nav-inner">
        <div class="nav-logo">
            <div class="nav-mark">E</div>
            <div class="nav-name">Investasi<span>Emas</span></div>
        </div>
        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#cara-kerja">Cara Kerja</a>
            @auth
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="nav-btn">Mulai Gratis →</a>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-inner">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Sistem Pakar Berbasis AI
            </div>
            <h1>Investasi <em>Emas</em><br>yang Lebih Cerdas.</h1>
            <p>Rekomendasi investasi emas yang dipersonalisasi menggunakan algoritma <strong style="color:var(--gold-light)">Certainty Factor</strong>. Beli, Tahan, atau Jual — keputusan berbasis data, bukan spekulasi.</p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">Ke Dashboard <span>→</span></a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Mulai Konsultasi Gratis <span>→</span></a>
                    <a href="{{ route('login') }}" class="btn-secondary">Sudah punya akun</a>
                @endauth
            </div>
        </div>

        <!-- VISUAL CARD PREVIEW -->
        <div class="hero-visual">
            <div class="vis-card vis-card-gold">
                <div class="vis-label">Hasil Analisis Certainty Factor</div>
                <div class="vis-value">BELI <span>Emas</span></div>
                <div class="vis-bar-wrap">
                    <div class="vis-bar-row">
                        <span class="vis-bar-label" style="color:var(--gold)">Beli</span>
                        <div class="vis-bar-bg"><div class="vis-bar-fill" style="width:87%;background:var(--gold);"></div></div>
                        <span class="vis-bar-pct" style="color:var(--gold);">87%</span>
                    </div>
                    <div class="vis-bar-row">
                        <span class="vis-bar-label" style="color:#f59e0b">Tahan</span>
                        <div class="vis-bar-bg"><div class="vis-bar-fill" style="width:42%;background:#f59e0b;"></div></div>
                        <span class="vis-bar-pct">42%</span>
                    </div>
                    <div class="vis-bar-row">
                        <span class="vis-bar-label" style="color:#ef4444">Jual</span>
                        <div class="vis-bar-bg"><div class="vis-bar-fill" style="width:18%;background:#ef4444;"></div></div>
                        <span class="vis-bar-pct">18%</span>
                    </div>
                </div>
            </div>
            <div class="vis-row">
                <div class="vis-card">
                    <div class="vis-label">Harga Emas/gram</div>
                    <div class="vis-value" style="font-size:19px;">Rp 1.420.000</div>
                </div>
                <div class="vis-card">
                    <div class="vis-label">Total Konsultasi</div>
                    <div class="vis-value" style="font-size:19px;">12 <span style="font-size:13px;">pertanyaan</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-row">
    <div class="stat-box">
        <div class="stat-box-num">12<span>+</span></div>
        <div class="stat-box-desc">Pertanyaan pakar tervalidasi</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-num">3</div>
        <div class="stat-box-desc">Hipotesis: Beli, Tahan, Jual</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-num">100<span>%</span></div>
        <div class="stat-box-desc">Berbasis Certainty Factor</div>
    </div>
</div>

<!-- FEATURES -->
<section id="fitur" class="features">
    <div class="section-tag">Fitur Unggulan</div>
    <h2 class="section-title">Dua Mode Konsultasi<br>untuk Semua Level.</h2>
    <p class="section-sub">Dari investor pemula hingga yang berpengalaman, kami punya alur konsultasi yang tepat untuk Anda.</p>

    <div class="feature-grid">
        <div class="f-card">
            <span class="f-num">01</span>
            <div class="f-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            </div>
            <h3>Konsultasi Pemula</h3>
            <p>Masukkan budget Anda dan ketahui berapa gram emas yang bisa didapatkan. Cocok untuk investor yang baru memulai.</p>
        </div>
        <div class="f-card">
            <span class="f-num">02</span>
            <div class="f-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3>Expert System CF</h3>
            <p>Jawab 12 pertanyaan pakar dan dapatkan rekomendasi <strong>Beli, Tahan, atau Jual</strong> dengan persentase keyakinan yang akurat.</p>
        </div>
        <div class="f-card">
            <span class="f-num">03</span>
            <div class="f-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <h3>Riwayat Konsultasi</h3>
            <p>Semua hasil analisis tersimpan otomatis. Pantau dan bandingkan progres keputusan investasi Anda dari waktu ke waktu.</p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section id="cara-kerja" class="how">
    <div class="how-inner">
        <div class="section-tag">Cara Kerja</div>
        <h2 class="section-title">4 Langkah Mudah.</h2>
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <h4>Daftar Akun</h4>
                <p>Buat akun gratis dalam hitungan detik tanpa memerlukan data kartu kredit.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <h4>Pilih Mode</h4>
                <p>Pilih antara Konsultasi Pemula (kalkulasi budget) atau Expert System (analisis CF).</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <h4>Jawab Pertanyaan</h4>
                <p>Jawab 12 pertanyaan pakar sesuai tingkat keyakinan Anda terhadap setiap pernyataan.</p>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <h4>Terima Rekomendasi</h4>
                <p>Sistem menghitung dan memberikan rekomendasi <strong style="color:var(--gold-light)">Beli, Tahan, atau Jual</strong> dengan persentase keyakinan.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="cta-box">
        <h2>Siap Mulai Berinvestasi<br><em style="font-style:normal;color:var(--gold);">Lebih Cerdas?</em></h2>
        <p>Bergabung sekarang dan dapatkan analisis investasi emas pertama Anda secara gratis.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-primary" style="display:inline-flex;">Ke Dashboard →</a>
        @else
            <a href="{{ route('register') }}" class="btn-primary" style="display:inline-flex;">Daftar Gratis Sekarang →</a>
        @endauth
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>&copy; {{ date('Y') }} Investasi Emas. Sistem Pakar berbasis Certainty Factor.</p>
</footer>

</body>
</html>
