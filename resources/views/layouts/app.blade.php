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
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; background: #070b13; color: #dde3f0; }
        a { text-decoration: none; color: inherit; }

        /* ===== CSS VARIABLES ===== */
        :root {
            --gold: #c8a84b;
            --gold-light: #e5cf85;
            --gold-glow: rgba(200,168,75,0.15);
            --bg: #070b13;
            --surface: #0e1525;
            --surface2: #131d2e;
            --border: #1c2b3d;
            --muted: #596780;
            --text: #dde3f0;
        }

        /* ===== LAYOUT ===== */
        .layout { display: flex; min-height: 100vh; }
        .content { flex: 1; padding: 28px 32px 80px; min-width: 0; margin-left: 88px; transition: margin-left 0.4s ease; }
        body.sidebar-open .content { margin-left: 272px; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 12px; left: 12px; bottom: 12px;
            width: 64px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width 0.38s cubic-bezier(0.4,0,0.2,1);
            z-index: 9000;
        }
        .sidebar:hover {
            width: 248px;
        }
        .sidebar:hover ~ .content { margin-left: 272px; }

        /* sidebar logo area */
        .sb-logo {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 18px 0 22px;
            flex-shrink: 0;
        }
        /* Logo mark takes full 64px to stay centered */
        .sb-logo-icon {
            width: 64px; min-width: 64px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-mark {
            width: 44px; height: 44px; min-width: 44px;
            background: linear-gradient(135deg, #e5cf85, #c8a84b);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 900; color: #000;
            box-shadow: 0 4px 14px rgba(200,168,75,0.3);
            flex-shrink: 0;
        }
        .sb-brand {
            white-space: nowrap;
            overflow: hidden;
            opacity: 0;
            transform: translateX(-6px);
            transition: opacity 0.25s 0.08s, transform 0.25s 0.08s;
            pointer-events: none;
        }
        .sidebar:hover .sb-brand { opacity: 1; transform: translateX(0); }
        .sb-brand-name { font-size: 17px; font-weight: 900; color: #fff; letter-spacing: -0.5px; }
        .sb-brand-name span { color: var(--gold); }
        .sb-brand-sub { font-size: 9px; font-weight: 700; color: var(--muted); letter-spacing: 1.2px; text-transform: uppercase; margin-top: 2px; }

        /* sidebar nav */
        .sb-nav { display: flex; flex-direction: column; gap: 3px; flex: 1; padding: 0; }
        .sb-item {
            display: flex;
            align-items: center;
            gap: 0;
            height: 46px;
            padding: 0;
            border-radius: 14px;
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            font-family: inherit;
            transition: background 0.18s, color 0.18s;
        }
        .sb-item:hover { background: var(--gold-glow); color: var(--gold-light); }
        .sb-item.active { background: rgba(200,168,75,0.12); color: var(--gold); }
        .sb-item.danger:hover { background: rgba(239,68,68,0.09); color: #f87171; }
        /* Icon always 64px wide = same as collapsed sidebar, so it's always centered */
        .sb-icon {
            width: 64px; min-width: 64px; height: 46px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-label {
            opacity: 0;
            transform: translateX(-6px);
            transition: opacity 0.22s 0.06s, transform 0.22s 0.06s;
            pointer-events: none;
            overflow: hidden;
            padding-right: 14px;
        }
        .sidebar:hover .sb-label { opacity: 1; transform: translateX(0); }

        /* sidebar footer */
        .sb-footer { padding: 8px 0 14px; flex-shrink: 0; border-top: 1px solid var(--border); }

        /* ===== CARDS ===== */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 22px;
        }
        .card-title { font-size: 14px; font-weight: 700; color: var(--gold); margin-bottom: 16px; }

        /* ===== BADGES ===== */
        .badge {
            display: inline-flex; align-items: center;
            padding: 4px 10px; border-radius: 20px;
            font-size: 10px; font-weight: 800;
            letter-spacing: 1px; text-transform: uppercase;
        }
        .badge-gold { background: rgba(200,168,75,.12); color: var(--gold); border: 1px solid rgba(200,168,75,.22); }
        .badge-green { background: rgba(16,185,129,.1); color: #34d399; border: 1px solid rgba(16,185,129,.2); }
        .badge-blue { background: rgba(59,130,246,.1); color: #60a5fa; border: 1px solid rgba(59,130,246,.2); }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 7px; padding: 10px 20px;
            border-radius: 11px; font-size: 13.5px; font-weight: 700;
            cursor: pointer; transition: all 0.18s; border: none;
            font-family: inherit; text-decoration: none;
        }
        .btn-gold { background: linear-gradient(135deg, #e5cf85, #c8a84b); color: #000; }
        .btn-gold:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(200,168,75,.35); }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--muted); }
        .btn-outline:hover { border-color: var(--gold); color: var(--gold); }
        .btn-danger { background: rgba(239,68,68,.09); border: 1px solid rgba(239,68,68,.28); color: #f87171; }
        .btn-danger:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
        .btn-sm { padding: 6px 13px; font-size: 12px; border-radius: 9px; }

        /* ===== FORMS ===== */
        .field-label { display: block; font-size: 11.5px; font-weight: 700; color: var(--muted); margin-bottom: 6px; letter-spacing: 0.3px; text-transform: uppercase; }
        .field-input {
            width: 100%; padding: 10px 13px; border-radius: 10px;
            background: var(--bg); border: 1px solid var(--border);
            color: var(--text); font-size: 13.5px; font-family: inherit;
            outline: none; transition: border-color 0.18s, box-shadow 0.18s;
        }
        .field-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,168,75,.1); }
        textarea.field-input { resize: vertical; }

        /* ===== TABLE ===== */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { padding: 9px 12px; color: var(--muted); font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border-bottom: 1px solid var(--border); text-align: left; }
        td { padding: 11px 12px; border-bottom: 1px solid rgba(28,43,61,0.6); color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(200,168,75,.025); }

        /* ===== PAGE HEADER ===== */
        .page-header { margin-bottom: 26px; }
        .page-header h1 { margin: 8px 0 5px; font-size: 30px; font-weight: 900; letter-spacing: -1.3px; color: #fff; }
        .page-header p { color: var(--muted); font-size: 13.5px; }

        /* ===== ALERTS ===== */
        .alert { padding: 11px 16px; border-radius: 11px; font-size: 13px; font-weight: 600; margin-bottom: 16px; }
        .alert-success { background: rgba(16,185,129,.09); border: 1px solid rgba(16,185,129,.22); color: #34d399; }
        .alert-error { background: rgba(239,68,68,.09); border: 1px solid rgba(239,68,68,.22); color: #f87171; }

        /* ===== MODAL ===== */
        .modal-backdrop {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(0,0,0,.72);
            backdrop-filter: blur(5px);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .modal-box {
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 22px; padding: 30px; width: 100%; max-width: 540px;
            box-shadow: 0 24px 80px rgba(0,0,0,.65), 0 0 0 1px rgba(200,168,75,.07);
            position: relative;
        }
        .modal-title { font-size: 19px; font-weight: 800; color: #fff; margin: 0 0 18px; }
        .modal-close {
            position: absolute; top: 18px; right: 18px;
            background: rgba(255,255,255,.05); border: 1px solid var(--border);
            color: var(--muted); width: 30px; height: 30px;
            border-radius: 50%; cursor: pointer; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s;
        }
        .modal-close:hover { background: rgba(239,68,68,.15); color: #f87171; border-color: rgba(239,68,68,.3); }

        /* ===== RADIO CARD ===== */
        .radio-card input[type=radio] { display: none; }
        .radio-card label {
            display: block; padding: 9px 10px; border-radius: 10px;
            border: 1px solid var(--border); cursor: pointer;
            text-align: center; font-size: 12.5px; font-weight: 600;
            color: var(--muted); transition: all 0.15s;
        }
        .radio-card input[type=radio]:checked + label { border-color: var(--gold); color: var(--gold); background: rgba(200,168,75,.1); }
        .radio-card label:hover { border-color: rgba(200,168,75,.4); color: var(--gold-light); }

        /* ===== STAT CARD ===== */
        .stat-icon { width: 46px; height: 46px; min-width: 46px; border-radius: 13px; display: flex; align-items: center; justify-content: center; }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 5px; } 
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }
    </style>
</head>
<body>
<div class="layout">

    <!-- ========== SIDEBAR ========== -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sb-logo">
            <div class="sb-logo-icon">
                <div class="sb-mark">E</div>
            </div>
            <div class="sb-brand">
                <div class="sb-brand-name">Investasi<span>Emas</span></div>
                <div class="sb-brand-sub">Sistem Pakar Cerdas</div>
            </div>
        </div>

        <!-- Nav items -->
        <nav class="sb-nav">
            <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sb-icon">
                    <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                </span>
                <span class="sb-label">Dashboard</span>
            </a>

            @if(auth()->user()->role === 'user')
            <a href="{{ route('consultation.beginner') }}" class="sb-item {{ request()->routeIs('consultation.beginner*') ? 'active' : '' }}">
                <span class="sb-icon">
                    <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </span>
                <span class="sb-label">Konsultasi Pemula</span>
            </a>
            <a href="{{ route('consultation.intermediate') }}" class="sb-item {{ request()->routeIs('consultation.intermediate*') ? 'active' : '' }}">
                <span class="sb-icon">
                    <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </span>
                <span class="sb-label">Konsultasi Pakar</span>
            </a>
            <a href="{{ route('consultation.history') }}" class="sb-item {{ request()->routeIs('consultation.history') ? 'active' : '' }}">
                <span class="sb-icon">
                    <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </span>
                <span class="sb-label">Riwayat</span>
            </a>
            @else
            <a href="{{ route('admin.questions') }}" class="sb-item {{ request()->routeIs('admin.questions') ? 'active' : '' }}">
                <span class="sb-icon">
                    <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </span>
                <span class="sb-label">Kelola Pertanyaan</span>
            </a>
            <a href="{{ route('admin.users') }}" class="sb-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <span class="sb-icon">
                    <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                </span>
                <span class="sb-label">Kelola Pengguna</span>
            </a>
            @endif
        </nav>

        <!-- Logout -->
        <div class="sb-footer">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="sb-item danger" style="width:100%;">
                    <span class="sb-icon">
                        <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </span>
                    <span class="sb-label">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ========== MAIN ========== -->
    <main class="content" id="main-content">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
</div>

<!-- TOAST NOTIFICATIONS -->
<div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:99998;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

<style>
.toast {
    display:flex; align-items:center; gap:12px;
    padding: 14px 18px; border-radius: 14px; min-width: 280px; max-width: 380px;
    font-size: 13.5px; font-weight: 600; color: #fff;
    box-shadow: 0 8px 32px rgba(0,0,0,.4);
    pointer-events: all;
    animation: toastIn .35s cubic-bezier(0.34,1.56,0.64,1) both;
    position: relative; overflow: hidden;
}
.toast-success { background: #0e1525; border: 1px solid rgba(52,211,153,.3); }
.toast-error   { background: #0e1525; border: 1px solid rgba(248,113,113,.3); }
.toast-icon { width: 32px; height: 32px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }
.toast-success .toast-icon { background: rgba(52,211,153,.15); color: #34d399; }
.toast-error   .toast-icon { background: rgba(248,113,113,.15); color: #f87171; }
.toast-bar {
    position:absolute; bottom:0; left:0; height:2px; border-radius:99px;
    animation: toastBar 4s linear both;
}
.toast-success .toast-bar { background: #34d399; }
.toast-error   .toast-bar { background: #f87171; }
@keyframes toastIn { from { opacity:0; transform:translateX(30px); } to { opacity:1; transform:translateX(0); } }
@keyframes toastOut { to { opacity:0; transform:translateX(30px); } }
@keyframes toastBar { from { width:100%; } to { width:0%; } }
</style>

<script>
    /* ===== TOAST ===== */
    function showToast(message, type) {
        type = type || 'success';
        var container = document.getElementById('toast-container');
        var icon = type === 'success' ? '✓' : '✕';
        var toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        toast.innerHTML =
            '<div class="toast-icon">' + icon + '</div>' +
            '<span style="flex:1;">' + message + '</span>' +
            '<div class="toast-bar"></div>';
        container.appendChild(toast);
        setTimeout(function() {
            toast.style.animation = 'toastOut .3s ease forwards';
            setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
        }, 4000);
    }

    // Auto-show from session flash
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() { showToast('{{ addslashes(session('success')) }}', 'success'); });
    @endif
    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() { showToast('{{ addslashes(session('error')) }}', 'error'); });
    @endif

    /* ===== MODAL ===== */
    function openModal(id) {
        var el = document.getElementById(id);
        if (el) { el.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    }
    function closeModal(id) {
        var el = document.getElementById(id);
        if (el) { el.style.display = 'none'; document.body.style.overflow = ''; }
    }
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) closeModal(e.target.id);
    });
    @if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var m = document.getElementById('modal-add-question');
        if (m) openModal('modal-add-question');
    });
    @endif

    /* ===== SIDEBAR HOVER MARGIN SYNC ===== */
    var sb = document.getElementById('sidebar');
    var mc = document.getElementById('main-content');
    if (sb && mc) {
        sb.addEventListener('mouseenter', function() { mc.style.marginLeft = '272px'; });
        sb.addEventListener('mouseleave', function() { mc.style.marginLeft = '88px'; });
    }
</script>
</body>
</html>

