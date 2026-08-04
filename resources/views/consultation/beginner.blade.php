@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto glass-panel rounded-2xl p-8 shadow-xl">
    <div class="mb-8 border-b border-dark-700 pb-6">
        <h2 class="text-3xl font-bold text-white mb-2">Konsultasi Pemula</h2>
        <p class="text-gray-400">Masukkan rencana investasi Anda untuk mendapatkan estimasi emas.</p>
    </div>

    <form action="{{ route('consultation.beginner.process') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="budget" class="block text-sm font-medium text-gray-300 mb-2">Budget Investasi (Rupiah)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">Rp</span>
                </div>
                <input type="number" name="budget" id="budget" required min="100000" class="block w-full pl-10 pr-3 py-3 border border-dark-600 rounded-lg leading-5 bg-dark-800 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-gold-500 focus:border-gold-500 transition duration-150 ease-in-out sm:text-sm" placeholder="Misal: 5000000">
            </div>
            @error('budget') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="goal" class="block text-sm font-medium text-gray-300 mb-2">Tujuan Investasi</label>
            <select id="goal" name="goal" required class="block w-full pl-3 pr-10 py-3 text-base border-dark-600 focus:outline-none focus:ring-gold-500 focus:border-gold-500 sm:text-sm rounded-lg bg-dark-800 text-gray-200">
                <option value="dana_darurat">Dana Darurat</option>
                <option value="tabungan_nikah">Tabungan Menikah</option>
                <option value="dana_pendidikan">Dana Pendidikan Anak</option>
                <option value="haji_umroh">Haji / Umroh</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div>
            <label for="timeframe" class="block text-sm font-medium text-gray-300 mb-2">Jangka Waktu Investasi</label>
            <select id="timeframe" name="timeframe" required class="block w-full pl-3 pr-10 py-3 text-base border-dark-600 focus:outline-none focus:ring-gold-500 focus:border-gold-500 sm:text-sm rounded-lg bg-dark-800 text-gray-200">
                <option value="short_term">Jangka Pendek (< 1 Tahun)</option>
                <option value="medium_term">Jangka Menengah (1 - 3 Tahun)</option>
                <option value="long_term">Jangka Panjang (> 3 Tahun)</option>
            </select>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-dark-900 bg-gold-500 hover:bg-gold-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 focus:ring-gold-500 transition-colors">
                Lihat Rekomendasi
            </button>
        </div>
    </form>
</div>
@endsection
