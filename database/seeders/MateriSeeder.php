<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = ['matematika', 'bahasa-indonesia', 'ipa', 'ips', 'bahasa-inggris'];
        $levels = ['sd', 'smp', 'sma'];

        // Material data for each subject and level
        $materialsData = [
            'matematika' => [
                'sd' => [
                    'Penjumlahan dan Pengurangan Bilangan Bulat',
                    'Perkalian dan Pembagian Dasar',
                    'Pecahan Sederhana',
                    'Geometri Dasar: Bangun Datar',
                    'Pengukuran Panjang dan Berat',
                    'Waktu dan Jam',
                    'Uang dan Mata Uang',
                    'Statistik Dasar: Diagram Batang',
                    'Bangun Ruang Sederhana',
                    'Soal Cerita Matematika SD'
                ],
                'smp' => [
                    'Aljabar Dasar',
                    'Persamaan Linear Satu Variabel',
                    'Teorema Pythagoras',
                    'Geometri: Lingkaran',
                    'Trigonometri Dasar',
                    'Statistik: Mean, Median, Modus',
                    'Peluang Dasar',
                    'Bangun Ruang: Kubus dan Balok',
                    'Sistem Persamaan Linear Dua Variabel',
                    'Fungsi Linear dan Kuadrat'
                ],
                'sma' => [
                    'Limit dan Turunan Fungsi',
                    'Integral Tak Tentu',
                    'Matriks dan Determinan',
                    'Vektor dalam Ruang Dimensi Tiga',
                    'Barisan dan Deret',
                    'Logika Matematika',
                    'Persamaan Lingkaran',
                    'Statistika Inferensial',
                    'Program Linear',
                    'Transformasi Geometri'
                ]
            ],
            'bahasa-indonesia' => [
                'sd' => [
                    'Mengenal Huruf dan Kata',
                    'Membaca Teks Sederhana',
                    'Menulis Kalimat Dasar',
                    'Pemahaman Cerita Rakyat',
                    'Puisi Anak',
                    'Pantun dan Syair',
                    'Kosakata Dasar',
                    'Tanda Baca',
                    'Membacakan Loud Reading',
                    'Menulis Surat Sederhana'
                ],
                'smp' => [
                    'Teks Berita',
                    'Teks Deskripsi',
                    'Teks Eksposisi',
                    'Teks Prosedur',
                    'Teks Naratif',
                    'Puisi Lama dan Baru',
                    'Drama dan Teater',
                    'Artikel Opini',
                    'Surat Lamaran Kerja',
                    'Pidato Persuasif'
                ],
                'sma' => [
                    'Teks Editorial',
                    'Teks Laporan Hasil Observasi',
                    'Teks Cerita Sejarah',
                    'Teks Ulasan',
                    'Teks Negosiasi',
                    'Puisi Kontemporer',
                    'Cerpen dan Novel',
                    'Kritik Sastra',
                    'Makalah Ilmiah',
                    'Proposal Penelitian'
                ]
            ],
            'ipa' => [
                'sd' => [
                    'Makhluk Hidup dan Lingkungan',
                    'Tubuh Manusia dan Kesehatan',
                    'Energi dan Perubahannya',
                    'Bumi dan Alam Semesta',
                    'Tanaman dan Hewan',
                    'Air dan Udara',
                    'Gaya dan Gerak',
                    'Sifat Benda',
                    'Ekosistem',
                    'Daur Ulang Sampah'
                ],
                'smp' => [
                    'Sistem Pencernaan Manusia',
                    'Sistem Pernapasan',
                    'Struktur Tumbuhan',
                    'Struktur Hewan',
                    'Zat Aditif dan Adiktif',
                    'Bioteknologi',
                    'Energi dan Perubahannya',
                    'Hukum Newton',
                    'Listrik dan Magnet',
                    'Bumi dan Tata Surya'
                ],
                'sma' => [
                    'Sel dan Jaringan',
                    'Genetika dan Hereditas',
                    'Evolusi',
                    'Ekologi',
                    'Kimia Dasar',
                    'Fisika Modern',
                    'Termokimia',
                    'Laju Reaksi',
                    'Hukum Termodinamika',
                    'Teknologi Nano'
                ]
            ],
            'ips' => [
                'sd' => [
                    'Keluarga dan Kerabat',
                    'Sekolah dan Pendidikan',
                    'Masyarakat dan Lingkungan',
                    'Pekerjaan dan Profesi',
                    'Transportasi',
                    'Perdagangan',
                    'Peta dan Denah',
                    'Sejarah Kemerdekaan',
                    'Lembaga Sosial',
                    'Budaya Daerah'
                ],
                'smp' => [
                    'Sosiologi Dasar',
                    'Geografi Indonesia',
                    'Sejarah Indonesia Kuno',
                    'Ekonomi Dasar',
                    'Pemerintahan Indonesia',
                    'Globalisasi',
                    'Demografi',
                    'Sumber Daya Alam',
                    'Perdagangan Internasional',
                    'Konflik Sosial'
                ],
                'sma' => [
                    'Sosiologi Lanjut',
                    'Geografi Regional',
                    'Sejarah Dunia Modern',
                    'Ekonomi Makro',
                    'Sistem Politik Indonesia',
                    'Hubungan Internasional',
                    'Antropologi Sosial',
                    'Perbankan dan Keuangan',
                    'Pembangunan Ekonomi',
                    'Hukum dan Hak Asasi'
                ]
            ],
            'bahasa-inggris' => [
                'sd' => [
                    'Alphabet and Phonics',
                    'Basic Greetings',
                    'Numbers and Counting',
                    'Colors and Shapes',
                    'Family Members',
                    'Animals',
                    'Fruits and Vegetables',
                    'Days of the Week',
                    'Simple Present Tense',
                    'Basic Vocabulary'
                ],
                'smp' => [
                    'Present Continuous Tense',
                    'Past Tense',
                    'Future Tense',
                    'Modal Verbs',
                    'Prepositions',
                    'Conjunctions',
                    'Reading Comprehension',
                    'Writing Paragraphs',
                    'Listening Skills',
                    'Speaking Practice'
                ],
                'sma' => [
                    'Conditional Sentences',
                    'Passive Voice',
                    'Reported Speech',
                    'Narrative Text',
                    'Expository Text',
                    'Argumentative Essay',
                    'Business English',
                    'Academic Writing',
                    'TOEFL Preparation',
                    'IELTS Preparation'
                ]
            ]
        ];

        foreach ($subjects as $subject) {
            foreach ($levels as $level) {
                $subcategorySlug = $subject . '-' . $level;
                $subcategory = Subcategory::where('slug', $subcategorySlug)->first();

                if ($subcategory && isset($materialsData[$subject][$level])) {
                    foreach ($materialsData[$subject][$level] as $index => $title) {
                        // Generate sample konten materi data
                        $kontenMateri = [
                            [
                                'type' => 'heading',
                                'content' => 'Pengenalan ' . $title
                            ],
                            [
                                'type' => 'paragraph',
                                'content' => 'Pada materi ini, kita akan mempelajari tentang ' . $title . '. Materi ini dirancang untuk membantu siswa memahami konsep dasar secara mendalam.'
                            ],
                            [
                                'type' => 'heading',
                                'content' => 'Konsep Dasar'
                            ],
                            [
                                'type' => 'paragraph',
                                'content' => 'Berikut adalah penjelasan detail tentang konsep-konsep penting dalam ' . $title . '.'
                            ],
                            [
                                'type' => 'list',
                                'content' => [
                                    'Konsep pertama yang perlu dipahami',
                                    'Konsep kedua yang berkaitan',
                                    'Konsep ketiga sebagai penerapan'
                                ]
                            ],
                            [
                                'type' => 'heading',
                                'content' => 'Contoh Soal'
                            ],
                            [
                                'type' => 'paragraph',
                                'content' => 'Mari kita lihat contoh penerapan konsep ini dalam soal.'
                            ]
                        ];

                        // Generate sample latihan data
                        $latihanData = [
                            [
                                'question' => 'Apa yang dimaksud dengan ' . $title . '?',
                                'type' => 'essay',
                                'points' => 10
                            ],
                            [
                                'question' => 'Jelaskan perbedaan antara konsep A dan konsep B dalam ' . $title,
                                'type' => 'essay',
                                'points' => 15
                            ],
                            [
                                'question' => 'Sebutkan 3 karakteristik utama dari ' . $title,
                                'type' => 'short_answer',
                                'points' => 10
                            ]
                        ];

                        // Generate sample quiz data
                        $quizData = [
                            'title' => 'Quiz ' . $title,
                            'status' => 'publish',
                            'passing_score' => 60,
                            'time_limit' => 30,
                            'description' => 'Quiz untuk menguji pemahaman tentang ' . $title,
                            'questions' => [
                                [
                                    'question' => 'Manakah pernyataan yang benar tentang ' . $title . '?',
                                    'options' => [
                                        'a' => 'Pilihan jawaban A yang salah',
                                        'b' => 'Pilihan jawaban B yang benar',
                                        'c' => 'Pilihan jawaban C yang salah',
                                        'd' => 'Pilihan jawaban D yang salah'
                                    ],
                                    'correct_answer' => 'b'
                                ],
                                [
                                    'question' => 'Apa fungsi utama dari ' . $title . '?',
                                    'options' => [
                                        'a' => 'Fungsi pertama',
                                        'b' => 'Fungsi kedua yang benar',
                                        'c' => 'Fungsi ketiga',
                                        'd' => 'Fungsi keempat'
                                    ],
                                    'correct_answer' => 'b'
                                ],
                                [
                                    'question' => 'Kapan ' . $title . ' pertama kali ditemukan?',
                                    'options' => [
                                        'a' => 'Tahun 1800',
                                        'b' => 'Tahun 1900 yang benar',
                                        'c' => 'Tahun 2000',
                                        'd' => 'Tahun 2020'
                                    ],
                                    'correct_answer' => 'b'
                                ],
                                [
                                    'question' => 'Siapa tokoh yang berkontribusi dalam pengembangan ' . $title . '?',
                                    'options' => [
                                        'a' => 'Tokoh A',
                                        'b' => 'Tokoh B yang benar',
                                        'c' => 'Tokoh C',
                                        'd' => 'Tokoh D'
                                    ],
                                    'correct_answer' => 'b'
                                ],
                                [
                                    'question' => 'Apa manfaat mempelajari ' . $title . '?',
                                    'options' => [
                                        'a' => 'Manfaat A',
                                        'b' => 'Manfaat B yang benar',
                                        'c' => 'Manfaat C',
                                        'd' => 'Manfaat D'
                                    ],
                                    'correct_answer' => 'b'
                                ]
                            ]
                        ];

                        $slug = strtolower(str_replace(' ', '-', $title)) . '-' . $index;
                        Material::firstOrCreate(
                            ['slug' => $slug],
                            [
                                'subcategory_id' => $subcategory->id,
                                'title' => $title,
                                'description' => 'Materi pembelajaran ' . $title . ' untuk tingkat ' . strtoupper($level),
                                'learning_objectives' => 'Memahami konsep dasar ' . $title . ' dan dapat menerapkannya dalam soal latihan',
                                'content' => json_encode($kontenMateri),
                                'latihan_data' => $latihanData,
                                'quiz_data' => $quizData,
                                'status' => 'publish',
                                'is_free' => true,
                            ]
                        );
                    }
                }
            }
        }
    }
}
