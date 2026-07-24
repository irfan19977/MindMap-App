<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\PracticeQuestion;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class BahasaIndonesiaSdContentSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['title' => 'Mengenal Huruf dan Kata', 'objective' => 'Siswa mampu membedakan huruf vokal dan konsonan serta membaca kata sederhana.', 'intro' => 'Huruf adalah lambang bunyi. Ketika beberapa huruf disusun dengan benar, huruf-huruf itu membentuk kata yang bermakna.', 'concepts' => ['Huruf vokal terdiri dari a, i, u, e, dan o.', 'Huruf selain vokal disebut huruf konsonan.', 'Kata dapat dibaca dengan mengenali bunyi setiap suku kata.'], 'example' => 'Kata b-u-k-u dibaca buku. Kata itu memiliki dua suku kata, yaitu bu dan ku.', 'practice' => ['Pilih kata yang tersusun dari huruf b, u, k, dan u.', 'Tuliskan dua kata yang diawali huruf m.'], 'quiz' => ['question' => 'Manakah yang termasuk huruf vokal?', 'options' => ['a' => 'b', 'b' => 'i', 'c' => 'k', 'd' => 'm'], 'answer' => 'b', 'explanation' => 'Huruf i adalah salah satu huruf vokal.']],
            ['title' => 'Membaca Teks Sederhana', 'objective' => 'Siswa mampu membaca teks pendek dan menemukan informasi penting di dalamnya.', 'intro' => 'Membaca teks berarti memahami isi tulisan, bukan hanya menyuarakan kata-katanya.', 'concepts' => ['Bacalah teks dengan lancar dan teliti.', 'Perhatikan siapa, apa, di mana, dan kapan pada teks.', 'Jawaban harus sesuai dengan informasi dalam teks.'], 'example' => 'Dita pergi ke perpustakaan pada hari Sabtu. Ia meminjam buku cerita tentang Kancil. Tokoh dalam teks tersebut adalah Dita.', 'practice' => ['Bacalah teks: Roni menyiram bunga setiap pagi. Apa kegiatan Roni?', 'Tuliskan tempat yang kamu kunjungi untuk membaca banyak buku.'], 'quiz' => ['question' => 'Pada teks contoh, buku cerita yang dipinjam Dita bercerita tentang apa?', 'options' => ['a' => 'Kancil', 'b' => 'Pesawat', 'c' => 'Laut', 'd' => 'Sepeda'], 'answer' => 'a', 'explanation' => 'Teks menyebutkan bahwa Dita meminjam buku cerita tentang Kancil.']],
            ['title' => 'Menulis Kalimat Dasar', 'objective' => 'Siswa mampu menyusun kata menjadi kalimat sederhana yang benar.', 'intro' => 'Kalimat adalah kumpulan kata yang menyampaikan pikiran secara lengkap.', 'concepts' => ['Kalimat diawali dengan huruf kapital.', 'Kalimat berita diakhiri tanda titik.', 'Susun kata agar maknanya jelas dan mudah dipahami.'], 'example' => 'Kata adik, bermain, dan bola dapat disusun menjadi kalimat: Adik bermain bola.', 'practice' => ['Susun kata berikut menjadi kalimat: sekolah - ke - Siti - pergi.', 'Buat satu kalimat tentang kegiatanmu pada pagi hari.'], 'quiz' => ['question' => 'Kalimat manakah yang ditulis dengan benar?', 'options' => ['a' => 'adik bermain bola', 'b' => 'Adik bermain bola.', 'c' => 'adik Bermain bola.', 'd' => 'Adik bermain bola'], 'answer' => 'b', 'explanation' => 'Kalimat yang benar diawali huruf kapital dan diakhiri tanda titik.']],
            ['title' => 'Pemahaman Cerita Rakyat', 'objective' => 'Siswa mampu mengenali tokoh, latar, dan pesan baik dalam cerita rakyat Indonesia.', 'intro' => 'Cerita rakyat adalah cerita yang diwariskan dari generasi ke generasi di berbagai daerah Indonesia.', 'concepts' => ['Tokoh adalah pelaku dalam cerita.', 'Latar menunjukkan tempat atau waktu kejadian.', 'Pesan cerita adalah pelajaran baik yang dapat kita teladani.'], 'example' => 'Dalam cerita Malin Kundang, pesan yang dapat diambil adalah kita harus menghormati dan menyayangi orang tua.', 'practice' => ['Sebutkan satu cerita rakyat dari daerahmu.', 'Apa pesan baik yang kamu peroleh dari cerita Malin Kundang?'], 'quiz' => ['question' => 'Pesan yang tepat dari cerita Malin Kundang adalah ...', 'options' => ['a' => 'Boleh melupakan keluarga', 'b' => 'Harus menghormati orang tua', 'c' => 'Harus hidup sendiri', 'd' => 'Tidak perlu berkata jujur'], 'answer' => 'b', 'explanation' => 'Cerita Malin Kundang mengajarkan pentingnya menghormati orang tua.']],
            ['title' => 'Puisi Anak', 'objective' => 'Siswa mampu mengenali ciri puisi anak dan menulis puisi pendek.', 'intro' => 'Puisi anak menggunakan kata-kata sederhana untuk menyampaikan perasaan atau gambaran tentang sesuatu.', 'concepts' => ['Puisi terdiri atas baris dan bait.', 'Pilihan kata dalam puisi dapat menimbulkan keindahan.', 'Puisi dapat bertema keluarga, sekolah, alam, atau sahabat.'], 'example' => 'Pagi cerah di halaman / Burung bernyanyi riang / Aku berangkat ke sekolah / Dengan hati senang.', 'practice' => ['Tuliskan dua baris puisi tentang hujan.', 'Sebutkan tema puisi yang kamu sukai.'], 'quiz' => ['question' => 'Bagian puisi yang terdiri atas beberapa baris disebut ...', 'options' => ['a' => 'Bait', 'b' => 'Judul', 'c' => 'Tokoh', 'd' => 'Latar'], 'answer' => 'a', 'explanation' => 'Beberapa baris puisi yang tersusun bersama disebut bait.']],
            ['title' => 'Pantun dan Syair', 'objective' => 'Siswa mampu membedakan pantun dan syair sederhana.', 'intro' => 'Pantun dan syair adalah puisi lama yang dikenal dalam kebudayaan Indonesia.', 'concepts' => ['Pantun umumnya terdiri dari empat baris.', 'Baris pertama dan kedua pantun disebut sampiran.', 'Syair memiliki isi pada setiap baris dan berima sama.'], 'example' => 'Pergi pagi membawa bekal / Bekal disimpan dalam kotak / Rajin belajar sejak kecil / Agar cita-cita mudah didapat.', 'practice' => ['Buat satu pantun nasihat empat baris.', 'Tuliskan satu nasihat yang terdapat dalam pantunmu.'], 'quiz' => ['question' => 'Pantun pada umumnya terdiri dari ... baris.', 'options' => ['a' => 'Dua', 'b' => 'Tiga', 'c' => 'Empat', 'd' => 'Enam'], 'answer' => 'c', 'explanation' => 'Ciri umum pantun adalah terdiri dari empat baris.']],
            ['title' => 'Kosakata Dasar', 'objective' => 'Siswa mampu memahami arti kata dan menggunakan kosakata sesuai konteks.', 'intro' => 'Kosakata adalah kumpulan kata yang kita pahami dan gunakan saat berbicara, membaca, serta menulis.', 'concepts' => ['Arti kata dapat dicari dari kalimatnya.', 'Kata baru dapat dipelajari melalui bacaan.', 'Gunakan kata yang sopan dan sesuai situasi.'], 'example' => 'Kata hemat berarti menggunakan sesuatu dengan tidak berlebihan. Kita perlu hemat air saat mandi.', 'practice' => ['Apa arti kata hemat?', 'Buat kalimat menggunakan kata bersih.'], 'quiz' => ['question' => 'Arti kata hemat adalah ...', 'options' => ['a' => 'Menggunakan berlebihan', 'b' => 'Menggunakan dengan tidak berlebihan', 'c' => 'Membuang semua barang', 'd' => 'Tidak melakukan apa-apa'], 'answer' => 'b', 'explanation' => 'Hemat berarti menggunakan sesuatu secara tidak berlebihan.']],
            ['title' => 'Tanda Baca', 'objective' => 'Siswa mampu menggunakan tanda titik, tanda tanya, dan tanda seru dengan tepat.', 'intro' => 'Tanda baca membantu pembaca memahami maksud sebuah kalimat.', 'concepts' => ['Tanda titik digunakan pada akhir kalimat berita.', 'Tanda tanya digunakan pada akhir kalimat tanya.', 'Tanda seru digunakan pada kalimat perintah atau seruan.'], 'example' => 'Ibu memasak sayur. Siapa yang datang? Wah, indah sekali!', 'practice' => ['Tambahkan tanda baca yang tepat: Siapa nama gurumu', 'Tambahkan tanda baca yang tepat: Tolong rapikan meja itu'], 'quiz' => ['question' => 'Tanda baca yang tepat untuk akhir kalimat tanya adalah ...', 'options' => ['a' => '.', 'b' => ',', 'c' => '?', 'd' => '!'], 'answer' => 'c', 'explanation' => 'Kalimat tanya selalu diakhiri dengan tanda tanya.']],
            ['title' => 'Membacakan Loud Reading', 'objective' => 'Siswa mampu membaca nyaring dengan lafal, intonasi, dan volume suara yang tepat.', 'intro' => 'Membaca nyaring adalah membaca dengan suara yang dapat didengar orang lain dengan jelas.', 'concepts' => ['Lafal adalah cara mengucapkan kata dengan benar.', 'Intonasi adalah naik turunnya suara saat membaca.', 'Volume suara harus cukup terdengar tanpa berteriak.'], 'example' => 'Saat membaca kalimat tanya, suara pada akhir kalimat biasanya naik: “Kapan kita berangkat?”', 'practice' => ['Bacakan kalimat: Aku senang belajar Bahasa Indonesia.', 'Jelaskan mengapa kita perlu membaca dengan lafal yang jelas.'], 'quiz' => ['question' => 'Saat membaca nyaring, kita perlu memperhatikan ...', 'options' => ['a' => 'Lafal dan intonasi', 'b' => 'Warna buku saja', 'c' => 'Ukuran meja', 'd' => 'Jumlah halaman saja'], 'answer' => 'a', 'explanation' => 'Lafal dan intonasi membantu pendengar memahami bacaan.']],
            ['title' => 'Menulis Surat Sederhana', 'objective' => 'Siswa mampu menulis surat pribadi sederhana dengan bagian yang lengkap.', 'intro' => 'Surat pribadi adalah tulisan untuk menyampaikan kabar atau pesan kepada orang yang kita kenal.', 'concepts' => ['Surat memiliki tempat dan tanggal penulisan.', 'Surat diawali salam pembuka dan diakhiri salam penutup.', 'Isi surat disampaikan dengan bahasa yang santun.'], 'example' => 'Bandung, 20 Juli 2026. Sahabatku Rani, apa kabar? Aku mengajakmu bermain pada hari Minggu. Salam, Sinta.', 'practice' => ['Tuliskan salam pembuka untuk surat kepada temanmu.', 'Buat dua kalimat isi surat untuk mengajak teman belajar bersama.'], 'quiz' => ['question' => 'Bagian yang tepat untuk mengawali surat pribadi adalah ...', 'options' => ['a' => 'Salam pembuka', 'b' => 'Daftar isi', 'c' => 'Daftar pustaka', 'd' => 'Judul berita'], 'answer' => 'a', 'explanation' => 'Surat pribadi diawali dengan salam pembuka yang sopan.']],
        ];

        foreach ($materials as $data) {
            $material = Material::where('title', $data['title'])->first();

            if (! $material) {
                continue;
            }

            $content = [
                ['type' => 'heading', 'content' => $data['title']],
                ['type' => 'paragraph', 'content' => $data['intro']],
                ['type' => 'heading', 'content' => 'Hal Penting'],
                ['type' => 'list', 'content' => $data['concepts']],
                ['type' => 'heading', 'content' => 'Contoh'],
                ['type' => 'paragraph', 'content' => $data['example']],
            ];

            $material->update([
                'learning_objectives' => $data['objective'],
                'content' => json_encode($content),
                'latihan_data' => [
                    ['question' => $data['practice'][0], 'type' => 'essay', 'points' => 10],
                    ['question' => $data['practice'][1], 'type' => 'essay', 'points' => 10],
                ],
            ]);

            $material->practiceQuestions()->delete();
            foreach ($data['practice'] as $index => $question) {
                PracticeQuestion::create([
                    'material_id' => $material->id,
                    'question' => $question,
                    'question_type' => 'essay',
                    'correct_answer' => 'Jawaban disesuaikan dengan materi dan contoh yang dipelajari.',
                    'explanation' => 'Periksa jawaban berdasarkan pembahasan pada materi.',
                    'points' => 10,
                    'order_number' => $index + 1,
                ]);
            }

            $quiz = Quiz::updateOrCreate(
                ['material_id' => $material->id],
                [
                    'title' => 'Quiz ' . $data['title'],
                    'description' => 'Evaluasi pemahaman materi ' . $data['title'] . ' untuk siswa SD.',
                    'time_limit' => 10,
                    'passing_score' => 70,
                    'status' => 'publish',
                ]
            );

            $quiz->quizQuestions()->delete();
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $data['quiz']['question'],
                'options' => $data['quiz']['options'],
                'correct_answer' => $data['quiz']['answer'],
                'explanation' => $data['quiz']['explanation'],
                'points' => 10,
                'order_number' => 1,
            ]);
        }
    }
}
