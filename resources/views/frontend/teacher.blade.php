@extends('frontend.layouts.app')

@section('content')
    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Tim <span class="label classic">Pengajar</span><br>Profesional</h1>
                        <p class="lead">Bergabunglah dengan tim pengajar berpengalaman kami yang berdedikasi untuk membantu Anda mencapai potensi maksimal dalam pembelajaran</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Teachers Section -->
    <style>
        .teacher-row {
            display: flex;
            flex-wrap: wrap;
        }
        .teacher-col {
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
        }
        .teacher-col img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 4px;
        }
        @media (max-width: 767px) {
            .teacher-col img {
                height: auto;
                object-fit: contain;
            }
        }
        .teacher-col .teacher-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .teacher-search-filter {
            max-width: 600px;
            margin: 25px auto 10px;
        }
        .teacher-search-filter .search-input-wrap {
            position: relative;
            margin-bottom: 18px;
        }
        .teacher-search-filter .search-input-wrap input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.3s;
        }
        .teacher-search-filter .search-input-wrap input:focus {
            border-color: #333;
        }
        .teacher-search-filter .search-input-wrap i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
        }
        .filter-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .filter-buttons .filter-btn {
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
        .filter-buttons .filter-btn:hover {
            border-color: #333;
            color: #333;
        }
        .filter-buttons .filter-btn.active {
            background: #333;
            border-color: #333;
            color: #fff;
        }
        .no-results {
            padding: 50px 0;
            color: #999;
        }
        .no-results i {
            display: block;
            margin-bottom: 15px;
            color: #ddd;
        }
    </style>
    <section>
        <div class="container-fluid text-center wow fadeIn">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Pengajar Kami</h2>
                    <p>Tim pengajar MindMap terdiri dari profesional berpengalaman di bidangnya masing-masing</p>

                    <div class="teacher-search-filter">
                        <div class="search-input-wrap">
                            <i class="fas fa-search"></i>
                            <input type="text" id="teacherSearch" placeholder="Cari nama pengajar atau spesialisasi...">
                        </div>
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-category="all">Semua</button>
                            @php
                                $categories = $teachers->pluck('category')->unique()->filter()->sort();
                            @endphp
                            @foreach($categories as $cat)
                            <button class="filter-btn" data-category="{{ $cat }}">{{ ucfirst($cat) }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div id="teacherGrid">
                <div class="row teacher-row">
                    @foreach($teachers as $teacher)
                    <div class="col-md-2 col-md-offset-0 col-sm-6 teacher-col teacher-item"
                         data-name="{{ strtolower($teacher->name) }}"
                         data-specialization="{{ strtolower($teacher->specialization ?? '') }}"
                         data-category="{{ strtolower($teacher->category ?? '') }}">
                        <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                        <div class="teacher-content">
                            <div>
                                <h4>{{ $teacher->name }}</h4>
                                <ul class="list-inline">
                                    @if($teacher->twitter_url)
                                    <li><a href="{{ $teacher->twitter_url }}" target="_blank"><i class="fab fa-twitter fa-2x fa-fw"></i></a></li>
                                    @endif
                                    @if($teacher->linkedin_url)
                                    <li><a href="{{ $teacher->linkedin_url }}" target="_blank"><i class="fab fa-linkedin fa-2x fa-fw"></i></a></li>
                                    @endif
                                    @if($teacher->github_url)
                                    <li><a href="{{ $teacher->github_url }}" target="_blank"><i class="fab fa-github fa-2x fa-fw"></i></a></li>
                                    @endif
                                </ul>
                                <h4>{{ $teacher->specialization }}</h4>
                                <p>{{ Str::limit($teacher->description, 80) }}</p>
                            </div>
                            <a href="{{ route('teacher.show', $teacher->slug) }}" class="btn btn-dark-border btn-sm">Lihat Profil</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div id="noResults" class="no-results" style="display:none;">
                <i class="fas fa-user-slash fa-3x"></i>
                <p>Tidak ada pengajar yang sesuai dengan pencarian Anda.</p>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('teacherSearch');
        var filterBtns = document.querySelectorAll('.filter-btn');
        var teacherItems = document.querySelectorAll('.teacher-item');
        var noResults = document.getElementById('noResults');
        var activeCategory = 'all';

        function filterTeachers() {
            var searchTerm = searchInput.value.toLowerCase().trim();
            var visibleCount = 0;

            teacherItems.forEach(function(item) {
                var name = item.getAttribute('data-name');
                var specialization = item.getAttribute('data-specialization');
                var category = item.getAttribute('data-category');

                var matchesSearch = !searchTerm || name.indexOf(searchTerm) !== -1 || specialization.indexOf(searchTerm) !== -1;
                var matchesCategory = activeCategory === 'all' || category === activeCategory;

                if (matchesSearch && matchesCategory) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterTeachers);

        filterBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                filterBtns.forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeCategory = btn.getAttribute('data-category');
                filterTeachers();
            });
        });
    });
    </script>

    <!-- CTA Section -->
    <section class="bg-gray text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Bergabung Menjadi Pengajar</h2>
                    <p>Apakah Anda memiliki keahlian yang ingin dibagikan? Bergabunglah dengan tim pengajar MindMap dan berkontribusi dalam mencerdaskan bangsa.</p>
                    <a href="/contact" class="btn btn-dark-border">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

@endsection
