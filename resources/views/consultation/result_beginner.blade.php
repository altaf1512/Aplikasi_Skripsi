@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl border-t-4 border-t-gold-500">
        <div class="p-8 sm:p-10">
            <div class="text-center mb-8">
                <svg class="mx-auto h-16 w-16 text-gold-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h2 class="text-3xl font-extrabold text-white">Hasil Rekomendasi</h2>
                <p class="mt-2 text-lg text-gray-400">Berdasarkan profil investasi Anda</p>
            </div>

            <div class="bg-dark-800 rounded-xl p-6 mb-8 border border-dark-700">
                <h3 class="text-xl font-bold text-white mb-4 text-center">{{ $recommendation }}</h3>
                
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-dark-900 p-4 rounded-lg text-center">
                        <span class="block text-sm text-gray-400 mb-1">Budget Anda</span>
                        <span class="block text-xl font-bold text-white">Rp {{ number_format($budget, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-dark-900 p-4 rounded-lg text-center border border-gold-500/30">
                        <span class="block text-sm text-gray-400 mb-1">Estimasi Emas</span>
                        <span class="block text-2xl font-bold text-gold-400">{{ $gram }} <span class="text-sm">Gram</span></span>
                    </div>
                </div>
                <div class="text-center mt-4 text-xs text-gray-500">
                    *Asumsi harga emas saat ini: Rp {{ number_format($goldPrice, 0, ',', '.') }} / gram.
                </div>
            </div>

            <div class="flex justify-center space-x-4">
                <a href="{{ route('home') }}" class="inline-flex justify-center py-3 px-6 border border-dark-600 shadow-sm text-base font-medium rounded-lg text-gray-300 bg-dark-800 hover:bg-dark-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 focus:ring-gold-500 transition-colors">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('consultation.beginner') }}" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-dark-900 bg-gold-500 hover:bg-gold-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 focus:ring-gold-500 transition-colors">
                    Hitung Ulang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
