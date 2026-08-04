@extends('layouts.app')

@section('content')
@php
    $colors = ['Beli'=>'#c9a84c','Tahan'=>'#f59e0b','Jual'=>'#ef4444'];
    $topColor = $colors[$topHypothesis] ?? '#c9a84c';
    $bgColors = ['Beli'=>'rgba(201,168,76,.1)','Tahan'=>'rgba(245,158,11,.1)','Jual'=>'rgba(239,68,68,.1)'];
@endphp
<div style="max-width:800px;margin:auto;">
    <!-- RESULT HEADER -->
    <div class="card" style="text-align:center;border-color:{{ $topColor }};border-top:3px solid {{ $topColor }};margin-bottom:20px;padding:40px;">
        <div style="width:72px;height:72px;border-radius:50%;background:{{ $bgColors[$topHypothesis] }};border:2px solid {{ $topColor }};display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <svg width="32" height="32" fill="none" stroke="{{ $topColor }}" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <p style="margin:0;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);">Hasil Analisis Certainty Factor</p>
        <div style="font-size:56px;font-weight:900;letter-spacing:-2px;color:{{ $topColor }};margin:8px 0 4px;line-height:1;">{{ strtoupper($topHypothesis) }}</div>
        <div style="font-size:22px;font-weight:700;color:var(--muted);">Keyakinan: <strong style="color:#fff;">{{ $topPercentage }}%</strong></div>
        <div class="card" style="text-align:left;margin-top:24px;background:{{ $bgColors[$topHypothesis] }};border-color:{{ $topColor }};border-radius:14px;padding:20px;">
            <p style="margin:0;color:#e8eaf0;line-height:1.7;font-size:15px;">{!! $explanation !!}</p>
        </div>
    </div>

    <!-- DETAIL SCORES -->
    <div class="card" style="margin-bottom:20px;">
        <p class="card-title">Detail Nilai Certainty Factor (CF)</p>
        <div style="display:flex;flex-direction:column;gap:16px;">
            @foreach($results as $hyp => $pct)
            @php $cl = $colors[$hyp] ?? '#888'; @endphp
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                    <span style="font-weight:700;color:#e8eaf0;">{{ $hyp }}</span>
                    <span style="font-weight:900;color:{{ $cl }};">{{ $pct }}%</span>
                </div>
                <div style="height:10px;background:#1e2d40;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ max(0, min(100, ($pct < 0 ? 0 : $pct))) }}%;background:{{ $cl }};border-radius:99px;transition:width 1s ease;"></div>
                </div>
                <div style="margin-top:4px;font-size:11px;color:var(--muted);">Nilai CF: {{ round($cfCombine[$hyp], 4) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ACTIONS -->
    <div style="display:flex;gap:12px;justify-content:center;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline">← Dashboard</a>
        <a href="{{ route('consultation.intermediate') }}" class="btn btn-gold">Ulangi Analisis</a>
        <a href="{{ route('consultation.history') }}" class="btn btn-outline">Lihat Riwayat</a>
    </div>
</div>

<style>
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 22px;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;border:none;font-family:inherit;text-decoration:none;}
.btn-gold{background:linear-gradient(135deg,#e8cc7a,#c9a84c);color:#000;}
.btn-gold:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(201,168,76,.35);}
.btn-outline{background:transparent;border:1px solid var(--border);color:var(--muted);}
.btn-outline:hover{border-color:var(--gold);color:var(--gold);}
</style>
@endsection
