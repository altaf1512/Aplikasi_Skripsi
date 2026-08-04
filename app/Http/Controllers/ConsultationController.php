<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\ExpertRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConsultationController extends Controller
{
    protected function getGoldPrice(): float
    {
        return (float) Cache::get('gold_price', 1400000);
    }

    /**
     * CF Combine: algoritma penggabungan Certainty Factor.
     * Menangani ketiga kasus: positif-positif, negatif-negatif, dan campuran.
     */
    protected function combine(float $cfOld, float $cfRule): float
    {
        if ($cfOld >= 0 && $cfRule >= 0) {
            return $cfOld + $cfRule * (1 - $cfOld);
        } elseif ($cfOld < 0 && $cfRule < 0) {
            return $cfOld + $cfRule * (1 + $cfOld);
        } else {
            $denominator = 1 - min(abs($cfOld), abs($cfRule));
            return $denominator > 0 ? ($cfOld + $cfRule) / $denominator : 0;
        }
    }

    // --- ALUR PEMULA ---
    public function beginnerForm()
    {
        return view('consultation.beginner', ['goldPrice' => $this->getGoldPrice()]);
    }

    public function beginnerProcess(Request $request)
    {
        $request->validate([
            'budget'    => 'required|numeric|min:100000',
            'goal'      => 'required|string',
            'timeframe' => 'required|string',
        ]);

        $goldPrice = $this->getGoldPrice();
        $budget    = (float) $request->budget;
        $gram      = round($budget / $goldPrice, 4);

        if ($request->timeframe === 'short_term') {
            $recommendation = "Kurang Direkomendasikan — Emas kurang ideal untuk jangka pendek karena selisih harga jual/beli (spread). Namun jika tujuan utama adalah mengamankan nilai uang, emas tetap menjadi pilihan yang lebih aman dibanding menyimpan tunai.";
        } elseif ($request->timeframe === 'mid_term') {
            $recommendation = "Cukup Direkomendasikan — Emas adalah instrumen hedging yang solid untuk jangka menengah (1–3 tahun). Nilainya cenderung naik mengikuti inflasi dan fluktuasi ekonomi.";
        } else {
            $recommendation = "Sangat Direkomendasikan — Untuk jangka panjang (>3 tahun), emas adalah pilihan terbaik. Aset ini telah terbukti mempertahankan dan melipatgandakan nilai kekayaan selama puluhan tahun.";
        }

        if (auth()->check()) {
            \App\Models\ConsultationHistory::create([
                'user_id'    => auth()->id(),
                'type'       => 'beginner',
                'input_data' => $request->all(),
                'result'     => $recommendation,
            ]);
        }

        return view('consultation.result_beginner', [
            'budget'         => $budget,
            'gram'           => $gram,
            'goldPrice'      => $goldPrice,
            'recommendation' => $recommendation,
            'goal'           => $request->goal,
            'timeframe'      => $request->timeframe,
        ]);
    }

    // --- ALUR MENENGAH (CERTAINTY FACTOR) ---
    public function intermediateForm()
    {
        $questions = Question::where('type', 'intermediate')->with('expertRules')->get();
        return view('consultation.intermediate', compact('questions'));
    }

    public function intermediateProcess(Request $request)
    {
        $cfUserInput = $request->input('cf_user', []);
        $questions   = Question::where('type', 'intermediate')->with('expertRules')->get();

        if (count($cfUserInput) < $questions->count()) {
            return redirect()->back()->with('error', 'Mohon jawab semua pertanyaan sebelum melanjutkan.');
        }

        // Inisialisasi — nilai awal 0, flag pertama-kali
        $cfCombine = ['Beli' => 0.0, 'Tahan' => 0.0, 'Jual' => 0.0];
        $isFirst   = ['Beli' => true,  'Tahan' => true,  'Jual' => true];

        // Pilihan jawaban user: Tidak=-1, Kurang Yakin=-0.4, Cukup Yakin=0.2, Yakin=0.6, Sangat Yakin=1
        $validOptions = ['-1', '-0.4', '0.2', '0.6', '1'];

        foreach ($questions as $question) {
            $raw       = $cfUserInput[$question->id] ?? '0';
            $cfUser    = in_array($raw, $validOptions) ? (float)$raw : 0.0;

            foreach ($question->expertRules as $rule) {
                $hyp     = $rule->hypothesis; // 'Beli' | 'Tahan' | 'Jual'
                $cfPakar = (float) $rule->cf_pakar;

                // CF Rule (Hipotesis Evidence) = CF User × CF Pakar
                $cfRule = $cfUser * $cfPakar;

                if ($isFirst[$hyp]) {
                    $cfCombine[$hyp] = $cfRule;
                    $isFirst[$hyp]   = false;
                } else {
                    $cfCombine[$hyp] = $this->combine($cfCombine[$hyp], $cfRule);
                }
            }
        }

        // Konversi ke persentase untuk tampilan
        $results = [
            'Beli'  => round($cfCombine['Beli']  * 100, 2),
            'Tahan' => round($cfCombine['Tahan'] * 100, 2),
            'Jual'  => round($cfCombine['Jual']  * 100, 2),
        ];

        // Tentukan hipotesis tertinggi
        arsort($results);
        $topHypothesis = array_key_first($results);
        $topPercentage = $results[$topHypothesis];

        $explanations = [
            'Beli'  => "Berdasarkan analisis sistem pakar dengan metode Certainty Factor, profil investasi Anda sangat mendukung keputusan untuk <strong>MEMBELI</strong> emas saat ini. Anda memiliki toleransi risiko yang baik, tujuan jangka panjang yang jelas, dan pemahaman bahwa emas adalah instrumen perlindungan nilai terpercaya.",
            'Tahan' => "Sistem merekomendasikan untuk <strong>MENAHAN</strong> posisi saat ini. Jika Anda sudah memiliki emas, simpanlah dan tunggu momentum yang lebih baik. Jika belum, pertimbangkan kembali kondisi dana darurat dan tujuan finansial Anda sebelum mengambil keputusan.",
            'Jual'  => "Berdasarkan profil yang diberikan, sistem menyarankan untuk <strong>MENJUAL</strong> atau tidak menambah porsi emas saat ini. Anda sepertinya membutuhkan aset dengan likuiditas lebih tinggi atau return yang lebih konsisten dalam jangka pendek.",
        ];

        if (auth()->check()) {
            \App\Models\ConsultationHistory::create([
                'user_id'    => auth()->id(),
                'type'       => 'intermediate',
                'input_data' => $cfUserInput,
                'result'     => "Rekomendasi: {$topHypothesis} ({$topPercentage}%)",
            ]);
        }

        return view('consultation.result_intermediate', [
            'results'        => $results,
            'cfCombine'      => $cfCombine,
            'topHypothesis'  => $topHypothesis,
            'topPercentage'  => $topPercentage,
            'explanation'    => $explanations[$topHypothesis],
        ]);
    }
}
