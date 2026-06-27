<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Dr. Ahmad Fauzi',
                'slug' => 'ahmad-fauzi',
                'specialization' => 'Matematika & Fisika',
                'category' => 'akademik',
                'description' => 'Doktor lulusan ITB dengan pengalaman mengajar lebih dari 10 tahun. Spesialis dalam matematika terapan dan fisika kuantum.',
                'education' => 'S3 Fisika, Institut Teknologi Bandung (ITB)',
                'experience' => '10+ tahun mengajar di berbagai universitas dan institusi pendidikan',
                'image_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face',
                'rating' => 4.8,
                'review_count' => 128,
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://twitter.com',
                'email' => 'ahmad.fauzi@example.com',
            ],
            [
                'name' => 'Prof. Sarah Wijaya',
                'slug' => 'sarah-wijaya',
                'specialization' => 'Kimia & Biologi',
                'category' => 'akademik',
                'description' => 'Profesor Kimia dari UI dengan penelitian di bidang material nano. Berpengalaman dalam pembelajaran sains interaktif.',
                'education' => 'S3 Kimia, Universitas Indonesia (UI)',
                'experience' => '15+ tahun penelitian dan mengajar di UI',
                'image_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop&crop=face',
                'rating' => 5.0,
                'review_count' => 95,
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://twitter.com',
                'email' => 'sarah.wijaya@example.com',
            ],
            [
                'name' => 'Budi Santoso, S.Kom',
                'slug' => 'budi-santoso',
                'specialization' => 'Programming & Web Development',
                'category' => 'digital',
                'description' => 'Full-stack developer dengan pengalaman 8 tahun di startup teknologi. Ahli dalam JavaScript, React, dan Laravel.',
                'education' => 'S1 Teknik Informatika, Universitas Indonesia (UI)',
                'experience' => '8+ tahun di startup teknologi dan freelance',
                'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
                'rating' => 4.5,
                'review_count' => 203,
                'linkedin_url' => 'https://linkedin.com',
                'github_url' => 'https://github.com',
                'email' => 'budi.santoso@example.com',
            ],
            [
                'name' => 'Dewi Kartika, M.Des',
                'slug' => 'dewi-kartika',
                'specialization' => 'UI/UX Design & Web Design',
                'category' => 'digital',
                'description' => 'Designer lulusan RMIT Australia dengan portofolio internasional. Spesialis dalam user experience dan visual design.',
                'education' => 'S2 Design, RMIT University Australia',
                'experience' => '6+ tahun bekerja dengan klien internasional',
                'image_url' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=400&fit=crop&crop=face',
                'rating' => 4.7,
                'review_count' => 156,
                'linkedin_url' => 'https://linkedin.com',
                'email' => 'dewi.kartika@example.com',
            ],
            [
                'name' => 'Rina Pratiwi, CA',
                'slug' => 'rina-pratiwi',
                'specialization' => 'Akuntansi & Keuangan',
                'category' => 'bisnis',
                'description' => 'Chartered Accountant dengan pengalaman di Big 4. Ahli dalam akuntansi manajemen dan analisis keuangan.',
                'education' => 'S1 Akuntansi, Universitas Gadjah Mada (UGM)',
                'experience' => '12+ tahun di Big 4 dan konsultan keuangan',
                'image_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop&crop=face',
                'rating' => 4.9,
                'review_count' => 87,
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://twitter.com',
                'email' => 'rina.pratiwi@example.com',
            ],
            [
                'name' => 'Eko Prasetyo, M.Pd',
                'slug' => 'eko-prasetyo',
                'specialization' => 'Metodologi Pembelajaran',
                'category' => 'akademik',
                'description' => 'Magister Pendidikan dengan spesialisasi dalam teknologi pendidikan. Konsultan kurikulum untuk berbagai institusi.',
                'education' => 'S2 Pendidikan, Universitas Negeri Jakarta (UNJ)',
                'experience' => '8+ tahun sebagai konsultan pendidikan',
                'image_url' => 'https://images.unsplash.com/photo-1557862921-37829c790f19?w=400&h=400&fit=crop&crop=face',
                'rating' => 4.3,
                'review_count' => 64,
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://twitter.com',
                'email' => 'eko.prasetyo@example.com',
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
