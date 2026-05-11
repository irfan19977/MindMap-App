    <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="index.html" class="b-brand">
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
                            <span class="nxl-micon"><i class="feather-book-open"></i></span>
                            <span class="nxl-mtext">Materi</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('materis.index') }}">Semua Materi</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('materis.create') }}">Tambah Materi</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-git-branch"></i></span>
                            <span class="nxl-mtext">MindMap</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="mindmaps.html">Semua MindMap</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="mindmaps-create.html">Buat MindMap</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="mindmaps-editor.html">Editor MindMap</a></li>
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
                            <li class="nxl-item"><a class="nxl-link" href="reports-users.html">Laporan User</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="reports-mindmaps.html">Laporan MindMap</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="reports-activities.html">Laporan Aktivitas</a></li>
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
                            <li class="nxl-item"><a class="nxl-link" href="analytics-engagement.html">Analitik Engagement</a></li>
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
                            <li class="nxl-item"><a class="nxl-link" href="users.html">Semua User</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="users-create.html">Tambah User</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-shield"></i></span>
                            <span class="nxl-mtext">Manajemen Role</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="roles.html">Semua Role</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="roles-create.html">Tambah Role</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-key"></i></span>
                            <span class="nxl-mtext">Manajemen Permission</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="permissions.html">Semua Permission</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="permissions-create.html">Tambah Permission</a></li>
                        </ul>
                    </li>
                    
                    <li class="nxl-item nxl-caption">
                        <label>Pengaturan</label>
                    </li>
                    <li class="nxl-item">
                        <a href="settings.html" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-settings"></i></span>
                            <span class="nxl-mtext">Pengaturan</span>
                        </a>
                    </li>
                    <li class="nxl-item">
                        <a href="profile.html" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">Profil Saya</span>
                        </a>
                    </li>
                        <li class="nxl-item nxl-caption">
                        <label>Bantuan</label>
                    </li>
                    <li class="nxl-item">
                        <a href="help.html" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-help-circle"></i></span>
                            <span class="nxl-mtext">Pusat Bantuan</span>
                        </a>
                    </li>
                    <li class="nxl-item">
                        <a href="login.html" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-log-out"></i></span>
                            <span class="nxl-mtext">Keluar</span>
                        </a>
                    </li>
                </ul>
                <div class="card text-center">
                    <div class="card-body">
                        <i class="feather-book-open fs-4 text-primary"></i>
                        <h6 class="mt-4 text-dark fw-bolder">MindMap Education</h6>
                        <p class="fs-11 my-3 text-dark">Platform pembelajaran interaktif dengan mind mapping untuk pengalaman belajar yang lebih baik.</p>
                        <a href="help.html" class="btn btn-primary w-100">Bantuan</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>