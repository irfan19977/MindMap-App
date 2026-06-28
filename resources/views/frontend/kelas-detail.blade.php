@extends('frontend.layouts.app')

@section('title', $category->name . ' - Kelas Pembelajaran')

@section('content')
    <!-- Header Section -->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="overlay"></div>
        <div class="intro-body">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="{{ route('kelas.index') }}">Kelas</a></li>
                    @if($category->parent)
                        <li><a href="{{ route('kelas.show', $category->parent->slug) }}">{{ $category->parent->name }}</a></li>
                    @endif
                    <li class="active">{{ $category->name }}</li>
                </ol>
                
                <h1>
                    @if($category->grade_level == 'sd')
                        <i class="fa fa-calculator text-primary"></i>
                    @elseif($category->grade_level == 'smp')
                        <i class="fa fa-atom text-success"></i>
                    @elseif($category->grade_level == 'sma')
                        <i class="fa fa-flask text-warning"></i>
                    @else
                        <i class="fa fa-code text-info"></i>
                    @endif
                    {{ $category->name }}
                </h1>
                
                <div class="course-meta">
                    <span class="label label-primary">
                        <i class="fa fa-graduation-cap"></i> 
                        {{ $category->formatted_grade_level }}
                    </span>
                    @if($category->is_free)
                        <span class="label label-success"><i class="fa fa-gift"></i> Gratis</span>
                    @else
                        <span class="label label-warning"><i class="fa fa-money"></i> Berbayar</span>
                    @endif
                    @if($category->is_featured)
                        <span class="label label-danger"><i class="fa fa-star"></i> Featured</span>
                    @endif
                    @if($category->parent)
                        <span class="label label-info"><i class="fa fa-folder"></i> {{ $category->parent->name }}</span>
                    @endif
                </div>
                
                <p>{{ $category->description ?? 'Pelajari materi pembelajaran berkualitas dengan metode yang interaktif dan mudah dipahami.' }}</p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="section-small">
        <div class="container">
            <div class="row">
                <!-- Left Content -->
                <div class="col-md-8">
                    <!-- Course Overview -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-info-circle text-primary"></i> Tentang Kelas
                            </h3>
                        </div>
                        <div class="panel-body">
                            <p>{{ $category->description ?? 'Tidak ada deskripsi tersedia untuk kelas ini.' }}</p>
                            
                            @if($category->children && $category->children->count() > 0)
                                <h4>Pilih Tingkatan:</h4>
                                <div class="row">
                                    @php
                                        $groupedChildren = $category->children->groupBy('grade_level');
                                        $gradeLabels = [
                                            'sd' => ['SD', 'fa-child', 'primary'],
                                            'smp' => ['SMP', 'fa-users', 'info'],
                                            'sma' => ['SMA', 'fa fa-graduation-cap', 'warning'],
                                            'umum' => ['Umum', 'fa-globe', 'success']
                                        ];
                                    @endphp
                                    @foreach($gradeLabels as $level => $labelInfo)
                                        @if(isset($groupedChildren[$level]))
                                            <div class="col-sm-6" style="margin-bottom: 15px;">
                                                <div class="panel panel-{{ $labelInfo[2] }}">
                                                    <div class="panel-heading text-center">
                                                        <h4><i class="{{ $labelInfo[1] }}"></i> {{ $labelInfo[0] }}</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="list-unstyled">
                                                            @foreach($groupedChildren[$level] as $child)
                                                                <li style="margin-bottom: 10px;">
                                                                    <a href="{{ route('mindmap.show', $child->slug) }}" class="text-{{ $labelInfo[2] }}">
                                                                        <strong>{{ $child->name }}</strong>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($category->parent && $category->parent->children->count() > 1)
                                <h4>Pilih Tingkatan Lain:</h4>
                                <div class="row">
                                    @foreach($category->parent->children as $sibling)
                                        @if($sibling->id != $category->id)
                                            <div class="col-sm-6" style="margin-bottom: 15px;">
                                                <div class="panel panel-{{ $sibling->grade_level == 'sd' ? 'primary' : ($sibling->grade_level == 'smp' ? 'info' : ($sibling->grade_level == 'sma' ? 'warning' : 'success')) }}">
                                                    <div class="panel-heading text-center">
                                                        <h4>
                                                            @if($sibling->grade_level == 'sd')
                                                                <i class="fa fa-child"></i> SD
                                                            @elseif($sibling->grade_level == 'smp')
                                                                <i class="fa fa-users"></i> SMP
                                                            @elseif($sibling->grade_level == 'sma')
                                                                <i class="fa fa-graduation-cap"></i> SMA
                                                            @else
                                                                <i class="fa fa-globe"></i> Umum
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    <div class="panel-body text-center">
                                                        <p>{{ $sibling->name }}</p>
                                                        <a href="{{ route('mindmap.show', $sibling->slug) }}" class="btn btn-{{ $sibling->grade_level == 'sd' ? 'primary' : ($sibling->grade_level == 'smp' ? 'info' : ($sibling->grade_level == 'sma' ? 'warning' : 'success')) }}">Pilih {{ strtoupper($sibling->grade_level) }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($category->parent)
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    <p>Ini adalah satu-satunya tingkatan yang tersedia untuk kategori <strong>{{ $category->parent->name }}</strong>.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Curriculum Overview -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-list text-primary"></i> Kurikulum
                            </h3>
                        </div>
                        <div class="panel-body">
                            @if($category->children && $category->children->count() > 0)
                                <div class="panel-group" id="curriculum-accordion">
                                    @foreach($category->children as $child)
                                        <div class="panel panel-{{ $child->grade_level == 'sd' ? 'primary' : ($child->grade_level == 'smp' ? 'info' : ($child->grade_level == 'sma' ? 'warning' : 'success')) }}">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#curriculum-accordion" href="#curriculum-{{ $child->id }}" class="text-{{ $child->grade_level == 'sd' ? 'primary' : ($child->grade_level == 'smp' ? 'info' : ($child->grade_level == 'sma' ? 'warning' : 'success')) }}" style="text-decoration: none;">
                                                        @if($child->grade_level == 'sd')
                                                            <i class="fa fa-child"></i>
                                                        @elseif($child->grade_level == 'smp')
                                                            <i class="fa fa-users"></i>
                                                        @elseif($child->grade_level == 'sma')
                                                            <i class="fa fa-graduation-cap"></i>
                                                        @else
                                                            <i class="fa fa-globe"></i>
                                                        @endif
                                                        {{ $child->name }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="curriculum-{{ $child->id }}" class="panel-collapse collapse {{ $loop->first ? 'in' : '' }}">
                                                <div class="panel-body">
                                                    @if($child->curriculum)
                                                        <div class="curriculum-content">
                                                            {!! $child->curriculum !!}
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning">
                                                            <i class="fa fa-exclamation-triangle"></i>
                                                            <p>Kurikulum untuk {{ $child->name }} belum tersedia.</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($category->curriculum)
                                <div class="curriculum-content">
                                    {!! $category->curriculum !!}
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    <p>Kurikulum untuk kelas ini belum tersedia. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-clipboard-list text-primary"></i> Persyaratan Umum
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li><i class="fa fa-chevron-right text-primary"></i> Usia disesuaikan dengan tingkatan yang dipilih</li>
                                <li><i class="fa fa-chevron-right text-primary"></i> Memiliki perangkat (laptop/tablet/smartphone) untuk akses materi</li>
                                <li><i class="fa fa-chevron-right text-primary"></i> Koneksi internet yang stabil</li>
                                <li><i class="fa fa-chevron-right text-primary"></i> Buku tulis dan alat tulis untuk latihan</li>
                                <li><i class="fa fa-chevron-right text-primary"></i> Kalkulator (untuk tingkatan SMP ke atas)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="col-md-4">
                    <!-- Course Info Card -->
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <h2 class="text-success">GRATIS</h2>
                            
                            <button class="btn btn-primary btn-lg btn-block">
                                <i class="fa fa-play-circle"></i> Mulai Belajar
                            </button>
                            
                            <button class="btn btn-default btn-lg btn-block">
                                <i class="fa fa-heart"></i> Simpan Kelas
                            </button>
                            
                            <hr>
                            
                            <div class="course-stats">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-clock-o text-primary"></i>
                                        <strong>8 Minggu</strong>
                                        <div class="text-muted small">Durasi kelas</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <i class="fa fa-signal text-primary"></i>
                                        <strong>SD</strong>
                                        <div class="text-muted small">Tingkat kesulitan</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-certificate text-primary"></i>
                                        <strong>Sertifikat</strong>
                                        <div class="text-muted small">Setelah kelulusan</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <i class="fa fa-users text-primary"></i>
                                        <strong>1,234</strong>
                                        <div class="text-muted small">Peserta terdaftar</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Courses -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-bookmark text-primary"></i> Kelas Terkait
                            </h4>
                        </div>
                        <div class="panel-body">
                            @forelse($relatedCategories as $related)
                                <a href="{{ route('kelas.show', $related->slug) }}" class="list-group-item">
                                    <h6>
                                        @if($related->grade_level == 'sd')
                                            <i class="fa fa-calculator text-primary"></i>
                                        @elseif($related->grade_level == 'smp')
                                            <i class="fa fa-atom text-success"></i>
                                        @elseif($related->grade_level == 'sma')
                                            <i class="fa fa-flask text-warning"></i>
                                        @else
                                            <i class="fa fa-code text-info"></i>
                                        @endif
                                        {{ $related->name }}
                                    </h6>
                                    <small>{{ $related->formatted_grade_level }}</small>
                                    @if($related->parent)
                                        <small class="text-muted"> • {{ $related->parent->name }}</small>
                                    @endif
                                </a>
                            @empty
                                <div class="text-center text-muted">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <p>Belum ada kelas terkait</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
