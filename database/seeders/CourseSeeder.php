<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Teacher;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();

        $courses = [
            // Dr. Ahmad Fauzi - Matematika & Fisika
            [
                'teacher_slug' => 'ahmad-fauzi',
                'title' => 'Matematika Dasar untuk Pemula',
                'slug' => 'matematika-dasar-pemula',
                'description' => 'Pelajari konsep dasar matematika dari aljabar hingga kalkulus dengan metode yang mudah dipahami.',
                'level' => 'beginner',
                'duration_hours' => 40,
                'price' => 299000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop',
                'enrollment_count' => 234,
                'rating' => 4.7,
                'review_count' => 45,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'ahmad-fauzi',
                'title' => 'Fisika Kuantum: Pengantar',
                'slug' => 'fisika-kuantum-pengantar',
                'description' => 'Memahami dasar-dasar fisika kuantum dan aplikasinya dalam teknologi modern.',
                'level' => 'advanced',
                'duration_hours' => 60,
                'price' => 499000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1636466497217-26a8cbeaf0aa?w=400&h=300&fit=crop',
                'enrollment_count' => 89,
                'rating' => 4.9,
                'review_count' => 32,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'ahmad-fauzi',
                'title' => 'Kalkulus Lanjut',
                'slug' => 'kalkulus-lanjut',
                'description' => 'Tinjauan mendalam tentang kalkulus diferensial dan integral untuk mahasiswa tingkat lanjut.',
                'level' => 'intermediate',
                'duration_hours' => 50,
                'price' => 399000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1509228468518-180dd4864904?w=400&h=300&fit=crop',
                'enrollment_count' => 156,
                'rating' => 4.6,
                'review_count' => 28,
                'is_published' => true,
            ],

            // Prof. Sarah Wijaya - Kimia & Biologi
            [
                'teacher_slug' => 'sarah-wijaya',
                'title' => 'Kimia Organik Dasar',
                'slug' => 'kimia-organik-dasar',
                'description' => 'Pelajari struktur, sifat, dan reaksi senyawa organik dengan pendekatan praktis.',
                'level' => 'beginner',
                'duration_hours' => 45,
                'price' => 349000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=400&h=300&fit=crop',
                'enrollment_count' => 198,
                'rating' => 4.8,
                'review_count' => 52,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'sarah-wijaya',
                'title' => 'Biologi Seluler Modern',
                'slug' => 'biologi-seluler-modern',
                'description' => 'Memahami struktur dan fungsi sel dengan teknologi terkini.',
                'level' => 'intermediate',
                'duration_hours' => 55,
                'price' => 449000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1576086213369-97a306d36557?w=400&h=300&fit=crop',
                'enrollment_count' => 134,
                'rating' => 5.0,
                'review_count' => 38,
                'is_published' => true,
            ],

            // Budi Santoso - Programming & Web Development
            [
                'teacher_slug' => 'budi-santoso',
                'title' => 'JavaScript untuk Pemula',
                'slug' => 'javascript-pemula',
                'description' => 'Belajar JavaScript dari nol hingga bisa membuat website interaktif.',
                'level' => 'beginner',
                'duration_hours' => 35,
                'price' => 249000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?w=400&h=300&fit=crop',
                'enrollment_count' => 456,
                'rating' => 4.6,
                'review_count' => 89,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'budi-santoso',
                'title' => 'React.js Masterclass',
                'slug' => 'reactjs-masterclass',
                'description' => 'Bangun aplikasi web modern dengan React.js dari dasar hingga advanced.',
                'level' => 'intermediate',
                'duration_hours' => 50,
                'price' => 399000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=400&h=300&fit=crop',
                'enrollment_count' => 312,
                'rating' => 4.8,
                'review_count' => 67,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'budi-santoso',
                'title' => 'Laravel Full-Stack Development',
                'slug' => 'laravel-fullstack',
                'description' => 'Buat aplikasi web lengkap dengan Laravel, dari backend hingga frontend.',
                'level' => 'advanced',
                'duration_hours' => 70,
                'price' => 599000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=400&h=300&fit=crop',
                'enrollment_count' => 178,
                'rating' => 4.7,
                'review_count' => 45,
                'is_published' => true,
            ],

            // Dewi Kartika - UI/UX Design
            [
                'teacher_slug' => 'dewi-kartika',
                'title' => 'UI Design Fundamentals',
                'slug' => 'ui-design-fundamentals',
                'description' => 'Pelajari prinsip dasar desain antarmuka pengguna yang efektif.',
                'level' => 'beginner',
                'duration_hours' => 30,
                'price' => 299000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=300&fit=crop',
                'enrollment_count' => 267,
                'rating' => 4.7,
                'review_count' => 58,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'dewi-kartika',
                'title' => 'UX Research & Testing',
                'slug' => 'ux-research-testing',
                'description' => 'Metode riset pengalaman pengguna dan testing untuk produk yang user-friendly.',
                'level' => 'intermediate',
                'duration_hours' => 40,
                'price' => 349000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1559028012-481c04fa702d?w=400&h=300&fit=crop',
                'enrollment_count' => 189,
                'rating' => 4.8,
                'review_count' => 41,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'dewi-kartika',
                'title' => 'Figma Advanced Techniques',
                'slug' => 'figma-advanced',
                'description' => 'Teknik lanjutan menggunakan Figma untuk desain kolaboratif dan prototyping.',
                'level' => 'intermediate',
                'duration_hours' => 35,
                'price' => 329000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=400&h=300&fit=crop',
                'enrollment_count' => 223,
                'rating' => 4.9,
                'review_count' => 56,
                'is_published' => true,
            ],

            // Rina Pratiwi - Akuntansi & Keuangan
            [
                'teacher_slug' => 'rina-pratiwi',
                'title' => 'Akuntansi Dasar',
                'slug' => 'akuntansi-dasar',
                'description' => 'Pahami prinsip dasar akuntansi dan pencatatan keuangan untuk bisnis.',
                'level' => 'beginner',
                'duration_hours' => 40,
                'price' => 329000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400&h=300&fit=crop',
                'enrollment_count' => 145,
                'rating' => 4.8,
                'review_count' => 34,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'rina-pratiwi',
                'title' => 'Analisis Keuangan Bisnis',
                'slug' => 'analisis-keuangan-bisnis',
                'description' => 'Teknik analisis laporan keuangan untuk pengambilan keputusan bisnis.',
                'level' => 'intermediate',
                'duration_hours' => 50,
                'price' => 449000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop',
                'enrollment_count' => 98,
                'rating' => 4.9,
                'review_count' => 28,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'rina-pratiwi',
                'title' => 'Manajemen Keuangan Pribadi',
                'slug' => 'manajemen-keuangan-pribadi',
                'description' => 'Strategi mengelola keuangan pribadi untuk kebebasan finansial.',
                'level' => 'beginner',
                'duration_hours' => 25,
                'price' => 199000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=400&h=300&fit=crop',
                'enrollment_count' => 312,
                'rating' => 4.7,
                'review_count' => 45,
                'is_published' => true,
            ],

            // Eko Prasetyo - Metodologi Pembelajaran
            [
                'teacher_slug' => 'eko-prasetyo',
                'title' => 'Teknologi dalam Pendidikan',
                'slug' => 'teknologi-pendidikan',
                'description' => 'Integrasi teknologi modern dalam proses pembelajaran yang efektif.',
                'level' => 'intermediate',
                'duration_hours' => 35,
                'price' => 299000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=300&fit=crop',
                'enrollment_count' => 87,
                'rating' => 4.5,
                'review_count' => 22,
                'is_published' => true,
            ],
            [
                'teacher_slug' => 'eko-prasetyo',
                'title' => 'Kurikulum Development',
                'slug' => 'kurikulum-development',
                'description' => 'Metode pengembangan kurikulum yang relevan dan adaptif.',
                'level' => 'advanced',
                'duration_hours' => 45,
                'price' => 399000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&h=300&fit=crop',
                'enrollment_count' => 54,
                'rating' => 4.6,
                'review_count' => 18,
                'is_published' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            $teacher = $teachers->where('slug', $courseData['teacher_slug'])->first();
            if ($teacher) {
                Course::create([
                    'teacher_id' => $teacher->id,
                    'title' => $courseData['title'],
                    'slug' => $courseData['slug'],
                    'description' => $courseData['description'],
                    'level' => $courseData['level'],
                    'duration_hours' => $courseData['duration_hours'],
                    'price' => $courseData['price'],
                    'thumbnail_url' => $courseData['thumbnail_url'],
                    'enrollment_count' => $courseData['enrollment_count'],
                    'rating' => $courseData['rating'],
                    'review_count' => $courseData['review_count'],
                    'is_published' => $courseData['is_published'],
                ]);
            }
        }
    }
}
