@extends('layouts.app')

@section('content')
<div class="page-header">
    <span class="badge badge-gold">SISTEM PAKAR</span>
    <h1>Konsultasi Expert System</h1>
    <p>Jawab {{ count($questions) }} pertanyaan berikut sesuai keyakinan Anda untuk mendapatkan analisis Certainty Factor.</p>
</div>

@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif

<form action="{{ route('consultation.intermediate.process') }}" method="POST">
    @csrf
    <div style="display:flex;flex-direction:column;gap:16px;">
        @foreach($questions as $index => $question)
        <div class="card" style="border-left:3px solid var(--border);transition:border-color .2s;">
            <div style="display:flex;gap:14px;align-items:flex-start;">
                <div style="width:36px;height:36px;min-width:36px;background:rgba(201,168,76,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:var(--gold);">{{ $index + 1 }}</div>
                <div style="flex:1;">
                    <p style="margin:0 0 14px;font-size:15px;color:#e8eaf0;line-height:1.6;font-weight:500;">{{ $question->text }}</p>
                    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;">
                        @php
                            $options = ['-1'=>'Tidak','-0.4'=>'Kurang Yakin','0.2'=>'Cukup Yakin','0.6'=>'Yakin','1'=>'Sangat Yakin'];
                        @endphp
                        @foreach($options as $val => $lbl)
                        <div class="radio-card">
                            <input type="radio" id="q{{ $question->id }}_{{ $loop->index }}" name="cf_user[{{ $question->id }}]" value="{{ $val }}" required>
                            <label for="q{{ $question->id }}_{{ $loop->index }}">{{ $lbl }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top:28px;display:flex;justify-content:flex-end;gap:12px;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline">Kembali</a>
        <button type="submit" class="btn btn-gold">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Proses Analisis Certainty Factor
        </button>
    </div>
</form>

<style>
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 22px;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;border:none;font-family:inherit;text-decoration:none;}
.btn-gold{background:linear-gradient(135deg,#e8cc7a,#c9a84c);color:#000;}
.btn-gold:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(201,168,76,.35);}
.btn-outline{background:transparent;border:1px solid var(--border);color:var(--muted);}
.btn-outline:hover{border-color:var(--gold);color:var(--gold);}
</style>
@endsection
