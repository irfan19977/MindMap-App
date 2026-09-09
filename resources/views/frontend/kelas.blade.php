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
                            Temukan Kelas
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Home</a></li>
                            <li class="active">Kelas</li>
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
                            <input type="text" id="classSearch" class="form-control bg-white border-gray rounded-1 px-5 py-3" placeholder="Cari kelas berdasarkan nama atau kategori..." style="font-size: 16px; height: 50px;">
                            <div class="abs" style="left: 20px; top: 50%; transform: translateY(-50%); color: #999;">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4" id="classGrid">
                    @forelse($classes as $index => $class)
                    <div class="col-md-4 class-card">
                        <div class="hover rounded-1 overflow-hidden relative mb-4">
                            <a href="{{ route('mindmap.show', $class->subcategory->slug ?? $class->category->slug) }}?class_id={{ $class->id }}">
                                <h3 class="abs bg-color m-3 text-white rounded-1 fs-32 lh-1 p-4 z-3 hover-move-up-100">{{ str_pad(($classes->currentPage() - 1) * 12 + $index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                                <div class="sw-overlay z-2 op-3"></div>
                                <img src="{{ $class->cover_image ? asset('storage/' . $class->cover_image) : asset('frontend/images/services/1.webp') }}" class="w-100 hover-scale-1-2" alt="{{ $class->name }}">
                            </a>
                        </div>

                        <h3><a href="{{ route('mindmap.show', $class->subcategory->slug ?? $class->category->slug) }}?class_id={{ $class->id }}" class="text-decoration-none">{{ $class->name }}</a></h3>
                        <p class="mb-2">
                            {{ $class->description ?? 'Kelas pembelajaran interaktif dengan materi berkualitas untuk membantu Anda mencapai tujuan belajar.' }}
                        </p>
                        @if($class->grade_level)
                        <span class="badge bg-primary">{{ strtoupper($class->grade_level) }}</span>
                        @endif
                    </div>
                    @empty
                    <div class="col-lg-12 text-center py-5">
                        <div class="bg-white border-gray rounded-1 p-5" style="max-width: 500px; margin: 0 auto;">
                            <div class="mb-3">
                                <i class="fa fa-book-open fs-48 text-muted"></i>
                            </div>
                            <h4 class="mb-3">Belum ada kelas yang tersedia</h4>
                            <p class="text-muted mb-0">Silakan cek kembali nanti untuk kelas yang tersedia.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="col-lg-12 pt-4 text-center">
                        @if($classes->hasPages())
                        <div class="d-inline-block">
                            <nav aria-label="Page navigation example">
                              <ul class="pagination">
                                @if($classes->onFirstPage())
                                <li class="page-item disabled">
                                  <span class="page-link"><i class="fa fa-chevron-left"></i></span>
                                </li>
                                @else
                                <li class="page-item">
                                  <a class="page-link" href="{{ $classes->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
                                  </a>
                                </li>
                                @endif

                                <?php
                                $currentPage = $classes->currentPage();
                                $lastPage = $classes->lastPage();
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($lastPage, $currentPage + 2);

                                if ($startPage > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="' . $classes->url(1) . '">1</a></li>';
                                    if ($startPage > 2) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                }

                                for ($i = $startPage; $i <= $endPage; $i++) {
                                    if ($i == $currentPage) {
                                        echo '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="' . $classes->url($i) . '">' . $i . '</a></li>';
                                    }
                                }

                                if ($endPage < $lastPage) {
                                    if ($endPage < $lastPage - 1) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                    echo '<li class="page-item"><a class="page-link" href="' . $classes->url($lastPage) . '">' . $lastPage . '</a></li>';
                                }
                                ?>

                                @if($classes->hasMorePages())
                                <li class="page-item">
                                  <a class="page-link" href="{{ $classes->nextPageUrl() }}" aria-label="Next">
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
                            <h4 class="mb-3">Tidak ada kelas yang ditemukan</h4>
                            <p class="text-muted mb-0">Coba kata kunci lain atau periksa ejaan pencarian Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('classSearch');
            const classGrid = document.getElementById('classGrid');
            const classCards = classGrid.querySelectorAll('.class-card');
            const noResults = document.getElementById('noResults');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                classCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();

                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && classCards.length > 0) {
                    noResults.style.display = '';
                } else {
                    noResults.style.display = 'none';
                }
            });
        });
        </script>
@endsection