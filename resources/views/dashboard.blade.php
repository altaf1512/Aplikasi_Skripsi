<x-app-layout>
@php
    $user = auth()->user();
    $isAdmin = $user->role === 'admin';
@endphp

@if($isAdmin)
@php
    $totalUsers        = \App\Models\User::count();
    $totalConsultations = \App\Models\ConsultationHistory::count();
    $totalToday        = \App\Models\ConsultationHistory::whereDate('created_at', today())->count();
    $goldPrice         = \Illuminate\Support\Facades\Cache::get('gold_price', 1400000);
    $chartDates        = collect(range(6, 0))->map(fn($d) => now()->subDays($d)->format('d M'));
    $chartData         = collect(range(6, 0))->map(fn($d) => \App\Models\ConsultationHistory::whereDate('created_at', now()->subDays($d))->count());
    $recents           = \App\Models\ConsultationHistory::with('user')->latest()->take(8)->get();
@endphp

<div class="page-header">
    <span class="badge badge-gold">ADMINISTRATOR</span>
    <h1>Dashboard Admin</h1>
    <p>Pantau aktivitas sistem dan kelola harga emas.</p>
</div>

<!-- STAT CARDS -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
    <div class="card" style="display:flex;align-items:center;gap:14px;">
        <div class="stat-icon" style="background:rgba(200,168,75,.12);color:var(--gold);">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">Total Pengguna</div>
            <div style="font-size:26px;font-weight:900;color:#fff;line-height:1.2;margin-top:2px;">{{ $totalUsers }}</div>
        </div>
    </div>
    <div class="card" style="display:flex;align-items:center;gap:14px;">
        <div class="stat-icon" style="background:rgba(16,185,129,.12);color:#34d399;">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">Total Konsultasi</div>
            <div style="font-size:26px;font-weight:900;color:#fff;line-height:1.2;margin-top:2px;">{{ $totalConsultations }}</div>
        </div>
    </div>
    <div class="card" style="display:flex;align-items:center;gap:14px;">
        <div class="stat-icon" style="background:rgba(99,102,241,.12);color:#818cf8;">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">Konsultasi Hari Ini</div>
            <div style="font-size:26px;font-weight:900;color:#fff;line-height:1.2;margin-top:2px;">{{ $totalToday }}</div>
        </div>
    </div>
    <div class="card">
        <div class="card-title" style="margin-bottom:10px;">Harga Emas / gram</div>
        <form action="{{ route('admin.goldprice.update') }}" method="POST" style="display:flex;gap:8px;align-items:flex-end;">
            @csrf
            <div style="flex:1;">
                <label class="field-label">Harga (Rp)</label>
                <input class="field-input" type="number" name="gold_price" value="{{ $goldPrice }}" required>
            </div>
            <button type="submit" class="btn btn-gold btn-sm" style="height:40px;">Simpan</button>
        </form>
    </div>
</div>

<!-- CHART + TABLE -->
<div style="display:grid;grid-template-columns:1.3fr 1fr;gap:20px;">
    <div class="card">
        <div class="card-title">Konsultasi 7 Hari Terakhir</div>
        <div style="height:240px;position:relative;">
            <canvas id="adminChart"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-title">Aktivitas Terbaru</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Pengguna</th><th>Tipe</th><th>Hasil</th></tr>
                </thead>
                <tbody>
                    @forelse($recents as $h)
                    <tr>
                        <td style="color:#e8eaf0;font-weight:600;">
                            {{ $h->user->name ?? '—' }}
                            <div style="font-size:11px;color:var(--muted);font-weight:400;">{{ $h->created_at->diffForHumans() }}</div>
                        </td>
                        <td><span class="badge {{ $h->type === 'beginner' ? 'badge-blue' : 'badge-green' }}">{{ $h->type }}</span></td>
                        <td style="font-size:11px;color:var(--muted);">{{ Str::limit($h->result, 28) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:var(--muted);padding:24px;">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('adminChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartDates) !!},
        datasets: [{
            label: 'Konsultasi',
            data: {!! json_encode($chartData) !!},
            borderColor: '#c8a84b',
            backgroundColor: 'rgba(200,168,75,0.07)',
            fill: true, tension: 0.4,
            pointBackgroundColor: '#c8a84b', pointRadius: 4,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { color: '#596780', stepSize: 1 }, grid: { color: '#1c2b3d' } },
            x: { ticks: { color: '#596780' }, grid: { display: false } }
        }
    }
});
</script>

@else

@php
    $histories = \App\Models\ConsultationHistory::where('user_id', $user->id)->latest()->take(5)->get();
    $allH      = \App\Models\ConsultationHistory::where('user_id', $user->id)->get();
    $cBeli     = $allH->filter(fn($h) => str_contains($h->result, 'Beli'))->count();
    $cTahan    = $allH->filter(fn($h) => str_contains($h->result, 'Tahan'))->count();
    $cJual     = $allH->filter(fn($h) => str_contains($h->result, 'Jual'))->count();
    $total     = $allH->count();
    $goldPrice = \Illuminate\Support\Facades\Cache::get('gold_price', 1400000);
@endphp

<div class="page-header">
    <span class="badge badge-gold">PENGGUNA</span>
    <h1>Halo, {{ Str::before($user->name, ' ') }}.</h1>
    <p>Harga emas hari ini <strong style="color:var(--gold);">Rp {{ number_format($goldPrice, 0, ',', '.') }}</strong>/gram.</p>
</div>

<!-- ACTION CARDS -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
    <a href="{{ route('consultation.beginner') }}" class="card" style="text-decoration:none;display:block;position:relative;overflow:hidden;border-color:rgba(200,168,75,.2);transition:transform .2s,border-color .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='var(--gold)';this.style.boxShadow='0 12px 32px rgba(200,168,75,.12)';" onmouseout="this.style.transform='';this.style.borderColor='rgba(200,168,75,.2)';this.style.boxShadow='';">
        <div style="position:absolute;right:-16px;top:-16px;width:90px;height:90px;background:radial-gradient(circle,rgba(200,168,75,.14),transparent);border-radius:50%;pointer-events:none;"></div>
        <span class="badge badge-gold" style="margin-bottom:14px;display:inline-flex;">PEMULA</span>
        <h3 style="margin:0 0 8px;font-size:19px;color:#fff;font-weight:800;">Konsultasi Pemula</h3>
        <p style="margin:0;color:var(--muted);font-size:13px;line-height:1.6;">Hitung estimasi gram emas sesuai budget dan tujuan investasi Anda.</p>
        <div style="margin-top:16px;font-size:13px;font-weight:700;color:var(--gold);">Mulai Sekarang →</div>
    </a>
    <a href="{{ route('consultation.intermediate') }}" class="card" style="text-decoration:none;display:block;position:relative;overflow:hidden;border-color:rgba(16,185,129,.15);transition:transform .2s,border-color .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='#34d399';this.style.boxShadow='0 12px 32px rgba(16,185,129,.1)';" onmouseout="this.style.transform='';this.style.borderColor='rgba(16,185,129,.15)';this.style.boxShadow='';">
        <div style="position:absolute;right:-16px;top:-16px;width:90px;height:90px;background:radial-gradient(circle,rgba(16,185,129,.1),transparent);border-radius:50%;pointer-events:none;"></div>
        <span class="badge badge-green" style="margin-bottom:14px;display:inline-flex;">PAKAR</span>
        <h3 style="margin:0 0 8px;font-size:19px;color:#fff;font-weight:800;">Expert System CF</h3>
        <p style="margin:0;color:var(--muted);font-size:13px;line-height:1.6;">Analisis 12 pertanyaan menggunakan algoritma Certainty Factor.</p>
        <div style="margin-top:16px;font-size:13px;font-weight:700;color:#34d399;">Mulai Analisis →</div>
    </a>
</div>

<!-- CHART + HISTORY -->
<div style="display:grid;grid-template-columns:220px 1fr;gap:20px;">
    <div class="card" style="display:flex;flex-direction:column;align-items:center;">
        <div class="card-title" style="width:100%;margin-bottom:12px;">Statistik Hasil</div>
        @if($total === 0)
            <div style="flex:1;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:12px;text-align:center;padding:20px;line-height:1.6;">
                Belum ada data.<br>Lakukan konsultasi pertama Anda.
            </div>
        @else
            <div style="width:160px;height:160px;position:relative;margin:8px 0;">
                <canvas id="userChart"></canvas>
            </div>
            <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;width:100%;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;"><span>● <span style="color:var(--gold);">Beli</span></span><strong style="color:#fff;">{{ $cBeli }}×</strong></div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;"><span>● <span style="color:#f59e0b;">Tahan</span></span><strong style="color:#fff;">{{ $cTahan }}×</strong></div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;"><span>● <span style="color:#ef4444;">Jual</span></span><strong style="color:#fff;">{{ $cJual }}×</strong></div>
            </div>
        @endif
    </div>
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <div class="card-title" style="margin-bottom:0;">Riwayat Terakhir</div>
            <a href="{{ route('consultation.history') }}" style="font-size:12px;font-weight:700;color:var(--gold);text-decoration:none;">Lihat semua →</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Tipe</th><th>Hasil</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @forelse($histories as $h)
                    <tr>
                        <td><span class="badge {{ $h->type === 'beginner' ? 'badge-blue' : 'badge-green' }}">{{ $h->type }}</span></td>
                        <td style="font-size:12px;color:var(--muted);">{{ Str::limit($h->result, 60) }}</td>
                        <td style="font-size:11px;color:var(--muted);white-space:nowrap;">{{ $h->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:var(--muted);padding:28px;">Belum ada riwayat konsultasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($total > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('userChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Beli', 'Tahan', 'Jual'],
        datasets: [{ data: [{{ $cBeli }}, {{ $cTahan }}, {{ $cJual }}], backgroundColor: ['#c8a84b','#f59e0b','#ef4444'], borderWidth: 0 }]
    },
    options: { plugins: { legend: { display: false } }, cutout: '70%' }
});
</script>
@endif

@endif
</x-app-layout>
