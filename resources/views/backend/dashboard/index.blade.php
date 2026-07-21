@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ __('messages.backend_dashboard') }}</h5>
                    </div>
                    <ul class="breadcrumb">
<<<<<<< HEAD
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.backend_home') }}</a></li>
=======
                        <li class="breadcrumb-item"><a href="index.php">{{ __('messages.backend_home') }}</a></li>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                        <li class="breadcrumb-item">{{ __('messages.backend_dashboard') }}</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>{{ __('messages.backend_back') }}</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
<<<<<<< HEAD
                            <div class="dropdown">
                                <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown">
                                    <i class="feather-calendar me-2"></i>
                                    <span>Last {{ $period }} Days</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('dashboard.index') }}?period=7" class="dropdown-item">Last 7 Days</a>
                                    <a href="{{ route('dashboard.index') }}?period=30" class="dropdown-item">Last 30 Days</a>
                                    <a href="{{ route('dashboard.index') }}?period=90" class="dropdown-item">Last 90 Days</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown">
                                    <i class="feather-zap me-2"></i>
                                    <span>Aksi Cepat</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('categories.create') }}" class="dropdown-item">
                                        <i class="feather-folder-plus me-2 text-primary"></i>Tambah Kategori
                                    </a>
                                    <a href="{{ route('materis.create') }}" class="dropdown-item">
                                        <i class="feather-file-plus me-2 text-success"></i>Tambah Materi
                                    </a>
                                    <a href="{{ route('mindmap.index') }}" class="dropdown-item">
                                        <i class="feather-git-branch me-2 text-warning"></i>Kelola MindMap
                                    </a>
                                    <hr class="my-1">
                                    <a href="{{ route('learning-results.index') }}" class="dropdown-item">
                                        <i class="feather-activity me-2 text-danger"></i>Hasil Pembelajaran
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-md btn-primary" data-bs-toggle="dropdown">
                                    <i class="feather-download me-2"></i>
                                    <span>Export</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('engagement.export', ['type' => 'users', 'format' => 'csv']) }}" class="dropdown-item">
                                        <i class="feather-users me-2"></i>Users (CSV)
                                    </a>
                                    <a href="{{ route('engagement.export', ['type' => 'categories', 'format' => 'csv']) }}" class="dropdown-item">
                                        <i class="feather-folder me-2"></i>Categories (CSV)
                                    </a>
                                    <a href="{{ route('engagement.export', ['type' => 'analytics', 'format' => 'csv']) }}" class="dropdown-item">
                                        <i class="feather-file-text me-2"></i>Analytics (CSV)
                                    </a>
                                    <a href="{{ route('engagement.export', ['type' => 'analytics', 'format' => 'json']) }}" class="dropdown-item">
                                        <i class="feather-code me-2"></i>Analytics (JSON)
=======
                            <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                                <span class="reportrange-picker-field"></span>
                            </div>
                            <div class="dropdown filter-dropdown">
                                <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10" data-bs-auto-close="outside">
                                    <i class="feather-filter me-2"></i>
                                    <span>{{ __('messages.backend_filter') }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="dropdown-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Role" checked="checked" />
                                            <label class="custom-control-label c-pointer" for="Role">{{ __('messages.backend_filter_role') }}</label>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Team" checked="checked" />
                                            <label class="custom-control-label c-pointer" for="Team">{{ __('messages.backend_filter_team') }}</label>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Email" checked="checked" />
                                            <label class="custom-control-label c-pointer" for="Email">{{ __('messages.backend_filter_email') }}</label>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Member" checked="checked" />
                                            <label class="custom-control-label c-pointer" for="Member">{{ __('messages.backend_filter_member') }}</label>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Recommendation" checked="checked" />
                                            <label class="custom-control-label c-pointer" for="Recommendation">{{ __('messages.backend_filter_recommendation') }}</label>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-plus me-3"></i>
                                        <span>{{ __('messages.backend_create_new') }}</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-filter me-3"></i>
                                        <span>{{ __('messages.backend_manage_filter') }}</span>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <!-- Summary Stats Row -->
                <div class="row">
                    <!-- Total Users -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
<<<<<<< HEAD
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded">
                                        <i class="feather-users fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalUsers }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Total Pengguna</h3>
=======
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-gray-200">
                                            <i class="feather-dollar-sign"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark"><span class="counter">45</span>/<span class="counter">76</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">{{ __('messages.backend_invoices_awaiting') }}</h3>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
<<<<<<< HEAD
                                        <span class="fs-12 text-muted">Siswa: {{ $totalStudents }}</span>
                                        <span class="fs-12 text-muted">Guru: {{ $totalTeachers }}</span>
=======
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">{{ __('messages.backend_invoices_awaiting') }} </a>
                                        <div class="w-100 text-end">
                                            <span class="fs-12 text-dark">$5,569</span>
                                            <span class="fs-11 text-muted">(56%)</span>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        @php $studentPercent = $totalUsers > 0 ? round(($totalStudents / $totalUsers) * 100) : 0; @endphp
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $studentPercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Materi -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
<<<<<<< HEAD
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-success text-success rounded">
                                        <i class="feather-book-open fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalMaterials }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Total Materi</h3>
=======
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-gray-200">
                                            <i class="feather-cast"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark"><span class="counter">48</span>/<span class="counter">86</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">{{ __('messages.backend_converted_leads') }}</h3>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
<<<<<<< HEAD
                                        <span class="fs-12 text-muted">{{ $totalCategories }} Kategori</span>
                                        <span class="fs-12 text-muted">{{ $totalSubcategories }} Sub Kategori</span>
=======
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">{{ __('messages.backend_converted_leads') }} </a>
                                        <div class="w-100 text-end">
                                            <span class="fs-12 text-dark">52 {{ __('messages.backend_completed') }}</span>
                                            <span class="fs-11 text-muted">(63%)</span>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MindMap -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
<<<<<<< HEAD
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded">
                                        <i class="feather-git-branch fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalMindmaps }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Total MindMap</h3>
=======
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-gray-200">
                                            <i class="feather-briefcase"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark"><span class="counter">16</span>/<span class="counter">20</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">{{ __('messages.backend_projects_progress') }}</h3>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
<<<<<<< HEAD
                                        <span class="fs-12 text-muted">Materi aktif</span>
                                        <span class="fs-12 text-dark fw-semibold">{{ $totalMindmaps }} mindmap</span>
=======
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">{{ __('messages.backend_projects_progress') }} </a>
                                        <div class="w-100 text-end">
                                            <span class="fs-12 text-dark">16 {{ __('messages.backend_completed') }}</span>
                                            <span class="fs-11 text-muted">(78%)</span>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Aktivitas Belajar -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
<<<<<<< HEAD
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded">
                                        <i class="feather-activity fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalProgress }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Aktivitas Belajar</h3>
=======
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-gray-200">
                                            <i class="feather-activity"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark"><span class="counter">46.59</span>%</div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">{{ __('messages.backend_conversion_rate') }}</h3>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
<<<<<<< HEAD
                                        <span class="fs-12 text-muted">Selesai: {{ $completedMaterials }}</span>
                                        @php $completionRate = $totalProgress > 0 ? round(($completedMaterials / $totalProgress) * 100) : 0; @endphp
                                        <span class="fs-12 text-dark fw-semibold">{{ $completionRate }}%</span>
=======
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line"> {{ __('messages.backend_conversion_rate') }} </a>
                                        <div class="w-100 text-end">
                                            <span class="fs-12 text-dark">$2,254</span>
                                            <span class="fs-11 text-muted">(46%)</span>
                                        </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Aktivitas Platform -->
                <div class="row">
                    <div class="col-xxl-8">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
<<<<<<< HEAD
                                <h5 class="card-title">Aktivitas Platform</h5>
=======
                                <h5 class="card-title">{{ __('messages.backend_payment_record') }}</h5>
                                <div class="card-header-action">
                                    <div class="card-header-btn">
                                        <div data-bs-toggle="tooltip" title="Delete">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"> </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Refresh">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"> </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                            <div data-bs-toggle="tooltip" title="Options">
                                                <i class="feather-more-vertical"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-at-sign"></i>New</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-calendar"></i>Event</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-bell"></i>Snoozed</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-trash-2"></i>Deleted</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-settings"></i>Settings</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-life-buoy"></i>Tips & Tricks</a>
                                        </div>
                                    </div>
                                </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div id="platform-activity-chart"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <div class="p-3 border border-dashed rounded">
<<<<<<< HEAD
                                            <div class="fs-12 text-muted mb-1">Kunjungan Hari Ini</div>
                                            <h6 class="fw-bold text-dark">{{ $todayVisits }}</h6>
=======
                                            <div class="fs-12 text-muted mb-1">{{ __('messages.backend_awaiting') }}</div>
                                            <h6 class="fw-bold text-dark">$5,486</h6>
                                            <div class="progress mt-2 ht-3">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 81%"></div>
                                            </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="p-3 border border-dashed rounded">
<<<<<<< HEAD
                                            <div class="fs-12 text-muted mb-1">Kunjungan ({{ $period }} hari)</div>
                                            <h6 class="fw-bold text-dark">{{ $platformChart->sum('visits') }}</h6>
=======
                                            <div class="fs-12 text-muted mb-1">{{ __('messages.backend_completed') }}</div>
                                            <h6 class="fw-bold text-dark">$9,275</h6>
                                            <div class="progress mt-2 ht-3">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 82%"></div>
                                            </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="p-3 border border-dashed rounded">
<<<<<<< HEAD
                                            <div class="fs-12 text-muted mb-1">Pendaftaran ({{ $period }} hari)</div>
                                            <h6 class="fw-bold text-dark">{{ $platformChart->sum('registrations') }}</h6>
=======
                                            <div class="fs-12 text-muted mb-1">{{ __('messages.backend_rejected') }}</div>
                                            <h6 class="fw-bold text-dark">$3,868</h6>
                                            <div class="progress mt-2 ht-3">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 68%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="fs-12 text-muted mb-1">{{ __('messages.backend_revenue') }}</div>
                                            <h6 class="fw-bold text-dark">$50,668</h6>
                                            <div class="progress mt-2 ht-3">
                                                <div class="progress-bar bg-dark" role="progressbar" style="width: 75%"></div>
                                            </div>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                    <!-- Statistik Quiz -->
                    <div class="col-xxl-4">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Statistik Quiz</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="text-center flex-fill">
                                        <div class="fs-3 fw-bold text-primary">{{ $totalQuizAttempts }}</div>
                                        <div class="fs-12 text-muted">Total Percobaan</div>
                                    </div>
                                    <div class="text-center flex-fill">
                                        <div class="fs-3 fw-bold text-success">{{ $quizPassedCount }}</div>
                                        <div class="fs-12 text-muted">Lulus</div>
                                    </div>
                                    <div class="text-center flex-fill">
                                        <div class="fs-3 fw-bold text-warning">{{ number_format($averageScore, 1) }}%</div>
                                        <div class="fs-12 text-muted">Rata-rata Skor</div>
=======
                    <!-- [Payment Records] end -->
                    <!-- [Total Sales] start -->
                    <div class="col-xxl-4">
                        <div class="card stretch stretch-full overflow-hidden">
                            <div class="bg-primary text-white">
                                <div class="p-4">
                                    <span class="badge bg-light text-primary text-dark float-end">12%</span>
                                    <div class="text-start">
                                        <h4 class="text-reset">30,569</h4>
                                        <p class="text-reset m-0">{{ __('messages.backend_total_sales') }}</p>
                                    </div>
                                </div>
                                <div id="total-sales-color-graph"></div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="hstack gap-3">
                                        <div class="avatar-image avatar-lg p-2 rounded">
                                            <img class="img-fluid" src="{{ asset('backend/assets/images/brand/shopify.png') }}" alt="" />
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="d-block">Shopify eCommerce Store</a>
                                            <span class="fs-12 text-muted">{{ __('messages.backend_project_development') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">$1200</div>
                                        <div class="fs-12 text-end">6 {{ __('messages.backend_project_count') }}</div>
                                    </div>
                                </div>
                                <hr class="border-dashed my-3" />
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="hstack gap-3">
                                        <div class="avatar-image avatar-lg p-2 rounded">
                                            <img class="img-fluid" src="{{ asset('backend/assets/images/brand/app-store.png') }}" alt="" />
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="d-block">iOS Apps Development</a>
                                            <span class="fs-12 text-muted">{{ __('messages.backend_project_development') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">$1450</div>
                                        <div class="fs-12 text-end">3 {{ __('messages.backend_project_count') }}</div>
                                    </div>
                                </div>
                                <hr class="border-dashed my-3" />
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="hstack gap-3">
                                        <div class="avatar-image avatar-lg p-2 rounded">
                                            <img class="img-fluid" src="{{ asset('backend/assets/images/brand/figma.png') }}" alt="" />
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="d-block">Figma Dashboard Design</a>
                                            <span class="fs-12 text-muted">{{ __('messages.backend_project_ui_ux') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">$1250</div>
                                        <div class="fs-12 text-end">5 {{ __('messages.backend_project_count') }}</div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="card-footer fs-11 fw-bold text-uppercase text-center py-4">{{ __('messages.backend_full_details') }}</a>
                        </div>
                    </div>
                    <!-- [Total Sales] end !-->
                    <!-- [Mini] start -->
                    <div class="col-lg-4">
                        <div class="card mb-4 stretch stretch-full">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="avatar-text">
                                        <i class="feather feather-star"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ __('messages.backend_tasks_completed') }}</div>
                                        <div class="fs-12 text-muted">22/35 completed</div>
                                    </div>
                                </div>
                                <div class="fs-4 fw-bold text-dark">22/35</div>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-between gap-4">
                                <div id="task-completed-area-chart"></div>
                                <div class="fs-12 text-muted text-nowrap">
                                    <span class="fw-semibold text-primary">28% more</span><br />
                                    <span>{{ __('messages.backend_from_last_week') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4 stretch stretch-full">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="avatar-text">
                                        <i class="feather feather-file-text"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ __('messages.backend_new_tasks') }}</div>
                                        <div class="fs-12 text-muted">0/20 tasks</div>
                                    </div>
                                </div>
                                <div class="fs-4 fw-bold text-dark">5/20</div>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-between gap-4">
                                <div id="new-tasks-area-chart"></div>
                                <div class="fs-12 text-muted text-nowrap">
                                    <span class="fw-semibold text-success">34% more</span><br />
                                    <span>{{ __('messages.backend_from_last_week') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4 stretch stretch-full">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="avatar-text">
                                        <i class="feather feather-airplay"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ __('messages.backend_project_done') }}</div>
                                        <div class="fs-12 text-muted">20/30 project</div>
                                    </div>
                                </div>
                                <div class="fs-4 fw-bold text-dark">20/30</div>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-between gap-4">
                                <div id="project-done-area-chart"></div>
                                <div class="fs-12 text-muted text-nowrap">
                                    <span class="fw-semibold text-danger">42% more</span><br />
                                    <span>{{ __('messages.backend_from_last_week') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [Mini] end !-->
                    <!-- [Leads Overview] start -->
                    <div class="col-xxl-4">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('messages.backend_leads_overview') }}</h5>
                                <div class="card-header-action">
                                    <div class="card-header-btn">
                                        <div data-bs-toggle="tooltip" title="Delete">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"> </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Refresh">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"> </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                            <div data-bs-toggle="tooltip" title="Options">
                                                <i class="feather-more-vertical"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-at-sign"></i>New</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-calendar"></i>Event</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-bell"></i>Snoozed</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-trash-2"></i>Deleted</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-settings"></i>Settings</a>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="feather-life-buoy"></i>Tips & Tricks</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body custom-card-action">
                                <div id="leads-overview-donut"></div>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #3454d1"></span>
                                            <span>{{ __('messages.backend_leads_new') }}<span class="fs-10 text-muted ms-1">(20K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #0d519e"></span>
                                            <span>{{ __('messages.backend_leads_contacted') }}<span class="fs-10 text-muted ms-1">(15K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #1976d2"></span>
                                            <span>{{ __('messages.backend_leads_qualified') }}<span class="fs-10 text-muted ms-1">(10K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #1e88e5"></span>
                                            <span>{{ __('messages.backend_leads_working') }}<span class="fs-10 text-muted ms-1">(18K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #2196f3"></span>
                                            <span>{{ __('messages.backend_filter_member') }}<span class="fs-10 text-muted ms-1">(10K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #42a5f5"></span>
                                            <span>Proposal<span class="fs-10 text-muted ms-1">(15K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #64b5f6"></span>
                                            <span>Leads<span class="fs-10 text-muted ms-1">(16K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #90caf9"></span>
                                            <span>Progress<span class="fs-10 text-muted ms-1">(14K)</span></span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                            <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #aad6fa"></span>
                                            <span>Others<span class="fs-10 text-muted ms-1">(10K)</span></span>
                                        </a>
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
                                    </div>
                                </div>
                                @if($totalQuizAttempts > 0)
                                <div class="mt-3">
                                    @php $passRate = round(($quizPassedCount / $totalQuizAttempts) * 100); @endphp
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fs-12 text-muted">Tingkat Kelulusan</span>
                                        <span class="fs-12 fw-bold">{{ $passRate }}%</span>
                                    </div>
                                    <div class="progress ht-6">
                                        <div class="progress-bar bg-success" style="width: {{ $passRate }}%"></div>
                                        <div class="progress-bar bg-danger" style="width: {{ 100 - $passRate }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <span class="fs-11 text-success">Lulus ({{ $quizPassedCount }})</span>
                                        <span class="fs-11 text-danger">Gagal ({{ $totalQuizAttempts - $quizPassedCount }})</span>
                                    </div>
                                </div>
                                @else
                                <div class="text-center text-muted py-3">
                                    <i class="feather-inbox fs-3 d-block mb-2"></i>
                                    <span>Belum ada percobaan quiz</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Third Row: Recent Activity -->
                <div class="row">
                    <!-- Recent Quiz Attempts -->
                    <div class="col-xxl-8">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Aktivitas Quiz Terbaru</h5>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="border-b">
                                                <th>Siswa</th>
                                                <th>Quiz</th>
                                                <th class="text-center">Skor</th>
                                                <th class="text-center">Status</th>
                                                <th>Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentQuizAttempts as $attempt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-text avatar-md bg-soft-primary text-primary rounded-circle">
                                                            {{ strtoupper(substr($attempt->user->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <span class="fw-semibold">{{ $attempt->user->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td><span class="text-truncate-1-line d-block" style="max-width:200px;">{{ $attempt->quiz->title ?? '-' }}</span></td>
                                                <td class="text-center">
                                                    <span class="fw-bold {{ $attempt->score >= 70 ? 'text-success' : ($attempt->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                                        {{ number_format($attempt->score, 0) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($attempt->status == 'passed')
                                                        <span class="badge bg-soft-success text-success">Lulus</span>
                                                    @elseif($attempt->status == 'failed')
                                                        <span class="badge bg-soft-danger text-danger">Gagal</span>
                                                    @else
                                                        <span class="badge bg-soft-warning text-warning">{{ ucfirst($attempt->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fs-12 text-muted">{{ $attempt->created_at->diffForHumans() }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    <i class="feather-inbox fs-3 d-block mb-2"></i>
                                                    Belum ada aktivitas quiz
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Top Students -->
                    <div class="col-xxl-4">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Top Siswa</h5>
                            </div>
                            <div class="card-body">
                                @forelse($topStudents as $index => $stu)
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 {{ !$loop->last ? 'border-bottom border-dashed' : '' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-md {{ $index == 0 ? 'bg-soft-warning text-warning' : 'bg-soft-primary text-primary' }} rounded-circle fw-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold d-block">{{ $stu->name }}</span>
                                            <span class="fs-11 text-muted">{{ $stu->email }}</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-soft-success text-success">{{ $stu->completed_count }} selesai</span>
                                </div>
                                @empty
                                <div class="text-center text-muted py-3">
                                    <i class="feather-inbox fs-3 d-block mb-2"></i>
                                    <span>Belum ada data siswa</span>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- [ Main Content ] end -->
        </div>
@endsection

@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var labels  = @json($platformChart->pluck('date'));
            var visits  = @json($platformChart->pluck('visits'));
            var registrations = @json($platformChart->pluck('registrations'));

            var el = document.querySelector('#platform-activity-chart');
            if (!el) return;

            var isRtl = document.documentElement.getAttribute('dir') === 'rtl';

            var options = {
                chart: {
                    height: 380,
                    width: '100%',
                    type: 'line',
                    stacked: false,
                    toolbar: { show: false },
                    rtl: isRtl
                },
                stroke: {
                    width: [1, 2],
                    curve: 'smooth',
                    lineCap: 'round'
                },
                plotOptions: {
                    bar: { endingShape: 'rounded', columnWidth: '30%' }
                },
                colors: ['#3454d1', '#a2acc7'],
                series: [
                    { name: 'Kunjungan',   type: 'bar',  data: visits },
                    { name: 'Pendaftaran', type: 'line', data: registrations }
                ],
                fill: {
                    opacity: [0.85, 0.25],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: 'vertical',
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 100, 100, 100]
                    }
                },
                markers: { size: 0 },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { fontSize: '10px', colors: '#A0ACBB' } }
                },
                yaxis: {
                    labels: {
                        formatter: function (e) { return +e; },
                        offsetX: -5,
                        offsetY: 0,
                        style: { color: '#A0ACBB' }
                    }
                },
                grid: {
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: false } }
                },
                dataLabels: { enabled: false },
                tooltip: {
                    y: { formatter: function (e) { return +e; } },
                    style: { fontSize: '12px', fontFamily: 'Inter' }
                },
                legend: { show: true, labels: { fontSize: '12px', colors: '#A0ACBB' } }
            };

            new ApexCharts(el, options).render();
        });
    </script>
@endpush
