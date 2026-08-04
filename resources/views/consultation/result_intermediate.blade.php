@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl border-t-4 border-t-gold-500">
        <div class="p-8 sm:p-10">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-dark-800 rounded-full border border-dark-700 mb-6 shadow-[0_0_20px_rgba(245,158,11,0.2)]">
                    <svg class="h-10 w-10 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h2 class="text-3xl font-extrabold text-white">Hasil Analisis Sistem Pakar</h2>
                <p class="mt-2 text-lg text-gray-400">Tingkat keyakinan berdasarkan metode Certainty Factor</p>
            </div>

            <!-- Recommendation Alert -->
            <div class="bg-dark-800 rounded-xl p-6 mb-10 border {{ $topHypothesis == 'Beli' ? 'border-green-500/50' : ($topHypothesis == 'Tahan' ? 'border-yellow-500/50' : 'border-red-500/50') }}">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="flex-shrink-0 text-center md:text-left">
                        <span class="block text-sm text-gray-400 mb-1">Rekomendasi Utama:</span>
                        <span class="block text-4xl font-black tracking-wider {{ $topHypothesis == 'Beli' ? 'text-green-400' : ($topHypothesis == 'Tahan' ? 'text-yellow-400' : 'text-red-400') }}">
                            {{ strtoupper($topHypothesis) }}
                        </span>
                        <span class="block text-sm text-gray-400 mt-1">Tingkat Keyakinan: <strong class="text-white">{{ $topPercentage }}%</strong></span>
                    </div>
                    <div class="flex-grow pl-0 md:pl-6 border-t md:border-t-0 md:border-l border-dark-700 pt-4 md:pt-0">
                        <p class="text-gray-300 text-lg leading-relaxed">
                            {{ $explanation }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Progress Bars -->
            <h3 class="text-xl font-bold text-white mb-6">Detail Persentase Hipotesis</h3>
            <div class="space-y-6 bg-dark-900 p-6 rounded-xl border border-dark-700">
                
                @foreach($results as $hypothesis => $percentage)
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-base font-semibold text-gray-200">{{ $hypothesis }}</span>
                        <span class="text-sm font-bold {{ $hypothesis == $topHypothesis ? 'text-gold-400' : 'text-gray-400' }}">{{ $percentage }}%</span>
                    </div>
                    <div class="w-full bg-dark-800 rounded-full h-3">
                        <div class="h-3 rounded-full {{ $hypothesis == 'Beli' ? 'bg-green-500' : ($hypothesis == 'Tahan' ? 'bg-yellow-500' : 'bg-red-500') }} transition-all duration-1000 ease-out" style="width: {{ max(0, $percentage) }}%"></div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="mt-10 flex justify-center space-x-4">
                <a href="{{ route('home') }}" class="inline-flex justify-center py-3 px-6 border border-dark-600 shadow-sm text-base font-medium rounded-lg text-gray-300 bg-dark-800 hover:bg-dark-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 focus:ring-gold-500 transition-colors">
                    Beranda
                </a>
                <a href="{{ route('consultation.intermediate') }}" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-dark-900 bg-gold-500 hover:bg-gold-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 focus:ring-gold-500 transition-colors">
                    Ulangi Tes
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
