@extends('frontend.layouts.app')

@section('content')
    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Profil <span class="label classic">Pengajar</span></h1>
                        <p class="lead">Kenali lebih dekat pengajar kami yang berdedikasi untuk kesuksesan pembelajaran Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Teacher Profile Section -->
    <section class="showcase section-small">
        <div class="container">
            <div class="row">
                <!-- Profile Image & Basic Info -->
                <div class="col-md-4">
                    <div class="profile-card text-center">
                        <img class="img-responsive center-block profile-img" src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                        <div class="profile-info">
                            <h3>{{ $teacher->name }}</h3>
                            <p class="text-muted">{{ $teacher->specialization }}</p>
                            <div class="profile-rating">
                                <div class="rating-stars">
                                    @php
                                        $fullStars = floor($teacher->rating);
                                        $hasHalfStar = ($teacher->rating - $fullStars) >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                    @endphp
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    @if($hasHalfStar)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @endif
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                </div>
                                <div class="rating-details">
                                    <span class="rating-number">{{ number_format($teacher->rating, 1) }}</span>
                                    <span class="review-count">{{ $teacher->review_count }} reviews</span>
                                </div>
                            </div>
                            <div class="profile-social">
                                <ul class="list-inline">
                                    @if($teacher->linkedin_url)
                                    <li><a href="{{ $teacher->linkedin_url }}" target="_blank" class="btn btn-sm btn-social"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif
                                    @if($teacher->twitter_url)
                                    <li><a href="{{ $teacher->twitter_url }}" target="_blank" class="btn btn-sm btn-social"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if($teacher->github_url)
                                    <li><a href="{{ $teacher->github_url }}" target="_blank" class="btn btn-sm btn-social"><i class="fab fa-github"></i></a></li>
                                    @endif
                                    @if($teacher->email)
                                    <li><a href="mailto:{{ $teacher->email }}" class="btn btn-sm btn-social"><i class="fas fa-envelope"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                            <a href="{{ route('teacher.index') }}" class="btn btn-dark-border"><i class="ion-ios-arrow-back"></i> Kembali ke Daftar Pengajar</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="col-md-8">
                    <div class="profile-details">
                        <h2>Tentang Saya</h2>
                        <p>{{ $teacher->description }}</p>

                        @if($teacher->education)
                        <h3>Pendidikan</h3>
                        <ul class="list-unstyled education-list">
                            <li><i class="ion-ios-ribbon text-primary"></i> {{ $teacher->education }}</li>
                        </ul>
                        @endif

                        @if($teacher->experience)
                        <h3>Pengalaman Mengajar</h3>
                        <ul class="list-unstyled experience-list">
                            <li>
                                <i class="ion-ios-briefcase text-success"></i>
                                <div>
                                    <strong>{{ $teacher->experience }}</strong>
                                </div>
                            </li>
                        </ul>
                        @endif

                        <h3>Kelas yang Diajar</h3>
                        @if($teacher->publishedCourses->count() > 0)
                        <div class="row">
                            @foreach($teacher->publishedCourses as $course)
                            <div class="col-sm-6">
                                <div class="class-card">
                                    @if($course->thumbnail_url)
                                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="class-thumbnail">
                                    @endif
                                    <h4><i class="ion-ios-book text-primary"></i> {{ $course->title }}</h4>
                                    <p class="small">{{ Str::limit($course->description, 80) }}</p>
                                    <div class="class-meta">
                                        <span class="badge badge-{{ $course->level == 'beginner' ? 'success' : ($course->level == 'intermediate' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                        <span class="text-muted"><i class="ion-ios-time"></i> {{ $course->duration_hours }} jam</span>
                                        <span class="text-muted"><i class="ion-ios-people"></i> {{ $course->enrollment_count }} siswa</span>
                                    </div>
                                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-sm btn-dark-border">Lihat Kelas</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted">Belum ada kelas yang tersedia saat ini.</p>
                        @endif

                        <h3>Testimoni Siswa</h3>
                        <div class="testimonials">
                            <div class="testimonial-item">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <strong>Andi Pratama</strong>
                                        <span class="reviewer-role">Mahasiswa Teknik</span>
                                    </div>
                                    <div class="review-rating">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="review-date">2 minggu yang lalu</span>
                                    </div>
                                </div>
                                <p class="italic">"Dr. Ahmad adalah pengajar yang luar biasa. Beliau dapat menjelaskan konsep matematika yang rumit dengan cara yang sangat mudah dipahami. Sangat direkomendasikan!"</p>
                                <div class="review-helpful">
                                    <button class="btn btn-sm btn-helpful"><i class="far fa-thumbs-up"></i> 45 orang merasa ini membantu</button>
                                </div>
                            </div>
                            <div class="testimonial-item">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <strong>Siti Rahayu</strong>
                                        <span class="reviewer-role">Siswa SMA</span>
                                    </div>
                                    <div class="review-rating">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <span class="review-date">1 bulan yang lalu</span>
                                    </div>
                                </div>
                                <p class="italic">"Metode pengajaran Dr. Ahmad sangat interaktif dan engaging. Saya yang awalnya kesulitan dengan fisika, sekarang justru menjadi favorit saya."</p>
                                <div class="review-helpful">
                                    <button class="btn btn-sm btn-helpful"><i class="far fa-thumbs-up"></i> 38 orang merasa ini membantu</button>
                                </div>
                            </div>
                            <div class="testimonial-item">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <strong>Budi Santoso</strong>
                                        <span class="reviewer-role">Profesional IT</span>
                                    </div>
                                    <div class="review-rating">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <span class="review-date">2 bulan yang lalu</span>
                                    </div>
                                </div>
                                <p class="italic">"Mengambil kelas statistika dengan Dr. Ahmad sangat membantu dalam pekerjaan saya. Penjelasannya praktis dan langsung bisa diterapkan."</p>
                                <div class="review-helpful">
                                    <button class="btn btn-sm btn-helpful"><i class="far fa-thumbs-up"></i> 32 orang merasa ini membantu</button>
                                </div>
                            </div>
                            <div class="testimonial-item">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <strong>Dewi Lestari</strong>
                                        <span class="reviewer-role">Mahasiswa Matematika</span>
                                    </div>
                                    <div class="review-rating">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="review-date">3 bulan yang lalu</span>
                                    </div>
                                </div>
                                <p class="italic">"Dr. Ahmad tidak hanya mengajarkan teori, tapi juga bagaimana berpikir kritis. Skill yang sangat valuable untuk karir akademis saya."</p>
                                <div class="review-helpful">
                                    <button class="btn btn-sm btn-helpful"><i class="far fa-thumbs-up"></i> 28 orang merasa ini membantu</button>
                                </div>
                            </div>
                        </div>
                        <div class="load-more-reviews">
                            <button class="btn btn-dark-border">Muat Lebih Banyak Review</button>
                        </div>

                        <h3>Pertanyaan yang Sering Diajukan (FAQ)</h3>
                        <div class="faq-section">
                            <div class="faq-item">
                                <div class="faq-question">
                                    <h4><i class="ion-ios-help-circle-outline text-primary"></i> Apakah kelas tersedia secara online?</h4>
                                    <button class="btn btn-faq-toggle"><i class="ion-ios-arrow-down"></i></button>
                                </div>
                                <div class="faq-answer">
                                    <p>Ya, semua kelas yang saya ajarkan tersedia secara online melalui platform MindMap. Anda dapat mengakses materi kapan saja dan di mana saja sesuai dengan jadwal yang tersedia.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <h4><i class="ion-ios-help-circle-outline text-primary"></i> Berapa lama durasi setiap kelas?</h4>
                                    <button class="btn btn-faq-toggle"><i class="ion-ios-arrow-down"></i></button>
                                </div>
                                <div class="faq-answer">
                                    <p>Durasi kelas bervariasi tergantung pada topik dan tingkat kesulitan. Umumnya, kelas dasar berdurasi 4-6 minggu, sedangkan kelas lanjutan dapat berlangsung 8-12 minggu. Setiap sesi biasanya berlangsung 90-120 menit.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <h4><i class="ion-ios-help-circle-outline text-primary"></i> Apakah ada sertifikat setelah menyelesaikan kelas?</h4>
                                    <button class="btn btn-faq-toggle"><i class="ion-ios-arrow-down"></i></button>
                                </div>
                                <div class="faq-answer">
                                    <p>Ya, setiap siswa yang menyelesaikan kelas dengan baik akan menerima sertifikat penyelesaian yang dapat digunakan untuk portofolio atau keperluan akademik/profesional.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <h4><i class="ion-ios-help-circle-outline text-primary"></i> Apakah tersedia konsultasi private?</h4>
                                    <button class="btn btn-faq-toggle"><i class="ion-ios-arrow-down"></i></button>
                                </div>
                                <div class="faq-answer">
                                    <p>Ya, saya menyediakan sesi konsultasi private untuk siswa yang membutuhkan bimbingan lebih personal. Silakan hubungi melalui fitur kontak untuk menjadwalkan sesi private.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <h4><i class="ion-ios-help-circle-outline text-primary"></i> Apa prasyarat untuk mengikuti kelas?</h4>
                                    <button class="btn btn-faq-toggle"><i class="ion-ios-arrow-down"></i></button>
                                </div>
                                <div class="faq-answer">
                                    <p>Prasyarat berbeda untuk setiap kelas. Untuk kelas dasar, biasanya tidak ada prasyarat khusus. Untuk kelas lanjut, disarankan memiliki pemahaman dasar terkait topik yang akan dipelajari. Detail prasyarat tersedia di halaman setiap kelas.</p>
                                </div>
                            </div>
                        </div>

                        <h3>Pengajar Lain yang Mungkin Anda Sukai</h3>
                        <div class="related-teachers">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="related-teacher-card">
                                        <img class="img-responsive center-block" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop&crop=face" alt="Prof. Sarah Wijaya">
                                        <div class="related-teacher-info">
                                            <h5>Prof. Sarah Wijaya</h5>
                                            <p class="text-muted small">Kimia & Biologi</p>
                                            <div class="related-teacher-rating">
                                                <i class="fas fa-star text-warning"></i>
                                                <span>5.0</span>
                                            </div>
                                            <a href="/teacher/sarah-wijaya" class="btn btn-sm btn-dark-border">Lihat Profil</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="related-teacher-card">
                                        <img class="img-responsive center-block" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face" alt="Budi Santoso, S.Kom">
                                        <div class="related-teacher-info">
                                            <h5>Budi Santoso, S.Kom</h5>
                                            <p class="text-muted small">Programming & Web Dev</p>
                                            <div class="related-teacher-rating">
                                                <i class="fas fa-star text-warning"></i>
                                                <span>4.5</span>
                                            </div>
                                            <a href="/teacher/budi-santoso" class="btn btn-sm btn-dark-border">Lihat Profil</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="related-teacher-card">
                                        <img class="img-responsive center-block" src="https://images.unsplash.com/photo-1557862921-37829c790f19?w=400&h=400&fit=crop&crop=face" alt="Eko Prasetyo, M.Pd">
                                        <div class="related-teacher-info">
                                            <h5>Eko Prasetyo, M.Pd</h5>
                                            <p class="text-muted small">Metodologi Pembelajaran</p>
                                            <div class="related-teacher-rating">
                                                <i class="fas fa-star text-warning"></i>
                                                <span>4.3</span>
                                            </div>
                                            <a href="/teacher/eko-prasetyo" class="btn btn-sm btn-dark-border">Lihat Profil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="cta-section">
                            <a href="/contact" class="btn btn-primary btn-lg">Hubungi Pengajar</a>
                            <a href="/kelas" class="btn btn-dark-border btn-lg">Lihat Semua Kelas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for FAQ Accordion -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ Accordion functionality
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', function() {
                    // Close all other FAQ items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current FAQ item
                    item.classList.toggle('active');
                });
            });
        });
    </script>
@endsection
