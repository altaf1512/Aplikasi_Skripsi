<?php

namespace Database\Seeders;

use App\Models\ExpertRule;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'code' => 'Q01',
                'text' => 'Apakah Anda mengharapkan keuntungan yang tinggi dalam waktu dekat (kurang dari 1 tahun)?',
                'rules' => ['Beli' => 0.2, 'Tahan' => 0.4, 'Jual' => 0.8]
            ],
            [
                'code' => 'Q02',
                'text' => 'Apakah Anda siap (tidak panik) jika harga investasi Anda turun sementara dalam jangka pendek?',
                'rules' => ['Beli' => 0.8, 'Tahan' => 0.6, 'Jual' => 0.2]
            ],
            [
                'code' => 'Q03',
                'text' => 'Apakah tujuan utama Anda berinvestasi adalah untuk melindungi nilai uang dari inflasi?',
                'rules' => ['Beli' => 0.9, 'Tahan' => 0.5, 'Jual' => 0.1]
            ],
            [
                'code' => 'Q04',
                'text' => 'Apakah Anda memiliki dana darurat yang cukup dan terpisah dari dana investasi ini?',
                'rules' => ['Beli' => 0.8, 'Tahan' => 0.7, 'Jual' => 0.3]
            ],
            [
                'code' => 'Q05',
                'text' => 'Apakah Anda membutuhkan investasi dengan likuiditas tinggi (sangat mudah dan cepat dicairkan tanpa kerugian besar)?',
                'rules' => ['Beli' => 0.5, 'Tahan' => 0.4, 'Jual' => 0.8] // Spread buy/sell emas lumayan
            ],
            [
                'code' => 'Q06',
                'text' => 'Apakah Anda percaya bahwa kondisi ekonomi global saat ini sedang tidak stabil?',
                'rules' => ['Beli' => 0.9, 'Tahan' => 0.6, 'Jual' => 0.2]
            ],
            [
                'code' => 'Q07',
                'text' => 'Apakah Anda mencari jenis investasi yang mudah diwariskan ke generasi selanjutnya secara fisik?',
                'rules' => ['Beli' => 1.0, 'Tahan' => 0.8, 'Jual' => 0.1]
            ],
            [
                'code' => 'Q08',
                'text' => 'Apakah Anda berencana untuk rutin menambah jumlah investasi (nabung rutin) setiap bulannya?',
                'rules' => ['Beli' => 0.9, 'Tahan' => 0.8, 'Jual' => 0.2]
            ],
            [
                'code' => 'Q09',
                'text' => 'Apakah Anda merasa khawatir dengan tingginya fluktuasi (naik-turun) harga saham dan kripto saat ini?',
                'rules' => ['Beli' => 0.8, 'Tahan' => 0.5, 'Jual' => 0.2]
            ],
            [
                'code' => 'Q10',
                'text' => 'Apakah Anda membutuhkan hasil imbalan rutin (seperti dividen atau bunga bulanan) dari investasi Anda?',
                'rules' => ['Beli' => 0.1, 'Tahan' => 0.2, 'Jual' => 0.9]
            ],
            [
                'code' => 'Q11',
                'text' => 'Apakah Anda cenderung panik dan ingin segera menjual aset saat melihat harganya sedang turun (merah)?',
                'rules' => ['Beli' => 0.2, 'Tahan' => 0.4, 'Jual' => 0.8]
            ],
            [
                'code' => 'Q12',
                'text' => 'Apakah Anda menganggap emas lebih sebagai tabungan perlindungan nilai jangka panjang daripada alat untuk trading aktif?',
                'rules' => ['Beli' => 0.9, 'Tahan' => 0.8, 'Jual' => 0.1]
            ],
        ];

        User::factory()->create([
            'name' => 'Admin SkripsiCare',
            'email' => 'admin@skripsicare.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'User SkripsiCare',
            'email' => 'user@skripsicare.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        foreach ($questions as $qData) {
            $question = Question::create([
                'code' => $qData['code'],
                'type' => 'intermediate',
                'text' => $qData['text'],
            ]);

            foreach ($qData['rules'] as $hypothesis => $cfPakar) {
                ExpertRule::create([
                    'question_id' => $question->id,
                    'hypothesis'  => $hypothesis,
                    'cf_pakar'    => $cfPakar,
                ]);
            }
        }
    }
}
