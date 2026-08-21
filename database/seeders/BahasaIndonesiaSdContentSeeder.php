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
            ['title' => 'Mengenal Huruf dan Kata', 'objective' => 'Siswa mampu membedakan huruf vokal dan konsonan serta membaca kata sederhana.', 'intro' => 'Huruf adalah lambang bunyi. Ketika beberapa huruf disusun dengan benar, huruf-huruf itu membentuk kata yang bermakna.', 'concepts' => ['Huruf vokal terdiri dari a, i, u, e, dan o.', 'Huruf selain vokal disebut huruf konsonan.', 'Kata dapat dibaca dengan mengenali bunyi setiap suku kata.'], 'example' => 'Kata b-u-k-u dibaca buku. Kata itu memiliki dua suku kata, yaitu bu dan ku.', 'practice' => ['Pilih kata yang tersusun dari huruf b, u, k, dan u.', 'Tuliskan dua kata yang diawali huruf m.'], 'quizzes' => [
                ['question' => 'Manakah yang termasuk huruf vokal?', 'options' => ['a' => 'b', 'b' => 'i', 'c' => 'k', 'd' => 'm'], 'answer' => 'b', 'explanation' => 'Huruf i adalah salah satu huruf vokal.'],
                ['question' => 'Berapa jumlah huruf vokal dalam bahasa Indonesia?', 'options' => ['a' => '3', 'b' => '4', 'c' => '5', 'd' => '6'], 'answer' => 'c', 'explanation' => 'Huruf vokal dalam bahasa Indonesia terdiri dari a, i, u, e, dan o, total 5 huruf.'],
                ['question' => 'Huruf manakah yang termasuk konsonan?', 'options' => ['a' => 'a', 'b' => 'i', 'c' => 'u', 'd' => 'b'], 'answer' => 'd', 'explanation' => 'Huruf b adalah huruf konsonan, bukan vokal.'],
                ['question' => 'Suku kata dalam kata "meja" adalah...', 'options' => ['a' => 'me-ja', 'b' => 'mej-a', 'c' => 'm-eja', 'd' => 'me-j-a'], 'answer' => 'a', 'explanation' => 'Kata meja memiliki dua suku kata: me dan ja.'],
                ['question' => 'Kata "buku" memiliki berapa suku kata?', 'options' => ['a' => '1', 'b' => '2', 'c' => '3', 'd' => '4'], 'answer' => 'b', 'explanation' => 'Kata buku memiliki dua suku kata: bu dan ku.']
            ]],
            ['title' => 'Membaca Teks Sederhana', 'objective' => 'Siswa mampu membaca teks pendek dan menemukan informasi penting di dalamnya.', 'intro' => 'Membaca teks berarti memahami isi tulisan, bukan hanya menyuarakan kata-katanya.', 'concepts' => ['Bacalah teks dengan lancar dan teliti.', 'Perhatikan siapa, apa, di mana, dan kapan pada teks.', 'Jawaban harus sesuai dengan informasi dalam teks.'], 'example' => 'Dita pergi ke perpustakaan pada hari Sabtu. Ia meminjam buku cerita tentang Kancil. Tokoh dalam teks tersebut adalah Dita.', 'practice' => ['Bacalah teks: Roni menyiram bunga setiap pagi. Apa kegiatan Roni?', 'Tuliskan tempat yang kamu kunjungi untuk membaca banyak buku.'], 'quizzes' => [
                ['question' => 'Pada teks contoh, buku cerita yang dipinjam Dita bercerita tentang apa?', 'options' => ['a' => 'Kancil', 'b' => 'Pesawat', 'c' => 'Laut', 'd' => 'Sepeda'], 'answer' => 'a', 'explanation' => 'Teks menyebutkan bahwa Dita meminjam buku cerita tentang Kancil.'],
                ['question' => 'Kapan Dita pergi ke perpustakaan?', 'options' => ['a' => 'Hari Jumat', 'b' => 'Hari Sabtu', 'c' => 'Hari Minggu', 'd' => 'Hari Senin'], 'answer' => 'b', 'explanation' => 'Teks menyebutkan Dita pergi ke perpustakaan pada hari Sabtu.'],
                ['question' => 'Siapa tokoh dalam teks contoh?', 'options' => ['a' => 'Kancil', 'b' => 'Dita', 'c' => 'Roni', 'd' => 'Budi'], 'answer' => 'b', 'explanation' => 'Tokoh dalam teks tersebut adalah Dita.'],
                ['question' => 'Apa yang dilakukan Dita di perpustakaan?', 'options' => ['a' => 'Membeli buku', 'b' => 'Meminjam buku', 'c' => 'Menjual buku', 'd' => 'Membaca buku'], 'answer' => 'b', 'explanation' => 'Dita meminjam buku cerita di perpustakaan.'],
                ['question' => 'Tempat untuk membaca banyak buku disebut...', 'options' => ['a' => 'Toko', 'b' => 'Sekolah', 'c' => 'Perpustakaan', 'd' => 'Rumah'], 'answer' => 'c', 'explanation' => 'Perpustakaan adalah tempat untuk membaca dan meminjam banyak buku.']
            ]],
            ['title' => 'Menulis Kalimat Dasar', 'objective' => 'Siswa mampu menyusun kata menjadi kalimat sederhana yang benar.', 'intro' => 'Kalimat adalah kumpulan kata yang menyampaikan pikiran secara lengkap.', 'concepts' => ['Kalimat diawali dengan huruf kapital.', 'Kalimat berita diakhiri tanda titik.', 'Susun kata agar maknanya jelas dan mudah dipahami.'], 'example' => 'Kata adik, bermain, dan bola dapat disusun menjadi kalimat: Adik bermain bola.', 'practice' => ['Susun kata berikut menjadi kalimat: sekolah - ke - Siti - pergi.', 'Buat satu kalimat tentang kegiatanmu pada pagi hari.'], 'quizzes' => [
                ['question' => 'Kalimat manakah yang ditulis dengan benar?', 'options' => ['a' => 'adik bermain bola', 'b' => 'Adik bermain bola.', 'c' => 'adik Bermain bola.', 'd' => 'Adik bermain bola'], 'answer' => 'b', 'explanation' => 'Kalimat yang benar diawali huruf kapital dan diakhiri tanda titik.'],
                ['question' => 'Kalimat berita diakhiri dengan tanda...', 'options' => ['a' => 'Tanda tanya', 'b' => 'Tanda seru', 'c' => 'Tanda titik', 'd' => 'Tanda koma'], 'answer' => 'c', 'explanation' => 'Kalimat berita diakhiri dengan tanda titik.'],
                ['question' => 'Kalimat yang benar dari kata "Siti pergi ke sekolah" adalah...', 'options' => ['a' => 'Siti pergi ke sekolah', 'b' => 'siti pergi ke sekolah.', 'c' => 'Siti pergi ke sekolah.', 'd' => 'Siti Pergi ke sekolah.'], 'answer' => 'c', 'explanation' => 'Kalimat yang benar diawali huruf kapital dan diakhiri tanda titik.'],
                ['question' => 'Huruf pertama dalam kalimat harus...', 'options' => ['a' => 'Huruf kecil', 'b' => 'Huruf kapital', 'c' => 'Huruf tebal', 'd' => 'Huruf miring'], 'answer' => 'b', 'explanation' => 'Kalimat harus diawali dengan huruf kapital.'],
                ['question' => 'Kata "bola, bermain, adik" disusun menjadi kalimat yang benar adalah...', 'options' => ['a' => 'Bola bermain adik', 'b' => 'Adik bola bermain', 'c' => 'Adik bermain bola', 'd' => 'Bermain adik bola'], 'answer' => 'c', 'explanation' => 'Susunan kata yang benar adalah Adik bermain bola.']
            ]],
            ['title' => 'Pemahaman Cerita Rakyat', 'objective' => 'Siswa mampu mengenali tokoh, latar, dan pesan baik dalam cerita rakyat Indonesia.', 'intro' => 'Cerita rakyat adalah cerita yang diwariskan dari generasi ke generasi di berbagai daerah Indonesia.', 'concepts' => ['Tokoh adalah pelaku dalam cerita.', 'Latar menunjukkan tempat atau waktu kejadian.', 'Pesan cerita adalah pelajaran baik yang dapat kita teladani.'], 'example' => 'Dalam cerita Malin Kundang, pesan yang dapat diambil adalah kita harus menghormati dan menyayangi orang tua.', 'practice' => ['Sebutkan satu cerita rakyat dari daerahmu.', 'Apa pesan baik yang kamu peroleh dari cerita Malin Kundang?'], 'quizzes' => [
                ['question' => 'Pesan yang tepat dari cerita Malin Kundang adalah ...', 'options' => ['a' => 'Boleh melupakan keluarga', 'b' => 'Harus menghormati orang tua', 'c' => 'Harus hidup sendiri', 'd' => 'Tidak perlu berkata jujur'], 'answer' => 'b', 'explanation' => 'Cerita Malin Kundang mengajarkan pentingnya menghormati orang tua.'],
                ['question' => 'Tokoh dalam cerita disebut...', 'options' => ['a' => 'Pelaku', 'b' => 'Penonton', 'c' => 'Pembaca', 'd' => 'Penulis'], 'answer' => 'a', 'explanation' => 'Tokoh adalah pelaku dalam cerita.'],
                ['question' => 'Latar dalam cerita menunjukkan...', 'options' => ['a' => 'Tempat atau waktu kejadian', 'b' => 'Jumlah tokoh', 'c' => 'Panjang cerita', 'd' => 'Judul cerita'], 'answer' => 'a', 'explanation' => 'Latar menunjukkan tempat atau waktu kejadian dalam cerita.'],
                ['question' => 'Pesan cerita disebut juga...', 'options' => ['a' => 'Amanat', 'b' => 'Tokoh', 'c' => 'Latar', 'd' => 'Alur'], 'answer' => 'a', 'explanation' => 'Pesan cerita juga disebut amanat.'],
                ['question' => 'Cerita rakyat biasanya berasal dari...', 'options' => ['a' => 'Luar negeri', 'b' => 'Daerah di Indonesia', 'c' => 'Dunia hewan', 'd' => 'Dunia dongeng'], 'answer' => 'b', 'explanation' => 'Cerita rakyat biasanya berasal dari berbagai daerah di Indonesia.']
            ]],
            ['title' => 'Puisi Anak', 'objective' => 'Siswa mampu mengenali ciri puisi anak dan menulis puisi pendek.', 'intro' => 'Puisi anak menggunakan kata-kata sederhana untuk menyampaikan perasaan atau gambaran tentang sesuatu.', 'concepts' => ['Puisi terdiri atas baris dan bait.', 'Pilihan kata dalam puisi dapat menimbulkan keindahan.', 'Puisi dapat bertema keluarga, sekolah, alam, atau sahabat.'], 'example' => 'Pagi cerah di halaman / Burung bernyanyi riang / Aku berangkat ke sekolah / Dengan hati senang.', 'practice' => ['Tuliskan dua baris puisi tentang hujan.', 'Sebutkan tema puisi yang kamu sukai.'], 'quizzes' => [
                ['question' => 'Bagian puisi yang terdiri atas beberapa baris disebut ...', 'options' => ['a' => 'Bait', 'b' => 'Judul', 'c' => 'Tokoh', 'd' => 'Latar'], 'answer' => 'a', 'explanation' => 'Beberapa baris puisi yang tersusun bersama disebut bait.'],
                ['question' => 'Satu baris dalam puisi disebut...', 'options' => ['a' => 'Bait', 'b' => 'Baris', 'c' => 'Stanza', 'd' => 'Paragraf'], 'answer' => 'b', 'explanation' => 'Satu baris dalam puisi disebut baris.'],
                ['question' => 'Puisi anak biasanya menggunakan kata-kata yang...', 'options' => ['a' => 'Sulit dipahami', 'b' => 'Sederhana', 'c' => 'Asing', 'd' => 'Panjang'], 'answer' => 'b', 'explanation' => 'Puisi anak menggunakan kata-kata sederhana yang mudah dipahami.'],
                ['question' => 'Tema puisi dapat berupa...', 'options' => ['a' => 'Keluarga saja', 'b' => 'Sekolah saja', 'c' => 'Alam saja', 'd' => 'Keluarga, sekolah, alam, atau sahabat'], 'answer' => 'd', 'explanation' => 'Puisi dapat bertema keluarga, sekolah, alam, atau sahabat.'],
                ['question' => 'Puisi bertujuan untuk menyampaikan...', 'options' => ['a' => 'Perasaan atau gambaran', 'b' => 'Cerita panjang', 'c' => 'Laporan resmi', 'd' => 'Data statistik'], 'answer' => 'a', 'explanation' => 'Puisi bertujuan menyampaikan perasaan atau gambaran tentang sesuatu.']
            ]],
            ['title' => 'Pantun dan Syair', 'objective' => 'Siswa mampu membedakan pantun dan syair sederhana.', 'intro' => 'Pantun dan syair adalah puisi lama yang dikenal dalam kebudayaan Indonesia.', 'concepts' => ['Pantun umumnya terdiri dari empat baris.', 'Baris pertama dan kedua pantun disebut sampiran.', 'Syair memiliki isi pada setiap baris dan berima sama.'], 'example' => 'Pergi pagi membawa bekal / Bekal disimpan dalam kotak / Rajin belajar sejak kecil / Agar cita-cita mudah didapat.', 'practice' => ['Buat satu pantun nasihat empat baris.', 'Tuliskan satu nasihat yang terdapat dalam pantunmu.'], 'quizzes' => [
                ['question' => 'Pantun pada umumnya terdiri dari ... baris.', 'options' => ['a' => 'Dua', 'b' => 'Tiga', 'c' => 'Empat', 'd' => 'Enam'], 'answer' => 'c', 'explanation' => 'Ciri umum pantun adalah terdiri dari empat baris.'],
                ['question' => 'Baris pertama dan kedua pantun disebut...', 'options' => ['a' => 'Isi', 'b' => 'Sampiran', 'c' => 'Judul', 'd' => 'Penutup'], 'answer' => 'b', 'explanation' => 'Baris pertama dan kedua pantun disebut sampiran.'],
                ['question' => 'Syair memiliki ciri khas yaitu...', 'options' => ['a' => 'Baris berbeda rima', 'b' => 'Setiap baris berima sama', 'c' => 'Hanya dua baris', 'd' => 'Tidak berima'], 'answer' => 'b', 'explanation' => 'Syair memiliki isi pada setiap baris dan berima sama.'],
                ['question' => 'Pantun dan syair adalah jenis...', 'options' => ['a' => 'Cerita fiksi', 'b' => 'Puisi lama', 'c' => 'Laporan resmi', 'd' => 'Artikel berita'], 'answer' => 'b', 'explanation' => 'Pantun dan syair adalah puisi lama dalam kebudayaan Indonesia.'],
                ['question' => 'Pantun nasihat berisi...', 'options' => ['a' => 'Lelucon', 'b' => 'Nasihat atau pelajaran', 'c' => 'Cerita fiksi', 'd' => 'Berita terkini'], 'answer' => 'b', 'explanation' => 'Pantun nasihat berisi nasihat atau pelajaran hidup.']
            ]],
            ['title' => 'Kosakata Dasar', 'objective' => 'Siswa mampu memahami arti kata dan menggunakan kosakata sesuai konteks.', 'intro' => 'Kosakata adalah kumpulan kata yang kita pahami dan gunakan saat berbicara, membaca, serta menulis.', 'concepts' => ['Arti kata dapat dicari dari kalimatnya.', 'Kata baru dapat dipelajari melalui bacaan.', 'Gunakan kata yang sopan dan sesuai situasi.'], 'example' => 'Kata hemat berarti menggunakan sesuatu dengan tidak berlebihan. Kita perlu hemat air saat mandi.', 'practice' => ['Apa arti kata hemat?', 'Buat kalimat menggunakan kata bersih.'], 'quizzes' => [
                ['question' => 'Arti kata hemat adalah ...', 'options' => ['a' => 'Menggunakan berlebihan', 'b' => 'Menggunakan dengan tidak berlebihan', 'c' => 'Membuang semua barang', 'd' => 'Tidak melakukan apa-apa'], 'answer' => 'b', 'explanation' => 'Hemat berarti menggunakan sesuatu secara tidak berlebihan.'],
                ['question' => 'Kita dapat mempelajari kata baru melalui...', 'options' => ['a' => 'Tidur', 'b' => 'Bacaan', 'c' => 'Bermain game', 'd' => 'Menonton TV saja'], 'answer' => 'b', 'explanation' => 'Kata baru dapat dipelajari melalui bacaan.'],
                ['question' => 'Kata yang sopan digunakan dalam situasi...', 'options' => ['a' => 'Semua situasi', 'b' => 'Situasi tertentu saja', 'c' => 'Situasi tidak resmi', 'd' => 'Situasi marah'], 'answer' => 'a', 'explanation' => 'Kata yang sopan sebaiknya digunakan dalam semua situasi.'],
                ['question' => 'Arti kata dapat dicari dari...', 'options' => ['a' => 'Warna kata', 'b' => 'Kalimatnya', 'c' => 'Panjang kata', 'd' => 'Jumlah huruf'], 'answer' => 'b', 'explanation' => 'Arti kata dapat dicari dari konteks kalimatnya.'],
                ['question' => 'Kosakata adalah kumpulan kata yang...', 'options' => ['a' => 'Kita pahami dan gunakan', 'b' => 'Kita lupakan', 'c' => 'Kita hindari', 'd' => 'Kita benci'], 'answer' => 'a', 'explanation' => 'Kosakata adalah kumpulan kata yang kita pahami dan gunakan dalam komunikasi.']
            ]],
            ['title' => 'Tanda Baca', 'objective' => 'Siswa mampu menggunakan tanda titik, tanda tanya, dan tanda seru dengan tepat.', 'intro' => 'Tanda baca membantu pembaca memahami maksud sebuah kalimat.', 'concepts' => ['Tanda titik digunakan pada akhir kalimat berita.', 'Tanda tanya digunakan pada akhir kalimat tanya.', 'Tanda seru digunakan pada kalimat perintah atau seruan.'], 'example' => 'Ibu memasak sayur. Siapa yang datang? Wah, indah sekali!', 'practice' => ['Tambahkan tanda baca yang tepat: Siapa nama gurumu', 'Tambahkan tanda baca yang tepat: Tolong rapikan meja itu'], 'quizzes' => [
                ['question' => 'Tanda baca yang tepat untuk akhir kalimat tanya adalah ...', 'options' => ['a' => '.', 'b' => ',', 'c' => '?', 'd' => '!'], 'answer' => 'c', 'explanation' => 'Kalimat tanya selalu diakhiri dengan tanda tanya.'],
                ['question' => 'Tanda titik digunakan pada akhir kalimat...', 'options' => ['a' => 'Tanya', 'b' => 'Berita', 'c' => 'Seru', 'd' => 'Perintah'], 'answer' => 'b', 'explanation' => 'Tanda titik digunakan pada akhir kalimat berita.'],
                ['question' => 'Tanda seru digunakan pada kalimat...', 'options' => ['a' => 'Berita', 'b' => 'Tanya', 'c' => 'Perintah atau seruan', 'd' => 'Penjelasan'], 'answer' => 'c', 'explanation' => 'Tanda seru digunakan pada kalimat perintah atau seruan.'],
                ['question' => 'Kalimat "Siapa nama gurumu" ditambahkan tanda baca yang tepat menjadi...', 'options' => ['a' => 'Siapa nama gurumu.', 'b' => 'Siapa nama gurumu,', 'c' => 'Siapa nama gurumu?', 'd' => 'Siapa nama gurumu!'], 'answer' => 'c', 'explanation' => 'Kalimat tanya harus diakhiri dengan tanda tanya.'],
                ['question' => 'Tanda baca membantu pembaca memahami...', 'options' => ['a' => 'Warna buku', 'b' => 'Maksud kalimat', 'c' => 'Ukuran huruf', 'd' => 'Jumlah kata'], 'answer' => 'b', 'explanation' => 'Tanda baca membantu pembaca memahami maksud sebuah kalimat.']
            ]],
            ['title' => 'Membacakan Loud Reading', 'objective' => 'Siswa mampu membaca nyaring dengan lafal, intonasi, dan volume suara yang tepat.', 'intro' => 'Membaca nyaring adalah membaca dengan suara yang dapat didengar orang lain dengan jelas.', 'concepts' => ['Lafal adalah cara mengucapkan kata dengan benar.', 'Intonasi adalah naik turunnya suara saat membaca.', 'Volume suara harus cukup terdengar tanpa berteriak.'], 'example' => 'Saat membaca kalimat tanya, suara pada akhir kalimat biasanya naik: "Kapan kita berangkat?"', 'practice' => ['Bacakan kalimat: Aku senang belajar Bahasa Indonesia.', 'Jelaskan mengapa kita perlu membaca dengan lafal yang jelas.'], 'quizzes' => [
                ['question' => 'Saat membaca nyaring, kita perlu memperhatikan ...', 'options' => ['a' => 'Lafal dan intonasi', 'b' => 'Warna buku saja', 'c' => 'Ukuran meja', 'd' => 'Jumlah halaman saja'], 'answer' => 'a', 'explanation' => 'Lafal dan intonasi membantu pendengar memahami bacaan.'],
                ['question' => 'Lafal adalah cara mengucapkan...', 'options' => ['a' => 'Kata dengan salah', 'b' => 'Kata dengan benar', 'c' => 'Kata dengan cepat', 'd' => 'Kata dengan pelan'], 'answer' => 'b', 'explanation' => 'Lafal adalah cara mengucapkan kata dengan benar.'],
                ['question' => 'Intonasi adalah naik turunnya...', 'options' => ['a' => 'Tubuh', 'b' => 'Suara', 'c' => 'Tangan', 'd' => 'Kaki'], 'answer' => 'b', 'explanation' => 'Intonasi adalah naik turunnya suara saat membaca.'],
                ['question' => 'Volume suara saat membaca nyaring harus...', 'options' => ['a' => 'Sangat pelan', 'b' => 'Berteriak', 'c' => 'Cukup terdengar', 'd' => 'Tidak terdengar'], 'answer' => 'c', 'explanation' => 'Volume suara harus cukup terdengar tanpa berteriak.'],
                ['question' => 'Saat membaca kalimat tanya, suara pada akhir kalimat biasanya...', 'options' => ['a' => 'Turun', 'b' => 'Naik', 'c' => 'Datar', 'd' => 'Berhenti'], 'answer' => 'b', 'explanation' => 'Saat membaca kalimat tanya, suara pada akhir kalimat biasanya naik.']
            ]],
            ['title' => 'Menulis Surat Sederhana', 'objective' => 'Siswa mampu menulis surat pribadi sederhana dengan bagian yang lengkap.', 'intro' => 'Surat pribadi adalah tulisan untuk menyampaikan kabar atau pesan kepada orang yang kita kenal.', 'concepts' => ['Surat memiliki tempat dan tanggal penulisan.', 'Surat diawali salam pembuka dan diakhiri salam penutup.', 'Isi surat disampaikan dengan bahasa yang santun.'], 'example' => 'Bandung, 20 Juli 2026. Sahabatku Rani, apa kabar? Aku mengajakmu bermain pada hari Minggu. Salam, Sinta.', 'practice' => ['Tuliskan salam pembuka untuk surat kepada temanmu.', 'Buat dua kalimat isi surat untuk mengajak teman belajar bersama.'], 'quizzes' => [
                ['question' => 'Bagian yang tepat untuk mengawali surat pribadi adalah ...', 'options' => ['a' => 'Salam pembuka', 'b' => 'Daftar isi', 'c' => 'Daftar pustaka', 'd' => 'Judul berita'], 'answer' => 'a', 'explanation' => 'Surat pribadi diawali dengan salam pembuka yang sopan.'],
                ['question' => 'Surat harus memiliki...', 'options' => ['a' => 'Tempat dan tanggal penulisan', 'b' => 'Daftar harga', 'c' => 'Peta', 'd' => 'Foto'], 'answer' => 'a', 'explanation' => 'Surat memiliki tempat dan tanggal penulisan.'],
                ['question' => 'Surat diakhiri dengan...', 'options' => ['a' => 'Salam penutup', 'b' => 'Salam pembuka', 'c' => 'Judul', 'd' => 'Daftar isi'], 'answer' => 'a', 'explanation' => 'Surat diakhiri dengan salam penutup.'],
                ['question' => 'Isi surat disampaikan dengan bahasa yang...', 'options' => ['a' => 'Kasar', 'b' => 'Santun', 'c' => 'Sombong', 'd' => 'Marah'], 'answer' => 'b', 'explanation' => 'Isi surat disampaikan dengan bahasa yang santun.'],
                ['question' => 'Surat pribadi adalah tulisan untuk menyampaikan...', 'options' => ['a' => 'Berita resmi', 'b' => 'Kabar atau pesan', 'c' => 'Laporan keuangan', 'd' => 'Data statistik'], 'answer' => 'b', 'explanation' => 'Surat pribadi adalah tulisan untuk menyampaikan kabar atau pesan kepada orang yang kita kenal.']
            ]],
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
                    'time_limit' => 15, // Ditingkatkan menjadi 15 menit untuk 5 soal
                    'passing_score' => 70,
                    'status' => 'publish',
                ]
            );

            $quiz->quizQuestions()->delete();
            foreach ($data['quizzes'] as $index => $quizData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $quizData['question'],
                    'options' => $quizData['options'],
                    'correct_answer' => $quizData['answer'],
                    'explanation' => $quizData['explanation'],
                    'points' => 20, // Setiap soal 20 poin, total 100 poin
                    'order_number' => $index + 1,
                ]);
            }
        }
    }
}