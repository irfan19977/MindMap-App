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
            <div class="row grid-pad">
                <div class="col-md-8">
                    <div class="row" id="class-grid">
                        @forelse($classes as $class)
                            <div class="col-sm-6 class-item" data-level="{{ $class->subcategory->grade_level ?? 'umum' }}">
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
                    </div>
                </div>

                <div class="col-md-3 col-md-offset-1">
                    <form class="form-inline subscribe-form" action="#" method="post">
                        <div class="input-group input-group-lg">
                            <input class="form-control" type="search" name="search" placeholder="Cari kelas...">
                            <span class="input-group-btn">
                                <button class="btn btn-dark" type="submit" name="search"><i class="fa fa-search fa-lg"></i></button>
                            </span>
                        </div>
                    </form>

                    <hr>
                    <h4>Kategori Pembelajaran</h4>
                    <ul class="list-unstyled">
                        @php
                            $uniqueCategories = $classes->pluck('category')->unique('id')->filter();
                        @endphp
                        @forelse($uniqueCategories as $cat)
                            <li>
                                <a href="{{ route('mindmap.show', $cat->slug) }}">
                                    @if($cat->grade_level == 'sd')
                                        <i class="fa fa-calculator text-primary"></i>
                                    @elseif($cat->grade_level == 'smp')
                                        <i class="fa fa-atom text-success"></i>
                                    @elseif($cat->grade_level == 'sma')
                                        <i class="fa fa-flask text-warning"></i>
                                    @else
                                        <i class="fa fa-code text-info"></i>
                                    @endif
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="javascript:void(0);"><i class="fa fa-info-circle"></i> Belum ada kategori</a></li>
                        @endforelse
                    </ul>

                    <hr>
                    <h4>Level Pembelajaran</h4>
                    <ul class="list-unstyled">
                        <li>
                            <a href="javascript:void(0);" onclick="filterByLevel('sd')">
                                <span class="label label-success">SD</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="filterByLevel('smp')">
                                <span class="label label-warning">SMP</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="filterByLevel('sma')">
                                <span class="label label-danger">SMA</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="filterByLevel('umum')">
                                <span class="label label-info">UMUM</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="showAllClasses()">
                                <span class="label label-default">Semua Level</span>
                            </a>
                        </li>
                    </ul>

                    <hr>
                    <h4>Subscribe</h4>
                    <p>Dapatkan informasi kelas terbaru dan penawaran khusus.</p>
                    <form class="form-inline subscribe-form" id="mc-embedded-subscribe-form" action="#" method="post" name="mc-embedded-subscribe-form" target="_blank" novalidate="">
                        <div class="input-group input-group-lg">
                            <input class="form-control" id="mce-EMAIL" type="email" name="EMAIL" placeholder="Email address...">
                            <span class="input-group-btn">
                                <button class="btn btn-dark" id="mc-embedded-subscribe" type="submit" name="subscribe">Subscribe</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Pagination-->
    <div class="section section-small bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <nav>
                        <ul class="pagination">
                            <li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">&middot;&middot;&middot;</a><a href="#">38</a></li>
                            <li><a href="#" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
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

<script>
function filterByLevel(level) {
    const items = document.querySelectorAll('.class-item');
    const contentArea = document.getElementById('class-grid');
    let visibleCount = 0;

    items.forEach(item => {
        if (item.dataset.level === level) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    if (visibleCount === 0) {
        contentArea.innerHTML = `
            <div class="col-sm-12">
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle fa-2x"></i>
                    <h4>Tidak Ada Kelas</h4>
                    <p>Belum ada kelas untuk level ${level.toUpperCase()} saat ini.</p>
                </div>
            </div>
        `;
    }

    document.getElementById('kelas').scrollIntoView({ behavior: 'smooth' });
}

function showAllClasses() {
    location.reload();
}
</script>
@endsection
