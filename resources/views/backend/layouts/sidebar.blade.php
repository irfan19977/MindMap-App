    <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="/" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="{{ asset('backend/assets/images/logo-full.png') }}" style="width: 200px;" alt="" class="logo logo-lg" />
                    <img src="{{ asset('backend/assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="nxl-navbar">
                    <li class="nxl-item nxl-caption">
                        <label>Main Menu</label>
                    </li>
                    <li class="nxl-item">
                        <a href="{{ route('dashboard.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-home"></i></span>
                            <span class="nxl-mtext">Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nxl-item nxl-caption">
                        <label>Konten Edukasi</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-folder"></i></span>
                            <span class="nxl-mtext">Kategori</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('categories.index') }}">Semua Kategori</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('categories.create') }}">Tambah Kategori</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-layers"></i></span>
                            <span class="nxl-mtext">Sub Kategori</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('subcategories.index') }}">Semua Sub Kategori</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('subcategories.create') }}">Tambah Sub Kategori</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-book-open"></i></span>
                            <span class="nxl-mtext">Materi</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('materis.index') }}">Semua Materi</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('materis.create') }}">Tambah Materi</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item">
                        <a class="nxl-link" href="{{ route('mindmap.index') }}">
                            <span class="nxl-micon"><i class="feather-git-branch"></i></span>
                            <span class="nxl-mtext">MindMap</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-activity"></i></span>
                            <span class="nxl-mtext">Hasil Pembelajaran</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('learning-results.index') }}">Tracking Siswa</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('learning-results.quizzes') }}">Hasil Quiz</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-caption">
                        <label>Laporan & Analitik</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-bar-chart-2"></i></span>
                            <span class="nxl-mtext">Report</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('reports.users') }}">Laporan User</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('reports.mindmaps') }}">Laporan MindMap</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('reports.activities') }}">Laporan Aktivitas</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-trending-up"></i></span>
                            <span class="nxl-mtext">Analitik</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="analytics-dashboard.html">Dashboard Analitik</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="analytics-learning.html">Analitik Pembelajaran</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('engagement.index') }}">Analitik Engagement</a></li>
                        </ul>
                    </li>
                    
                    <li class="nxl-item nxl-caption">
                        <label>Manajemen Pengguna</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">Manajemen User</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('users.index') }}">Semua User</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('users.create') }}">Tambah User</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-shield"></i></span>
                            <span class="nxl-mtext">Manajemen Role</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('roles.index') }}">Semua Role</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('roles.create') }}">Tambah Role</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-key"></i></span>
                            <span class="nxl-mtext">Manajemen Permission</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('permissions.index') }}">Semua Permission</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('permissions.create') }}">Tambah Permission</a></li>
                        </ul>
                    </li>
                        <li class="nxl-item nxl-caption">
                        <label>Bantuan</label>
                    </li>
                    <li class="nxl-item">
                        <a href="{{ route('help.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-help-circle"></i></span>
                            <span class="nxl-mtext">Pusat Bantuan</span>
                        </a>
                    </li>
                    <li class="nxl-item">
                        <form action="{{ route('logout') }}" method="POST" id="sidebar-logout-form">
                            @csrf
                            <a href="javascript:void(0)" class="nxl-link" onclick="document.getElementById('sidebar-logout-form').submit()">
                                <span class="nxl-micon"><i class="feather-log-out"></i></span>
                                <span class="nxl-mtext">Keluar</span>
                            </a>
                        </form>
                    </li>
                </ul>
                <div class="card text-center">
                    <div class="card-body">
                        <i class="feather-book-open fs-4 text-primary"></i>
                        <h6 class="mt-4 text-dark fw-bolder">MindMap Education</h6>
                        <p class="fs-11 my-3 text-dark">Platform pembelajaran interaktif dengan mind mapping untuk pengalaman belajar yang lebih baik.</p>
                        <a href="{{ route('help.index') }}" class="btn btn-primary w-100">Bantuan</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>