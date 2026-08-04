<x-app-layout>
    <div class="page-header" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <span class="badge badge-gold">RIWAYAT</span>
            <h1>Riwayat Konsultasi</h1>
            <p>Semua hasil konsultasi Anda tersimpan di sini.</p>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('consultation.beginner') }}" class="btn btn-outline btn-sm">+ Konsultasi Pemula</a>
            <a href="{{ route('consultation.intermediate') }}" class="btn btn-gold btn-sm">+ Expert System</a>
        </div>
    </div>

    @php $histories = \App\Models\ConsultationHistory::where('user_id', auth()->id())->latest()->paginate(12); @endphp

    @if($histories->isEmpty())
    <div class="card" style="text-align:center;padding:56px 24px;border-style:dashed;">
        <div style="width:56px;height:56px;border-radius:16px;background:rgba(200,168,75,.1);border:1px solid rgba(200,168,75,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="26" height="26" fill="none" stroke="#c8a84b" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:800;color:#fff;margin-bottom:8px;">Belum ada riwayat</h3>
        <p style="color:var(--muted);margin-bottom:24px;">Mulai konsultasi pertama Anda untuk mendapatkan rekomendasi investasi emas.</p>
        <a href="{{ route('consultation.intermediate') }}" class="btn btn-gold" style="margin:auto;display:inline-flex;">Mulai Konsultasi Sekarang →</a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:14px;margin-bottom:24px;">
        @foreach($histories as $history)
        <div class="card" style="border-left:3px solid {{ $history->type === 'beginner' ? '#60a5fa' : '#34d399' }};transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.3)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:10px;">
                <span class="badge {{ $history->type === 'beginner' ? 'badge-blue' : 'badge-green' }}">
                    {{ $history->type === 'beginner' ? 'PEMULA' : 'EXPERT CF' }}
                </span>
                <span style="font-size:11px;color:var(--muted);">{{ $history->created_at->format('d M Y, H:i') }}</span>
            </div>
            <p style="font-size:13.5px;color:var(--text);line-height:1.6;margin-bottom:10px;">{{ $history->result }}</p>
            <div style="font-size:11px;color:var(--muted);">{{ $history->created_at->diffForHumans() }}</div>
        </div>
        @endforeach
    </div>

    @if($histories->hasPages())
    <div style="display:flex;justify-content:center;margin-top:8px;">
        {{ $histories->links() }}
    </div>
    @endif
    @endif

    <style>
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 20px;border-radius:11px;font-size:13.5px;font-weight:700;cursor:pointer;transition:all .18s;border:none;font-family:inherit;text-decoration:none;}
    .btn-gold{background:linear-gradient(135deg,#e5cf85,#c8a84b);color:#000;}
    .btn-gold:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(200,168,75,.35);}
    .btn-outline{background:transparent;border:1px solid var(--border);color:var(--muted);}
    .btn-outline:hover{border-color:var(--gold);color:var(--gold);}
    .btn-sm{padding:7px 14px;font-size:12px;border-radius:9px;}
    </style>
</x-app-layout>
