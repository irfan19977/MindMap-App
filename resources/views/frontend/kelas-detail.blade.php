@extends('frontend.layouts.app')

@section('title', $class->name . ' - Kelas MindMap')

@section('content')
    <!-- Header Section -->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="overlay"></div>
        <div class="intro-body">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="{{ route('kelas.index') }}">Kelas</a></li>
                    <li class="active">{{ $class->name }}</li>
                </ol>

                <h1>
                    <i class="fa fa-{{ $class->subcategory->grade_level == 'sd' ? 'child' : ($class->subcategory->grade_level == 'smp' ? 'users' : ($class->subcategory->grade_level == 'sma' ? 'graduation-cap' : 'globe')) }} text-{{ $class->subcategory->grade_level == 'sd' ? 'primary' : ($class->subcategory->grade_level == 'smp' ? 'success' : ($class->subcategory->grade_level == 'sma' ? 'warning' : 'info')) }}"></i>
                    {{ $class->name }}
                </h1>

                <div class="course-meta">
                    <span class="label label-primary"><i class="fa fa-folder"></i> {{ $class->category->name ?? '-' }}</span>
                    <span class="label label-{{ $class->subcategory->grade_level == 'sd' ? 'primary' : ($class->subcategory->grade_level == 'smp' ? 'success' : ($class->subcategory->grade_level == 'sma' ? 'warning' : 'info')) }}">
                        <i class="fa fa-graduation-cap"></i> {{ $class->subcategory->formatted_grade_level ?? 'Umum' }}
                    </span>
                    <span class="label label-info"><i class="fa fa-book"></i> {{ $class->materials->count() }} Materi</span>
                </div>

                <p>{{ $class->description ?? 'Belajar dengan alur terstruktur melalui mindmap interaktif.' }}</p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="section-small">
        <div class="container">
            <div class="row">
                <!-- Left Content -->
                <div class="col-md-8">
                    <!-- Materi Kelas -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-list text-primary"></i> Materi Kelas</h3>
                        </div>
                        <div class="panel-body">
                            @if($class->materials->count() > 0)
                                <div class="list-group">
                                    @foreach($class->materials as $index => $material)
                                        <a href="{{ route('materi.show', $material->slug) }}" class="list-group-item">
                                            <span class="badge bg-primary">{{ $index + 1 }}</span>
                                            <h4 class="list-group-item-heading">{{ $material->title }}</h4>
                                            <p class="list-group-item-text">{{ Str::limit($material->description, 80) }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    <p>Belum ada materi di kelas ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle text-primary"></i> Tentang Kelas</h3>
                        </div>
                        <div class="panel-body">
                            <p>{{ $class->description ?? 'Tidak ada deskripsi untuk kelas ini.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <img src="{{ $class->cover_image_url }}" alt="{{ $class->name }}" class="img-responsive center-block" style="max-height: 180px; object-fit: cover; margin-bottom: 15px;">

                            @auth
                                @if($enrollment)
                                    @if($enrollment->status === 'pending')
                                        <button class="btn btn-warning btn-lg btn-block" disabled>
                                            <i class="fa fa-clock-o"></i> Menunggu Persetujuan
                                        </button>
                                    @elseif($enrollment->status === 'active' || $enrollment->status === 'completed')
                                        <a href="{{ route('mindmap.show', $class->subcategory->slug) }}" class="btn btn-success btn-lg btn-block">
                                            <i class="fa fa-play-circle"></i> Mulai Belajar
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('kelas.join', $class->slug) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                <i class="fa fa-sign-in"></i> Gabung Kelas
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('kelas.join', $class->slug) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            <i class="fa fa-sign-in"></i> Gabung Kelas
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block">
                                    <i class="fa fa-sign-in"></i> Login untuk Gabung
                                </a>
                            @endauth

                            <hr>

                            <div class="course-stats">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-user text-primary"></i>
                                        <strong>{{ $class->teacher->name ?? '-' }}</strong>
                                        <div class="text-muted small">Pengajar</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <i class="fa fa-book text-primary"></i>
                                        <strong>{{ $class->materials->count() }}</strong>
                                        <div class="text-muted small">Materi</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-folder text-primary"></i>
                                        <strong>{{ $class->category->name ?? '-' }}</strong>
                                        <div class="text-muted small">Kategori</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <i class="fa fa-graduation-cap text-primary"></i>
                                        <strong>{{ $class->subcategory->formatted_grade_level ?? 'Umum' }}</strong>
                                        <div class="text-muted small">Jenjang</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
