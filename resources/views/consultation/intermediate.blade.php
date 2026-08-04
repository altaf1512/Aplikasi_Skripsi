@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto glass-panel rounded-2xl p-6 md:p-10 shadow-xl">
    <div class="mb-8 border-b border-dark-700 pb-6 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Konsultasi Sistem Pakar</h2>
        <p class="text-gray-400">Jawab 12 pertanyaan berikut sesuai dengan keyakinan Anda untuk mendapatkan analisis investasi yang akurat.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded mb-6 text-center">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('consultation.intermediate.process') }}" method="POST">
        @csrf

        <div class="space-y-8">
            @foreach($questions as $index => $question)
            <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-gold-500/50 transition-colors">
                <p class="text-lg font-medium text-white mb-4">
                    <span class="text-gold-500 font-bold mr-2">{{ $index + 1 }}.</span> {{ $question->text }}
                </p>
                
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    @php
                        $options = [
                            '-1' => 'Tidak',
                            '-0.4' => 'Kurang Yakin',
                            '0.2' => 'Cukup Yakin',
                            '0.6' => 'Yakin',
                            '1' => 'Sangat Yakin'
                        ];
                    @endphp

                    @foreach($options as $value => $label)
                    <label class="relative flex cursor-pointer">
                        <input type="radio" name="cf_user[{{ $question->id }}]" value="{{ $value }}" class="peer sr-only" required>
                        <div class="w-full text-center py-2 px-3 rounded-lg border border-dark-600 bg-dark-900 text-sm font-medium text-gray-400 peer-checked:bg-gold-500/20 peer-checked:border-gold-500 peer-checked:text-gold-400 transition-all hover:bg-dark-700">
                            {{ $label }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 pt-6 border-t border-dark-700">
            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-dark-900 bg-gold-500 hover:bg-gold-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 focus:ring-gold-500 transition-transform hover:-translate-y-1">
                Proses Hasil Analisis (Metode Certainty Factor)
            </button>
        </div>
    </form>
</div>
@endsection
