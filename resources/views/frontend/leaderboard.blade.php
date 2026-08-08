@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro introhalf" data-background="{{ asset('frontend/img/main/header.png') }}">
      <div class="intro-body">
        <h1>Leaderboard</h1>
        <h4>Tantang dirimu setiap season dan lihat siapa yang teratas</h4>
      </div>
    </header>

    <style>
        /* ==========================================================
           Layout
           ========================================================== */
        .leaderboard-section { padding: 60px 0; }

        .leaderboard-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 28px;
            box-shadow: 0 25px 80px rgba(15, 23, 42, 0.12);
            padding: 36px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(18px);
        }

        .leaderboard-card--glass {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.14);
        }

        .leaderboard-card h2 {
            margin-bottom: 12px;
            font-size: 2.3rem;
            letter-spacing: -0.04em;
        }

        /* Header row: title/description on the left, CTA on the right */
        .leaderboard-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .leaderboard-header .btn-primary {
            flex-shrink: 0;
        }

        .season-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(79, 142, 247, 0.14), rgba(132, 76, 247, 0.12));
            color: #2a4365;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.82rem;
            margin-bottom: 14px;
        }

        /* ==========================================================
           Table
           ========================================================== */
        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
        }

        .leaderboard-table th,
        .leaderboard-table td {
            padding: 18px 16px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            text-align: left;
            vertical-align: middle;
        }

        .leaderboard-table th {
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.85rem;
        }

        .leaderboard-table tbody tr {
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .leaderboard-table tbody tr:hover {
            background: rgba(79, 142, 247, 0.08);
            transform: translateX(4px);
        }

        .rank-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.06);
            color: #334155;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .empty-state {
            text-align: center;
            padding: 40px 16px;
            color: #64748b;
        }

        /* ==========================================================
           Level badges
           ========================================================== */
        .level-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.65rem 0.85rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            color: #fff;
            transition: transform 0.2s ease;
            white-space: nowrap;
        }

        .level-badge:hover { transform: translateY(-2px); }

        .level-explorer { background: linear-gradient(135deg, #8ec5fc 0%, #e0c3fc 100%); }
        .level-active   { background: linear-gradient(135deg, #68d391 0%, #34d399 100%); }
        .level-seeker   { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
        .level-rising   { background: linear-gradient(135deg, #a3bded 0%, #6991c7 100%); }
        .level-smart    { background: linear-gradient(135deg, #ffd86f 0%, #fc9d9a 100%); }
        .level-expert   { background: linear-gradient(135deg, #8fd3f4 0%, #84fab0 100%); }
        .level-master   { background: linear-gradient(135deg, #c1c8e4 0%, #8e9eab 100%); }
        .level-future   { background: linear-gradient(135deg, #fbda61 0%, #ff5acd 100%); }

        /* ==========================================================
           Podium (top 3), true 2nd / 1st / 3rd order via `order`
           ========================================================== */
        .podium-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: end;
            gap: 18px;
            margin-bottom: 34px;
        }

        .podium-item {
            background: rgba(255, 255, 255, 0.78);
            border-radius: 24px;
            padding: 22px;
            text-align: center;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.75);
            position: relative;
            overflow: hidden;
        }

        .podium-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top, rgba(79, 142, 247, 0.12), transparent 55%);
            pointer-events: none;
        }

        /* visual order: 2nd - 1st - 3rd, 1st stands taller */
        .podium-item--rank-1 { order: 2; padding: 32px 22px; transform: translateY(-14px); }
        .podium-item--rank-2 { order: 1; }
        .podium-item--rank-3 { order: 3; }

        .podium-rank {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #4f8ef7 0%, #8a6dff 100%);
            box-shadow: 0 14px 32px rgba(79, 142, 247, 0.25);
            position: relative;
            animation: podium-pulse 2s ease-in-out infinite;
        }

        @keyframes podium-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .podium-item--rank-1 .podium-rank {
            width: 64px;
            height: 64px;
            font-size: 1.3rem;
            background: linear-gradient(135deg, #f6c744 0%, #f79c42 100%);
            box-shadow: 0 14px 32px rgba(247, 156, 66, 0.35), 0 0 0 4px rgba(246, 199, 68, 0.3);
            animation: podium-gold 2s ease-in-out infinite;
        }

        @keyframes podium-gold {
            0%, 100% { transform: scale(1); box-shadow: 0 14px 32px rgba(247, 156, 66, 0.35), 0 0 0 4px rgba(246, 199, 68, 0.3); }
            50% { transform: scale(1.08); box-shadow: 0 20px 40px rgba(247, 156, 66, 0.45), 0 0 0 8px rgba(246, 199, 68, 0.4); }
        }

        .podium-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
        }

        .podium-icon {
            display: inline-flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
        }

        .podium-name {
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 6px;
            color: #1e293b;
        }

        .podium-meta {
            font-size: 0.92rem;
            color: #4b5563;
        }

        .btn-primary {
            border-radius: 999px;
            padding: 0.95rem 1.6rem;
            font-weight: 700;
            box-shadow: 0 18px 36px rgba(79, 142, 247, 0.16);
        }

        /* ==========================================================
           Stat cards
           ========================================================== */
        .leaderboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin: 20px 0 32px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 22px;
            padding: 20px 22px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        }

        .stat-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
        }

        .stat-note {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 4px;
        }

        /* ==========================================================
           Rank hero — big emblem showcase, game-style (ML-inspired)
           ========================================================== */
        .rank-hero {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 30px;
            border-radius: 28px;
            margin-top: 16px;
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(circle at 12% 20%, rgba(56, 189, 248, 0.28), transparent 55%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            width: 100%;
        }

        .rank-hero--empty {
            background:
                radial-gradient(circle at 12% 20%, rgba(148, 163, 184, 0.25), transparent 55%),
                linear-gradient(135deg, #334155 0%, #475569 100%);
        }

        .rank-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255, 255, 255, 0.09) 45%, transparent 60%);
            transform: translateX(-120%);
            animation: rank-hero-shine 5s ease-in-out infinite;
        }

        @keyframes rank-hero-shine {
            0% { transform: translateX(-120%); }
            55%, 100% { transform: translateX(120%); }
        }

        .rank-hero-emblem-wrap {
            position: relative;
            flex-shrink: 0;
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rank-hero-ring {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.28);
            animation: rank-ring-pulse 2.4s ease-in-out infinite;
        }

        @keyframes rank-ring-pulse {
            0%, 100% { transform: scale(1); opacity: 0.75; }
            50% { transform: scale(1.1); opacity: 0.2; }
        }

        .rank-hero-emblem {
            width: 88px;
            height: 88px;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.16), 0 14px 30px rgba(0, 0, 0, 0.35);
        }

        .rank-hero-icon {
            font-size: 2.3rem;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.35));
        }

        .rank-hero-info {
            display: grid;
            gap: 4px;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .rank-hero-stats {
            display: flex;
            gap: 16px;
            margin-left: auto;
        }

        .rank-hero-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .rank-hero-stat-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
        }

        .rank-hero-stat-value {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
        }

        .rank-hero-eyebrow {
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 700;
        }

        .rank-hero-title {
            font-size: 1.7rem;
            font-weight: 900;
            margin: 0;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .rank-hero-desc {
            color: rgba(255, 255, 255, 0.78);
            font-size: 0.92rem;
            margin: 2px 0 0;
            max-width: 560px;
        }

        .rank-hero-desc strong { color: #fff; }

        .rank-hero .btn-primary {
            margin-left: auto;
            flex-shrink: 0;
        }

        /* ==========================================================
           Progress Bar
           ========================================================== */
        .rank-progress {
            margin-top: 12px;
        }

        .rank-progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .rank-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #38bdf8, #0ea5e9);
            border-radius: 999px;
            transition: width 0.5s ease;
        }

        .rank-progress-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        /* ==========================================================
           Rank road — horizontal tier path with hexagon nodes
           ========================================================== */
        .rank-road-wrap {
            margin-top: 22px;
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .rank-road-wrap::-webkit-scrollbar { height: 6px; }
        .rank-road-wrap::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.4);
            border-radius: 999px;
        }

        .rank-road {
            display: flex;
            align-items: flex-start;
            min-width: max-content;
            padding: 14px 4px 4px;
        }

        .rank-node {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            width: 96px;
            flex-shrink: 0;
            position: relative;
        }

        .rank-node-badge {
            width: 80px;
            height: 80px;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.14);
            transition: transform 0.2s ease;
        }

        .rank-node-icon { font-size: 1.4rem; }

        .rank-node-name {
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            color: #334155;
            line-height: 1.2;
        }

        .rank-node-xp {
            font-size: 0.95rem;
            font-weight: 600;
            text-align: center;
            color: #64748b;
        }

        .rank-node--locked .rank-node-badge {
            background: rgba(148, 163, 184, 0.25) !important;
            box-shadow: none;
        }

        .rank-node--locked .rank-node-icon img {
            filter: grayscale(1);
            opacity: 0.5;
        }
        .rank-node--locked .rank-node-name { color: rgba(100, 116, 139, 0.7); }

        .rank-node--current .rank-node-badge {
            transform: scale(1.16);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.35), 0 16px 30px rgba(56, 189, 248, 0.35);
        }

        .rank-node--current .rank-node-name {
            color: #0369a1;
            font-weight: 800;
        }

        .rank-node-tag {
            position: absolute;
            top: -10px;
            padding: 2px 9px;
            border-radius: 999px;
            background: #0ea5e9;
            color: #fff;
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            box-shadow: 0 6px 14px rgba(14, 165, 233, 0.4);
        }

        .rank-connector {
            flex: 1 0 28px;
            min-width: 24px;
            height: 4px;
            margin-top: 33px;
            border-radius: 2px;
            background: rgba(148, 163, 184, 0.25);
        }

        .rank-connector--active {
            background: linear-gradient(90deg, #38bdf8, #0ea5e9);
        }

        /* ==========================================================
           Responsive
           ========================================================== */
        @media (max-width: 768px) {
            .leaderboard-card { padding: 24px; }
            .leaderboard-header { flex-direction: column; align-items: stretch; }
            .leaderboard-header .btn-primary { text-align: center; }
            .podium-row { grid-template-columns: 1fr; }
            .podium-item--rank-1,
            .podium-item--rank-2,
            .podium-item--rank-3 { order: 0; transform: none; }
            .leaderboard-table th:nth-child(5),
            .leaderboard-table td:nth-child(5) { display: none; }
            .rank-hero { flex-direction: column; text-align: center; padding: 22px; }
            .rank-hero-desc { max-width: none; }
            .rank-hero-info { flex: none; }
            .rank-hero-stats { margin-left: 0; margin-top: 12px; width: 100%; justify-content: center; }

            /* Improved rank road for mobile */
            .rank-road-wrap {
                padding: 16px 8px;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
            }

            .rank-road {
                padding: 8px 4px;
            }

            .rank-node {
                width: 80px;
                gap: 6px;
            }

            .rank-node-badge {
                width: 56px;
                height: 56px;
            }

            .rank-node-name {
                font-size: 0.75rem;
            }

            .rank-node-xp {
                font-size: 0.65rem;
            }

            .rank-node-tag {
                font-size: 0.55rem;
                padding: 1px 6px;
            }
        }

        /* ==========================================================
           Celebration animation
           ========================================================== */
        .confetti-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
            overflow: hidden;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            animation: confetti-fall 3s ease-out forwards;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>

    @php
        $month = now()->month;
        $quarter = (int) ceil($month / 3);
        $seasonNames = ['Discovery', 'Momentum', 'Growth', 'Legacy'];
        $seasonName = $seasonNames[$quarter - 1] ?? 'Discovery';
        $seasonLabel = "Season {$seasonName} • Q{$quarter} " . now()->year;

        $levelClasses = [
            'New Explorer' => 'level-explorer',
            'Active Learner' => 'level-active',
            'Knowledge Seeker' => 'level-seeker',
            'Rising Scholar' => 'level-rising',
            'Smart Achiever' => 'level-smart',
            'Expert Learner' => 'level-expert',
            'Master Mind' => 'level-master',
            'Future Leader' => 'level-future',
        ];

        $levelIcons = [
            'New Explorer' => '🧭',
            'Active Learner' => '📚',
            'Knowledge Seeker' => '🔍',
            'Rising Scholar' => '🌱',
            'Smart Achiever' => '🏅',
            'Expert Learner' => '🎓',
            'Master Mind' => '🧠',
            'Future Leader' => '👑',
        ];

        $levelImages = [
            'New Explorer' => 'new-explorer.png',
            'Active Learner' => 'active-learner.png',
            'Knowledge Seeker' => 'knowledge-seeker.png',
            'Rising Scholar' => 'rising-scholar.png',
            'Smart Achiever' => 'smart-achiever.png',
            'Expert Learner' => 'expert-learner.png',
            'Master Mind' => 'master-mind.png',
            'Future Leader' => 'future-leader.png',
        ];

        $rankTiers = [
            ['name' => 'New Explorer', 'icon' => '🧭', 'subtitle' => 'Mulai menjelajah dunia belajar.', 'min_xp' => 10],
            ['name' => 'Active Learner', 'icon' => '📚', 'subtitle' => 'Konsisten dan terus belajar.', 'min_xp' => 100],
            ['name' => 'Knowledge Seeker', 'icon' => '🔍', 'subtitle' => 'Mencari wawasan yang lebih dalam.', 'min_xp' => 300],
            ['name' => 'Rising Scholar', 'icon' => '🌱', 'subtitle' => 'Tingkatkan kebiasaan belajar.', 'min_xp' => 600],
            ['name' => 'Smart Achiever', 'icon' => '🏅', 'subtitle' => 'Tampil sebagai pelajar berprestasi.', 'min_xp' => 1000],
            ['name' => 'Expert Learner', 'icon' => '🎓', 'subtitle' => 'Memahami konsep dengan matang.', 'min_xp' => 1500],
            ['name' => 'Master Mind', 'icon' => '🧠', 'subtitle' => 'Menjadi pemikir strategis.', 'min_xp' => 2500],
            ['name' => 'Future Leader', 'icon' => '👑', 'subtitle' => 'Siap memimpin di masa depan.', 'min_xp' => 4000],
        ];

        $currentLevel = $currentStudent->level ?? null;
        // Determine current tier based on XP, not database level
        $currentTierIndex = false;
        if ($currentStudent) {
            foreach ($rankTiers as $index => $tier) {
                if ($currentStudent->experience_points >= $tier['min_xp']) {
                    $currentTierIndex = $index;
                } else {
                    break;
                }
            }
        }
        
        // Update currentLevel based on XP
        if ($currentTierIndex !== false) {
            $currentLevel = $rankTiers[$currentTierIndex]['name'];
        }

        $lastTierIndex = count($rankTiers) - 1;
        $isTopTier = $currentTierIndex !== false && $currentTierIndex === $lastTierIndex;
        $nextTier = ($currentTierIndex !== false && !$isTopTier) ? $rankTiers[$currentTierIndex + 1] : null;

        // Calculate progress to next rank
        $currentTierMinXp = $currentTierIndex !== false ? $rankTiers[$currentTierIndex]['min_xp'] : 0;
        $nextTierMinXp = $nextTier ? $nextTier['min_xp'] : $currentTierMinXp;
        $xpProgress = 0;
        if ($nextTier && $nextTierMinXp > $currentTierMinXp && $currentStudent->experience_points >= $currentTierMinXp) {
            $xpProgress = min(100, round(($currentStudent->experience_points - $currentTierMinXp) / ($nextTierMinXp - $currentTierMinXp) * 100));
        }

        $studentCount = $students->count();
        $topXp = $students->first()->experience_points ?? 0;
        $avgXp = $studentCount > 0 ? (int) round($students->avg('experience_points')) : 0;

        // Filter students to only include those with minimum XP (10 XP for New Explorer)
        $minXpForLeaderboard = 10;
        $qualifiedStudents = $students->filter(function ($item) use ($minXpForLeaderboard) {
            return $item->experience_points >= $minXpForLeaderboard;
        });

        // Calculate current student's rank from qualified students only
        $currentStudentRank = null;
        if ($currentStudent && $currentStudent->experience_points >= $minXpForLeaderboard) {
            $currentStudentRank = $qualifiedStudents->search(function ($item) use ($currentStudent) {
                return $item->user_id === $currentStudent->user_id;
            });
            if ($currentStudentRank !== false) {
                $currentStudentRank = $currentStudentRank + 1;
            }
        }
    @endphp

    <section class="leaderboard-section">
        <div class="container">
            <div class="leaderboard-card leaderboard-card--glass">
                <div class="leaderboard-header">
                    <div>
                        <small class="season-label">{{ $seasonLabel }}</small>
                        <h2>Leaderboard Global</h2>
                        <p class="text-muted">Tantang dirimu setiap season 3 bulan sekali dan lihat siapa yang teratas dalam perjalanan belajar.</p>
                    </div>
                    @if(auth()->check())
                        <a href="{{ route('student.profile') }}" class="btn btn-primary btn-lg">Kembali ke Profil</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Lihat Rank Kamu</a>
                    @endif
                </div>

                <div class="rank-road-wrap">
                    <div class="rank-road">
                        @foreach($rankTiers as $tierIndex => $tier)
                            @php
                                $isAchieved = $currentTierIndex !== false && $tierIndex < $currentTierIndex;
                                $isCurrent = $currentTierIndex === $tierIndex;
                                $isLocked = !($isAchieved || $isCurrent);
                                $nodeClass = $levelClasses[$tier['name']] ?? 'level-explorer';
                            @endphp
                            <div class="rank-node {{ $isCurrent ? 'rank-node--current' : '' }} {{ $isLocked ? 'rank-node--locked' : '' }}">
                                <div class="rank-node-badge {{ $nodeClass }}">
                                    <span class="rank-node-icon">
                                        <img src="{{ asset('frontend/img/leaderboard/' . $levelImages[$tier['name']]) }}" alt="{{ $tier['name'] }}" style="width: 64px; height: 64px;">
                                    </span>
                                </div>
                                <span class="rank-node-name">{{ $tier['name'] }}</span>
                                <span class="rank-node-xp">{{ $tier['min_xp'] }} XP</span>
                            </div>
                            @if(!$loop->last)
                                <div class="rank-connector {{ $isAchieved || $isCurrent ? 'rank-connector--active' : '' }}"></div>
                            @endif
                        @endforeach
                    </div>
                </div>

                @if($currentStudent && $currentStudent->experience_points >= $minXpForLeaderboard)
                    <div class="rank-hero">
                        <div class="rank-hero-emblem-wrap">
                            <div class="rank-hero-ring"></div>
                            <img src="{{ asset('frontend/img/leaderboard/' . $levelImages[$currentLevel]) }}" alt="{{ $currentLevel }}" style="width: 72px; height: 72px;">
                        </div>
                        <div class="rank-hero-info">
                            <span class="rank-hero-eyebrow">Rank Kamu</span>
                            <h3 class="rank-hero-title">{{ $currentLevel }}</h3>
                            <p class="rank-hero-desc">
                                <strong>{{ number_format($currentStudent->experience_points) }} XP</strong> terkumpul.
                                @if($isTopTier)
                                    Kamu sudah mencapai rank tertinggi — pertahankan posisimu! 🏆
                                @elseif($nextTier)
                                    Terus belajar untuk naik ke <strong>{{ $nextTier['name'] }}</strong>.
                                    <div class="rank-progress">
                                        <div class="rank-progress-bar">
                                            <div class="rank-progress-fill" style="width: {{ $xpProgress }}%;"></div>
                                        </div>
                                        <div class="rank-progress-text">{{ number_format($nextTierMinXp - $currentStudent->experience_points) }} XP lagi ke {{ $nextTier['name'] }}</div>
                                    </div>
                                @endif
                            </p>
                        </div>
                        <div class="rank-hero-stats">
                            <div class="rank-hero-stat">
                                <span class="rank-hero-stat-label">Peringkat</span>
                                <span class="rank-hero-stat-value">#{{ $currentStudentRank ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @elseif($currentStudent)
                    <div class="rank-hero rank-hero--empty">
                        <div class="rank-hero-emblem-wrap">
                            <div class="rank-hero-emblem level-explorer">
                                <span class="rank-hero-icon">🎯</span>
                            </div>
                        </div>
                        <div class="rank-hero-info">
                            <span class="rank-hero-eyebrow">Belum Qualifikasi</span>
                            <h3 class="rank-hero-title">Rank Kamu</h3>
                            <p class="rank-hero-desc">Kamu butuh <strong>{{ $minXpForLeaderboard }} XP</strong> untuk masuk leaderboard. Kumpulkan XP dengan menyelesaikan materi dan quiz!</p>
                        </div>
                        <a href="{{ route('kelas.index') }}" class="btn btn-primary">Mulai Belajar</a>
                    </div>
                @else
                    <div class="rank-hero rank-hero--empty">
                        <div class="rank-hero-emblem-wrap">
                            <div class="rank-hero-emblem level-explorer">
                                <span class="rank-hero-icon">🎯</span>
                            </div>
                        </div>
                        <div class="rank-hero-info">
                            <span class="rank-hero-eyebrow">Belum ada data</span>
                            <h3 class="rank-hero-title">Rank Kamu</h3>
                            <p class="rank-hero-desc">Masuk sebagai siswa untuk melihat status rank dan kemajuan XP kamu.</p>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
                    </div>
                @endif

                @if($qualifiedStudents->count() > 0)
                    @if($qualifiedStudents->count() >= 3)
                        <div class="podium-row">
                            @foreach($qualifiedStudents->take(3) as $index => $item)
                                <div class="podium-item podium-item--rank-{{ $index + 1 }}">
                                    <div class="podium-rank">{{ $index + 1 }}</div>
                                    <div class="podium-badge {{ $levelClasses[$item->level] ?? 'level-explorer' }}">
                                        <span class="podium-icon">
                                            <img src="{{ asset('frontend/img/leaderboard/' . $levelImages[$item->level]) }}" alt="{{ $item->level }}" style="width: 24px; height: 24px;">
                                        </span>
                                        <span>{{ $item->level }}</span>
                                    </div>
                                    <div class="podium-name">{{ $item->user->name }}</div>
                                    <div class="podium-meta">{{ number_format($item->experience_points) }} XP • {{ $item->passed_quiz_count }} Quiz</div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="leaderboard-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">XP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($qualifiedStudents as $index => $item)
                                    <tr>
                                        <td><span class="rank-circle">{{ $index + 1 }}</span></td>
                                        <td>
                                            <div><strong>{{ $item->user->name }}</strong></div>
                                            <div class="text-muted small">{{ $item->user->email }}</div>
                                        </td>
                                        <td>
                                            <span class="level-badge {{ $levelClasses[$item->level] ?? 'level-explorer' }}">
                                                <img src="{{ asset('frontend/img/leaderboard/' . $levelImages[$item->level]) }}" alt="{{ $item->level }}" style="width: 20px; height: 20px; margin-right: 4px;"> {{ $item->level }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($item->experience_points) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <p>Belum ada peserta di leaderboard untuk season ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <script>
        // Celebration confetti animation when user reaches new rank
        function triggerConfetti() {
            const container = document.createElement('div');
            container.className = 'confetti-container';
            document.body.appendChild(container);

            const colors = ['#f6c744', '#4f8ef7', '#8a6dff', '#38bdf8', '#0ea5e9', '#f79c42'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDelay = Math.random() * 2 + 's';
                confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                container.appendChild(confetti);
            }

            setTimeout(() => {
                container.remove();
            }, 5000);
        }

        // Check if user just leveled up (you can customize this logic based on your backend)
        @if($currentStudent && session('rank_upgraded'))
            @php
                session()->forget('rank_upgraded');
            @endphp
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(triggerConfetti, 500);
            });
        @endif
    </script>
@endsection