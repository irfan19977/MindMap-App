@extends('frontend.layouts.app')

@section('content')
    <style>
        :root {
            --olive: #7C815D;
            --olive-dark: #656A49;
            --olive-light: #EEF0E6;
            --text: #22231C;
            --muted: #8B8D7E;
            --border: #ECECE4;
            --gold: #FFD700;
            --silver: #C0C0C0;
            --bronze: #CD7F32;
        }
        
        .leaderboard-section {
            padding: 50px 0 80px;
            background: #F7F7F3;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        }
        
        .sidebar-card img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 12px;
        }
        
        .sidebar-card h5 {
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 700;
        }
        
        .sidebar-card span {
            color: var(--muted);
            font-size: 13px;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 999px;
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 15px;
            background: white;
            color: var(--text);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .sidebar-link:hover {
            color: var(--olive);
        }
        
        .sidebar-link.active {
            background: var(--olive);
            color: white;
        }
        
        .sidebar-link i {
            width: 18px;
            text-align: center;
        }
        
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 36px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.03);
            position: relative;
        }
        
        .card-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .content-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .content-card h4 i {
            color: var(--olive);
        }
        
        .filter-group {
            display: flex;
            gap: 12px;
        }
        
        .filter-select {
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: white;
            font-size: 14px;
            color: var(--text);
            cursor: pointer;
            transition: border-color 0.2s;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--olive);
        }
        
        /* Podium Card Styles */
        .podium-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
            margin-top: 60px;
        }
        
        .podium-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            box-shadow: 0 4px 14px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .podium-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        
        .podium-card.podium-gold {
            border: 2px solid var(--gold);
            margin-top: -50px;
        }
        
        .podium-card.podium-silver {
            border: 2px solid var(--silver);
        }
        
        .podium-card.podium-bronze {
            border: 2px solid var(--bronze);
        }
        
        .podium-rank {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 15px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .podium-gold .podium-rank {
            background: linear-gradient(135deg, var(--gold) 0%, #FFA500 100%);
        }
        
        .podium-silver .podium-rank {
            background: linear-gradient(135deg, var(--silver) 0%, #A8A8A8 100%);
        }
        
        .podium-bronze .podium-rank {
            background: linear-gradient(135deg, var(--bronze) 0%, #B87333 100%);
        }
        
        .podium-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 12px;
            border: 3px solid var(--border);
        }

        .podium-avatar-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 12px;
            border: 3px solid var(--border);
            background: var(--olive-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--olive);
        }
        
        .podium-gold .podium-avatar {
            width: 100px;
            height: 100px;
        }
        
        .podium-name {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 4px;
            color: var(--text);
        }
        
        .podium-username {
            font-size: 13px;
            color: var(--muted);
            margin: 0 0 8px;
        }
        
        .podium-points {
            font-size: 20px;
            font-weight: 700;
            color: var(--olive);
        }
        
        .podium-points small {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }
        
        /* Leaderboard Table */
        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .leaderboard-table thead th {
            text-align: left;
            padding: 16px;
            border-bottom: 2px solid var(--border);
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .leaderboard-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background-color 0.2s;
        }
        
        .leaderboard-table tbody tr:hover {
            background-color: var(--olive-light);
        }
        
        .leaderboard-table tbody td {
            padding: 16px;
            vertical-align: middle;
        }
        
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 16px;
        }
        
        .rank-1, .rank-2, .rank-3 {
            background: linear-gradient(135deg, var(--gold) 0%, #FFA500 100%);
            color: white;
        }
        
        .rank-4, .rank-5, .rank-6 {
            background: var(--olive-light);
            color: var(--olive-dark);
        }
        
        .rank-other {
            background: #f5f5f5;
            color: var(--muted);
        }
        
        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .student-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .student-details h6 {
            margin: 0 0 2px;
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }
        
        .student-details small {
            font-size: 12px;
            color: var(--muted);
        }
        
        .points-cell {
            font-weight: 700;
            color: var(--olive);
            font-size: 16px;
        }
        
        .streak-badge {
            background: linear-gradient(135deg, var(--olive) 0%, var(--olive-dark) 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* User Rank Card */
        .user-rank-card {
            background: linear-gradient(135deg, var(--olive) 0%, var(--olive-dark) 100%);
            color: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(124, 129, 93, 0.3);
        }
        
        .user-rank-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-rank-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }
        
        .user-rank-info h5 {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 700;
        }
        
        .user-rank-info p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .user-rank-stats {
            display: flex;
            gap: 30px;
            margin-left: auto;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .user-row {
            background: linear-gradient(135deg, var(--olive-light) 0%, rgba(124, 129, 93, 0.1) 100%) !important;
            border-left: 4px solid var(--olive);
        }
        
        .user-row .student-details h6 {
            color: var(--olive);
        }
        
        .jump-to-rank-btn {
            background: var(--olive);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .jump-to-rank-btn:hover {
            background: var(--olive-dark);
        }
        
        .rank-beyond-50 {
            background: #e9ecef;
            color: #6c757d;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            display: block;
        }
        
        .stat-label {
            font-size: 12px;
            opacity: 0.8;
        }
        
        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        
        .pagination-custom {
            display: flex;
            gap: 8px;
        }
        
        .pagination-custom a,
        .pagination-custom span {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            background: transparent;
            color: var(--text);
            border: none;
        }
        
        .pagination-custom a:hover {
            background: var(--olive-light);
            color: var(--olive);
        }
        
        .pagination-custom span.active {
            background: var(--olive);
            color: white;
        }
        
        .pagination-custom span.disabled {
            color: var(--muted);
            background: transparent;
            cursor: not-allowed;
        }
        
        @media (max-width: 900px) {
            .podium-section {
                display: none;
            }

            .mobile-only {
                display: block !important;
            }

            .desktop-only {
                display: none !important;
            }

            /* Fix circular elements on mobile */
            .rank-badge {
                width: 32px !important;
                height: 32px !important;
                font-size: 14px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .student-avatar {
                width: 36px !important;
                height: 36px !important;
                flex-shrink: 0;
            }

            .student-info {
                gap: 8px !important;
            }

            .student-details h6 {
                font-size: 13px !important;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 120px;
            }

            .student-details small {
                font-size: 11px !important;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 120px;
            }

            .leaderboard-table th,
            .leaderboard-table td {
                padding: 10px 8px !important;
                font-size: 13px;
            }

            .points-cell {
                font-size: 13px !important;
            }
        }

        @media (min-width: 901px) {
            .mobile-only {
                display: none !important;
            }

            .desktop-only {
                display: block !important;
            }
        }
        }
            
            .user-rank-content {
                flex-direction: column;
                text-align: center;
            }
            
            .user-rank-stats {
                margin-left: 0;
                margin-top: 20px;
            }
            
            .filter-group {
                flex-direction: column;
            }
            
            .filter-select {
                width: 100%;
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="jarallax relative overflow-hidden z-1000 mt-80">
        <img src="{{ asset('frontend/images//slider/2.png') }}" class="jarallax-img" alt="">
        <div class="sw-overlay op-2"></div>
        <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
        <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
        <div class="container relative z-2">
            <div class="row wow fadeInRight">
                <div class="col-lg-10">
                    <h1 class="fs-sm-10vw mb-0">Leaderboard</h1>
                    <ul class="crumb">
                        <li><a href="/">Home</a></li>
                        <li class="active">Leaderboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="leaderboard-section">
        <div class="container">
            <div class="row">
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar-card">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 12px;">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <h5>Leaderboard</h5>
                        <span>Papan Peringkat</span>
                    </div>

                    <!-- Statistics Card -->
                    <div class="sidebar-card">
                        <div style="text-align: left; margin-bottom: 16px;">
                            <h5 style="display: flex; align-items: center; gap: 8px; margin: 0 0 12px;">
                                <i class="fa-solid fa-chart-line" style="color: var(--olive);"></i> Statistik
                            </h5>
                        </div>
                        <div style="text-align: left;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted); font-size: 13px;">Total Siswa</span>
                                <span style="font-weight: 600; font-size: 14px;">1,234</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted); font-size: 13px;">Top 50 Ditampilkan</span>
                                <span style="font-weight: 600; font-size: 14px;">50</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted); font-size: 13px;">Total Poin</span>
                                <span style="font-weight: 600; font-size: 14px;">5.2M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted); font-size: 13px;">Materi Selesai</span>
                                <span style="font-weight: 600; font-size: 14px;">8,456</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--muted); font-size: 13px;">Rata-rata Streak</span>
                                <span style="font-weight: 600; font-size: 14px;">12 hari</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="sidebar-card" style="background: linear-gradient(135deg, var(--olive-light) 0%, rgba(124, 129, 93, 0.1) 100%);">
                        <div style="text-align: left;">
                            <h5 style="display: flex; align-items: center; gap: 8px; margin: 0 0 12px; color: var(--olive-dark);">
                                <i class="fa-solid fa-lightbulb"></i> Tips Naik Peringkat
                            </h5>
                            <ul style="margin: 0; padding-left: 16px; font-size: 13px; color: var(--text);">
                                <li style="margin-bottom: 8px;">Selesaikan materi setiap hari</li>
                                <li style="margin-bottom: 8px;">Pertahankan streak belajar</li>
                                <li style="margin-bottom: 8px;">Ikuti kuis dan ujian</li>
                                <li style="margin-bottom: 0;">Bantu teman belajar</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="col-lg-9">
                    
                    <!-- Main Leaderboard -->
                    <div class="content-card">
                        <div class="card-header-row">
                            <h4><i class="fa-solid fa-trophy"></i> Papan Peringkat Siswa</h4>
                            <div class="filter-group">
                                @auth
                                <button onclick="jumpToMyRank()" class="jump-to-rank-btn">
                                    <i class="fa-solid fa-crosshairs"></i> Lihat Peringkat Saya
                                </button>
                                @endauth
                            </div>
                        </div>

                        <!-- Top 3 Podium Cards -->
                        <div class="podium-section">
                            @php
                                $top3 = $allStudents->take(3);
                                $silver = $top3->get(1);
                                $gold = $top3->get(0);
                                $bronze = $top3->get(2);
                            @endphp
                            <div class="podium-card podium-silver">
                                @if($silver)
                                    <div class="podium-rank">2</div>
                                    <img src="{{ $silver->avatar_url ?? asset('frontend/images/avatar-placeholder.webp') }}" class="podium-avatar" alt="2nd Place">
                                    <h5 class="podium-name">{{ $silver->user->name ?? 'Siswa Silver' }}</h5>
                                    <div class="podium-points">{{ number_format($silver->experience_points ?? 0) }} <small>poin</small></div>
                                @else
                                    <div class="podium-rank">2</div>
                                    <div class="podium-avatar-placeholder">
                                        <i class="fa-solid fa-user-slash"></i>
                                    </div>
                                    <h5 class="podium-name">Podium Kosong</h5>
                                    <div class="podium-points">- <small>poin</small></div>
                                @endif
                            </div>
                            <div class="podium-card podium-gold">
                                @if($gold)
                                    <div class="podium-rank">1</div>
                                    <img src="{{ $gold->avatar_url ?? asset('frontend/images/avatar-placeholder.webp') }}" class="podium-avatar" alt="1st Place">
                                    <h5 class="podium-name">{{ $gold->user->name ?? 'Siswa Gold' }}</h5>
                                    <div class="podium-points">{{ number_format($gold->experience_points ?? 0) }} <small>poin</small></div>
                                @else
                                    <div class="podium-rank">1</div>
                                    <div class="podium-avatar-placeholder">
                                        <i class="fa-solid fa-user-slash"></i>
                                    </div>
                                    <h5 class="podium-name">Podium Kosong</h5>
                                    <div class="podium-points">- <small>poin</small></div>
                                @endif
                            </div>
                            <div class="podium-card podium-bronze">
                                @if($bronze)
                                    <div class="podium-rank">3</div>
                                    <img src="{{ $bronze->avatar_url ?? asset('frontend/images/avatar-placeholder.webp') }}" class="podium-avatar" alt="3rd Place">
                                    <h5 class="podium-name">{{ $bronze->user->name ?? 'Siswa Bronze' }}</h5>
                                    <div class="podium-points">{{ number_format($bronze->experience_points ?? 0) }} <small>poin</small></div>
                                @else
                                    <div class="podium-rank">3</div>
                                    <div class="podium-avatar-placeholder">
                                        <i class="fa-solid fa-user-slash"></i>
                                    </div>
                                    <h5 class="podium-name">Podium Kosong</h5>
                                    <div class="podium-points">- <small>poin</small></div>
                                @endif
                            </div>
                        </div>

                        <!-- Leaderboard Table -->
                        <!-- Mobile: Show table with all students starting from rank 1 -->
                        <div class="table-responsive mobile-only" style="display: none;">
                            <table class="leaderboard-table">
                                <thead>
                                    <tr>
                                        <th width="80">Peringkat</th>
                                        <th>Siswa</th>
                                        <th>Poin</th>
                                        <th>Materi Selesai</th>
                                        <th>Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody id="leaderboardBodyMobile">
                                    @php
                                        $currentPage = $mobileStudents->currentPage();
                                        $perPage = $mobileStudents->perPage();
                                        $rankOffset = ($currentPage - 1) * $perPage + 1;
                                    @endphp

                                    @foreach($mobileStudents as $student)
                                    @php
                                        $globalRank = $rankOffset + $loop->index;
                                    @endphp
                                    <tr>
                                        <td><span class="rank-badge rank-other">{{ $globalRank }}</span></td>
                                        <td>
                                            <div class="student-info">
                                                <img src="{{ $student->avatar_url ?? asset('frontend/images/avatar-placeholder.webp') }}" class="student-avatar" alt="">
                                                <div class="student-details">
                                                    <h6>{{ $student->user->name ?? 'Unknown' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="points-cell">{{ number_format($student->experience_points ?? 0) }}</span></td>
                                        <td>{{ $student->completed_materials_count ?? 0 }}</td>
                                        <td>{{ $student->created_at ? $student->created_at->format('M Y') : '-' }}</td>
                                    </tr>
                                    @endforeach

                                    @auth
                                    @if($currentStudent)
                                    @php
                                        $userRank = $allStudents->search(fn($s) => $s->id === $currentStudent->id);
                                        $userRank = $userRank !== false ? $userRank + 1 : null;
                                        $isBeyond50 = $userRank > 50;
                                    @endphp
                                    <tr class="user-row" id="myRankRow">
                                        <td><span class="rank-badge {{ $isBeyond50 ? 'rank-beyond-50' : 'rank-other' }}">{{ $isBeyond50 ? '-' : $userRank }}</span></td>
                                        <td>
                                            <div class="student-info">
                                                @if($currentStudent->avatar_url)
                                                    <img src="{{ $currentStudent->avatar_url }}" class="student-avatar" alt="{{ $currentStudent->user->name }}">
                                                @else
                                                    <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold;">
                                                        {{ strtoupper(substr($currentStudent->user->name ?? 'A', 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="student-details">
                                                    <h6>{{ $currentStudent->user->name }} <span style="background: var(--olive); color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-left: 8px;">Anda</span></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="points-cell">{{ number_format($currentStudent->experience_points ?? 0) }}</span></td>
                                        <td>{{ $currentStudent->completed_materials_count ?? 0 }}</td>
                                        <td>{{ $currentStudent->created_at ? $currentStudent->created_at->format('M Y') : '-' }}</td>
                                    </tr>
                                    @endif
                                    @endauth
                                </tbody>
                            </table>
                        </div>

                        <!-- Desktop: Show table starting from rank 4 (podium shows 1-3) -->
                        @if($allStudents->count() > 3)
                        <div class="table-responsive desktop-only">
                            <table class="leaderboard-table">
                                <thead>
                                    <tr>
                                        <th width="80">Peringkat</th>
                                        <th>Siswa</th>
                                        <th>Poin</th>
                                        <th>Materi Selesai</th>
                                        <th>Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody id="leaderboardBody">
                                    @php
                                        $currentPage = $desktopStudents->currentPage();
                                        $perPage = $desktopStudents->perPage();
                                        $rankOffset = ($currentPage - 1) * $perPage + 4; // Start from rank 4
                                    @endphp

                                    @foreach($desktopStudents as $student)
                                    @php
                                        $globalRank = $rankOffset + $loop->index;
                                    @endphp
                                    <tr>
                                        <td><span class="rank-badge rank-other">{{ $globalRank }}</span></td>
                                        <td>
                                            <div class="student-info">
                                                <img src="{{ $student->avatar_url ?? asset('frontend/images/avatar-placeholder.webp') }}" class="student-avatar" alt="">
                                                <div class="student-details">
                                                    <h6>{{ $student->user->name ?? 'Unknown' }}</h6>
                                                    <small>@{{ $student->user->name ?? 'unknown' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="points-cell">{{ number_format($student->experience_points ?? 0) }}</span></td>
                                        <td>{{ $student->completed_materials_count ?? 0 }}</td>
                                        <td>{{ $student->created_at ? $student->created_at->format('M Y') : '-' }}</td>
                                    </tr>
                                    @endforeach
                                    
                                    @auth
                                    @if($currentStudent)
                                    @php
                                        $userRank = $allStudents->search(fn($s) => $s->id === $currentStudent->id);
                                        $userRank = $userRank !== false ? $userRank + 1 : null;
                                        $isBeyond50 = $userRank > 50;
                                    @endphp
                                    <tr class="user-row" id="myRankRow">
                                        <td><span class="rank-badge {{ $isBeyond50 ? 'rank-beyond-50' : 'rank-other' }}">{{ $isBeyond50 ? '-' : $userRank }}</span></td>
                                        <td>
                                            <div class="student-info">
                                                @if($currentStudent->avatar_url)
                                                    <img src="{{ $currentStudent->avatar_url }}" class="student-avatar" alt="{{ $currentStudent->user->name }}">
                                                @else
                                                    <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold;">
                                                        {{ strtoupper(substr($currentStudent->user->name ?? 'A', 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="student-details">
                                                    <h6>{{ $currentStudent->user->name }} <span style="background: var(--olive); color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-left: 8px;">Anda</span></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="points-cell">{{ number_format($currentStudent->experience_points ?? 0) }}</span></td>
                                        <td>{{ $currentStudent->completed_materials_count ?? 0 }}</td>
                                        <td>{{ $currentStudent->created_at ? $currentStudent->created_at->format('M Y') : '-' }}</td>
                                    </tr>
                                    @endif
                                    @endauth
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <!-- Pagination Mobile -->
                        @if($mobileStudents->hasPages())
                        <div class="pagination-wrapper mobile-only" style="display: none;">
                            <div class="pagination-custom">
                                @if($mobileStudents->onFirstPage())
                                    <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
                                @else
                                    <a href="{{ $mobileStudents->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
                                @endif

                                @php
                                    $currentPage = $mobileStudents->currentPage();
                                    $lastPage = $mobileStudents->lastPage();
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($lastPage, $currentPage + 2);

                                    if ($startPage > 1) {
                                        echo '<a href="' . $mobileStudents->url(1) . '">1</a>';
                                        if ($startPage > 2) {
                                            echo '<span class="disabled">...</span>';
                                        }
                                    }

                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        if ($i == $currentPage) {
                                            echo '<span class="active">' . $i . '</span>';
                                        } else {
                                            echo '<a href="' . $mobileStudents->url($i) . '">' . $i . '</a>';
                                        }
                                    }

                                    if ($endPage < $lastPage) {
                                        if ($endPage < $lastPage - 1) {
                                            echo '<span class="disabled">...</span>';
                                        }
                                        echo '<a href="' . $mobileStudents->url($lastPage) . '">' . $lastPage . '</a>';
                                    }
                                @endphp

                                @if($mobileStudents->hasMorePages())
                                    <a href="{{ $mobileStudents->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
                                @else
                                    <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Pagination Desktop -->
                        @if($desktopStudents->hasPages())
                        <div class="pagination-wrapper desktop-only">
                            <div class="pagination-custom">
                                @if($desktopStudents->onFirstPage())
                                    <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
                                @else
                                    <a href="{{ $desktopStudents->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
                                @endif

                                @php
                                    $currentPage = $desktopStudents->currentPage();
                                    $lastPage = $desktopStudents->lastPage();
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($lastPage, $currentPage + 2);

                                    if ($startPage > 1) {
                                        echo '<a href="' . $desktopStudents->url(1) . '">1</a>';
                                        if ($startPage > 2) {
                                            echo '<span class="disabled">...</span>';
                                        }
                                    }

                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        if ($i == $currentPage) {
                                            echo '<span class="active">' . $i . '</span>';
                                        } else {
                                            echo '<a href="' . $desktopStudents->url($i) . '">' . $i . '</a>';
                                        }
                                    }

                                    if ($endPage < $lastPage) {
                                        if ($endPage < $lastPage - 1) {
                                            echo '<span class="disabled">...</span>';
                                        }
                                        echo '<a href="' . $desktopStudents->url($lastPage) . '">' . $lastPage . '</a>';
                                    }
                                @endphp

                                @if($desktopStudents->hasMorePages())
                                    <a href="{{ $desktopStudents->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
                                @else
                                    <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const categoryFilter = document.getElementById('categoryFilter');

        categoryFilter.addEventListener('change', function() {
            // Add your filtering logic here
            console.log('Category filter changed:', this.value);
        });
    });

    function showLeaderboardSection(section) {
        // Remove active class from all links
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.classList.remove('active');
        });
        
        // Add active class to clicked link
        document.getElementById('link-' + section).classList.add('active');
        
        // Add your section switching logic here
        console.log('Showing section:', section);
    }

    function jumpToMyRank() {
        const myRankRow = document.getElementById('myRankRow');
        if (myRankRow) {
            // Scroll to the user's rank row
            myRankRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Add highlight animation
            myRankRow.style.transition = 'background-color 0.3s ease';
            myRankRow.style.backgroundColor = 'rgba(124, 129, 93, 0.5)';
            
            // Remove highlight after animation
            setTimeout(() => {
                myRankRow.style.backgroundColor = '';
            }, 2000);
        }
    }
    </script>
@endsection