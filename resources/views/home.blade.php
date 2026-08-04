@extends('layouts.app')

@section('content')
<div class="text-center mb-16">
    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
        Cerdas Berinvestasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-gold-600">Emas</span>
    </h1>
    <p class="text-lg text-gray-400 max-w-2xl mx-auto">
        Dapatkan rekomendasi investasi emas yang dipersonalisasi sesuai dengan profil risiko, tujuan, dan kondisi finansial Anda menggunakan Sistem Pakar.
    </p>
</div>

<div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
    <!-- Card Pemula -->
    <div class="glass-panel rounded-2xl p-8 flex flex-col items-center text-center transition-transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-gold-500/10">
        <div class="w-16 h-16 bg-dark-800 rounded-full flex items-center justify-center mb-6 border border-dark-700">
            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        </div>
        <h2 class="text-2xl font-bold mb-3 text-white">Investor Pemula</h2>
        <p class="text-gray-400 mb-8 flex-grow">
            Baru mulai mengenal investasi? Gunakan alur sederhana ini untuk menghitung estimasi jumlah emas berdasarkan budget Anda.
        </p>
        <a href="{{ route('consultation.beginner') }}" class="btn-gold w-full py-3 px-6 rounded-lg text-center inline-block">
            Mulai Konsultasi Pemula
        </a>
    </div>

    <!-- Card Menengah -->
    <div class="glass-panel rounded-2xl p-8 flex flex-col items-center text-center transition-transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-gold-500/10 border-gold-500/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 bg-gold-500 text-dark-900 text-xs font-bold px-3 py-1 rounded-bl-lg">
            Akurasi Tinggi
        </div>
        <div class="w-16 h-16 bg-dark-800 rounded-full flex items-center justify-center mb-6 border border-dark-700">
            <svg class="w-8 h-8 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <h2 class="text-2xl font-bold mb-3 text-white">Investor Menengah</h2>
        <p class="text-gray-400 mb-8 flex-grow">
            Analisis mendalam dengan 12 parameter menggunakan algoritma Certainty Factor. Rekomendasi Beli, Tahan, atau Jual.
        </p>
        <a href="{{ route('consultation.intermediate') }}" class="btn-gold w-full py-3 px-6 rounded-lg text-center inline-block shadow-[0_0_15px_rgba(245,158,11,0.3)]">
            Mulai Sistem Pakar CF
        </a>
    </div>
</div>
@endsection
