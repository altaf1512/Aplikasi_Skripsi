<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    // Harga emas statis sesuai permintaan user
    private $goldPrice = 1500000;

    public function index()
    {
        return view('home');
    }

    // --- ALUR PEMULA ---
    public function beginnerForm()
    {
        return view('consultation.beginner');
    }

    public function beginnerProcess(Request $request)
    {
        $request->validate([
            'budget' => 'required|numeric|min:100000',
            'goal' => 'required|string',
            'timeframe' => 'required|string',
        ]);

        $budget = $request->budget;
        $gram = $budget / $this->goldPrice;
        
        $recommendation = "Beli Emas";
        if ($request->timeframe == 'short_term') {
            $recommendation = "Emas kurang direkomendasikan untuk jangka pendek (kurang dari 1 tahun) karena adanya selisih harga jual dan beli (spread). Namun jika untuk mengamankan uang, Anda tetap bisa membeli emas.";
        } else {
            $recommendation = "Sangat direkomendasikan untuk membeli emas sebagai perlindungan nilai uang Anda dalam jangka menengah hingga panjang.";
        }

        return view('consultation.result_beginner', [
            'budget' => $budget,
            'gram' => round($gram, 2),
            'goldPrice' => $this->goldPrice,
            'recommendation' => $recommendation,
            'goal' => $request->goal,
            'timeframe' => $request->timeframe,
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
        // $request->cf_user array dengan format: ['question_id' => cf_user_value]
        $cfUserInput = $request->input('cf_user', []);
        
        if (count($cfUserInput) < 12) {
            return redirect()->back()->with('error', 'Mohon jawab semua pertanyaan.');
        }

        $questions = Question::where('type', 'intermediate')->with('expertRules')->get();
        
        // Inisialisasi perhitungan
        $cfCombine = [
            'Beli' => 0,
            'Tahan' => 0,
            'Jual' => 0,
        ];

        $firstRule = [
            'Beli' => true,
            'Tahan' => true,
            'Jual' => true,
        ];

        foreach ($questions as $question) {
            $userCfValue = isset($cfUserInput[$question->id]) ? floatval($cfUserInput[$question->id]) : 0;
            
            foreach ($question->expertRules as $rule) {
                $hypothesis = $rule->hypothesis;
                $pakarCfValue = $rule->cf_pakar;
                
                // Hitung CF Rule (HE) = CF User * CF Pakar
                $cfRule = $userCfValue * $pakarCfValue;

                // Hitung CF Combine
                if ($firstRule[$hypothesis]) {
                    $cfCombine[$hypothesis] = $cfRule;
                    $firstRule[$hypothesis] = false;
                } else {
                    $cfOld = $cfCombine[$hypothesis];
                    if ($cfOld >= 0 && $cfRule >= 0) {
                        $cfCombine[$hypothesis] = $cfOld + $cfRule * (1 - $cfOld);
                    } elseif ($cfOld < 0 && $cfRule < 0) {
                        $cfCombine[$hypothesis] = $cfOld + $cfRule * (1 + $cfOld);
                    } else {
                        $denominator = 1 - min(abs($cfOld), abs($cfRule));
                        $cfCombine[$hypothesis] = $denominator > 0 ? ($cfOld + $cfRule) / $denominator : 0;
                    }
                }
            }
        }

        // Ubah ke persentase
        $results = [
            'Beli' => round($cfCombine['Beli'] * 100, 2),
            'Tahan' => round($cfCombine['Tahan'] * 100, 2),
            'Jual' => round($cfCombine['Jual'] * 100, 2),
        ];

        // Tentukan hasil tertinggi
        arsort($results);
        $topHypothesis = array_key_first($results);
        $topPercentage = $results[$topHypothesis];

        $explanation = "";
        switch ($topHypothesis) {
            case 'Beli':
                $explanation = "Berdasarkan analisis sistem pakar, Anda sangat disarankan untuk MEMBELI emas saat ini. Kondisi finansial dan psikologis Anda sangat mendukung untuk investasi aset safe haven.";
                break;
            case 'Tahan':
                $explanation = "Rekomendasi saat ini adalah menahan (HOLD). Jika Anda sudah memiliki emas, simpanlah. Jika belum, mungkin ini bukan momen yang paling krusial untuk memaksakan membeli, pertimbangkan kondisi dana darurat Anda.";
                break;
            case 'Jual':
                $explanation = "Sistem merekomendasikan Anda untuk MENJUAL atau tidak berinvestasi emas saat ini. Anda sepertinya membutuhkan likuiditas tinggi atau mengharapkan return jangka pendek yang tidak bisa diberikan oleh emas.";
                break;
        }

        return view('consultation.result_intermediate', compact('results', 'topHypothesis', 'topPercentage', 'explanation'));
    }
}
