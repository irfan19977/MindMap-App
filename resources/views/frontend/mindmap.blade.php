@extends('frontend.layouts.app')

@section('content')
            <section class="jarallax relative overflow-hidden z-1000 mt-80">
            <img src="{{ asset('frontend/images/slider/2.png') }}" class="jarallax-img" alt="">
            <div class="sw-overlay op-2"></div>
            <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
            <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
            <div class="container relative z-2">
                <div class="row wow fadeInRight">
                    <div class="col-lg-10">
                        <h1 class="fs-sm-10vw mb-0">
                            @if(isset($category))
                                {{ $category->name }}
                            @elseif(isset($subcategory))
                                {{ $subcategory->name }}
                            @else
                                MindMap Pembelajaran
                            @endif
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Home</a></li>
                            <li><a href="/kelas">Kelas</a></li>
                            <li class="active">
                                @if(isset($category))
                                    {{ $category->name }}
                                @elseif(isset($subcategory))
                                    {{ $subcategory->name }}
                                @else
                                MindMap
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    @if(isset($mindmap) && $mindmap)
                        @php
                            $creator = $mindmap->creator
                                ?? \App\Models\User::find($subcategory->created_by ?? $category->created_by ?? null);
                            $teacher = $creator->teacher ?? null;
                        @endphp

                        <!-- Sidebar Kiri - Informasi Pembuat -->
                        <div class="col-lg-4">
                            <div class="bg-white border-gray rounded-1 p-4 mb-4">
                                <div class="text-center mb-4">
                                    @if($teacher && $teacher->image_url)
                                        <img src="{{ asset('storage/' . $teacher->image_url) }}" class="w-100px h-100px rounded-circle object-cover mx-auto mb-3" alt="{{ $creator->name }}">
                                    @elseif($creator->profile_photo)
                                        <img src="{{ asset('storage/' . $creator->profile_photo) }}" class="w-100px h-100px rounded-circle object-cover mx-auto mb-3" alt="{{ $creator->name }}">
                                    @else
                                        <div class="w-100px h-100px rounded-circle bg-color mx-auto mb-3 flex items-center justify-content-center text-white fs-32">
                                            {{ strtoupper(substr($creator->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <h4 class="mb-1">{{ $creator->name ?? 'Tidak diketahui' }}</h4>
                                    <p class="text-muted mb-0">{{ $creator->email ?? '-' }}</p>
                                </div>

                                @if($teacher)
                                <div class="row g-3 mb-4">
                                    <div class="col-6 text-center">
                                        <div class="fs-24 font-bold id-color">{{ $teacher->materials()->count() }}</div>
                                        <div class="text-muted fs-12">Materi</div>
                                    </div>
                                    <div class="col-6 text-center">
                                        <div class="fs-24 font-bold id-color">{{ $teacher->published_courses->count() }}</div>
                                        <div class="text-muted fs-12">Kursus</div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                        <div class="fs-24 font-bold id-color">{{ number_format($teacher->rating ?? 0, 1) }}</div>
                                        <div class="text-muted fs-12">Rating</div>
                                    </div>
                                    <div class="col-6 text-center">
                                        <div class="fs-24 font-bold id-color">{{ $teacher->students()->count() }}</div>
                                        <div class="text-muted fs-12">Siswa</div>
                                    </div>
                                </div>
                                @endif

                                @if($teacher && $teacher->specialization)
                                <div class="mb-4">
                                    <strong>Spesialisasi:</strong>
                                    <p class="mb-0">{{ $teacher->specialization }}</p>
                                </div>
                                @endif

                                @if($teacher && $teacher->slug)
                                <a href="{{ route('teacher.show', $teacher->slug) }}" class="btn btn-primary w-100">Lihat Profil Guru</a>
                                @endif
                            </div>

                            <!-- Kelas Terkait -->
                            @if(isset($relatedClasses) && $relatedClasses->count() > 0)
                            <div class="bg-white border-gray rounded-1 p-4">
                                <h4 class="mb-4">Kelas Terkait</h4>
                                @foreach($relatedClasses as $class)
                                <div class="border-bottom pb-3 mb-3">
                                    <h5 class="mb-2">{{ $class->name }}</h5>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">{{ $class->materials->count() }} Materi</small>
                                        <small class="text-muted">{{ $class->teacher->name ?? '-' }}</small>
                                    </div>
                                    @guest
                                        <a href="{{ route('login') }}?intended={{ urlencode(request()->fullUrl()) }}" class="btn btn-sm btn-primary w-100 text-decoration-none">
                                            <i class="fa fa-sign-in"></i> Login
                                        </a>
                                    @else
                                        @if(isset($enrollments[$class->id]))
                                            @if($enrollments[$class->id] === 'pending')
                                                <button class="btn btn-sm btn-warning w-100" disabled>
                                                    <i class="fa fa-clock"></i> Menunggu
                                                </button>
                                            @elseif($enrollments[$class->id] === 'active' || $enrollments[$class->id] === 'completed')
                                                <a href="{{ route('mindmap.show', $subcategory->slug ?? $category->slug) }}?class_id={{ $class->id }}" class="btn btn-sm btn-success w-100 text-decoration-none">
                                                    <i class="fa fa-book-open"></i> Buka Kelas
                                                </a>
                                            @else
                                                <form method="POST" action="{{ route('kelas.join', $class->slug) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                                        <i class="fa fa-sign-in"></i> Gabung
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form method="POST" action="{{ route('kelas.join', $class->slug) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                                    <i class="fa fa-sign-in"></i> Gabung
                                                </button>
                                            </form>
                                        @endif
                                    @endguest
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Canvas MindMap -->
                        <div class="col-lg-8">
                            <div class="bg-white border-gray rounded-1 p-4">
                                <div class="mb-4">
                                    <h3 class="mb-2">MindMap Pembelajaran</h3>
                                    <p class="text-muted">
                                        @if(isset($category))
                                            Visualisasi materi pembelajaran untuk kategori {{ $category->name }}
                                        @elseif(isset($subcategory))
                                            Visualisasi materi pembelajaran untuk {{ $subcategory->name }}
                                        @endif
                                    </p>
                                </div>

                                <div class="drawio-layout">
                                    <div class="drawio-canvas-area">
                                        <div class="canvas-chrome">
                                            <span class="canvas-chrome__hint"><i class="feather-info"></i> Scroll untuk geser · Ctrl + scroll untuk zoom</span>
                                        </div>
                                        <div class="canvas-viewport">
                                            <div id="mindmap-canvas" class="canvas-container" style="width: 3000px; height: 3000px;">
                                                <svg id="connections-svg" class="connections-layer">
                                                    <defs>
                                                        <marker id="arrow-solid" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                                            <polygon points="0 0, 12 4.5, 0 9" fill="#475569"/>
                                                        </marker>
                                                        <marker id="arrow-dashed" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                                            <polygon points="0 0, 12 4.5, 0 9" fill="#3b82f6"/>
                                                        </marker>
                                                        <marker id="arrow-dotted" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                                            <polygon points="0 0, 12 4.5, 0 9" fill="#10b981"/>
                                                        </marker>
                                                        <marker id="arrow-thick" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                                            <polygon points="0 0, 12 4.5, 0 9" fill="#7c3aed"/>
                                                        </marker>
                                                    </defs>
                                                </svg>
                                                <div id="mindmap-loading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 1000;">
                                                    <p>Loading mindmap...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="canvas-statusbar">
                                            <span class="canvas-statusbar__item" id="status-tool"><i class="feather-move"></i> Pan</span>
                                            <span class="canvas-statusbar__divider"></span>
                                            <span class="canvas-statusbar__item" id="status-nodes">0 node</span>
                                        </div>

                                        <div class="zoom-controls">
                                            <button type="button" onclick="zoomOut()" class="zoom-btn" title="Zoom Out">
                                                <i class="feather-minus"></i>
                                            </button>
                                            <button type="button" onclick="resetZoom()" class="zoom-level" title="Reset view">100%</button>
                                            <button type="button" onclick="zoomIn()" class="zoom-btn" title="Zoom In">
                                                <i class="feather-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-12 text-center py-5">
                            <div class="bg-white border-gray rounded-1 p-5">
                                <i class="fa fa-project-diagram fs-48 text-muted mb-3"></i>
                                <h4 class="mb-3">MindMap Tidak Tersedia</h4>
                                <p class="text-muted">MindMap untuk materi ini belum tersedia.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    <style>
    :root {
        --mm-primary: var(--bs-primary, #3454d1);
        --mm-primary-dark: #2b48bc;
        --mm-primary-light: #ebeefa;
        --mm-success: #059669;
        --mm-warning: #d97706;
        --mm-border: #e2e8f0;
        --mm-surface: #ffffff;
        --mm-muted: #64748b;
        --mm-canvas-bg: #f1f5f9;
        --mm-grid: #cbd5e1;
        --mm-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
        --mm-shadow-lg: 0 8px 24px rgba(15, 23, 42, 0.12);
        --mm-radius: 10px;
        --mm-panel-width: 236px;
    }

    .mindmap-node {
        position: absolute;
        min-width: 150px;
        max-width: 240px;
        padding: 10px 18px;
        border-radius: 8px;
        border: 2px solid transparent;
        cursor: pointer;
        user-select: none;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-shadow: 3px 3px 0 rgba(0,0,0,0.25);
        transition: box-shadow 0.15s ease, filter 0.15s ease;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.3;
    }

    .mindmap-node:hover {
        filter: brightness(1.06);
        box-shadow: 4px 4px 0 rgba(0,0,0,0.3);
    }

    .mindmap-node.material  { background: #fde047; border-color: #ca8a04; color: #1a1a1a; }
    .mindmap-node.main-topic { background: #60a5fa; border-color: #1d4ed8; color: #fff; }
    .mindmap-node.sub-topic  { background: #86efac; border-color: #15803d; color: #1a1a1a; }

    .mindmap-node.completed::after {
        content: '✓';
        position: absolute;
        top: -8px;
        right: -8px;
        background: #3454d1;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(52,84,209,0.4);
    }

    .mindmap-node.locked {
        opacity: 0.5;
        filter: grayscale(0.8);
        pointer-events: none;
    }

    .mindmap-node.locked .lock-icon {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        border: 2px solid white;
    }

    .connection-line {
        stroke: #94a3b8;
        stroke-width: 2.5;
        fill: none;
        pointer-events: stroke;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .connection-line.solid-line {
        stroke: #667eea;
        stroke-width: 2.5;
        filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.2));
    }

    .connection-line.dashed-line {
        stroke: #ef4444;
        stroke-width: 2.5;
        stroke-dasharray: 10, 6;
        filter: drop-shadow(0 2px 4px rgba(239, 68, 68, 0.2));
    }

    .connection-line.dotted-line {
        stroke: #10b981;
        stroke-width: 2.5;
        stroke-dasharray: 3, 6;
        filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.2));
    }

    .connection-line.curved-line {
        stroke: #f59e0b;
        stroke-width: 2.5;
        fill: none;
        filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.2));
    }

    .connection-line.thick-line {
        stroke: #8b5cf6;
        stroke-width: 5;
        filter: drop-shadow(0 2px 6px rgba(139, 92, 246, 0.3));
    }

    .connection-line.double-line {
        stroke: #ec4899;
        stroke-width: 2;
    }

    .connection-line.wavy-line {
        stroke: #06b6d4;
        stroke-width: 2;
        fill: none;
    }

    .connection-line.manual-line {
        stroke: #6b7280;
        stroke-width: 2;
        fill: none;
    }

    .connection-line.sub-topic-line {
        stroke: #3b82f6;
        stroke-width: 2;
        stroke-dasharray: 5, 5;
        opacity: 0.7;
    }

    .connection-line.hierarchy-line {
        stroke: #3b82f6;
        stroke-width: 3;
    }

    .connection-line.selected {
        stroke: #10b981 !important;
        stroke-width: 4 !important;
        filter: drop-shadow(0 0 6px rgba(16, 185, 129, 0.4));
    }

    .connection-line:hover {
        cursor: pointer;
        stroke-width: 3;
        filter: drop-shadow(0 0 3px rgba(59, 130, 246, 0.3));
    }

    .connection-line.manual-temp-line {
        stroke: #f59e0b;
        stroke-width: 2;
        stroke-dasharray: 5, 5;
        fill: none;
        animation: dash 0.5s linear infinite;
    }

    @keyframes dash {
        to {
            stroke-dashoffset: -10;
        }
    }

    .canvas-container {
        position: relative;
        background-color: var(--mm-canvas-bg);
        background-image: radial-gradient(circle, var(--mm-grid) 1px, transparent 1px);
        background-size: 20px 20px;
        overflow: hidden;
        cursor: default;
        user-select: none;
        transform-origin: 0 0;
    }

    .connections-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 5;
    }

    .empty-state {
        text-align: center;
        padding: 28px 16px;
    }

    .empty-state__icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 12px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 22px;
    }

    .empty-state__title {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin: 0 0 4px;
    }

    .empty-state__hint {
        font-size: 11px;
        color: var(--mm-muted);
        margin: 0;
        line-height: 1.4;
    }

    .drawio-layout {
        height: calc(100vh - 140px);
        min-height: 520px;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--mm-border);
        border-radius: 12px;
        overflow: hidden;
        background: var(--mm-surface);
        box-shadow: var(--mm-shadow);
    }

    .drawio-canvas-area {
        flex: 1;
        position: relative;
        background: #e2e8f0;
        overflow: hidden;
        min-width: 0;
    }

    .canvas-chrome {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 20;
        padding: 8px 12px;
        background: linear-gradient(180deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    .canvas-chrome__hint {
        font-size: 11px;
        color: var(--mm-muted);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .canvas-viewport {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 32px;
        overflow: auto;
        pointer-events: auto;
    }

    .canvas-statusbar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 32px;
        background: rgba(255, 255, 255, 0.96);
        border-top: 1px solid var(--mm-border);
        display: flex;
        align-items: center;
        padding: 0 14px;
        gap: 10px;
        font-size: 11px;
        color: var(--mm-muted);
        z-index: 15;
    }

    .canvas-statusbar__item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .canvas-statusbar__divider {
        width: 1px;
        height: 14px;
        background: var(--mm-border);
    }

    .zoom-controls {
        position: absolute;
        bottom: 44px;
        right: 14px;
        z-index: 20;
        display: flex;
        align-items: center;
        background: var(--mm-surface);
        border: 1px solid var(--mm-border);
        border-radius: 10px;
        padding: 4px;
        box-shadow: var(--mm-shadow-lg);
        gap: 2px;
    }

    .zoom-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        border-radius: 8px;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s;
    }

    .zoom-btn:hover {
        background: #f1f5f9;
    }

    .zoom-level {
        min-width: 52px;
        height: 32px;
        border: none;
        background: #f8fafc;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: background 0.15s;
    }

    .zoom-level:hover {
        background: #f1f5f9;
    }

    .profile-card {
        background: #fff;
        border: 1px solid var(--mm-border);
        border-radius: 16px;
        padding: 28px 20px;
        margin-bottom: 20px;
        box-shadow: var(--mm-shadow);
        text-align: center;
    }

    .profile-avatar-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 16px;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        overflow: hidden;
        border: 4px solid #f1f5f9;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-verified {
        position: absolute;
        bottom: 6px;
        right: 6px;
        width: 26px;
        height: 26px;
        background: #10b981;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        border: 2px solid #fff;
    }

    .profile-name {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .profile-email {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .profile-stat {
        flex: 1;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 12px 6px;
        min-width: 0;
    }

    .profile-stat-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .profile-stat-label {
        font-size: 11px;
        color: #64748b;
    }

    .profile-details {
        text-align: left;
        margin-bottom: 20px;
        border-top: 1px solid #f1f5f9;
        padding-top: 16px;
    }

    .profile-detail-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        font-size: 13px;
    }

    .profile-detail-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f1f5f9;
        color: var(--mm-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .profile-detail-label {
        flex: 1;
        color: #64748b;
    }

    .profile-detail-value {
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }

    .profile-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .profile-btn-primary {
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(52, 84, 209, 0.3);
    }

    .profile-btn-primary:hover {
        background: linear-gradient(135deg, var(--mm-primary-dark) 0%, #1e3a8a 100%);
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
    }

    .mindmap-progress {
        margin-bottom: 15px;
    }
    .mindmap-progress .progress-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 14px;
        color: #334155;
        margin-bottom: 8px;
    }
    .mindmap-progress .progress-info span:last-child {
        color: #6c757d;
    }
    .mindmap-progress .progress-bar-wrapper {
        background: #e2e8f0;
        border-radius: 10px;
        height: 12px;
        overflow: hidden;
    }
    .mindmap-progress .progress-bar-fill {
        background: #6c757d;
        height: 100%;
        border-radius: 10px;
        width: 0%;
        transition: width 0.4s ease;
    }
    </style>

    @if(isset($mindmap) && $mindmap)
    <script>
    let selectedNode = null;
    let selectedConnection = null;
    let nodeIdCounter = 1;
    let connections = [];
    let nodes = [];
    let isDragging = false;
    let draggedNode = null;
    let dragOffset = { x: 0, y: 0 };
    let userCompletedMaterials = [];
    let lockedNodes = new Set();
    let activeClassId = '{{ $classId ?? '' }}';

    // Draw.io features
    let currentTool = 'pan';
    let zoomLevel = 1;
    let panOffset = { x: 0, y: 0 };
    let isPanning = false;
    let panStart = { x: 0, y: 0 };

    // Grid and canvas settings (draw.io style)
    const GRID_SIZE = 10;
    let gridEnabled = true;
    let spacePressed = false;

    // Read-only mode - disable editing
    const READ_ONLY = true;

    // Initialize canvas
    document.addEventListener('DOMContentLoaded', function() {
        initializeCanvas();
    });

    function initializeCanvas() {
        const canvas = document.getElementById('mindmap-canvas');
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const canvasViewport = document.querySelector('.canvas-viewport');

        // Prevent context menu on canvas
        canvas.addEventListener('contextmenu', e => e.preventDefault());

        // Mouse wheel for zoom (Ctrl + scroll)
        canvasViewport.addEventListener('wheel', handleWheel, { passive: false });

        // Initialize line style selection
        setTool('pan');
        updateNodeCount();

        // Fetch user progress for locking system
        fetchUserProgress().then(() => {
            // Load mindmap data after fetching progress
            const mindmapData = @json($mindmap->structure);
            if (mindmapData && mindmapData.nodes && mindmapData.connections) {
                renderMindmap(mindmapData);
                updateProgressBar();

                // Auto-center the mindmap after rendering
                setTimeout(() => autoCenterMindmap(), 100);
            }
        });
    }

    async function fetchUserProgress() {
        try {
            const response = await fetch('/api/user-progress');
            const data = await response.json();
            userCompletedMaterials = data.completed_materials || [];
        } catch (error) {
            console.error('Error fetching user progress:', error);
            userCompletedMaterials = [];
        }
    }

    function determineLockedNodes(structure) {
        lockedNodes.clear();

        if (!structure.connections || !structure.nodes) {
            return;
        }

        // Build a map of node dependencies
        const nodeDependencies = new Map();

        structure.connections.forEach(conn => {
            const fromNode = structure.nodes.find(n => n.id === conn.from);
            const toNode = structure.nodes.find(n => n.id === conn.to);

            if (fromNode && toNode && fromNode.materialId) {
                if (!nodeDependencies.has(conn.to)) {
                    nodeDependencies.set(conn.to, []);
                }
                nodeDependencies.get(conn.to).push(fromNode.materialId);
            }
        });

        // Determine which nodes should be locked
        structure.nodes.forEach(node => {
            if (node.materialId && nodeDependencies.has(node.id)) {
                const prerequisites = nodeDependencies.get(node.id);
                const allPrerequisitesCompleted = prerequisites.every(prereqId =>
                    userCompletedMaterials.includes(prereqId)
                );

                if (!allPrerequisitesCompleted) {
                    lockedNodes.add(node.id);
                }
            }
        });
    }

    function updateProgressBar() {
        const total = nodes.filter(function(node) {
            return node.materialId;
        }).length;

        const completed = nodes.filter(function(node) {
            return node.materialId && userCompletedMaterials.includes(node.materialId);
        }).length;

        const percentage = total > 0 ? Math.round((completed / total) * 100) : 0;

        const fill = document.getElementById('progress-bar-fill');
        const text = document.getElementById('progress-text');

        if (fill) {
            fill.style.width = percentage + '%';
        }
        if (text) {
            text.textContent = percentage + '%';
        }
    }

    function renderMindmap(structure) {
        const canvas = document.getElementById('mindmap-canvas');
        const loadingIndicator = document.getElementById('mindmap-loading');

        // Remove loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }

        // Determine which nodes should be locked
        determineLockedNodes(structure);

        if (structure.nodes) {
            structure.nodes.forEach(nodeData => {
                const node = document.createElement('div');
                let nodeClass = `mindmap-node ${nodeData.type || 'material'}`;

                // Add locked class if node is locked
                if (lockedNodes.has(nodeData.id)) {
                    nodeClass += ' locked';
                }

                // Add completed class if material is completed
                if (nodeData.materialId && userCompletedMaterials.includes(nodeData.materialId)) {
                    nodeClass += ' completed';
                }

                node.className = nodeClass;
                node.id = nodeData.id;
                node.style.left = nodeData.x + 'px';
                node.style.top = nodeData.y + 'px';

                node.innerHTML = `
                    <span class="node-label">${nodeData.title}</span>
                    ${lockedNodes.has(nodeData.id) ? '<i class="feather-lock lock-icon"></i>' : ''}
                `;

                // In read-only mode, make nodes clickable to navigate to material detail
                node.addEventListener('click', function(e) {
                    e.stopPropagation();

                    // Check if node is locked
                    if (lockedNodes.has(nodeData.id)) {
                        e.preventDefault();
                        alert('Materi ini terkunci. Selesaikan materi sebelumnya terlebih dahulu untuk membuka materi ini.');
                        return;
                    }

                    if (nodeData.materialSlug) {
                        // Use activeClassId from mindmap, fallback to URL parameter
                        const urlParams = new URLSearchParams(window.location.search);
                        const classId = activeClassId || urlParams.get('class_id');
                        const materialUrl = classId ? '/materi/' + nodeData.materialSlug + '?class_id=' + classId : '/materi/' + nodeData.materialSlug;
                        window.location.href = materialUrl;
                    } else if (nodeData.materialId) {
                        // If slug is not available, try to get it via AJAX
                        const urlParams = new URLSearchParams(window.location.search);
                        const classId = activeClassId || urlParams.get('class_id');
                        fetch(`/api/materials/${nodeData.materialId}/slug`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.slug) {
                                    const materialUrl = classId ? '/materi/' + data.slug + '?class_id=' + classId : '/materi/' + data.slug;
                                    window.location.href = materialUrl;
                                }
                            })
                            .catch(error => console.error('Error fetching material slug:', error));
                    }
                });

                // Add cursor pointer to indicate clickable (unless locked)
                if (!lockedNodes.has(nodeData.id)) {
                    node.style.cursor = 'pointer';
                } else {
                    node.style.cursor = 'not-allowed';
                }

                canvas.appendChild(node);

                nodes.push({
                    id: nodeData.id,
                    materialId: nodeData.materialId,
                    title: nodeData.title,
                    x: nodeData.x,
                    y: nodeData.y,
                    type: nodeData.type || 'material',
                    completed: nodeData.completed || false,
                    style: nodeData.style || {}
                });
            });
        }

        if (structure.connections) {
            structure.connections.forEach(connData => {
                connections.push(connData);
            });
            updateConnections();
        }

        updateNodeCount();
    }

    function updateNodeCount() {
        const el = document.getElementById('status-nodes');
        if (el) {
            const count = document.querySelectorAll('.mindmap-node:not(.root)').length;
            el.textContent = count + ' node';
        }
    }

    function autoCenterMindmap() {
        if (nodes.length === 0) return;

        const canvasViewport = document.querySelector('.canvas-viewport');
        const viewportWidth = canvasViewport.clientWidth;
        const viewportHeight = canvasViewport.clientHeight;

        // Calculate bounding box of all nodes
        let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;
        nodes.forEach(node => {
            const nodeEl = document.getElementById(node.id);
            if (nodeEl) {
                const width = nodeEl.offsetWidth;
                const height = nodeEl.offsetHeight;
                minX = Math.min(minX, node.x);
                maxX = Math.max(maxX, node.x + width);
                minY = Math.min(minY, node.y);
                maxY = Math.max(maxY, node.y + height);
            }
        });

        // Calculate mindmap dimensions
        const mindmapWidth = maxX - minX;
        const mindmapHeight = maxY - minY;

        // Center horizontally
        const scrollLeft = minX + (mindmapWidth / 2) - (viewportWidth / 2);

        // Scroll to show top with padding (not center vertically to avoid cutoff)
        const topPadding = 100; // Add 100px padding at top
        const scrollTop = minY - topPadding;

        canvasViewport.scrollLeft = scrollLeft;
        canvasViewport.scrollTop = scrollTop;
    }

    function updateToolStatus(tool) {
        const el = document.getElementById('status-tool');
        if (!el) return;
        const icons = { select: 'feather-mouse-pointer', pan: 'feather-move' };
        const labels = { select: 'Select', pan: 'Pan' };
        el.innerHTML = `<i class="${icons[tool] || 'feather-tool'}"></i> ${labels[tool] || tool}`;
    }

    function handleWheel(e) {
        if (e.ctrlKey || e.metaKey) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? 0.99 : 1.01;
            zoomLevel = Math.max(0.1, Math.min(5, zoomLevel * delta));
            updateZoom();
        }
        // Allow normal scrolling for panning
    }

    function setTool(tool) {
        if (READ_ONLY && tool !== 'pan') return;

        currentTool = tool;

        const canvas = document.getElementById('mindmap-canvas');
        switch(tool) {
            case 'select':
                canvas.style.cursor = 'default';
                break;
            case 'pan':
                canvas.style.cursor = 'grab';
                break;
            default:
                canvas.style.cursor = 'default';
                break;
        }

        updateToolStatus(tool);
    }

    function zoomIn() {
        zoomLevel = Math.min(zoomLevel * 1.1, 3);
        updateZoom();
    }

    function zoomOut() {
        zoomLevel = Math.max(zoomLevel / 1.1, 0.5);
        updateZoom();
    }

    function resetZoom() {
        zoomLevel = 1;
        updateZoom();
    }

    function updateZoom() {
        const canvas = document.getElementById('mindmap-canvas');

        // Use CSS zoom for scaling (works better with scrollbars)
        canvas.style.zoom = zoomLevel;

        // Update grid background size
        const scaledGridSize = 20 * zoomLevel;
        canvas.style.backgroundSize = `${scaledGridSize}px ${scaledGridSize}px`;

        // Update zoom level display
        document.querySelector('.zoom-level').textContent = Math.round(zoomLevel * 100) + '%';

        updateConnections();
    }

    // ─── Same anchor system as index.blade.php ───
    function getNodeAnchorXY(nodeId, anchor) {
        const nodeData = nodes.find(n => n.id === nodeId);
        const el = document.getElementById(nodeId);
        if (!nodeData || !el) return null;
        const w = el.offsetWidth, h = el.offsetHeight;
        const map = {
            r: { x: nodeData.x + w,     y: nodeData.y + h / 2 },
            l: { x: nodeData.x,          y: nodeData.y + h / 2 },
            b: { x: nodeData.x + w / 2,  y: nodeData.y + h     },
            t: { x: nodeData.x + w / 2,  y: nodeData.y         }
        };
        return map[anchor] || map['r'];
    }

    function getBestAnchors(fromId, toId) {
        const fn = nodes.find(n => n.id === fromId);
        const tn = nodes.find(n => n.id === toId);
        const fe = document.getElementById(fromId);
        const te = document.getElementById(toId);
        if (!fn || !tn || !fe || !te) return { from: 'r', to: 'l' };
        const fcx = fn.x + fe.offsetWidth / 2;
        const fcy = fn.y + fe.offsetHeight / 2;
        const tcx = tn.x + te.offsetWidth / 2;
        const tcy = tn.y + te.offsetHeight / 2;
        const dx = tcx - fcx, dy = tcy - fcy;
        if (Math.abs(dx) >= Math.abs(dy)) {
            return dx >= 0 ? { from: 'r', to: 'l' } : { from: 'l', to: 'r' };
        } else {
            return dy >= 0 ? { from: 'b', to: 't' } : { from: 't', to: 'b' };
        }
    }

    function updateConnections() {
        const svg = document.getElementById('connections-svg');
        if (!svg) return;
        svg.querySelectorAll('.conn-path, .conn-hit').forEach(el => el.remove());

        const styleColor  = { solid:'#475569', dashed:'#3b82f6', dotted:'#10b981', thick:'#7c3aed' };
        const styleDash   = { dashed:'8 4', dotted:'2 5' };
        const styleWidth  = { thick: 4 };
        const styleMarker = { dashed:'arrow-dashed', dotted:'arrow-dotted', thick:'arrow-thick' };

        connections.forEach(conn => {
            const anchors = getBestAnchors(conn.from, conn.to);
            const p1 = getNodeAnchorXY(conn.from, anchors.from);
            const p2 = getNodeAnchorXY(conn.to,   anchors.to);
            if (!p1 || !p2) return;

            const style    = conn.style || 'solid';
            const lineType = conn.lineType || 'straight';
            const stroke   = styleColor[style] || '#475569';
            const sw       = styleWidth[style] || 2;
            const marker   = styleMarker[style] || 'arrow-solid';

            let d;
            if (lineType === 'curved') {
                const tension = Math.max(60, Math.abs(p2.x - p1.x) * 0.5, Math.abs(p2.y - p1.y) * 0.5);
                const anchorDir = { r:[1,0], l:[-1,0], b:[0,1], t:[0,-1] };
                const d1 = anchorDir[anchors.from] || [1,0];
                const d2 = anchorDir[anchors.to]   || [-1,0];
                d = `M ${p1.x} ${p1.y} C ${p1.x+d1[0]*tension} ${p1.y+d1[1]*tension}, ${p2.x+d2[0]*tension} ${p2.y+d2[1]*tension}, ${p2.x} ${p2.y}`;
            } else {
                d = `M ${p1.x} ${p1.y} L ${p2.x} ${p2.y}`;
            }

            const hit = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            hit.setAttribute('d', d);
            hit.setAttribute('class', 'conn-hit');
            hit.setAttribute('fill', 'none');
            hit.setAttribute('stroke', 'transparent');
            hit.setAttribute('stroke-width', '14');
            hit.style.pointerEvents = 'stroke';
            svg.appendChild(hit);

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('d', d);
            path.setAttribute('class', 'conn-path');
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke', stroke);
            path.setAttribute('stroke-width', sw);
            if (styleDash[style]) path.setAttribute('stroke-dasharray', styleDash[style]);
            path.setAttribute('marker-end', `url(#${marker})`);
            path.style.pointerEvents = 'none';
            svg.appendChild(path);
        });
    }
    </script>
    @endif
@endsection