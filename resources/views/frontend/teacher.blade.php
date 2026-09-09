@extends('frontend.layouts.app')

@section('content')
            <section class="jarallax relative overflow-hidden z-1000 mt-80">
            <img src="{{ asset('frontend/images/background/1.webp') }}" class="jarallax-img" alt="">
            <div class="sw-overlay op-2"></div>
            <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
            <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
            <div class="container relative z-2">
                <div class="row wow fadeInRight">
                    <div class="col-lg-10">
                        <h1 class="fs-sm-10vw mb-0">
                            Tim Pengajar Profesional
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Home</a></li>
                            <li class="active">Pengajar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="relative">
                            <input type="text" id="teacherSearch" class="form-control bg-white border-gray rounded-1 px-5 py-3" placeholder="Cari guru berdasarkan nama atau mata pelajaran..." style="font-size: 16px; height: 50px;">
                            <div class="abs" style="left: 20px; top: 50%; transform: translateY(-50%); color: #999;">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4" id="teacherGrid">
                    @forelse($teachers as $teacher)
                    <!-- teacher item begin -->
                    <div class="col-lg-4 col-sm-6 teacher-card">
                        <div class="hover rounded-1 overflow-hidden relative text-light text-center wow fadeInRight" data-wow-delay=".0s">
                            <img src="{{ $teacher->image_url ? asset('storage/' . $teacher->image_url) : asset('frontend/images/services/1.webp') }}" class="hover-scale-1-1 w-100" alt="{{ $teacher->name }}">
                            <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                <div class="mb-3">
                                    {{ $teacher->description ?? 'Guru berpengalaman dengan metode pengajaran yang interaktif dan menyenangkan.' }}
                                </div>
                                <a class="btn-line" href="{{ route('teacher.show', $teacher->slug) }}">Lihat Profil</a>
                            </div>
                            <img src="{{ asset('frontend/images/icons-white/1.png') }}" class="abs abs-centered w-20 z-2" alt="">
                            <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                            <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                <h3 class="hs-4 mb-3">{{ $teacher->name }}</h3>
                                <p class="text-white-50 fs-14">{{ $teacher->specialization ?? 'Guru' }}</p>
                            </div>
                            <div class="gradient-edge-bottom color abs w-100 h-70 bottom-0"></div>
                        </div>
                    </div>
                    <!-- teacher item end -->
                    @empty
                    <div class="col-lg-12 text-center py-5">
                        <div class="bg-white border-gray rounded-1 p-5" style="max-width: 500px; margin: 0 auto;">
                            <div class="mb-3">
                                <i class="fa fa-user-minus fs-48 text-muted"></i>
                            </div>
                            <h4 class="mb-3">Belum ada guru yang tersedia</h4>
                            <p class="text-muted mb-0">Silakan cek kembali nanti untuk guru yang terdaftar.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="col-lg-12 pt-4 text-center">
                        @if($teachers->hasPages())
                        <div class="d-inline-block">
                            <nav aria-label="Page navigation example">
                              <ul class="pagination">
                                @if($teachers->onFirstPage())
                                <li class="page-item disabled">
                                  <span class="page-link"><i class="fa fa-chevron-left"></i></span>
                                </li>
                                @else
                                <li class="page-item">
                                  <a class="page-link" href="{{ $teachers->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
                                  </a>
                                </li>
                                @endif

                                <?php
                                $currentPage = $teachers->currentPage();
                                $lastPage = $teachers->lastPage();
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($lastPage, $currentPage + 2);

                                if ($startPage > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="' . $teachers->url(1) . '">1</a></li>';
                                    if ($startPage > 2) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                }

                                for ($i = $startPage; $i <= $endPage; $i++) {
                                    if ($i == $currentPage) {
                                        echo '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="' . $teachers->url($i) . '">' . $i . '</a></li>';
                                    }
                                }

                                if ($endPage < $lastPage) {
                                    if ($endPage < $lastPage - 1) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                    echo '<li class="page-item"><a class="page-link" href="' . $teachers->url($lastPage) . '">' . $lastPage . '</a></li>';
                                }
                                ?>

                                @if($teachers->hasMorePages())
                                <li class="page-item">
                                  <a class="page-link" href="{{ $teachers->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
                                  </a>
                                </li>
                                @else
                                <li class="page-item disabled">
                                  <span class="page-link"><i class="fa fa-chevron-right"></i></span>
                                </li>
                                @endif
                              </ul>
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row" id="noResults" style="display: none;">
                    <div class="col-lg-12 text-center py-5">
                        <div class="bg-white border-gray rounded-1 p-5" style="max-width: 500px; margin: 0 auto;">
                            <div class="mb-3">
                                <i class="fa fa-search-minus fs-48 text-muted"></i>
                            </div>
                            <h4 class="mb-3">Tidak ada guru yang ditemukan</h4>
                            <p class="text-muted mb-0">Coba kata kunci lain atau periksa ejaan pencarian Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('teacherSearch');
            const teacherGrid = document.getElementById('teacherGrid');
            const teacherCards = teacherGrid.querySelectorAll('.teacher-card');
            const noResults = document.getElementById('noResults');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                teacherCards.forEach(card => {
                    const name = card.querySelector('h3').textContent.toLowerCase();
                    const subject = card.querySelector('p').textContent.toLowerCase();
                    const description = card.querySelector('.mb-3').textContent.toLowerCase();

                    if (name.includes(searchTerm) || subject.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && teacherCards.length > 0) {
                    noResults.style.display = '';
                } else {
                    noResults.style.display = 'none';
                }
            });
        });
        </script>
@endsection