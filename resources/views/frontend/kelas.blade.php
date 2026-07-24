@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="overlay"></div>
        <div class="intro-body">
            <h1>Kelas Pembelajaran</h1>
            <h4>Pilih kelas yang ingin Anda pelajari dan ikuti alur mindmap yang terstruktur</h4><a class="page-scroll" href="#kelas"><span class="mouse"><span><i class="icon ion-ios-arrow-down"></i></span></span></a>
        </div>
    </header>

    <!-- Kelas Block-->
    <section class="section-small" id="kelas">
        <div class="container">
            <style>
                .class-search-filter {
                    max-width: 600px;
                    margin: 0 auto 30px;
                }
                .class-search-filter .search-input-wrap {
                    position: relative;
                    margin-bottom: 15px;
                }
                .class-search-filter .search-input-wrap input {
                    width: 100%;
                    padding: 12px 20px 12px 45px;
                    border: 2px solid #e0e0e0;
                    border-radius: 30px;
                    font-size: 15px;
                    outline: none;
                    transition: border-color 0.3s;
                }
                .class-search-filter .search-input-wrap input:focus {
                    border-color: #333;
                }
                .class-search-filter .search-input-wrap i {
                    position: absolute;
                    left: 18px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #999;
                    font-size: 16px;
                }
                .class-search-filter .filter-buttons {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                    gap: 8px;
                }
                .class-search-filter .filter-buttons button {
                    padding: 7px 20px;
                    border: 2px solid #e0e0e0;
                    border-radius: 25px;
                    background: #fff;
                    color: #555;
                    font-size: 14px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.3s;
                }
                .class-search-filter .filter-buttons button:hover {
                    border-color: #333;
                    color: #333;
                }
                .class-search-filter .filter-buttons button.active {
                    background: #333;
                    border-color: #333;
                    color: #fff;
                }
            </style>

            <div class="row grid-pad">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 text-center">
                            <div class="class-search-filter">
                                <div class="search-input-wrap">
                                    <i class="fa fa-search"></i>
                                    <input type="text" id="classSearch" placeholder="Cari kelas...">
                                </div>
                                <div class="filter-buttons">
                                    <button type="button" class="filter-btn active" data-level="all">Semua</button>
                                    <button type="button" class="filter-btn" data-level="sd">SD</button>
                                    <button type="button" class="filter-btn" data-level="smp">SMP</button>
                                    <button type="button" class="filter-btn" data-level="sma">SMA</button>
                                    <button type="button" class="filter-btn" data-level="umum">Umum</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="class-grid">
                        @forelse($classes as $class)
                            <div class="col-md-4 col-sm-6 class-item"
                                 data-name="{{ strtolower($class->name) }}"
                                 data-description="{{ strtolower($class->description ?? '') }}"
                                 data-level="{{ $class->subcategory->grade_level ?? 'umum' }}">
                                <a href="{{ route('mindmap.show', $class->subcategory->slug) }}">
                                    <div style="position: relative; display: inline-block;">
                                        @if($class->cover_image)
                                            <img class="img-responsive center-block" src="{{ $class->cover_image_url }}" alt="{{ $class->name }}" style="max-width: 300px; height: 200px; object-fit: cover;">
                                        @else
                                            <img class="img-responsive center-block" src="{{ asset('frontend/img/main/0.jpg') }}" alt="{{ $class->name }}" style="max-width: 300px; height: 200px; object-fit: cover;">
                                        @endif
                                        <span class="label label-{{ $class->subcategory->grade_level == 'sd' ? 'primary' : ($class->subcategory->grade_level == 'smp' ? 'success' : ($class->subcategory->grade_level == 'sma' ? 'warning' : 'info')) }}" style="position: absolute; top: 10px; left: 10px; font-size: 12px; font-weight: bold;">
                                            {{ $class->subcategory->formatted_grade_level ?? 'UMUM' }}
                                        </span>
                                    </div>
                                    <h5>
                                        @if($class->subcategory->grade_level == 'sd')
                                            <i class="fa fa-calculator text-primary"></i>
                                        @elseif($class->subcategory->grade_level == 'smp')
                                            <i class="fa fa-atom text-success"></i>
                                        @elseif($class->subcategory->grade_level == 'sma')
                                            <i class="fa fa-flask text-warning"></i>
                                        @else
                                            <i class="fa fa-code text-info"></i>
                                        @endif
                                        {{ $class->name }}
                                    </h5>
                                </a>
                                <p>{{ Str::limit($class->description, 100) ?? 'Pelajari materi pembelajaran berkualitas dengan metode yang interaktif dan mudah dipahami.' }}</p>
                                <a class="btn btn-gray btn-xs" href="{{ route('mindmap.show', $class->subcategory->slug) }}">Lihat Alur Belajar</a>
                            </div>
                        @empty
                            <div class="col-sm-12">
                                <div class="alert alert-info text-center">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <h4>Belum Ada Kelas</h4>
                                    <p>Belum ada kelas yang tersedia saat ini. Silakan kembali lagi nanti.</p>
                                </div>
                            </div>
                        @endforelse

                        <div id="noResults" class="col-sm-12" style="display: none;">
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle fa-2x"></i>
                                <h4>Tidak Ada Kelas</h4>
                                <p>Tidak ada kelas yang cocok dengan pencarian Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('classSearch');
        var filterBtns = document.querySelectorAll('.filter-btn');
        var classItems = document.querySelectorAll('.class-item');
        var noResults = document.getElementById('noResults');
        var activeLevel = 'all';

        function filterClasses() {
            var term = searchInput.value.toLowerCase().trim();
            var visibleCount = 0;

            classItems.forEach(function(item) {
                var name = item.getAttribute('data-name') || '';
                var description = item.getAttribute('data-description') || '';
                var level = item.getAttribute('data-level') || 'umum';
                var matchSearch = term === '' || name.indexOf(term) !== -1 || description.indexOf(term) !== -1;
                var matchLevel = activeLevel === 'all' || level === activeLevel;

                if (matchSearch && matchLevel) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? '' : 'none';
        }

        searchInput.addEventListener('input', filterClasses);

        filterBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                filterBtns.forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeLevel = btn.getAttribute('data-level');
                filterClasses();
            });
        });
    });
    </script>
    <!-- Action Section-->
    <section class="section-small bg-gray2 action">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="no-pad">Siap Memulai?</h2>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <p class="no-pad">Bergabunglah dengan ribuan siswa yang telah meningkatkan kemampuan mereka melalui platform MindMap.</p>
                </div>
                <div class="col-md-2 col-md-offset-1">
                    <a class="btn btn-dark btn-lg" href="/register">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

@endsection
