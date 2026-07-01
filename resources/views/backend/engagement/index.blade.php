@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Engagement Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Engagement</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <div class="dropdown">
                            <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown">
                                <i class="feather-calendar me-2"></i>
                                <span>Last 7 Days</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item" onclick="updatePeriod(7)">Last 7 Days</a>
                                <a href="javascript:void(0);" class="dropdown-item" onclick="updatePeriod(30)">Last 30 Days</a>
                                <a href="javascript:void(0);" class="dropdown-item" onclick="updatePeriod(90)">Last 90 Days</a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item" onclick="showCustomRangePicker()">Custom Range</a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown">
                                <i class="feather-zap me-2"></i>
                                <span>Quick Actions</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('users.create') }}" class="dropdown-item">
                                    <i class="feather-user-plus me-2 text-primary"></i>Add User
                                </a>
                                <a href="{{ route('categories.create') }}" class="dropdown-item">
                                    <i class="feather-folder-plus me-2 text-success"></i>Add Category
                                </a>
                                <a href="{{ route('materis.create') }}" class="dropdown-item">
                                    <i class="feather-file-plus me-2 text-warning"></i>Add Materi
                                </a>
                                <hr class="my-1">
                                <a href="{{ route('categories.index') }}" class="dropdown-item">
                                    <i class="feather-layers me-2 text-info"></i>Manage Categories
                                </a>
                                <a href="{{ route('users.index') }}" class="dropdown-item">
                                    <i class="feather-users me-2 text-secondary"></i>Manage Users
                                </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-md btn-primary" data-bs-toggle="dropdown">
                                <i class="feather-download me-2"></i>
                                <span>Export</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('engagement.export', ['type' => 'analytics', 'format' => 'csv']) }}" class="dropdown-item">
                                    <i class="feather-file-text me-2"></i>Analytics (CSV)
                                </a>
                                <a href="{{ route('engagement.export', ['type' => 'users', 'format' => 'csv']) }}" class="dropdown-item">
                                    <i class="feather-users me-2"></i>Users (CSV)
                                </a>
                                <a href="{{ route('engagement.export', ['type' => 'categories', 'format' => 'csv']) }}" class="dropdown-item">
                                    <i class="feather-folder me-2"></i>Categories (CSV)
                                </a>
                                <a href="{{ route('engagement.export', ['type' => 'analytics', 'format' => 'json']) }}" class="dropdown-item">
                                    <i class="feather-code me-2"></i>Analytics (JSON)
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
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded">
                                    <i class="feather-users fs-4"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalUsers }}</div>
                                    <h3 class="fs-13 fw-semibold text-muted">Total Users</h3>
                                </div>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-12 text-muted">New this week</span>
                                    <span class="fs-12 text-dark fw-semibold">{{ $userGrowth->sum('count') }}</span>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    @php $weeklyPercent = $totalUsers > 0 ? min(round(($userGrowth->sum('count') / $totalUsers) * 100), 100) : 0; @endphp
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $weeklyPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-soft-success text-success rounded">
                                    <i class="feather-wifi fs-4"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">
                                        <span id="liveOnlineCount">--</span>
                                        <span class="live-indicator" style="display: inline-block; width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-left: 4px; animation: pulse 2s infinite;"></span>
                                    </div>
                                    <h3 class="fs-13 fw-semibold text-muted">Online Now</h3>
                                </div>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-12 text-muted">Updated</span>
                                    <span class="fs-12 text-dark fw-semibold" id="liveTimestamp">--:--:--</span>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded">
                                    <i class="feather-folder fs-4"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalCategories }}</div>
                                    <h3 class="fs-13 fw-semibold text-muted">Total Kategori</h3>
                                </div>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-12 text-muted">With content</span>
                                    <span class="fs-12 text-dark fw-semibold">{{ $categoryActivity->where('materis_count', '>', 0)->count() }}</span>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    @php $withContentPercent = $totalCategories > 0 ? round(($categoryActivity->where('materis_count', '>', 0)->count() / $totalCategories) * 100) : 0; @endphp
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $withContentPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded">
                                    <i class="feather-file-text fs-4"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalMateris }}</div>
                                    <h3 class="fs-13 fw-semibold text-muted">Total Materi</h3>
                                </div>
                            </div>
                            <div class="pt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-12 text-muted">Avg per kategori</span>
                                    <span class="fs-12 text-dark fw-semibold">{{ $totalCategories > 0 ? round($totalMateris / $totalCategories, 1) : 0 }}</span>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">User Growth Trend</h6>
                            </div>
                            <div class="card-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="feather-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item">View Details</a>
                                        <a href="javascript:void(0);" class="dropdown-item">Export Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="userGrowthChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-lg-5">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Daily Engagement</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="dailyEngagementChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Activity & Recent Users -->
            <div class="row">
                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Top Categories by Activity</h6>
                            </div>
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Subcategories</th>
                                            <th>Materis</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categoryActivity as $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-text avatar-sm bg-primary-soft">
                                                        <span class="text-primary fw-bold">{{ substr($category->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $category->name }}</h6>
                                                        <span class="fs-12 text-muted">{{ Str::limit($category->description, 30) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $category->subcategories_count }}</td>
                                            <td>{{ $category->materis_count }}</td>
                                            <td>
                                                <div class="progress ht-3" style="width: 100px;">
                                                    @php
                                                        $maxMateris = $categoryActivity->max('materis_count');
                                                        $percentage = $maxMateris > 0 ? ($category->materis_count / $maxMateris) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Recent Users</h6>
                            </div>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-text avatar-sm bg-success-soft">
                                                        <span class="text-success fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>
                                                @if($user->last_login_at && $user->last_login_at->gte(now()->subDays(7)))
                                                    <span class="badge bg-success-soft text-success">Active</span>
                                                @else
                                                    <span class="badge bg-warning-soft text-warning">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retention & Activity Feed -->
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">User Retention</h6>
                            </div>
                            <div class="card-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="feather-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item" onclick="loadRetentionData(7)">Last 7 Days</a>
                                        <a href="javascript:void(0);" class="dropdown-item" onclick="loadRetentionData(30)">Last 30 Days</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="retentionChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-lg-5">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Activity Feed</h6>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="refreshActivityFeed()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="activityFeed" class="activity-feed">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Analytics Row -->
            <div class="row">
                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Activity Heatmap</h6>
                                <span class="fs-12 text-muted">User activity by day and hour</span>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="loadHeatmap()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="heatmapContainer" class="heatmap-container">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Funnel Analysis</h6>
                                <span class="fs-12 text-muted">User journey conversion</span>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="loadFunnelAnalysis()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="funnelContainer">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Geographic & User Journey -->
            <div class="row">
                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Geographic Distribution</h6>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="loadGeographicData()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="geographicContainer">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">User Journey Stats</h6>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="loadUserJourney()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="userJourneyContainer">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Segmentation & Alerts -->
            <div class="row">
                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">User Segmentation</h6>
                                <span class="fs-12 text-muted">User behavior analysis</span>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="loadUserSegmentation()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="segmentationContainer">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <div class="card-left">
                                <h6 class="mb-0">Alerts & Anomalies</h6>
                                <span class="fs-12 text-muted">Important notifications</span>
                            </div>
                            <button class="btn btn-sm btn-light" onclick="loadAlerts()">
                                <i class="feather-refresh-cw"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="alertsContainer">
                                <div class="text-center text-muted">
                                    <i class="feather-loader spin"></i> Loading...
                                </div>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Growth Chart
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            const userGrowthData = @json($userGrowth);
            
            new Chart(userGrowthCtx, {
                type: 'line',
                data: {
                    labels: userGrowthData.map(item => item.date),
                    datasets: [{
                        label: 'New Users',
                        data: userGrowthData.map(item => item.count),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Daily Engagement Chart
            const dailyEngagementCtx = document.getElementById('dailyEngagementChart').getContext('2d');
            const dailyEngagementData = @json($dailyEngagement);
            
            new Chart(dailyEngagementCtx, {
                type: 'bar',
                data: {
                    labels: dailyEngagementData.map(item => \`\${item.date.slice(5)}\`),
                    datasets: [
                        {
                            label: 'New Users',
                            data: dailyEngagementData.map(item => item.new_users),
                            backgroundColor: '#6366f1'
                        },
                        {
                            label: 'Active Users',
                            data: dailyEngagementData.map(item => item.active_users),
                            backgroundColor: '#10b981'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Load retention data
            loadRetentionData(30);

            // Load activity feed
            refreshActivityFeed();

            // Load advanced analytics
            loadHeatmap();
            loadFunnelAnalysis();
            loadGeographicData();
            loadUserJourney();

            // Load new features
            loadUserSegmentation();
            loadAlerts();

            // Load live online users
            loadLiveOnlineUsers();
            
            // Auto-refresh live online users every 30 seconds
            setInterval(loadLiveOnlineUsers, 30000);
            
            // Auto-refresh alerts every 60 seconds
            setInterval(loadAlerts, 60000);
        });

        function updatePeriod(days) {
            // Reload page with period parameter
            window.location.href = `{{ route('engagement.index') }}?period=${days}`;
        }

        function loadRetentionData(period) {
            fetch(`{{ route('engagement.retention') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('retentionChart').getContext('2d');
                    
                    // Destroy existing chart if it exists
                    if (window.retentionChartInstance) {
                        window.retentionChartInstance.destroy();
                    }

                    window.retentionChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.map(item => item.date.slice(5)),
                            datasets: [
                                {
                                    label: '7-Day Retention',
                                    data: data.map(item => item.retention_7d),
                                    borderColor: '#6366f1',
                                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: '30-Day Retention',
                                    data: data.map(item => item.retention_30d),
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    fill: true,
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        callback: function(value) {
                                            return value + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
        }

        function refreshActivityFeed() {
            const feedContainer = document.getElementById('activityFeed');
            feedContainer.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.activity-feed') }}?limit=10`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        feedContainer.innerHTML = '<div class="text-center text-muted">No recent activity</div>';
                        return;
                    }

                    feedContainer.innerHTML = data.map(activity => `
                        <div class="activity-item mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-text avatar-sm bg-${activity.color}-soft">
                                    <i class="feather-${activity.icon} text-${activity.color}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fs-13">${activity.message}</p>
                                    <span class="fs-11 text-muted">${activity.user} • ${activity.time}</span>
                                </div>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    feedContainer.innerHTML = '<div class="text-center text-danger">Failed to load activity feed</div>';
                });
        }

        // Auto-refresh activity feed every 30 seconds
        setInterval(refreshActivityFeed, 30000);

        function loadHeatmap() {
            const container = document.getElementById('heatmapContainer');
            container.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.heatmap') }}?period=30`)
                .then(response => response.json())
                .then(data => {
                    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    const hours = Array.from({length: 24}, (_, i) => i);
                    
                    let html = '<div class="heatmap-grid">';
                    html += '<div class="heatmap-row heatmap-header"><div></div>';
                    hours.forEach(hour => {
                        html += `<div class="heatmap-cell">${hour}:00</div>`;
                    });
                    html += '</div>';

                    days.forEach(day => {
                        html += `<div class="heatmap-row"><div class="heatmap-cell day-label">${day}</div>`;
                        hours.forEach(hour => {
                            const count = data[day][hour] || 0;
                            const intensity = Math.min(count / 10, 1); // Normalize to 0-1
                            const color = intensity === 0 ? '#f3f4f6' : `rgba(99, 102, 241, ${0.2 + intensity * 0.8})`;
                            html += `<div class="heatmap-cell" style="background-color: ${color}" title="${day} ${hour}:00 - ${count} users">${count || ''}</div>`;
                        });
                        html += '</div>';
                    });
                    html += '</div>';
                    
                    container.innerHTML = html;
                })
                .catch(error => {
                    container.innerHTML = '<div class="text-center text-danger">Failed to load heatmap</div>';
                });
        }

        function loadFunnelAnalysis() {
            const container = document.getElementById('funnelContainer');
            container.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.funnel-analysis') }}?period=30`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="funnel-container">';
                    
                    data.forEach((stage, index) => {
                        const width = stage.conversion_rate;
                        html += `
                            <div class="funnel-stage">
                                <div class="funnel-bar" style="width: ${width}%">
                                    <div class="funnel-info">
                                        <strong>${stage.stage}</strong>
                                        <span class="count">${stage.count}</span>
                                    </div>
                                    <div class="funnel-metrics">
                                        <span class="conversion">${stage.conversion_rate}% conversion</span>
                                        <span class="dropoff">${stage.drop_off}% drop-off</span>
                                    </div>
                                </div>
                                <p class="funnel-description">${stage.description}</p>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    container.innerHTML = html;
                })
                .catch(error => {
                    container.innerHTML = '<div class="text-center text-danger">Failed to load funnel analysis</div>';
                });
        }

        function loadGeographicData() {
            const container = document.getElementById('geographicContainer');
            container.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.geographic') }}`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="geographic-list">';
                    
                    data.forEach(item => {
                        const percentage = data[0].count > 0 ? (item.count / data[0].count) * 100 : 0;
                        html += `
                            <div class="geographic-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="country-name">${item.country}</span>
                                    <span class="user-count">${item.count} users</span>
                                </div>
                                <div class="progress ht-3">
                                    <div class="progress-bar bg-primary" style="width: ${percentage}%"></div>
                                </div>
                                <small class="text-muted">${item.domain}</small>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    container.innerHTML = html;
                })
                .catch(error => {
                    container.innerHTML = '<div class="text-center text-danger">Failed to load geographic data</div>';
                });
        }

        function loadUserJourney() {
            const container = document.getElementById('userJourneyContainer');
            container.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.user-journey') }}`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="journey-stats">';
                    
                    html += `
                        <div class="journey-stat-item">
                            <div class="stat-icon bg-primary-soft">
                                <i class="feather-clock text-primary"></i>
                            </div>
                            <div class="stat-details">
                                <h4>${Math.round(data.avg_time_to_first_login || 0)}h</h4>
                                <span class="text-muted">Avg Time to First Login</span>
                            </div>
                        </div>
                        <div class="journey-stat-item">
                            <div class="stat-icon bg-success-soft">
                                <i class="feather-user-check text-success"></i>
                            </div>
                            <div class="stat-details">
                                <h4>${data.users_with_first_login}</h4>
                                <span class="text-muted">Users with First Login</span>
                            </div>
                        </div>
                        <div class="journey-stat-item">
                            <div class="stat-icon bg-warning-soft">
                                <i class="feather-user-x text-warning"></i>
                            </div>
                            <div class="stat-details">
                                <h4>${data.users_without_first_login}</h4>
                                <span class="text-muted">Users Without First Login</span>
                            </div>
                        </div>
                        <div class="journey-stat-item">
                            <div class="stat-icon bg-info-soft">
                                <i class="feather-activity text-info"></i>
                            </div>
                            <div class="stat-details">
                                <h4>${data.avg_session_duration}h</h4>
                                <span class="text-muted">Avg Session Duration</span>
                            </div>
                        </div>
                    `;
                    
                    html += '</div>';
                    container.innerHTML = html;
                })
                .catch(error => {
                    container.innerHTML = '<div class="text-center text-danger">Failed to load user journey data</div>';
                });
        }

        function loadLiveOnlineUsers() {
            fetch(`{{ route('engagement.live-online') }}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('liveOnlineCount').textContent = data.online_count;
                    document.getElementById('liveTimestamp').textContent = data.timestamp;
                })
                .catch(error => {
                    console.error('Failed to load live online users:', error);
                });
        }

        function showCustomRangePicker() {
            const today = new Date().toISOString().split('T')[0];
            const startDate = prompt('Enter start date (YYYY-MM-DD):', today);
            if (!startDate) return;
            
            const endDate = prompt('Enter end date (YYYY-MM-DD):', today);
            if (!endDate) return;
            
            loadCustomRangeAnalytics(startDate, endDate);
        }

        function loadCustomRangeAnalytics(startDate, endDate) {
            fetch(`{{ route('engagement.custom-range') }}?start_date=${startDate}&end_date=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    alert(`Analytics for ${data.period.start} to ${data.period.end}:\n\nNew Users: ${data.metrics.new_users}\nActive Users: ${data.metrics.active_users}\nNew Categories: ${data.metrics.new_categories}\nNew Materis: ${data.metrics.new_materis}`);
                })
                .catch(error => {
                    alert('Failed to load custom range analytics');
                });
        }

        function loadUserSegmentation() {
            const container = document.getElementById('segmentationContainer');
            container.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.segmentation') }}`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="segmentation-grid">';
                    
                    Object.values(data).forEach(segment => {
                        html += `
                            <div class="segment-card segment-${segment.color}">
                                <div class="segment-header">
                                    <div class="segment-icon bg-${segment.color}-soft">
                                        <i class="feather-users text-${segment.color}"></i>
                                    </div>
                                    <div class="segment-count">${segment.count}</div>
                                </div>
                                <h6 class="segment-label">${segment.label}</h6>
                                <p class="segment-description">${segment.description}</p>
                                <div class="segment-percentage">${segment.percentage}% of total users</div>
                                <div class="progress ht-2 mt-2">
                                    <div class="progress-bar bg-${segment.color}" style="width: ${segment.percentage}%"></div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    container.innerHTML = html;
                })
                .catch(error => {
                    container.innerHTML = '<div class="text-center text-danger">Failed to load segmentation data</div>';
                });
        }

        function loadAlerts() {
            const container = document.getElementById('alertsContainer');
            container.innerHTML = '<div class="text-center text-muted"><i class="feather-loader spin"></i> Loading...</div>';

            fetch(`{{ route('engagement.alerts') }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<div class="text-center text-muted"><i class="feather-check-circle text-success" style="font-size: 32px;"></i><p class="mt-2">No alerts at this time</p></div>';
                        return;
                    }

                    let html = '<div class="alerts-list">';
                    
                    data.forEach(alert => {
                        const alertClass = alert.type === 'success' ? 'success' : 
                                          alert.type === 'warning' ? 'warning' : 
                                          alert.type === 'danger' ? 'danger' : 'info';
                        
                        html += `
                            <div class="alert-item alert-${alertClass}">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="alert-icon bg-${alertClass}-soft">
                                        <i class="feather-${alert.icon} text-${alertClass}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-title mb-1">${alert.title}</h6>
                                        <p class="alert-message mb-2">${alert.message}</p>
                                        <small class="text-muted">${alert.timestamp}</small>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    container.innerHTML = html;
                })
                .catch(error => {
                    container.innerHTML = '<div class="text-center text-danger">Failed to load alerts</div>';
                });
        }

        function toggleDarkMode() {
            const body = document.body;
            const icon = document.getElementById('darkModeIcon');
            
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                icon.classList.remove('feather-moon');
                icon.classList.add('feather-sun');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                icon.classList.remove('feather-sun');
                icon.classList.add('feather-moon');
                localStorage.setItem('darkMode', 'disabled');
            }
        }

        // Check for saved dark mode preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            const icon = document.getElementById('darkModeIcon');
            
            if (savedDarkMode === 'enabled') {
                document.body.classList.add('dark-mode');
                icon.classList.remove('feather-moon');
                icon.classList.add('feather-sun');
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Dark mode styles */
        .dark-mode {
            background-color: #1a1a2e;
            color: #e4e4e7;
        }
        
        .dark-mode .card {
            background-color: #16213e;
            border-color: #0f3460;
        }
        
        .dark-mode .card-header {
            background-color: #1a1a2e;
            border-color: #0f3460;
        }
        
        .dark-mode .table {
            color: #e4e4e7;
        }
        
        .dark-mode .table thead th {
            background-color: #0f3460;
            color: #e4e4e7;
        }
        
        .dark-mode .table tbody tr:hover {
            background-color: #1a1a2e;
        }
        
        .dark-mode .text-muted {
            color: #a1a1aa !important;
        }
        
        .dark-mode .text-dark {
            color: #e4e4e7 !important;
        }
        
        .dark-mode .badge {
            color: #e4e4e7;
        }
        
        /* Heatmap styles */
        .heatmap-grid {
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-x: auto;
        }
        
        .heatmap-row {
            display: flex;
            gap: 4px;
            min-width: max-content;
        }
        
        .heatmap-cell {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .heatmap-cell:hover {
            transform: scale(1.1);
            z-index: 10;
        }
        
        .heatmap-cell.day-label {
            width: 80px;
            font-weight: 600;
            font-size: 11px;
            background-color: #f3f4f6;
        }
        
        .dark-mode .heatmap-cell.day-label {
            background-color: #0f3460;
            color: #e4e4e7;
        }
        
        /* Funnel styles */
        .funnel-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .funnel-stage {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .funnel-bar {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            padding: 16px;
            border-radius: 8px;
            color: white;
            transition: all 0.3s;
        }
        
        .funnel-bar:hover {
            transform: translateX(4px);
        }
        
        .funnel-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .funnel-info .count {
            font-size: 24px;
            font-weight: bold;
        }
        
        .funnel-metrics {
            display: flex;
            gap: 16px;
            font-size: 12px;
        }
        
        .funnel-description {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
        }
        
        .dark-mode .funnel-description {
            color: #a1a1aa;
        }
        
        /* Geographic styles */
        .geographic-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .geographic-item {
            padding: 12px;
            border-radius: 8px;
            background-color: #f9fafb;
        }
        
        .dark-mode .geographic-item {
            background-color: #1a1a2e;
        }
        
        .country-name {
            font-weight: 600;
        }
        
        .user-count {
            font-weight: bold;
            color: #6366f1;
        }
        
        /* Journey stats styles */
        .journey-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        
        .journey-stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            border-radius: 8px;
            background-color: #f9fafb;
        }
        
        .dark-mode .journey-stat-item {
            background-color: #1a1a2e;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-details h4 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        
        .stat-details span {
            font-size: 12px;
        }
        
        /* Activity feed styles */
        .activity-item {
            padding: 12px;
            border-radius: 8px;
            background-color: #f9fafb;
            transition: all 0.2s;
        }
        
        .activity-item:hover {
            background-color: #f3f4f6;
        }
        
        .dark-mode .activity-item {
            background-color: #1a1a2e;
        }
        
        .dark-mode .activity-item:hover {
            background-color: #16213e;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .journey-stats {
                grid-template-columns: 1fr;
            }
            
            .heatmap-grid {
                font-size: 8px;
            }
            
            .heatmap-cell {
                width: 30px;
                height: 30px;
            }
            
            .heatmap-cell.day-label {
                width: 60px;
            }
        }
        
        /* Pulse animation for live indicator */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }
        
        /* Segmentation styles */
        .segmentation-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        
        .segment-card {
            padding: 16px;
            border-radius: 8px;
            background-color: #f9fafb;
            transition: all 0.2s;
        }
        
        .segment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .dark-mode .segment-card {
            background-color: #1a1a2e;
        }
        
        .segment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .segment-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .segment-count {
            font-size: 24px;
            font-weight: bold;
        }
        
        .segment-label {
            margin: 0 0 4px 0;
            font-size: 14px;
            font-weight: 600;
        }
        
        .segment-description {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #6b7280;
        }
        
        .dark-mode .segment-description {
            color: #a1a1aa;
        }
        
        .segment-percentage {
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Alerts styles */
        .alerts-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .alert-item {
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid;
            background-color: #f9fafb;
        }
        
        .dark-mode .alert-item {
            background-color: #1a1a2e;
        }
        
        .alert-success {
            border-color: #10b981;
        }
        
        .alert-warning {
            border-color: #f59e0b;
        }
        
        .alert-danger {
            border-color: #ef4444;
        }
        
        .alert-info {
            border-color: #3b82f6;
        }
        
        .alert-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .alert-title {
            font-size: 14px;
            font-weight: 600;
        }
        
        .alert-message {
            font-size: 13px;
            margin: 0;
        }
        
        /* Responsive for segmentation */
        @media (max-width: 768px) {
            .segmentation-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
