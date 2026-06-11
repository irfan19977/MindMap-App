@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Mind Map Creator</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item">Mind Map</li>
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
                    <button id="save-mindmap-btn" class="btn btn-primary">
                        <i class="feather-save me-2"></i>Simpan Mind Map
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- [ Main Content ] start -->
    <div class="main-content">
        <div class="drawio-layout">
            <!-- Toolbar -->
            <div class="drawio-toolbar">
                <div class="toolbar-section">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-tool="select" onclick="setTool('select')" title="Select (V)">
                            <i class="feather-mouse-pointer"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-tool="pan" onclick="setTool('pan')" title="Pan (Space + drag)">
                            <i class="feather-move"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-divider"></div>
                    
                    <div class="btn-group me-2">
                        <button class="btn btn-sm btn-outline-warning" onclick="zoomIn()" title="Zoom In">
                            <i class="feather-zoom-in"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="zoomOut()" title="Zoom Out">
                            <i class="feather-zoom-out"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="resetZoom()" title="Reset Zoom">
                            <i class="feather-maximize-2"></i>
                        </button>
                    </div>
                </div>
                
                <div class="toolbar-section ms-auto">
                    <div class="btn-group">
                        <button onclick="clearCanvas()" class="btn btn-sm btn-outline-danger" title="Clear Canvas">
                            <i class="feather-trash-2"></i>
                        </button>
                        <button onclick="saveMindmap()" class="btn btn-sm btn-primary" title="Save">
                            <i class="feather-save"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="drawio-workspace">
                <!-- Left Panel - Categories -->
                <div class="drawio-left-panel custom-scrollbar">
                    <div class="panel-section panel-section--flex">
                        <div class="panel-header panel-header--accent">
                            <div class="panel-header__row">
                                <h6 class="mb-0"><i class="feather-layers me-2"></i>Kategori</h6>
                                <span class="panel-badge">{{ $categories->count() }}</span>
                            </div>
                            <p class="panel-subtitle mb-0">Pilih kategori untuk memuat materi</p>
                        </div>
                        <div class="panel-body panel-body--categories">
                            <div class="panel-search">
                                <i class="feather-search panel-search__icon"></i>
                                <input type="text" id="category-search" class="panel-search__input" placeholder="Cari kategori..." oninput="filterCategories(this.value)">
                            </div>
                            <div id="selected-category-label" class="selected-category-chip d-none">
                                <i class="feather-check-circle"></i>
                                <span id="selected-category-text"></span>
                            </div>
                            <div class="category-list custom-scrollbar" id="category-list">
                                @foreach($categories as $category)
                                    <div class="category-group mb-3" data-category-group="{{ $category->id }}">
                                        <button 
                                            onclick="toggleCategory('{{ $category->id }}', '{{ $category->name }}')"
                                            class="category-btn w-full text-start d-flex align-items-center"
                                            data-category-id="{{ $category->id }}">
                                            <span class="category-icon">
                                                <i class="feather-folder"></i>
                                            </span>
                                            <span class="category-text">{{ $category->name }}</span>
                                            @if($category->subcategories->count() > 0)
                                                <span class="category-arrow ms-auto">
                                                    <i class="feather-chevron-down"></i>
                                                </span>
                                            @endif
                                        </button>

                                        @if($category->subcategories->count() > 0)
                                            <div class="category-children" id="category-children-{{ $category->id }}">
                                                @foreach($category->subcategories as $child)
                                                    <button 
                                                        onclick="selectCategory('{{ $child->id }}', '{{ $category->name }} > {{ $child->name }}')"
                                                        class="category-btn category-child w-full text-start d-flex align-items-center"
                                                        data-category-id="{{ $child->id }}">
                                                        <span class="category-icon child-icon">
                                                            <i class="feather-folder"></i>
                                                        </span>
                                                        <span class="category-text">{{ $child->name }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Canvas Area -->
                <div class="drawio-canvas-area">
                    <div class="canvas-chrome">
                        <span class="canvas-chrome__hint"><i class="feather-info"></i> Seret dari titik node untuk menghubungkan · Space + drag untuk geser · Ctrl + scroll untuk zoom</span>
                    </div>
                    <div class="canvas-viewport">
                        <div id="mindmap-canvas" class="canvas-container" style="width: 3000px; height: 3000px;">
                            <svg id="connections-svg" class="connections-layer"></svg>

                            <!-- Root node removed - start with empty canvas -->
                            <!-- <div id="root-node" class="mindmap-node root" style="left: 1500px; top: 1500px;">
                                <span class="node-label" id="root-text">Operating System</span>
                                <div class="connection-anchor anchor-tl" data-anchor="tl" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-t" data-anchor="t" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-tr" data-anchor="tr" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-r" data-anchor="r" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-br" data-anchor="br" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-b" data-anchor="b" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-bl" data-anchor="bl" data-node-id="root-node"></div>
                                <div class="connection-anchor anchor-l" data-anchor="l" data-node-id="root-node"></div>
                            </div> -->

                            <input type="hidden" id="connection-style" value="solid">
                        </div>
                    </div>

                    <div class="canvas-statusbar">
                        <span class="canvas-statusbar__item" id="status-tool"><i class="feather-move"></i> Pan</span>
                        <span class="canvas-statusbar__divider"></span>
                        <span class="canvas-statusbar__item" id="status-line-style">Garis: Solid</span>
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

                <!-- Right Panel - Materi & Garis Koneksi (tabs) -->
                <div class="drawio-right-panel">
                    <div class="mm-panel-tabs" role="tablist">
                        <button type="button" class="mm-panel-tab active" role="tab" aria-selected="true" data-tab="materials" onclick="switchRightPanelTab('materials')">
                            <i class="feather-book-open"></i>
                            <span>Materi</span>
                            <span id="materials-count" class="mm-panel-tab__badge">0</span>
                        </button>
                        <button type="button" class="mm-panel-tab" role="tab" aria-selected="false" data-tab="connections" onclick="switchRightPanelTab('connections')">
                            <i class="feather-git-branch"></i>
                            <span>Garis</span>
                        </button>
                    </div>

                    <div class="mm-panel-tab-content custom-scrollbar">
                        <div class="mm-tab-pane active" id="tab-materials" role="tabpanel">
                            <div class="mm-tab-pane__header">
                                <p class="mm-tab-pane__hint mb-0">Seret materi ke canvas untuk menambah node</p>
                            </div>
                            <div class="panel-body panel-body--materials">
                                <div id="materials-list" class="materials-list custom-scrollbar">
                                    <div class="empty-state">
                                        <div class="empty-state__icon"><i class="feather-inbox"></i></div>
                                        <p class="empty-state__title">Belum ada materi</p>
                                        <p class="empty-state__hint">Pilih kategori di panel kiri untuk memuat daftar materi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mm-tab-pane" id="tab-connections" role="tabpanel">
                            <div class="mm-tab-pane__header">
                                <p class="mm-tab-pane__hint mb-0">Klik garis untuk memilih, lalu pilih gaya garis untuk mengubahnya</p>
                            </div>
                            <div class="panel-body panel-body--connections">
                            <div class="connection-hint" id="connection-hint">
                                <i class="feather-mouse-pointer"></i>
                                <span>Pilih gaya garis, seret dari titik node sumber ke titik node tujuan</span>
                            </div>

                            <p class="line-group-label">Dasar</p>
                            <div class="line-style-grid">
                                <div class="line-style-item selected" data-line-style="solid" onclick="setLineStyle('solid')" title="Garis Solid">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Solid</span>
                                </div>
                                <div class="line-style-item" data-line-style="dashed" onclick="setLineStyle('dashed')" title="Garis Putus-putus">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#ef4444" stroke-width="2" stroke-dasharray="8,4"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Dashed</span>
                                </div>
                                <div class="line-style-item" data-line-style="dotted" onclick="setLineStyle('dotted')" title="Garis Titik-titik">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#10b981" stroke-width="2" stroke-dasharray="2,4"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Dotted</span>
                                </div>
                                <div class="line-style-item" data-line-style="curved" onclick="setLineStyle('curved')" title="Garis Melengkung">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 Q20 5 35 15" stroke="#f59e0b" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Curved</span>
                                </div>
                            </div>

                            <p class="line-group-label">Lanjutan</p>
                            <div class="line-style-grid">
                                <div class="line-style-item" data-line-style="thick" onclick="setLineStyle('thick')" title="Garis Tebal">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#8b5cf6" stroke-width="4"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Thick</span>
                                </div>
                                <div class="line-style-item" data-line-style="double" onclick="setLineStyle('double')" title="Garis Ganda">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="13" x2="35" y2="13" stroke="#ec4899" stroke-width="2"/>
                                            <line x1="5" y1="17" x2="35" y2="17" stroke="#ec4899" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Double</span>
                                </div>
                                <div class="line-style-item" data-line-style="wavy" onclick="setLineStyle('wavy')" title="Garis Bergelombang">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 Q10 10 15 15 T25 15 T35 15" stroke="#06b6d4" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Wavy</span>
                                </div>
                                <div class="line-style-item" data-line-style="manual" onclick="setLineStyle('manual')" title="Manual Path">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 L10 10 L20 20 L30 8 L35 15" stroke="#6b7280" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Manual</span>
                                </div>
                            </div>

                            <p class="line-group-label">Mind map</p>
                            <div class="line-style-grid line-style-grid--single">
                                <div class="line-style-item" data-line-style="sub-topic" onclick="setLineStyle('sub-topic')" title="Sub Topic (Dotted)">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.7"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Sub Topic</span>
                                </div>
                                <div class="line-style-item" data-line-style="hierarchy" onclick="setLineStyle('hierarchy')" title="Hierarchy (Thick)">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="3"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Hierarchy</span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>

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
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border: 2px solid #cbd5e1;
        border-radius: 16px;
        padding: 14px 20px;
        cursor: default;
        user-select: none;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1), 0 2px 4px rgba(15, 23, 42, 0.06);
        transition: none !important;
        z-index: 10;
        min-width: 130px;
        white-space: nowrap;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.5;
        color: #1e293b;
        backdrop-filter: blur(12px);
        pointer-events: auto;
    }

    .mindmap-node:hover,
    .mindmap-node:active,
    .mindmap-node:focus {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%) !important;
        border: 2px solid #cbd5e1 !important;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1), 0 2px 4px rgba(15, 23, 42, 0.06) !important;
        transform: none !important;
        color: #1e293b !important;
        text-shadow: none !important;
    }

    .mindmap-node:hover *,
    .mindmap-node:active *,
    .mindmap-node:focus * {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        transform: none !important;
        color: inherit !important;
        text-shadow: none !important;
    }

    .mindmap-node:hover:not(.root) {
        /* Hover effect disabled */
    }

    .mindmap-node.root {
        transform: translate(-50%, -50%);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        font-weight: 600;
        font-size: 15px;
        padding: 16px 24px;
        min-width: 160px;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4), 0 4px 16px rgba(102, 126, 234, 0.3);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .mindmap-node.root:hover {
        /* Hover effect disabled */
    }

    .mindmap-node.root .node-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 8px;
        font-size: 14px;
        backdrop-filter: blur(4px);
    }

    .mindmap-node.root .node-label {
        flex: 1;
    }

    .mindmap-node.selected {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2), 0 12px 32px rgba(59, 130, 246, 0.25);
        transform: none !important;
    }

    .mindmap-node.connection-source {
        border-color: #10b981;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0.4);
        }
        100% {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);
        }
    }

    .mindmap-node.subcategory {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
        transition: none;
    }

    .mindmap-node.subcategory:hover {
        /* Hover effect disabled */
    }

    .mindmap-node.material {
        background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%);
        color: white;
        border: none;
        box-shadow: 0 6px 20px rgba(255, 107, 53, 0.35), 0 3px 10px rgba(255, 107, 53, 0.2);
        backdrop-filter: blur(10px);
        transition: none !important;
    }

    .mindmap-node.material:hover,
    .mindmap-node.material:active,
    .mindmap-node.material:focus,
    .mindmap-node.material:hover *,
    .mindmap-node.material:active *,
    .mindmap-node.material:focus * {
        background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%) !important;
        color: white !important;
        border: none !important;
        box-shadow: 0 6px 20px rgba(255, 107, 53, 0.35), 0 3px 10px rgba(255, 107, 53, 0.2) !important;
        transform: none !important;
        text-shadow: none !important;
    }

    .mindmap-node.completed {
        position: relative;
    }

    .mindmap-node.completed::after {
        content: '✓';
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: bold;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .mindmap-node.sub-topic {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-color: #f59e0b;
        font-size: 13px;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        transition: none;
    }

    .mindmap-node.sub-topic:hover {
        /* Hover effect disabled */
    }

    .mindmap-node.main-topic {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        font-weight: bold;
        font-size: 15px;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        transition: none;
    }

    .mindmap-node.main-topic:hover {
        /* Hover effect disabled */
    }

    .completion-toggle {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        color: #64748b;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 15;
    }

    .completion-toggle:hover {
        /* Hover effect disabled */
    }

    .completion-toggle.completed {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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

    .control-point {
        transition: all 0.2s ease;
    }

    .control-point:hover {
        r: 8;
        fill: #2563eb;
        stroke-width: 3;
    }

    .control-point:active {
        r: 10;
        fill: #1d4ed8;
    }

    .resize-handle {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #3b82f6;
        border: 2px solid white;
        border-radius: 50%;
        cursor: pointer;
        z-index: 20;
        transition: all 0.2s ease;
    }

    .resize-handle:hover {
        /* Hover effect disabled */
    }

    .resize-handle.nw { top: -5px; left: -5px; cursor: nw-resize; }
    .resize-handle.n { top: -5px; left: 50%; transform: translateX(-50%); cursor: n-resize; }
    .resize-handle.ne { top: -5px; right: -5px; cursor: ne-resize; }
    .resize-handle.e { top: 50%; right: -5px; transform: translateY(-50%); cursor: e-resize; }
    .resize-handle.se { bottom: -5px; right: -5px; cursor: se-resize; }
    .resize-handle.s { bottom: -5px; left: 50%; transform: translateX(-50%); cursor: s-resize; }
    .resize-handle.sw { bottom: -5px; left: -5px; cursor: sw-resize; }
    .resize-handle.w { top: 50%; left: -5px; transform: translateY(-50%); cursor: w-resize; }

    /* Connection anchor points */
    .connection-anchor {
        position: absolute;
        width: 10px;
        height: 10px;
        background: rgba(59, 130, 246, 0.9);
        border: 2px solid white;
        border-radius: 50%;
        cursor: crosshair;
        z-index: 25;
        opacity: 0;
        transition: all 0.25s ease;
        pointer-events: none;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    }

    .mindmap-node:hover .connection-anchor,
    .mindmap-node.show-anchors .connection-anchor {
        /* Anchor visibility disabled */
    }

    .connection-anchor:hover {
        /* Hover effect disabled */
    }

    .connection-anchor.active {
        background: #10b981;
        animation: anchor-pulse 1s infinite;
    }

    @keyframes anchor-pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
    }

    /* Anchor positions */
    .anchor-tl { top: -6px; left: -6px; }
    .anchor-t { top: -6px; left: 50%; transform: translateX(-50%); }
    .anchor-tr { top: -6px; right: -6px; }
    .anchor-r { top: 50%; right: -6px; transform: translateY(-50%); }
    .anchor-br { bottom: -6px; right: -6px; }
    .anchor-b { bottom: -6px; left: 50%; transform: translateX(-50%); }
    .anchor-bl { bottom: -6px; left: -6px; }
    .anchor-l { top: 50%; left: -6px; transform: translateY(-50%); }

    /* Temporary connection line */
    .temp-connection-line {
        stroke: #3b82f6;
        stroke-width: 2;
        stroke-dasharray: 5, 5;
        fill: none;
        pointer-events: none;
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


    .btn-xs {
        padding: 2px 6px;
        font-size: 10px;
        line-height: 1.2;
        border-radius: 3px;
    }

    .category-btn {
        background: var(--mm-surface);
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        padding: 8px 10px;
        margin-bottom: 5px;
        transition: all 0.18s ease;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        box-shadow: var(--mm-shadow);
        width: 100%;
    }

    .category-btn:hover {
        /* Hover effect disabled */
    }

    .category-btn.active {
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        color: #fff !important;
        border-color: var(--mm-primary-dark) !important;
        box-shadow: 0 4px 14px rgba(52, 84, 209, 0.28);
    }

    .category-group.is-hidden {
        display: none;
    }

    .category-icon {
        width: 26px;
        height: 26px;
        background: var(--mm-primary-light);
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--mm-primary);
        margin-right: 8px;
        flex-shrink: 0;
        transition: all 0.18s ease;
        font-size: 13px;
    }

    .category-btn:hover .category-icon {
        background: var(--mm-primary);
        color: #fff;
    }

    .category-btn.active .category-icon {
        background: rgba(255, 255, 255, 0.22);
        color: #fff;
    }

    .category-text {
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .category-arrow {
        color: #6b7280;
        transition: transform 0.2s ease;
    }

    .category-children {
        margin-left: 8px;
        margin-top: 4px;
        padding-left: 8px;
        border-left: 2px solid var(--mm-border);
        display: none;
    }

    .category-children.show {
        display: block;
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .category-child {
        padding: 7px 10px;
        font-size: 11px;
    }

    .category-child .category-icon {
        width: 28px;
        height: 28px;
        margin-right: 10px;
    }

    .child-icon {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #10b981;
    }

    .category-btn:hover .child-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .category-btn.active .child-icon {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
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

    .material-item {
        cursor: default;
        transition: none;
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        padding: 8px 10px;
        margin-bottom: 5px;
        background: var(--mm-surface);
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }

    .material-item__icon {
        width: 24px;
        height: 24px;
        background: #ecfdf5;
        color: var(--mm-success);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
    }

    .material-item__body {
        flex: 1;
        min-width: 0;
    }

    .material-item__title {
        font-size: 11px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 2px;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .material-item__meta {
        font-size: 10px;
        color: var(--mm-muted);
    }

    .material-item:hover {
        /* Hover effect disabled */
    }

    .material-item:active {
        cursor: default;
        opacity: 1;
    }

    .panel-search {
        position: relative;
        margin-bottom: 12px;
    }

    .panel-search__icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .panel-search__input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid var(--mm-border);
        border-radius: 8px;
        font-size: 12px;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .panel-search__input:focus {
        outline: none;
        border-color: var(--mm-primary);
        box-shadow: 0 0 0 3px rgba(52, 84, 209, 0.12);
        background: #fff;
    }

    .selected-category-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        margin-bottom: 10px;
        background: var(--mm-primary-light);
        border: 1px solid #c7d2fe;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 500;
        color: var(--mm-primary-dark);
    }

    .selected-category-chip i {
        flex-shrink: 0;
        font-size: 14px;
    }

    .btn.w-full {
        width: 100%;
    }

    /* Editor layout */
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

    .drawio-toolbar {
        height: 48px;
        background: linear-gradient(180deg, #fafbfc 0%, #f1f5f9 100%);
        border-bottom: 1px solid var(--mm-border);
        display: flex;
        align-items: center;
        padding: 0 14px;
        flex-shrink: 0;
    }

    .drawio-toolbar .btn.active {
        background: var(--mm-primary);
        border-color: var(--mm-primary);
        color: #fff;
    }

    .toolbar-section {
        display: flex;
        align-items: center;
    }

    .toolbar-divider {
        width: 1px;
        height: 30px;
        background: #dee2e6;
        margin: 0 10px;
    }

    .drawio-workspace {
        flex: 1;
        display: flex;
        overflow: hidden;
    }

    .drawio-left-panel,
    .drawio-right-panel {
        width: var(--mm-panel-width);
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fafbfc;
    }

    .drawio-left-panel {
        border-right: 1px solid var(--mm-border);
    }

    .drawio-right-panel {
        border-left: 1px solid var(--mm-border);
    }

    .drawio-canvas-area {
        flex: 1;
        position: relative;
        background: #e2e8f0;
        overflow: hidden;
        min-width: 0;
    }

    .panel-section {
        border-bottom: 1px solid var(--mm-border);
    }

    .drawio-left-panel .panel-section--flex {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        border-bottom: none;
    }

    .panel-body--categories {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
        padding: 10px 12px;
    }

    .panel-header {
        padding: 10px 12px;
        border-bottom: 1px solid var(--mm-border);
        background: var(--mm-surface);
    }

    .panel-header--accent { border-left: 3px solid var(--mm-primary); }
    .panel-header--materials { border-left: 3px solid var(--mm-success); }
    .panel-header--connection { border-left: 3px solid #0ea5e9; }

    .panel-header__row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .panel-header h6 {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .panel-subtitle {
        font-size: 11px;
        color: var(--mm-muted);
        margin-top: 4px;
        line-height: 1.35;
    }

    .panel-badge {
        font-size: 10px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 999px;
        background: var(--mm-primary-light);
        color: var(--mm-primary);
    }

    .panel-badge--success {
        background: #ecfdf5;
        color: var(--mm-success);
    }

    .panel-body {
        padding: 14px 16px;
    }

    .panel-body--connections {
        padding: 12px 16px 16px;
        overflow-y: auto;
        flex: 1;
        min-height: 0;
    }

    .panel-body--materials {
        flex: 1;
        overflow: hidden;
        padding: 8px 10px 10px;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .category-list {
        flex: 1;
        overflow-y: auto;
        min-height: 0;
    }

    /* Right panel tabs */
    .mm-panel-tabs {
        display: flex;
        flex-shrink: 0;
        border-bottom: 1px solid var(--mm-border);
        background: var(--mm-surface);
    }

    .mm-panel-tab {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 10px 8px;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        background: transparent;
        font-size: 11px;
        font-weight: 600;
        color: var(--mm-muted);
        cursor: pointer;
        transition: color 0.18s ease, background 0.18s ease, border-color 0.18s ease;
    }

    .mm-panel-tab i {
        font-size: 14px;
    }

    .mm-panel-tab:hover {
        /* Hover effect disabled */
    }

    .mm-panel-tab.active {
        color: var(--mm-primary);
        border-bottom-color: var(--mm-primary);
        background: var(--mm-primary-light);
    }

    .mm-panel-tab__badge {
        font-size: 10px;
        font-weight: 600;
        padding: 1px 6px;
        border-radius: 999px;
        background: #ecfdf5;
        color: var(--mm-success);
        line-height: 1.4;
    }

    .mm-panel-tab.active .mm-panel-tab__badge {
        background: rgba(255, 255, 255, 0.95);
        color: var(--mm-primary);
    }

    .mm-panel-tab-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
    }

    .mm-tab-pane {
        display: none;
        flex-direction: column;
        flex: 1;
        min-height: 0;
        overflow: hidden;
    }

    .mm-tab-pane.active {
        display: flex;
    }

    .mm-tab-pane__header {
        flex-shrink: 0;
        padding: 8px 12px;
        background: #fafbfc;
        border-bottom: 1px solid var(--mm-border);
    }

    .mm-tab-pane__hint {
        font-size: 11px;
        color: var(--mm-muted);
        line-height: 1.35;
    }

    .line-group-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        margin: 12px 0 8px;
    }

    .line-group-label:first-of-type {
        margin-top: 0;
    }

    .line-style-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .line-style-grid--single {
        grid-template-columns: repeat(2, 1fr);
    }

    .line-style-item {
        border: 1px solid var(--mm-border);
        border-radius: 8px;
        padding: 8px 6px;
        cursor: pointer;
        transition: all 0.18s ease;
        text-align: center;
        background: var(--mm-surface);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .line-style-item:hover {
        /* Hover effect disabled */
    }

    .line-style-item.selected {
        border-color: var(--mm-primary);
        background: var(--mm-primary-light);
        box-shadow: 0 0 0 2px rgba(52, 84, 209, 0.2);
    }

    .line-preview {
        background: #f8fafc;
        border-radius: 6px;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .line-label {
        font-size: 10px;
        font-weight: 500;
        color: var(--mm-muted);
    }

    .connection-hint {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        margin-bottom: 14px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        font-size: 11px;
        color: #0369a1;
        line-height: 1.4;
    }

    .connection-hint i {
        flex-shrink: 0;
        margin-top: 1px;
        font-size: 14px;
    }

    .connection-hint.is-active {
        background: #ecfdf5;
        border-color: #6ee7b7;
        color: #047857;
    }

    .materials-list {
        flex: 1;
        overflow-y: auto;
        min-height: 120px;
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
        overflow: hidden;
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
        /* Hover effect disabled */
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
        /* Hover effect disabled */
    }

    /* Keyboard shortcut styling */
    kbd {
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 11px;
        font-family: monospace;
        box-shadow: 0 1px 0 rgba(0,0,0,0.1);
    }

</style>

<script>
    let selectedCategory = null;
    let selectedNode = null;
    let selectedNodeForConnection = null;
    let selectedConnection = null;
    let nodeIdCounter = 1;
    let connections = [];
    let nodes = [];
    let isDragging = false;
    let draggedNode = null;
    let dragOffset = { x: 0, y: 0 };
    let connectionMode = false;
    let manualDrawingMode = false;
    let currentDrawingPath = [];
    let drawingStartNode = null;
    let tempConnectionLine = null;
    let controlPoints = [];
    let draggedControlPoint = null;

    // Drag-to-connect state
    let isDraggingConnection = false;
    let dragConnectionStartNode = null;
    let dragConnectionStartAnchor = null;
    let dragConnectionTempLine = null;
    let dragConnectionCurrentTarget = null;

    // Draw.io features
    let currentTool = 'pan';
    let zoomLevel = 1;
    let panOffset = { x: 0, y: 0 };
    let isPanning = false;
    let panStart = { x: 0, y: 0 };
    let selectedShape = null;

    // Grid and canvas settings (draw.io style)
    const GRID_SIZE = 10; // 10px grid
    let gridEnabled = true;
    let spacePressed = false;

    // Initialize canvas
    document.addEventListener('DOMContentLoaded', function() {
        initializeCanvas();
    });

    function initializeCanvas() {
        const canvas = document.getElementById('mindmap-canvas');
        const canvasArea = document.querySelector('.drawio-canvas-area');
        
        // Center canvas horizontally at 100% zoom
        const canvasWidth = 3000; // Canvas width from HTML
        const viewportWidth = canvasArea.clientWidth;
        const centerOffset = (viewportWidth - canvasWidth) / 2;
        panOffset.x = centerOffset;
        panOffset.y = 0; // Keep at top
        
        // Apply initial positioning
        updateZoom();
        
        // Mouse events for dragging nodes
        canvas.addEventListener('mousedown', handleMouseDown);
        document.addEventListener('mousemove', handleMouseMove);
        document.addEventListener('mouseup', handleMouseUp);
        
        // Canvas click for manual drawing
        canvas.addEventListener('click', handleCanvasClick);
        
        // Prevent context menu on canvas
        canvas.addEventListener('contextmenu', e => e.preventDefault());
        
        // Mouse wheel for zoom (draw.io style)
        canvasArea.addEventListener('wheel', handleWheel, { passive: false });
        
        // Spacebar for pan mode (draw.io style)
        document.addEventListener('keydown', handleKeyDown);
        document.addEventListener('keyup', handleKeyUp);
        
        // Pan with middle mouse button
        canvasArea.addEventListener('mousedown', handleMiddleMousePan);
        
        // Initialize drag and drop
        initializeDragDrop();

        // Initialize line style selection
        setLineStyle('solid');
        setTool('pan');
        updateNodeCount();

        // Add event listener to save button
        const saveBtn = document.getElementById('save-mindmap-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', saveMindmap);
        }

        // Add click listener to root node (disabled - no root node)
        // const rootNode = document.getElementById('root-node');
        // if (rootNode) {
        //     rootNode.addEventListener('click', function(e) {
        //         e.stopPropagation();
        //         selectNode('root-node');
        //     });

        //     // Add event listeners to root node anchors
        //     const rootAnchors = rootNode.querySelectorAll('.connection-anchor');
        //     rootAnchors.forEach(anchor => {
        //         const anchorPos = anchor.dataset.anchor;
        //         anchor.addEventListener('mousedown', (e) => handleAnchorMouseDown(e, 'root-node', anchorPos));
        //     });
        // }

        // Initialize the Operating System mind map structure (disabled - start with empty canvas)
        // setTimeout(() => {
        //     initializeOperatingSystemMindmap();
        // }, 100);
    }

    // Initialize mind map with Operating System structure
    function initializeOperatingSystemMindmap() {
        // Clear existing nodes and connections
        const existingNodes = document.querySelectorAll('.mindmap-node:not(.root)');
        existingNodes.forEach(node => node.remove());
        nodes.length = 0;
        connections.length = 0;
        updateConnections();

        const centerX = 1500;
        const centerY = 1500;

        // Main topic nodes
        const windowsNode = addMaterialNode('windows', 'Windows', '', centerX - 400, centerY - 300, 'main-topic');
        const unixLinuxNode = addMaterialNode('unix-linux', 'Unix/Linux', '', centerX - 400, centerY, 'main-topic');
        const programmingNode = addMaterialNode('programming', 'Learn a Programming Language', '', centerX - 400, centerY + 300, 'main-topic');
        const terminalNode = addMaterialNode('terminal', 'Terminal Knowledge', '', centerX + 400, centerY - 300, 'main-topic');
        const processNode = addMaterialNode('process', 'Process Monitoring', '', centerX + 400, centerY, 'main-topic');
        const performanceNode = addMaterialNode('performance', 'Performance Monitoring', '', centerX + 400, centerY + 300, 'main-topic');
        const networkingNode = addMaterialNode('networking', 'Networking Tools', '', centerX, centerY - 400, 'main-topic');
        const textNode = addMaterialNode('text', 'Text Manipulation', '', centerX, centerY + 400, 'main-topic');

        // Unix/Linux sub-topics
        const freebsdNode = addMaterialNode('freebsd', 'FreeBSD', '', centerX - 600, centerY - 100, 'sub-topic');
        const openbsdNode = addMaterialNode('openbsd', 'OpenBSD', '', centerX - 600, centerY - 50, 'sub-topic');
        const netbsdNode = addMaterialNode('netbsd', 'NetBSD', '', centerX - 600, centerY, 'sub-topic');
        const ubuntuNode = addMaterialNode('ubuntu', 'Ubuntu / Debian', '', centerX - 600, centerY + 50, 'sub-topic');
        const suseNode = addMaterialNode('suse', 'SUSE Linux', '', centerX - 600, centerY + 100, 'sub-topic');
        const rhelNode = addMaterialNode('rhel', 'RHEL / Derivatives', '', centerX - 600, centerY + 150, 'sub-topic');

        // Programming sub-topics
        const pythonNode = addMaterialNode('python', 'Python', '', centerX - 600, centerY + 350, 'sub-topic');
        const rubyNode = addMaterialNode('ruby', 'Ruby', '', centerX - 600, centerY + 400, 'sub-topic');
        const goNode = addMaterialNode('go', 'Go', '', centerX - 600, centerY + 450, 'sub-topic');
        const rustNode = addMaterialNode('rust', 'Rust', '', centerX - 600, centerY + 500, 'sub-topic');
        const jsNode = addMaterialNode('js', 'JavaScript / Node.js', '', centerX - 600, centerY + 550, 'sub-topic');

        // Terminal Knowledge sub-topics
        const scriptingNode = addMaterialNode('scripting', 'Scripting', '', centerX + 600, centerY - 350, 'main-topic');
        const editorsNode = addMaterialNode('editors', 'Editors', '', centerX + 600, centerY - 250, 'main-topic');

        // Scripting sub-topics
        const bashNode = addMaterialNode('bash', 'Bash', '', centerX + 800, centerY - 380, 'sub-topic');
        const powershellNode = addMaterialNode('powershell', 'PowerShell', '', centerX + 800, centerY - 330, 'sub-topic');

        // Editors sub-topics
        const vimNode = addMaterialNode('vim', 'Vim / Nano / Emacs', '', centerX + 800, centerY - 280, 'sub-topic');

        // Connect root to main topics
        connectNodesWithAnchors('root-node', 'l', windowsNode.id, 'r', 'hierarchy');
        connectNodesWithAnchors('root-node', 'l', unixLinuxNode.id, 'r', 'hierarchy');
        connectNodesWithAnchors('root-node', 'l', programmingNode.id, 'r', 'hierarchy');
        connectNodesWithAnchors('root-node', 'r', terminalNode.id, 'l', 'hierarchy');
        connectNodesWithAnchors('root-node', 'r', processNode.id, 'l', 'hierarchy');
        connectNodesWithAnchors('root-node', 'r', performanceNode.id, 'l', 'hierarchy');
        connectNodesWithAnchors('root-node', 't', networkingNode.id, 'b', 'hierarchy');
        connectNodesWithAnchors('root-node', 'b', textNode.id, 't', 'hierarchy');

        // Connect Unix/Linux to sub-topics
        connectNodesWithAnchors(unixLinuxNode.id, 'l', freebsdNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(unixLinuxNode.id, 'l', openbsdNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(unixLinuxNode.id, 'l', netbsdNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(unixLinuxNode.id, 'l', ubuntuNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(unixLinuxNode.id, 'l', suseNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(unixLinuxNode.id, 'l', rhelNode.id, 'r', 'sub-topic');

        // Connect Programming to sub-topics
        connectNodesWithAnchors(programmingNode.id, 'l', pythonNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(programmingNode.id, 'l', rubyNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(programmingNode.id, 'l', goNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(programmingNode.id, 'l', rustNode.id, 'r', 'sub-topic');
        connectNodesWithAnchors(programmingNode.id, 'l', jsNode.id, 'r', 'sub-topic');

        // Connect Terminal Knowledge to sub-topics
        connectNodesWithAnchors(terminalNode.id, 'r', scriptingNode.id, 'l', 'hierarchy');
        connectNodesWithAnchors(terminalNode.id, 'r', editorsNode.id, 'l', 'hierarchy');

        // Connect Scripting to sub-topics
        connectNodesWithAnchors(scriptingNode.id, 'r', bashNode.id, 'l', 'sub-topic');
        connectNodesWithAnchors(scriptingNode.id, 'r', powershellNode.id, 'l', 'sub-topic');

        // Connect Editors to sub-topics
        connectNodesWithAnchors(editorsNode.id, 'r', vimNode.id, 'l', 'sub-topic');

        // Mark some nodes as completed (simulating the checkmarks in the image)
        setTimeout(() => {
            const completedNodes = [pythonNode.id, bashNode.id, vimNode.id, ubuntuNode.id];
            completedNodes.forEach(nodeId => {
                const node = document.getElementById(nodeId);
                const nodeData = nodes.find(n => n.id === nodeId);
                if (node && nodeData) {
                    nodeData.completed = true;
                    node.classList.add('completed');
                    const toggle = node.querySelector('.completion-toggle');
                    if (toggle) toggle.classList.add('completed');
                }
            });
        }, 100);
    }

    // Grid snapping function (draw.io style)
    function snapToGrid(value) {
        if (!gridEnabled) return value;
        return Math.round(value / GRID_SIZE) * GRID_SIZE;
    }

    // Mouse wheel zoom handler
    function handleWheel(e) {
        if (e.ctrlKey || e.metaKey) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? 0.99 : 1.01;
            zoomLevel = Math.max(0.1, Math.min(5, zoomLevel * delta));
            updateZoom();
        }
    }

    function isTypingInField() {
        const el = document.activeElement;
        if (!el) return false;
        const tag = el.tagName;
        if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return true;
        return el.isContentEditable;
    }

    // Spacebar handlers for pan mode
    function handleKeyDown(e) {
        if (isTypingInField()) return;

        if (e.code === 'Space' && !spacePressed) {
            e.preventDefault();
            spacePressed = true;
            document.getElementById('mindmap-canvas').style.cursor = 'grab';
        } else if (e.key === 'Delete' || e.key === 'Backspace') {
            e.preventDefault();
            deleteSelectedElement();
        }
    }

    function handleKeyUp(e) {
        if (isTypingInField()) return;

        if (e.code === 'Space') {
            spacePressed = false;
            document.getElementById('mindmap-canvas').style.cursor = 'default';
        }
    }

    // Middle mouse pan handler
    function handleMiddleMousePan(e) {
        if (e.button === 1) { // Middle mouse button
            e.preventDefault();
            startPan(e);
        }
    }

    function handleControlPointMouseDown(e) {
        e.stopPropagation();
        e.preventDefault();
        
        const connectionId = e.target.getAttribute('data-connection-id');
        const type = e.target.getAttribute('data-type');
        const index = e.target.getAttribute('data-index');
        
        draggedControlPoint = {
            element: e.target,
            connectionId: connectionId,
            type: type,
            index: index ? parseInt(index) : null,
            startX: parseFloat(e.target.getAttribute('cx')),
            startY: parseFloat(e.target.getAttribute('cy'))
        };
        
        console.log('Started dragging control point:', draggedControlPoint);
    }

    function handleAnchorMouseDown(e, nodeId, anchorPos) {
        e.stopPropagation();
        e.preventDefault();
        
        console.log('Started dragging connection from anchor:', nodeId, anchorPos);
        
        isDraggingConnection = true;
        dragConnectionStartNode = nodeId;
        dragConnectionStartAnchor = anchorPos;
        
        // Get anchor position
        const node = document.getElementById(nodeId);
        const anchor = node.querySelector(`.connection-anchor[data-anchor="${anchorPos}"]`);
        const canvas = document.getElementById('mindmap-canvas');
        const canvasRect = canvas.getBoundingClientRect();
        const anchorRect = anchor.getBoundingClientRect();
        
        const startX = (anchorRect.left + anchorRect.width / 2 - canvasRect.left) / zoomLevel;
        const startY = (anchorRect.top + anchorRect.height / 2 - canvasRect.top) / zoomLevel;
        
        // Create temporary line
        const svg = document.getElementById('connections-svg');
        dragConnectionTempLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        dragConnectionTempLine.setAttribute('x1', startX);
        dragConnectionTempLine.setAttribute('y1', startY);
        dragConnectionTempLine.setAttribute('x2', startX);
        dragConnectionTempLine.setAttribute('y2', startY);
        dragConnectionTempLine.setAttribute('class', 'temp-connection-line');
        svg.appendChild(dragConnectionTempLine);
        
        // Mark the anchor as active
        anchor.classList.add('active');
        
        // Switch to connections tab to show line styles
        switchRightPanelTab('connections');
    }

    function handleMouseDown(e) {
        // Find the closest mindmap-node parent
        const node = e.target.closest('.mindmap-node');
        
        if (node) {
            if (e.button === 0) { // Left click
                e.preventDefault(); // Prevent text selection
                isDragging = true;
                draggedNode = node;
                
                // Get current position of the node
                const nodeStyle = window.getComputedStyle(node);
                const currentLeft = parseInt(nodeStyle.left) || 0;
                const currentTop = parseInt(nodeStyle.top) || 0;
                
                // Calculate offset from mouse to node position
                const canvasRect = document.getElementById('mindmap-canvas').getBoundingClientRect();
                dragOffset.x = e.clientX - canvasRect.left - currentLeft;
                dragOffset.y = e.clientY - canvasRect.top - currentTop;
                
                draggedNode.style.zIndex = 1000;
                draggedNode.style.cursor = 'grabbing';
                console.log('Started dragging node:', node.id);
                console.log('Current position:', { left: currentLeft, top: currentTop });
                console.log('Drag offset:', dragOffset);
            }
        } else {
            // No node clicked - check for pan (spacebar or pan tool)
            if (e.button === 0 && (spacePressed || currentTool === 'pan')) {
                e.preventDefault();
                startPan(e);
            }
        }
    }

    function handleMouseMove(e) {
        if (isPanning) {
            // Handle panning
            doPan(e);
            return;
        }
        
        if (isDraggingConnection && dragConnectionTempLine) {
            // Handle dragging connection line
            const canvas = document.getElementById('mindmap-canvas');
            const canvasRect = canvas.getBoundingClientRect();
            const x = (e.clientX - canvasRect.left) / zoomLevel;
            const y = (e.clientY - canvasRect.top) / zoomLevel;
            
            // Update temporary line end position
            dragConnectionTempLine.setAttribute('x2', x);
            dragConnectionTempLine.setAttribute('y2', y);
            
            // Check if hovering over a node (not the start node)
            const hoveredNode = e.target.closest('.mindmap-node');
            if (hoveredNode && hoveredNode.id !== dragConnectionStartNode) {
                // Show anchors on the hovered node (disabled)
                if (dragConnectionCurrentTarget !== hoveredNode.id) {
                    // Hide anchors on previous target
                    if (dragConnectionCurrentTarget) {
                        const prevTarget = document.getElementById(dragConnectionCurrentTarget);
                        if (prevTarget) prevTarget.classList.remove('show-anchors');
                    }
                    // Show anchors on new target (disabled)
                    // hoveredNode.classList.add('show-anchors');
                    dragConnectionCurrentTarget = hoveredNode.id;
                }
            } else {
                // Hide anchors if not hovering over a valid target
                if (dragConnectionCurrentTarget) {
                    const prevTarget = document.getElementById(dragConnectionCurrentTarget);
                    if (prevTarget) prevTarget.classList.remove('show-anchors');
                    dragConnectionCurrentTarget = null;
                }
            }
            
        } else if (draggedControlPoint) {
            // Handle control point dragging
            const canvas = document.getElementById('mindmap-canvas');
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Update control point position
            draggedControlPoint.element.setAttribute('cx', x);
            draggedControlPoint.element.setAttribute('cy', y);
            
            // Update connection data
            updateConnectionFromControlPoint(draggedControlPoint, x, y);
            
        } else if (isDragging && draggedNode) {
            // Handle node dragging with grid snapping (draw.io style)
            const canvasRect = document.getElementById('mindmap-canvas').getBoundingClientRect();
            
            // Calculate new position using the corrected offset
            let x = e.clientX - canvasRect.left - dragOffset.x;
            let y = e.clientY - canvasRect.top - dragOffset.y;
            
            // Apply grid snapping for more precise alignment
            x = snapToGrid(x);
            y = snapToGrid(y);
            
            // Strict boundaries - prevent dragging beyond canvas edges
            const minBound = 0;
            const maxX = canvasRect.width - draggedNode.offsetWidth;
            const maxY = canvasRect.height - draggedNode.offsetHeight;
            
            const constrainedX = Math.max(minBound, Math.min(x, maxX));
            const constrainedY = Math.max(minBound, Math.min(y, maxY));
            
            draggedNode.style.left = constrainedX + 'px';
            draggedNode.style.top = constrainedY + 'px';
            
            // Update node data
            const nodeData = nodes.find(n => n.id === draggedNode.id);
            if (nodeData) {
                nodeData.x = constrainedX;
                nodeData.y = constrainedY;
            }
            
            updateConnections();
        }
    }

    function handleMouseUp(e) {
        if (isDraggingConnection) {
            // Check if dropped on an anchor
            const targetAnchor = e.target.closest('.connection-anchor');
            if (targetAnchor && dragConnectionCurrentTarget) {
                const targetNodeId = targetAnchor.dataset.nodeId;
                const targetAnchorPos = targetAnchor.dataset.anchor;
                
                // Complete the connection
                const selectedStyle = document.getElementById('connection-style').value;
                connectNodesWithAnchors(dragConnectionStartNode, dragConnectionStartAnchor, targetNodeId, targetAnchorPos, selectedStyle);
            }
            
            // Clean up
            if (dragConnectionTempLine) {
                dragConnectionTempLine.remove();
                dragConnectionTempLine = null;
            }
            
            // Remove active class from start anchor
            const startNode = document.getElementById(dragConnectionStartNode);
            if (startNode) {
                const startAnchor = startNode.querySelector(`.connection-anchor[data-anchor="${dragConnectionStartAnchor}"]`);
                if (startAnchor) startAnchor.classList.remove('active');
            }
            
            // Hide anchors on target
            if (dragConnectionCurrentTarget) {
                const targetNode = document.getElementById(dragConnectionCurrentTarget);
                if (targetNode) targetNode.classList.remove('show-anchors');
            }
            
            isDraggingConnection = false;
            dragConnectionStartNode = null;
            dragConnectionStartAnchor = null;
            dragConnectionCurrentTarget = null;
            
        } else if (draggedControlPoint) {
            console.log('Finished dragging control point');
            draggedControlPoint = null;
        } else if (draggedNode) {
            draggedNode.style.zIndex = 10;
            draggedNode.style.cursor = 'move';
            console.log('Finished dragging node:', draggedNode.id);
        }
        
        // End pan if active
        if (isPanning) {
            endPan();
        }
        
        isDragging = false;
        draggedNode = null;
    }

    function updateConnectionFromControlPoint(controlPoint, x, y) {
        const connection = connections.find(conn => conn.id === controlPoint.connectionId);
        if (!connection) return;
        
        // Use stored node positions instead of DOM rect to avoid zoom issues
        const fromNodeData = nodes.find(n => n.id === connection.from);
        const toNodeData = nodes.find(n => n.id === connection.to);
        
        if (!fromNodeData || !toNodeData) return;
        
        // Calculate positions from stored data plus node center offset
        const GRID_SIZE = 20;
        let x1 = fromNodeData.x + 60; // Node width is 120px, so center is at +60
        let y1 = fromNodeData.y + 20; // Node height is 40px, so center is at +20
        let x2 = toNodeData.x + 60;
        let y2 = toNodeData.y + 20;
        
        x1 = Math.round(x1 / GRID_SIZE) * GRID_SIZE;
        y1 = Math.round(y1 / GRID_SIZE) * GRID_SIZE;
        x2 = Math.round(x2 / GRID_SIZE) * GRID_SIZE;
        y2 = Math.round(y2 / GRID_SIZE) * GRID_SIZE;
        
        // Snap dragged position to grid
        x = Math.round(x / GRID_SIZE) * GRID_SIZE;
        y = Math.round(y / GRID_SIZE) * GRID_SIZE;
        
        if (controlPoint.type === 'corner1' || controlPoint.type === 'corner2') {
            // Convert to manual path when corner control points are dragged
            if (!connection.path) {
                connection.path = [];
                connection.style = 'manual';
            }
            
            // Calculate the orthogonal path with the dragged corner
            const deltaX = Math.abs(x2 - x1);
            const deltaY = Math.abs(y2 - y1);
            
            let pathPoints = [];
            
            if (deltaX > deltaY) {
                // Horizontal first, then vertical
                if (controlPoint.type === 'corner1') {
                    pathPoints = [{ x: x, y: y1 }, { x: x, y: y2 }];
                } else {
                    pathPoints = [{ x: x1, y: y }, { x: x2, y: y }];
                }
            } else {
                // Vertical first, then horizontal
                if (controlPoint.type === 'corner1') {
                    pathPoints = [{ x: x1, y: y }, { x: x2, y: y }];
                } else {
                    pathPoints = [{ x: x, y: y1 }, { x: x, y: y2 }];
                }
            }
            
            connection.path = pathPoints;
            
        } else if (controlPoint.type === 'midpoint') {
            // Legacy support for old midpoint control points
            // Convert to manual path
            connection.path = [{ x, y }];
            connection.style = 'manual';
            
        } else if (controlPoint.type === 'path' && controlPoint.index !== null) {
            // For manual paths, allow free movement but keep it as manual
            if (connection.path && connection.path[controlPoint.index]) {
                connection.path[controlPoint.index] = { x, y };
            }
            
        } else if (controlPoint.type === 'midpoint-end') {
            // For manual paths, allow adding points
            if (!connection.path) {
                connection.path = [{ x, y }];
                connection.style = 'manual';
            } else {
                connection.path.push({ x, y });
            }
        }
        
        // Redraw connections
        updateConnections();
    }

    function filterCategories(query) {
        const q = (query || '').trim().toLowerCase();
        document.querySelectorAll('.category-group').forEach(group => {
            const buttons = group.querySelectorAll('.category-btn');
            let visible = false;
            buttons.forEach(btn => {
                const text = btn.querySelector('.category-text')?.textContent.toLowerCase() || '';
                const match = !q || text.includes(q);
                btn.style.display = match ? '' : 'none';
                if (match) visible = true;
            });
            group.classList.toggle('is-hidden', !visible);
        });
    }

    function updateCategoryChip(name) {
        const chip = document.getElementById('selected-category-label');
        const text = document.getElementById('selected-category-text');
        if (!chip || !text) return;
        if (name) {
            text.textContent = name;
            chip.classList.remove('d-none');
        } else {
            chip.classList.add('d-none');
        }
    }

    function updateNodeCount() {
        const el = document.getElementById('status-nodes');
        if (el) {
            const count = document.querySelectorAll('.mindmap-node:not(.root)').length;
            el.textContent = count + ' node';
        }
    }

    function updateLineStyleStatus(style) {
        const el = document.getElementById('status-line-style');
        if (el) {
            const labels = {
                solid: 'Solid', dashed: 'Dashed', dotted: 'Dotted', curved: 'Curved',
                thick: 'Thick', double: 'Double', wavy: 'Wavy', manual: 'Manual',
                'sub-topic': 'Sub Topic', hierarchy: 'Hierarchy'
            };
            el.textContent = 'Garis: ' + (labels[style] || style);
        }
    }

    function updateToolStatus(tool) {
        const el = document.getElementById('status-tool');
        if (!el) return;
        const icons = { select: 'feather-mouse-pointer', pan: 'feather-move' };
        const labels = { select: 'Select', pan: 'Pan' };
        el.innerHTML = `<i class="${icons[tool] || 'feather-tool'}"></i> ${labels[tool] || tool}`;
    }

    function toggleCategory(categoryId, categoryName) {
        selectedCategory = categoryId;
        updateCategoryChip(categoryName);
        
        // Update UI - remove active class from all buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to selected button
        document.querySelector(`[data-category-id="${categoryId}"]`).classList.add('active');
        
        // Hide all category children first
        document.querySelectorAll('.category-children').forEach(children => {
            children.classList.remove('show');
        });
        
        // Reset all arrows
        document.querySelectorAll('.category-arrow').forEach(arrow => {
            arrow.style.transform = 'rotate(0deg)';
        });
        
        // Show children of the selected category
        const childrenContainer = document.getElementById(`category-children-${categoryId}`);
        if (childrenContainer) {
            childrenContainer.classList.add('show');
            // Rotate the arrow
            const arrow = document.querySelector(`[data-category-id="${categoryId}"] .category-arrow`);
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }
        
        // Update root node
        document.getElementById('root-text').textContent = categoryName;
        
        // Clear canvas and materials when parent category is selected
        resetCanvas();
        document.getElementById('materials-list').innerHTML = `
            <div class="empty-state">
                <div class="empty-state__icon"><i class="feather-inbox"></i></div>
                <p class="empty-state__title">Belum ada materi</p>
                <p class="empty-state__hint">Pilih subkategori untuk memuat daftar materi</p>
            </div>
        `;
        document.getElementById('materials-count').textContent = '0';
        
        // Don't load materials for parent categories - only for subcategories
        // Materials are stored in subcategories, not parent categories
    }

    function selectCategory(categoryId, categoryName) {
        selectedCategory = categoryId;
        updateCategoryChip(categoryName);
        
        // Update UI - remove active class from all buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to selected button
        document.querySelector(`[data-category-id="${categoryId}"]`).classList.add('active');
        
        // Hide all category children first
        document.querySelectorAll('.category-children').forEach(children => {
            children.classList.remove('show');
        });
        
        // Reset all arrows
        document.querySelectorAll('.category-arrow').forEach(arrow => {
            arrow.style.transform = 'rotate(0deg)';
        });
        
        // Show children of the selected category's parent if it's a child category
        const selectedBtn = document.querySelector(`[data-category-id="${categoryId}"]`);
        const parentGroup = selectedBtn.closest('.category-group');
        const childrenContainer = parentGroup.querySelector('.category-children');

        if (childrenContainer) {
            childrenContainer.classList.add('show');
            // Rotate the arrow
            const arrow = parentGroup.querySelector('.category-arrow');
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        // Update root node (disabled - no root node)
        // const rootText = document.getElementById('root-text');
        // if (rootText) {
        //     rootText.textContent = categoryName;
        // }

        // Load materials
        switchRightPanelTab('materials');
        loadMaterials(categoryId);

        // Load mindmap data from database
        loadMindmapData(categoryId);
    }

    function loadMindmapData(categoryId) {
        console.log('Loading mindmap for category:', categoryId);
        fetch(`/mindmap-creator/load?reference_id=${categoryId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Load response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Load response data:', data);
            if (data.success && data.data && data.data.structure) {
                console.log('Rendering mindmap structure:', data.data.structure);
                renderMindmap(data.data.structure);
            } else {
                console.log('No mindmap data found or invalid structure');
                // Clear canvas when no mindmap exists for this category
                resetCanvas();
            }
        })
        .catch(error => {
            console.error('Error loading mindmap:', error);
        });
    }

    function renderMindmap(structure) {
        // Clear existing nodes and connections
        resetCanvas();

        const canvas = document.getElementById('mindmap-canvas');
        if (!canvas) {
            console.error('Canvas element not found');
            return;
        }

        if (structure.nodes) {
            structure.nodes.forEach(nodeData => {
                // Create node element
                const node = document.createElement('div');
                node.className = `mindmap-node ${nodeData.type || 'material'}`;
                node.id = nodeData.id;
                node.style.left = nodeData.x + 'px';
                node.style.top = nodeData.y + 'px';

                // Choose icon based on node type
                let icon = 'feather-book-open';
                if (nodeData.type === 'main-topic') icon = 'feather-layers';
                else if (nodeData.type === 'sub-topic') icon = 'feather-file-text';

                node.innerHTML = `
                    <i class="feather-${icon} me-2"></i>
                    <span>${nodeData.title}</span>
                `;

                // Add 8 connection anchor points
                const anchorPositions = ['tl', 't', 'tr', 'r', 'br', 'b', 'bl', 'l'];
                anchorPositions.forEach(pos => {
                    const anchor = document.createElement('div');
                    anchor.className = `connection-anchor anchor-${pos}`;
                    anchor.dataset.anchor = pos;
                    anchor.dataset.nodeId = nodeData.id;
                    anchor.addEventListener('mousedown', (e) => handleAnchorMouseDown(e, nodeData.id, pos));
                    node.appendChild(anchor);
                });

                // Add click listener
                node.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selectNode(nodeData.id);
                });

                // Add drag functionality
                node.addEventListener('mousedown', function(e) {
                    if (e.target.classList.contains('connection-anchor')) return;
                    e.stopPropagation(); // Prevent event bubbling to canvas
                    handleMouseDown(e);
                });

                canvas.appendChild(node);

                // Add to nodes array
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
        refreshMaterialsList();
    }

    function resetCanvas() {
        // Remove all nodes from canvas
        const canvas = document.getElementById('mindmap-canvas');
        if (canvas) {
            canvas.querySelectorAll('.mindmap-node').forEach(node => {
                node.remove();
            });
        }

        // Remove all connections
        document.querySelectorAll('.connection-line').forEach(line => {
            line.remove();
        });

        // Clear arrays
        nodes.length = 0;
        connections.length = 0;
        selectedNode = null;
        selectedConnection = null;
        selectedNodeForConnection = null;
    }

    function switchRightPanelTab(tabName) {
        document.querySelectorAll('.mm-panel-tab').forEach(tab => {
            const isActive = tab.dataset.tab === tabName;
            tab.classList.toggle('active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
        document.querySelectorAll('.mm-tab-pane').forEach(pane => {
            pane.classList.toggle('active', pane.id === `tab-${tabName}`);
        });
    }

    function loadMaterials(categoryId) {
        fetch(`/mindmap-creator/materials?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                displayMaterials(data.materials);
            })
            .catch(error => {
                console.error('Error loading materials:', error);
            });
    }

    function displayMaterials(materials) {
        const container = document.getElementById('materials-list');
        const countEl = document.getElementById('materials-count');

        // Get material IDs that are already on the canvas
        const canvasMaterialIds = nodes
            .filter(node => node.materialId && node.type === 'material')
            .map(node => node.materialId);

        // Filter out materials that are already on the canvas
        const availableMaterials = materials.filter(material => !canvasMaterialIds.includes(material.id));

        if (countEl) countEl.textContent = availableMaterials.length;

        if (availableMaterials.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state__icon"><i class="feather-check-circle"></i></div>
                    <p class="empty-state__title">Semua materi sudah ditambahkan</p>
                    <p class="empty-state__hint">Semua materi dari kategori ini sudah ada di canvas</p>
                </div>`;
            return;
        }

        container.innerHTML = availableMaterials.map(material => `
            <div class="material-item"
                draggable="true"
                ondragstart="startDrag(event, '${material.id}', '${material.title.replace(/'/g, "\\'")}', '${(material.description || '').replace(/'/g, "\\'")}', 'material')">
                <span class="material-item__icon"><i class="feather-file-text"></i></span>
                <div class="material-item__body">
                    <p class="material-item__title">${material.title}</p>
                    <span class="material-item__meta">${material.difficulty_level || '-'} · ${material.duration || '-'}</span>
                </div>
            </div>
        `).join('');
    }

    function refreshMaterialsList() {
        if (!selectedCategory) return;
        loadMaterials(selectedCategory);
    }

    function startDrag(e, materialId, title, description, nodeType = 'material') {
        console.log('=== DRAG START ===');
        console.log('Event type:', e.type);
        console.log('Target:', e.target);
        console.log('Material data:', { materialId, title, description, nodeType });
        
        try {
            e.dataTransfer.setData('materialId', materialId);
            e.dataTransfer.setData('title', title);
            e.dataTransfer.setData('description', description);
            e.dataTransfer.setData('nodeType', nodeType);
            console.log('Data set successfully');
        } catch (error) {
            console.error('Error setting drag data:', error);
        }
    }

    // Allow dropping on canvas
    function initializeDragDrop() {
        const canvas = document.getElementById('mindmap-canvas');
        const viewport = document.querySelector('.canvas-viewport');
        const dropTargets = [viewport, canvas]; // Try both
        
        dropTargets.forEach(target => {
            if (!target) return;
            
            target.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Drag over:', this.className);
            });

            target.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('=== DROP EVENT ===');
                console.log('Drop triggered on:', this.id || this.className);
                console.log('Drop coordinates:', { clientX: e.clientX, clientY: e.clientY });
                
                const materialId = e.dataTransfer.getData('materialId');
                const title = e.dataTransfer.getData('title');
                const description = e.dataTransfer.getData('description');
                const nodeType = e.dataTransfer.getData('nodeType') || 'material';
                
                console.log('Retrieved data:', { materialId, title, description, nodeType });
                
                if (materialId && materialId !== '') {
                    // Get canvas rect for coordinate calculation
                    const canvasRect = canvas.getBoundingClientRect();
                    
                    // Calculate position relative to the transformed canvas
                    // e.clientX/Y is screen coordinates
                    // We need to convert to canvas coordinates considering zoom and pan
                    let x = (e.clientX - canvasRect.left) / zoomLevel - 60;
                    let y = (e.clientY - canvasRect.top) / zoomLevel - 20;
                    
                    // Snap to grid for precise alignment
                    x = snapToGrid(x);
                    y = snapToGrid(y);
                    
                    console.log('Canvas rect:', canvasRect);
                    console.log('Zoom level:', zoomLevel);
                    console.log('Calculated position:', { x, y });
                    
                    addMaterialNode(materialId, title, description, x, y, nodeType);
                } else {
                    console.warn('No materialId found in drop data');
                }
            });
        });
    }

    function addCustomNode(title, nodeType) {
        // Add node at viewport center, accounting for pan and zoom
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const viewportCenterX = canvasArea.clientWidth / 2;
        const viewportCenterY = canvasArea.clientHeight / 2;
        
        // Convert viewport coordinates to canvas coordinates
        const x = (viewportCenterX - panOffset.x * zoomLevel) / zoomLevel - 60; // Subtract node width/2
        const y = (viewportCenterY - panOffset.y * zoomLevel) / zoomLevel - 20; // Subtract node height/2
        
        addMaterialNode('custom-' + Date.now(), title, '', x, y, nodeType);
    }

    function toggleNodeCompletion(nodeId, event) {
        event.stopPropagation();
        
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        const toggle = node.querySelector('.completion-toggle');
        
        if (nodeData && toggle) {
            nodeData.completed = !nodeData.completed;
            
            if (nodeData.completed) {
                node.classList.add('completed');
                toggle.classList.add('completed');
            } else {
                node.classList.remove('completed');
                toggle.classList.remove('completed');
            }
            
            console.log('Node completion toggled:', nodeId, nodeData.completed);
        }
    }

    function addMaterialNode(materialId, title, description, x, y, nodeType = 'material') {
        console.log('Adding material node:', { materialId, title, x, y, nodeType });

        const nodeId = 'node-' + nodeIdCounter++;
        const node = document.createElement('div');
        node.className = `mindmap-node ${nodeType}`;
        node.id = nodeId;
        node.style.left = x + 'px';
        node.style.top = y + 'px';

        // Choose icon based on node type
        let icon = 'feather-book-open';
        if (nodeType === 'main-topic') icon = 'feather-layers';
        else if (nodeType === 'sub-topic') icon = 'feather-file-text';

        node.innerHTML = `
            <i class="feather-${icon} me-2"></i>
            <span>${title}</span>
        `;
        
        // Add 8 connection anchor points
        const anchorPositions = ['tl', 't', 'tr', 'r', 'br', 'b', 'bl', 'l'];
        anchorPositions.forEach(pos => {
            const anchor = document.createElement('div');
            anchor.className = `connection-anchor anchor-${pos}`;
            anchor.dataset.anchor = pos;
            anchor.dataset.nodeId = nodeId;
            anchor.addEventListener('mousedown', (e) => handleAnchorMouseDown(e, nodeId, pos));
            node.appendChild(anchor);
        });
        
        node.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event bubbling
            selectNode(nodeId);
        });
        
        // Add drag functionality
        node.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('connection-anchor')) return;
            e.stopPropagation(); // Prevent event bubbling to canvas
            handleMouseDown(e);
        });
        
        const canvas = document.getElementById('mindmap-canvas');
        if (!canvas) {
            console.error('Canvas not found!');
            return;
        }
        
        canvas.appendChild(node);
        updateNodeCount();
        
        nodes.push({
            id: nodeId,
            materialId: materialId,
            title: title,
            description: description,
            x: x,
            y: y,
            type: nodeType,
            completed: false
        });
        
        console.log('Nodes array updated:', nodes);
        
        // Refresh materials list to remove the added material from sidebar
        refreshMaterialsList();
        
        // No auto-connection - user will connect manually
    }

    function toggleConnectionMode() {
        connectionMode = !connectionMode;
        const btn = document.getElementById('connection-mode-btn');
        
        if (connectionMode) {
            if (btn) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-primary');
                btn.innerHTML = '<i class="feather-link me-1"></i>Mode Koneksi Aktif';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'crosshair';
            console.log('Connection mode activated');
        } else {
            if (btn) {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
                btn.innerHTML = '<i class="feather-link me-1"></i>Mode Koneksi';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'default';
            selectedNodeForConnection = null;
        }

        const style = document.getElementById('connection-style')?.value || 'solid';
        updateLineStyleStatus(style);
        const hint = document.getElementById('connection-hint');
        if (hint) hint.classList.toggle('is-active', connectionMode || manualDrawingMode);
        
        document.querySelectorAll('.mindmap-node').forEach(node => {
            node.classList.remove('selected', 'connection-source');
        });
    }

    function toggleManualDrawingMode() {
        manualDrawingMode = !manualDrawingMode;
        const btn = document.getElementById('manual-drawing-btn');
        
        if (manualDrawingMode) {
            // Disable connection mode if active
            if (connectionMode) {
                toggleConnectionMode();
            }
            
            if (btn) {
                btn.classList.remove('btn-outline-warning');
                btn.classList.add('btn-warning');
                btn.innerHTML = '<i class="feather-edit-3 me-1"></i>Mode Gambar Aktif';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'crosshair';
            console.log('Manual drawing mode activated');
        } else {
            if (btn) {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-outline-warning');
                btn.innerHTML = '<i class="feather-edit-3 me-1"></i>Mode Gambar Manual';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'default';
            cancelCurrentDrawing();
            console.log('Manual drawing mode deactivated');
        }
    }

    function selectConnection(connectionId) {
        console.log('=== SELECT CONNECTION ===');
        console.log('Connection ID:', connectionId);
        
        // Clear all previous selections
        clearAllSelections();
        
        // Find and highlight the selected connection
        const connectionElement = document.querySelector(`[data-connection-id="${connectionId}"]`);
        if (connectionElement) {
            connectionElement.classList.add('selected');
            selectedConnection = connectionId;
            
            // Update properties panel for connection
            updateConnectionPropertiesPanel(connectionId);
            
            console.log('Connection selected:', connectionId);
        }
    }

    function clearAllSelections() {
        // Clear node selections
        document.querySelectorAll('.mindmap-node').forEach(n => {
            n.classList.remove('selected', 'connection-source');
            removeResizeHandles(n);
        });

        // Clear connection selections
        document.querySelectorAll('.connection-line').forEach(line => {
            line.classList.remove('selected');
        });

        // Clear selection variables
        selectedNode = null;
        selectedConnection = null;
        selectedNodeForConnection = null;
    }

    function addResizeHandles(node) {
        // Remove existing handles if any
        removeResizeHandles(node);

        const positions = ['nw', 'n', 'ne', 'e', 'se', 's', 'sw', 'w'];

        positions.forEach(pos => {
            const handle = document.createElement('div');
            handle.className = `resize-handle ${pos}`;
            handle.dataset.position = pos;
            handle.dataset.nodeId = node.id;

            // Prevent node drag when clicking handle
            handle.addEventListener('mousedown', (e) => {
                e.stopPropagation();
                startResize(e, node, pos);
            });

            node.appendChild(handle);
        });
    }

    function removeResizeHandles(node) {
        const handles = node.querySelectorAll('.resize-handle');
        handles.forEach(handle => handle.remove());
    }

    let isResizing = false;
    let resizeDirection = null;
    let resizeStartX = 0;
    let resizeStartY = 0;
    let resizeStartWidth = 0;
    let resizeStartHeight = 0;
    let resizeStartLeft = 0;
    let resizeStartTop = 0;
    let resizeNode = null;

    function startResize(e, node, direction) {
        isResizing = true;
        resizeDirection = direction;
        resizeNode = node;
        resizeStartX = e.clientX;
        resizeStartY = e.clientY;
        resizeStartWidth = node.offsetWidth;
        resizeStartHeight = node.offsetHeight;
        resizeStartLeft = node.offsetLeft;
        resizeStartTop = node.offsetTop;

        document.addEventListener('mousemove', handleResize);
        document.addEventListener('mouseup', stopResize);
    }

    function handleResize(e) {
        if (!isResizing || !resizeNode) return;

        const deltaX = e.clientX - resizeStartX;
        const deltaY = e.clientY - resizeStartY;

        const canvas = document.getElementById('mindmap-canvas');
        const rect = canvas.getBoundingClientRect();
        const zoom = zoomLevel;

        // Adjust for zoom
        const adjustedDeltaX = deltaX / zoom;
        const adjustedDeltaY = deltaY / zoom;

        let newWidth = resizeStartWidth;
        let newHeight = resizeStartHeight;
        let newLeft = resizeStartLeft;
        let newTop = resizeStartTop;

        // Handle resize based on direction
        if (resizeDirection.includes('e')) {
            newWidth = resizeStartWidth + adjustedDeltaX;
        }
        if (resizeDirection.includes('w')) {
            newWidth = resizeStartWidth - adjustedDeltaX;
            newLeft = resizeStartLeft + adjustedDeltaX;
        }
        if (resizeDirection.includes('s')) {
            newHeight = resizeStartHeight + adjustedDeltaY;
        }
        if (resizeDirection.includes('n')) {
            newHeight = resizeStartHeight - adjustedDeltaY;
            newTop = resizeStartTop + adjustedDeltaY;
        }

        // Minimum size constraints
        newWidth = Math.max(100, newWidth);
        newHeight = Math.max(40, newHeight);

        // Apply changes
        resizeNode.style.width = newWidth + 'px';
        resizeNode.style.height = newHeight + 'px';
        resizeNode.style.left = newLeft + 'px';
        resizeNode.style.top = newTop + 'px';

        // Update node data
        const nodeData = nodes.find(n => n.id === resizeNode.id);
        if (nodeData) {
            nodeData.x = newLeft;
            nodeData.y = newTop;
        }

        // Update connections
        updateConnections();
    }

    function stopResize() {
        isResizing = false;
        resizeNode = null;
        document.removeEventListener('mousemove', handleResize);
        document.removeEventListener('mouseup', stopResize);
    }

    function selectNode(nodeId) {
        console.log('=== SELECT NODE ===');
        console.log('Node ID:', nodeId);
        console.log('Connection mode:', connectionMode);
        console.log('Manual drawing mode:', manualDrawingMode);
        console.log('Selected node for connection:', selectedNodeForConnection);
        
        const node = document.getElementById(nodeId);
        if (!node) {
            console.error('Node not found:', nodeId);
            return;
        }
        
        if (manualDrawingMode) {
            console.log('In manual drawing mode');
            // Manual drawing mode logic
            if (!drawingStartNode) {
                // Start drawing from this node
                drawingStartNode = nodeId;
                currentDrawingPath = [];
                node.classList.add('connection-source');
                console.log('Started drawing from node:', nodeId);
            } else if (drawingStartNode !== nodeId) {
                // End drawing at this node
                finishManualDrawing(nodeId);
                console.log('Finished drawing to node:', nodeId);
            } else {
                // Clicking the same node - cancel drawing
                cancelCurrentDrawing();
                console.log('Drawing cancelled');
            }
        } else if (connectionMode) {
            console.log('In connection mode');
            // Connection mode logic
            if (!selectedNodeForConnection) {
                // First node selection
                selectedNodeForConnection = nodeId;
                node.classList.add('connection-source');
                console.log('First node selected for connection:', nodeId);
            } else if (selectedNodeForConnection !== nodeId) {
                // Second node selection - create connection
                const selectedStyle = document.getElementById('connection-style').value;
                console.log('Creating connection with style:', selectedStyle);
                connectNodes(selectedNodeForConnection, nodeId, selectedStyle);
                
                // Clear selections
                document.getElementById(selectedNodeForConnection).classList.remove('connection-source');
                node.classList.remove('connection-source');
                selectedNodeForConnection = null;
                
                // Auto-deactivate connection mode after successful connection
                connectionMode = false;
                const btn = document.getElementById('connection-mode-btn');
                if (btn) {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                    btn.innerHTML = '<i class="feather-link me-1"></i>Mode Koneksi';
                }
                document.getElementById('mindmap-canvas').style.cursor = 'default';
                
                console.log('Connection created between nodes with style:', selectedStyle);
                console.log('Connection mode auto-deactivated');
            } else {
                // Clicking the same node - deselect
                node.classList.remove('connection-source');
                selectedNodeForConnection = null;
                console.log('Connection selection cancelled');
            }
        } else {
            console.log('In normal mode');
            // Check if clicking the same node - toggle selection
            if (selectedNode === nodeId) {
                // Deselect the node
                node.classList.remove('selected');
                removeResizeHandles(node);
                selectedNode = null;
            } else {
                // Clear all selections first
                clearAllSelections();

                // Select the node
                node.classList.add('selected');
                selectedNode = nodeId;

                // Add resize handles
                addResizeHandles(node);
            }
        }
    }

    // Double-click to edit node text
    document.addEventListener('dblclick', function(e) {
        const node = e.target.closest('.mindmap-node');
        if (node && !connectionMode && !manualDrawingMode) {
            const nodeId = node.id;
            const label = node.querySelector('.node-label');
            if (label) {
                enableInlineEdit(nodeId, label);
            }
        }
    });

    function enableInlineEdit(nodeId, labelElement) {
        const currentText = labelElement.textContent;
        const node = document.getElementById(nodeId);

        // Create input element
        const input = document.createElement('input');
        input.type = 'text';
        input.value = currentText;
        input.className = 'inline-edit-input';

        // Copy styles from label
        const computedStyle = window.getComputedStyle(labelElement);
        input.style.fontSize = computedStyle.fontSize;
        input.style.fontWeight = computedStyle.fontWeight;
        input.style.color = computedStyle.color;
        input.style.textAlign = computedStyle.textAlign;
        input.style.background = 'transparent';
        input.style.border = 'none';
        input.style.outline = 'none';
        input.style.width = '100%';
        input.style.minWidth = '100px';

        // Replace label with input
        labelElement.style.display = 'none';
        labelElement.parentNode.insertBefore(input, labelElement);
        input.focus();
        input.select();

        // Save on blur or Enter key
        function saveEdit() {
            const newText = input.value.trim() || currentText;
            labelElement.textContent = newText;
            labelElement.style.display = '';
            input.remove();

            // Update node data
            const nodeData = nodes.find(n => n.id === nodeId);
            if (nodeData) {
                nodeData.title = newText;
            }

            // Update connections if node size changed
            updateConnections();
        }

        input.addEventListener('blur', saveEdit);
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                input.blur();
            } else if (e.key === 'Escape') {
                input.value = currentText;
                input.blur();
            }
        });
    }

    function handleCanvasClick(e) {
        if (!manualDrawingMode || !drawingStartNode) return;
        
        // Don't process if clicking on a node
        if (e.target.classList.contains('mindmap-node')) return;
        
        const canvas = document.getElementById('mindmap-canvas');
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        addDrawingPoint(x, y);
    }

    function addDrawingPoint(x, y) {
        currentDrawingPath.push({ x, y });
        console.log('Added drawing point:', { x, y });
        updateTempConnectionLine();
    }

    function updateTempConnectionLine() {
        const svg = document.getElementById('connections-svg');
        
        // Remove existing temp line
        if (tempConnectionLine) {
            tempConnectionLine.remove();
        }
        
        if (currentDrawingPath.length === 0) return;
        
        const startNode = document.getElementById(drawingStartNode);
        if (!startNode) return;
        
        const startRect = startNode.getBoundingClientRect();
        const canvasRect = document.getElementById('mindmap-canvas').getBoundingClientRect();
        const startX = startRect.left + startRect.width / 2 - canvasRect.left;
        const startY = startRect.top + startRect.height / 2 - canvasRect.top;
        
        // Create path from node to all points
        let pathData = `M ${startX} ${startY}`;
        currentDrawingPath.forEach(point => {
            pathData += ` L ${point.x} ${point.y}`;
        });
        
        tempConnectionLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        tempConnectionLine.setAttribute('d', pathData);
        tempConnectionLine.setAttribute('class', 'connection-line manual-temp-line');
        tempConnectionLine.style.stroke = '#f59e0b';
        tempConnectionLine.style.strokeWidth = '2';
        tempConnectionLine.style.strokeDasharray = '5, 5';
        tempConnectionLine.style.fill = 'none';
        tempConnectionLine.style.pointerEvents = 'none';
        
        svg.appendChild(tempConnectionLine);
    }

    function finishManualDrawing(endNodeId) {
        if (!drawingStartNode || currentDrawingPath.length === 0) {
            console.log('No drawing path to finish');
            return;
        }
        
        // Check if connection already exists (prevent duplicates)
        const existingConnection = connections.find(conn => 
            (conn.from === drawingStartNode && conn.to === endNodeId) || 
            (conn.from === endNodeId && conn.to === drawingStartNode)
        );
        
        if (existingConnection) {
            console.log('Connection already exists between these nodes');
            cancelCurrentDrawing();
            return;
        }
        
        // Create connection with manual path
        const selectedStyle = document.getElementById('connection-style').value;
        const connection = {
            from: drawingStartNode,
            to: endNodeId,
            style: selectedStyle === 'manual' ? 'manual' : selectedStyle,
            path: currentDrawingPath,
            id: `conn-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
        };
        
        connections.push(connection);
        updateConnections();
        
        // Auto-deactivate manual drawing mode after successful connection
        manualDrawingMode = false;
        const btn = document.getElementById('manual-drawing-btn');
        if (btn) {
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-outline-warning');
            btn.innerHTML = '<i class="feather-edit-3 me-1"></i>Mode Gambar Manual';
        }
        document.getElementById('mindmap-canvas').style.cursor = 'default';
        
        // Clean up
        cancelCurrentDrawing();
        
        console.log('Manual connection created:', connection);
        console.log('Manual drawing mode auto-deactivated');
    }

    function cancelCurrentDrawing() {
        // Clear temp line
        if (tempConnectionLine) {
            tempConnectionLine.remove();
            tempConnectionLine = null;
        }
        
        // Clear selections
        document.querySelectorAll('.mindmap-node').forEach(node => {
            node.classList.remove('connection-source');
        });
        
        // Reset variables
        drawingStartNode = null;
        currentDrawingPath = [];
        
        console.log('Current drawing cancelled');
    }

    // Draw.io Tool Functions
    function setTool(tool) {
        // Disable any active connection modes first
        if (connectionMode && tool !== 'connector') {
            toggleConnectionMode();
        }
        if (manualDrawingMode && tool !== 'manual-connector') {
            toggleManualDrawingMode();
        }
        
        currentTool = tool;
        
        document.querySelectorAll('.drawio-toolbar [data-tool]').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-tool') === tool);
        });

        // Update cursor
        const canvas = document.getElementById('mindmap-canvas');
        switch(tool) {
            case 'select':
                canvas.style.cursor = 'default';
                // Cancel any pending drawing/connection
                cancelCurrentDrawing();
                clearAllSelections();
                break;
            case 'pan':
                canvas.style.cursor = 'grab';
                // Cancel any pending drawing/connection
                cancelCurrentDrawing();
                clearAllSelections();
                break;
            default:
                canvas.style.cursor = 'default';
                break;
        }
        
        updateToolStatus(tool);
    }

    function setLineStyle(style) {
        document.getElementById('connection-style').value = style;

        document.querySelectorAll('.line-style-item').forEach(item => {
            item.classList.remove('selected');
        });

        const selectedItem = document.querySelector(`.line-style-item[data-line-style="${style}"]`);
        if (selectedItem) {
            selectedItem.classList.add('selected');
        }

        updateLineStyleStatus(style);

        // Update selected connection style if one is selected
        if (selectedConnection) {
            const connection = connections.find(c => c.id === selectedConnection);
            if (connection) {
                connection.style = style;
                updateConnections();
                console.log('Updated selected connection style to:', style);
            }
        }

        if (style === 'manual') {
            if (!manualDrawingMode) toggleManualDrawingMode();
            if (connectionMode) toggleConnectionMode();
        } else {
            if (!connectionMode) toggleConnectionMode();
            if (manualDrawingMode) toggleManualDrawingMode();
        }

        const hint = document.getElementById('connection-hint');
        if (hint) hint.classList.toggle('is-active', connectionMode || manualDrawingMode);
    }

    // Zoom Functions (draw.io style) - Slower/gradual zoom
    function zoomIn() {
        zoomLevel = Math.min(zoomLevel * 1.02, 5);
        updateZoom();
    }

    function zoomOut() {
        zoomLevel = Math.max(zoomLevel / 1.02, 0.1);
        updateZoom();
    }

    function resetZoom() {
        zoomLevel = 1;
        
        // Center canvas horizontally when resetting zoom
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const canvasWidth = 3000; // Canvas width from HTML
        const viewportWidth = canvasArea.clientWidth;
        const centerOffset = (viewportWidth - canvasWidth) / 2;
        
        panOffset.x = centerOffset;
        panOffset.y = 0; // Keep at top
        
        updateZoom();
    }

    function updateZoom() {
        const canvas = document.getElementById('mindmap-canvas');
        const canvasArea = document.querySelector('.drawio-canvas-area');
        
        // Constrain pan offset to prevent canvas from moving beyond viewport
        const canvasWidth = 3000;
        const canvasHeight = 3000;
        const viewportWidth = canvasArea.clientWidth;
        const viewportHeight = canvasArea.clientHeight;
        
        // Calculate maximum allowed pan offset
        const maxPanX = (canvasWidth * zoomLevel - viewportWidth) / zoomLevel;
        const maxPanY = (canvasHeight * zoomLevel - viewportHeight) / zoomLevel;
        
        // Constrain pan offset
        panOffset.x = Math.max(-maxPanX, Math.min(0, panOffset.x));
        panOffset.y = Math.max(-maxPanY, Math.min(0, panOffset.y));
        
        canvas.style.transform = `scale(${zoomLevel}) translate(${panOffset.x}px, ${panOffset.y}px)`;
        
        // Scale the line grid background to maintain visual consistency
        // At zoom 1: 20px grid. At zoom 2: 40px grid, etc.
        const scaledGridSize = 20 * zoomLevel;
        canvas.style.backgroundSize = `${scaledGridSize}px ${scaledGridSize}px`;
        
        // Update zoom level display
        document.querySelector('.zoom-level').textContent = Math.round(zoomLevel * 100) + '%';
        
        // Update connections
        updateConnections();
    }

    // Pan Functions (draw.io style)
    function startPan(e) {
        // Allow panning with pan tool, spacebar, or middle mouse button
        const isPanTool = currentTool === 'pan';
        const isSpacebarPan = spacePressed;
        const isMiddleMouse = e.button === 1;
        
        if (isPanTool || isSpacebarPan || isMiddleMouse) {
            isPanning = true;
            panStart = { 
                x: e.clientX - panOffset.x * zoomLevel, 
                y: e.clientY - panOffset.y * zoomLevel 
            };
            document.getElementById('mindmap-canvas').style.cursor = 'grabbing';
            e.preventDefault();
        }
    }

    function doPan(e) {
        if (isPanning) {
            panOffset.x = (e.clientX - panStart.x) / zoomLevel;
            panOffset.y = (e.clientY - panStart.y) / zoomLevel;
            updateZoom();
        }
    }

    function endPan() {
        if (isPanning) {
            isPanning = false;
            const canvas = document.getElementById('mindmap-canvas');
            
            if (currentTool === 'pan') {
                canvas.style.cursor = 'grab';
            } else if (spacePressed) {
                canvas.style.cursor = 'grab';
            } else {
                canvas.style.cursor = 'default';
            }
        }
    }

    // Properties Panel Functions
    function updateSelectedElement() {
        if (!selectedNode) return;
        
        const node = document.getElementById(selectedNode);
        if (!node) return;
        
        const fillColor = document.getElementById('fill-color').value;
        const borderColor = document.getElementById('border-color').value;
        const borderWidth = document.getElementById('border-width').value;
        const opacity = document.getElementById('opacity').value / 100;
        
        node.style.backgroundColor = fillColor;
        node.style.borderColor = borderColor;
        node.style.borderWidth = borderWidth + 'px';
        node.style.opacity = opacity;
        
        // Update node data
        const nodeData = nodes.find(n => n.id === selectedNode);
        if (nodeData) {
            nodeData.fillColor = fillColor;
            nodeData.borderColor = borderColor;
            nodeData.borderWidth = borderWidth;
            nodeData.opacity = opacity;
        }
    }

    function updateConnectionPropertiesPanel(connectionId) {
        const connection = connections.find(c => c.id === connectionId);
        if (!connection) return;
        
        const fromNode = nodes.find(n => n.id === connection.from);
        const toNode = nodes.find(n => n.id === connection.to);
        
        const panel = document.getElementById('properties-panel');
        panel.innerHTML = `
            <div class="mb-3">
                <label class="form-label">Connection ID</label>
                <input type="text" class="form-control form-control-sm" value="${connection.id}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Style</label>
                <input type="text" class="form-control form-control-sm" value="${connection.style || 'solid'}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">From</label>
                <input type="text" class="form-control form-control-sm" value="${fromNode ? fromNode.title : connection.from}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">To</label>
                <input type="text" class="form-control form-control-sm" value="${toNode ? toNode.title : connection.to}" readonly>
            </div>
            <div class="mb-3">
                <button class="btn btn-sm btn-outline-danger" onclick="deleteConnection('${connectionId}')">
                    <i class="feather-trash-2 me-1"></i>Delete Connection
                </button>
            </div>
        `;
    }

    function deleteSelectedElement() {
        if (selectedNode) {
            // Delete selected node
            const node = document.getElementById(selectedNode);
            if (node && node.id !== 'root-node') {
                if (confirm('Are you sure you want to delete this node and all its connections?')) {
                    removeNode(node);
                }
            }
        } else if (selectedConnection) {
            // Delete selected connection
            if (confirm('Are you sure you want to delete this connection?')) {
                deleteConnection(selectedConnection);
            }
        }
    }

    function deleteConnection(connectionId) {
        connections = connections.filter(c => c.id !== connectionId);
        updateConnections();
        
        // Clear selection and reset properties panel
        clearAllSelections();
        document.getElementById('properties-panel').innerHTML = '<p class="text-muted">Select an element to edit properties</p>';
    }

    function updatePropertiesPanel(nodeId) {
        const nodeData = nodes.find(n => n.id === nodeId);
        if (!nodeData) return;
        
        const panel = document.getElementById('properties-panel');
        const isRootNode = nodeId === 'root-node';
        
        panel.innerHTML = `
            <div class="mb-3">
                <label class="form-label">ID</label>
                <input type="text" class="form-control form-control-sm" value="${nodeData.id}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" class="form-control form-control-sm" value="${nodeData.type || 'node'}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control form-control-sm" value="${nodeData.title || ''}" onchange="updateNodeTitle('${nodeId}', this.value)">
            </div>
            <div class="mb-3">
                <label class="form-label">Position</label>
                <div class="row">
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm" value="${Math.round(nodeData.x)}" onchange="updateNodePosition('${nodeId}', 'x', this.value)">
                    </div>
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm" value="${Math.round(nodeData.y)}" onchange="updateNodePosition('${nodeId}', 'y', this.value)">
                    </div>
                </div>
            </div>
            ${!isRootNode ? `
            <div class="mb-3">
                <button class="btn btn-sm btn-outline-danger" onclick="deleteSelectedElement()">
                    <i class="feather-trash-2 me-1"></i>Delete Node
                </button>
            </div>
            ` : ''}
        `;
        
        // Update format controls
        if (nodeData.fillColor) document.getElementById('fill-color').value = nodeData.fillColor;
        if (nodeData.borderColor) document.getElementById('border-color').value = nodeData.borderColor;
        if (nodeData.borderWidth) document.getElementById('border-width').value = nodeData.borderWidth;
        if (nodeData.opacity) document.getElementById('opacity').value = nodeData.opacity * 100;
    }

    function updateNodeTitle(nodeId, title) {
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        
        if (node && nodeData) {
            nodeData.title = title;
            node.querySelector('span').textContent = title;
        }
    }

    function updateNodePosition(nodeId, axis, value) {
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        
        if (node && nodeData) {
            const numValue = parseFloat(value);
            nodeData[axis] = numValue;
            node.style[axis === 'x' ? 'left' : 'top'] = numValue + 'px';
            updateConnections();
        }
    }

    function connectNodes(fromId, toId, style = 'solid') {
        // Check if connection already exists (prevent duplicates)
        const existingConnection = connections.find(conn => 
            (conn.from === fromId && conn.to === toId) || 
            (conn.from === toId && conn.to === fromId)
        );
        
        if (existingConnection) {
            console.log('Connection already exists between these nodes');
            // Optional: Update the style if different
            if (existingConnection.style !== style) {
                existingConnection.style = style;
                updateConnections();
            }
            return;
        }
        
        connections.push({ 
            from: fromId, 
            to: toId, 
            style: style,
            id: `conn-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
        });
        updateConnections();
    }

    function connectNodesWithAnchors(fromId, fromAnchor, toId, toAnchor, style = 'solid') {
        // Check if connection already exists (prevent duplicates)
        const existingConnection = connections.find(conn => 
            (conn.from === fromId && conn.to === toId) || 
            (conn.from === toId && conn.to === fromId)
        );
        
        if (existingConnection) {
            console.log('Connection already exists between these nodes');
            // Optional: Update the style and anchors if different
            if (existingConnection.style !== style || existingConnection.fromAnchor !== fromAnchor || existingConnection.toAnchor !== toAnchor) {
                existingConnection.style = style;
                existingConnection.fromAnchor = fromAnchor;
                existingConnection.toAnchor = toAnchor;
                updateConnections();
            }
            return;
        }
        
        connections.push({ 
            from: fromId, 
            fromAnchor: fromAnchor,
            to: toId,
            toAnchor: toAnchor,
            style: style,
            id: `conn-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
        });
        updateConnections();
    }

    function getAnchorPosition(nodeId, anchorPos) {
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        if (!node || !nodeData) return { x: 0, y: 0 };

        const width = node.offsetWidth;
        const height = node.offsetHeight;
        const x = nodeData.x;
        const y = nodeData.y;

        // Anchor offset (anchors are positioned 6px outside the node)
        const ANCHOR_OFFSET = 6;

        // Calculate anchor position based on anchor position
        let anchorX, anchorY;
        switch(anchorPos) {
            case 'tl':
                anchorX = x - ANCHOR_OFFSET;
                anchorY = y - ANCHOR_OFFSET;
                break;
            case 't':
                anchorX = x + width / 2;
                anchorY = y - ANCHOR_OFFSET;
                break;
            case 'tr':
                anchorX = x + width + ANCHOR_OFFSET;
                anchorY = y - ANCHOR_OFFSET;
                break;
            case 'r':
                anchorX = x + width + ANCHOR_OFFSET;
                anchorY = y + height / 2;
                break;
            case 'br':
                anchorX = x + width + ANCHOR_OFFSET;
                anchorY = y + height + ANCHOR_OFFSET;
                break;
            case 'b':
                anchorX = x + width / 2;
                anchorY = y + height + ANCHOR_OFFSET;
                break;
            case 'bl':
                anchorX = x - ANCHOR_OFFSET;
                anchorY = y + height + ANCHOR_OFFSET;
                break;
            case 'l':
                anchorX = x - ANCHOR_OFFSET;
                anchorY = y + height / 2;
                break;
            default:
                // Default to center
                anchorX = x + width / 2;
                anchorY = y + height / 2;
        }
        
        // Don't snap anchor positions to grid - keep them precise at the center
        return { x: anchorX, y: anchorY };
    }

    function updateConnections() {
        const svg = document.getElementById('connections-svg');
        svg.innerHTML = '';
        
        // Clear existing control points
        controlPoints = [];
        
        connections.forEach(conn => {
            const fromNode = document.getElementById(conn.from);
            const toNode = document.getElementById(conn.to);
            
            if (fromNode && toNode) {
                // Use stored node positions instead of DOM rect to avoid zoom issues
                const fromNodeData = nodes.find(n => n.id === conn.from);
                const toNodeData = nodes.find(n => n.id === conn.to);
                
                if (!fromNodeData || !toNodeData) return;
                
                // Calculate positions from anchor points if available, otherwise use center
                let x1, y1, x2, y2;
                
                if (conn.fromAnchor) {
                    const fromPos = getAnchorPosition(conn.from, conn.fromAnchor);
                    x1 = fromPos.x;
                    y1 = fromPos.y;
                } else {
                    const fromNodeElement = document.getElementById(conn.from);
                    const fromWidth = fromNodeElement.offsetWidth;
                    const fromHeight = fromNodeElement.offsetHeight;
                    x1 = fromNodeData.x + fromWidth / 2;
                    y1 = fromNodeData.y + fromHeight / 2;
                }
                
                if (conn.toAnchor) {
                    const toPos = getAnchorPosition(conn.to, conn.toAnchor);
                    x2 = toPos.x;
                    y2 = toPos.y;
                } else {
                    const toNodeElement = document.getElementById(conn.to);
                    const toWidth = toNodeElement.offsetWidth;
                    const toHeight = toNodeElement.offsetHeight;
                    x2 = toNodeData.x + toWidth / 2;
                    y2 = toNodeData.y + toHeight / 2;
                }

                // Only snap to grid for manual paths, not for anchor-based connections
                // Anchor-based connections should be precise
                if (!conn.fromAnchor && !conn.toAnchor) {
                    const GRID_SIZE = 20;
                    x1 = Math.round(x1 / GRID_SIZE) * GRID_SIZE;
                    y1 = Math.round(y1 / GRID_SIZE) * GRID_SIZE;
                    x2 = Math.round(x2 / GRID_SIZE) * GRID_SIZE;
                    y2 = Math.round(y2 / GRID_SIZE) * GRID_SIZE;
                }
                
                let line;
                const style = conn.style || 'solid';
                
                // Handle manual path connections
                if (style === 'manual' && conn.path && conn.path.length > 0) {
                    line = createManualPath(x1, y1, x2, y2, conn.path, conn);
                } else {
                    switch(style) {
                    case 'dashed':
                        line = createDashedLine(x1, y1, x2, y2);
                        break;
                    case 'dotted':
                        line = createDottedLine(x1, y1, x2, y2);
                        break;
                    case 'curved':
                        line = createCurvedLine(x1, y1, x2, y2);
                        break;
                    case 'thick':
                        line = createThickLine(x1, y1, x2, y2);
                        break;
                    case 'double':
                        line = createDoubleLine(x1, y1, x2, y2);
                        break;
                    case 'wavy':
                        line = createWavyLine(x1, y1, x2, y2);
                        break;
                    case 'sub-topic':
                        line = createSubTopicLine(x1, y1, x2, y2);
                        break;
                    case 'hierarchy':
                        line = createHierarchyLine(x1, y1, x2, y2);
                        break;
                    default:
                        line = createSolidLine(x1, y1, x2, y2);
                }
                
                // Only add control points for manual paths, not for regular connections
                // Control points will only appear when user explicitly creates a manual path
            }
                
                line.setAttribute('data-connection-id', conn.id);
                line.setAttribute('data-from', conn.from);
                line.setAttribute('data-to', conn.to);
                line.setAttribute('data-style', style);
                
                // Add click event listener for connection selection
                line.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selectConnection(conn.id);
                });
                
                svg.appendChild(line);
            }
        });
    }

    function createSolidLine(x1, y1, x2, y2) {
        // Create orthogonal L-shaped path instead of diagonal line
        return createOrthogonalLine(x1, y1, x2, y2, 'solid-line');
    }

    function createDashedLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'dashed-line');
    }

    function createDottedLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'dotted-line');
    }

    function createCurvedLine(x1, y1, x2, y2) {
        // For curved lines, we'll keep the original curved behavior but make it orthogonal-inspired
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        
        // Create a curved path that starts horizontal/vertical then curves
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        
        // Determine the dominant direction for the curve
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        
        let d;
        if (deltaX > deltaY) {
            // Mostly horizontal - curve vertically
            d = `M ${x1} ${y1} L ${midX} ${y1} Q ${midX} ${midY - 20} ${midX} ${midY} L ${x2} ${midY} L ${x2} ${y2}`;
        } else {
            // Mostly vertical - curve horizontally
            d = `M ${x1} ${y1} L ${x1} ${midY} Q ${midX - 20} ${midY} ${midX} ${midY} L ${midX} ${y2} L ${x2} ${y2}`;
        }
        
        path.setAttribute('d', d);
        path.setAttribute('class', 'connection-line curved-line');
        return path;
    }

    function createThickLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'thick-line');
    }

    function createDoubleLine(x1, y1, x2, y2) {
        // Create double orthogonal lines
        const group = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        
        // Calculate orthogonal path
        const path1 = createOrthogonalLine(x1, y1 - 2, x2, y2 - 2, 'double-line');
        const path2 = createOrthogonalLine(x1, y1 + 2, x2, y2 + 2, 'double-line');
        
        group.appendChild(path1);
        group.appendChild(path2);
        
        return group;
    }

    function createWavyLine(x1, y1, x2, y2) {
        // Create wavy orthogonal path
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        
        // Create wavy L-shaped path
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        
        let d;
        if (deltaX > deltaY) {
            // Horizontal first, then vertical with waves
            d = `M ${x1} ${y1} Q ${x1 + 20} ${y1 - 5} ${x1 + 40} ${y1} T ${x1 + 80} ${y1} L ${midX} ${y1} Q ${midX + 10} ${midY - 5} ${midX} ${midY} T ${midX + 40} ${midY} L ${x2} ${midY} Q ${x2 - 10} ${midY + 5} ${x2} ${y2}`;
        } else {
            // Vertical first, then horizontal with waves
            d = `M ${x1} ${y1} Q ${x1 - 5} ${y1 + 20} ${x1} ${y1 + 40} T ${x1} ${y1 + 80} L ${x1} ${midY} Q ${x1 - 5} ${midY + 10} ${x1} ${midY} T ${x1} ${midY + 40} L ${x1} ${y2} Q ${x1 + 5} ${y2 - 10} ${x2} ${y2}`;
        }
        
        path.setAttribute('d', d);
        path.setAttribute('class', 'connection-line wavy-line');
        return path;
    }

    function createSubTopicLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'sub-topic-line');
    }

    function createHierarchyLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'hierarchy-line');
    }

    function createOrthogonalLine(x1, y1, x2, y2, lineClass) {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        
        // Grid size for snapping
        const GRID_SIZE = 20;
        
        // Calculate orthogonal path (L-shaped) with grid snapping
        let midX = (x1 + x2) / 2;
        let midY = (y1 + y2) / 2;
        
        // Snap intermediate points to grid
        midX = Math.round(midX / GRID_SIZE) * GRID_SIZE;
        midY = Math.round(midY / GRID_SIZE) * GRID_SIZE;
        
        // Determine the best L-shaped route
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        
        let pathData;
        if (deltaX > deltaY) {
            // Go horizontal first, then vertical
            pathData = `M ${x1} ${y1} L ${midX} ${y1} L ${midX} ${y2} L ${x2} ${y2}`;
        } else {
            // Go vertical first, then horizontal
            pathData = `M ${x1} ${y1} L ${x1} ${midY} L ${x2} ${midY} L ${x2} ${y2}`;
        }
        
        path.setAttribute('d', pathData);
        path.setAttribute('class', `connection-line ${lineClass}`);
        path.style.fill = 'none';
        
        return path;
    }

    function createManualPath(x1, y1, x2, y2, pathPoints, connection) {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        
        // Snap path points to grid
        const GRID_SIZE = 20;
        
        // Create path from start node through all points to end node
        let pathData = `M ${x1} ${y1}`;
        pathPoints.forEach(point => {
            const snappedX = Math.round(point.x / GRID_SIZE) * GRID_SIZE;
            const snappedY = Math.round(point.y / GRID_SIZE) * GRID_SIZE;
            pathData += ` L ${snappedX} ${snappedY}`;
        });
        pathData += ` L ${x2} ${y2}`;
        
        path.setAttribute('d', pathData);
        path.setAttribute('class', 'connection-line manual-line');
        path.style.stroke = '#6b7280';
        path.style.strokeWidth = '2';
        path.style.fill = 'none';
        path.style.pointerEvents = 'none';
        
        // Add control points for manual path
        addControlPointsForPath(pathPoints, connection, x1, y1, x2, y2);
        
        return path;
    }

    function addControlPointsForLine(svg, x1, y1, x2, y2, connection) {
        // Grid size for snapping
        const GRID_SIZE = 20;
        
        // Calculate orthogonal path corners for control points
        let midX = (x1 + x2) / 2;
        let midY = (y1 + y2) / 2;
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        
        // Snap intermediate points to grid
        midX = Math.round(midX / GRID_SIZE) * GRID_SIZE;
        midY = Math.round(midY / GRID_SIZE) * GRID_SIZE;
        
        let corner1X, corner1Y, corner2X, corner2Y;
        
        if (deltaX > deltaY) {
            // Horizontal first, then vertical
            corner1X = midX;
            corner1Y = y1;
            corner2X = midX;
            corner2Y = y2;
        } else {
            // Vertical first, then horizontal
            corner1X = x1;
            corner1Y = midY;
            corner2X = x2;
            corner2Y = midY;
        }
        
        // Add control points at the corners of the L-shape
        const corner1 = createControlPoint(corner1X, corner1Y, connection, 'corner1');
        const corner2 = createControlPoint(corner2X, corner2Y, connection, 'corner2');
        
        svg.appendChild(corner1);
        svg.appendChild(corner2);
        
        controlPoints.push({
            element: corner1,
            connection: connection,
            type: 'corner1',
            x: corner1X,
            y: corner1Y
        });
        
        controlPoints.push({
            element: corner2,
            connection: connection,
            type: 'corner2',
            x: corner2X,
            y: corner2Y
        });
    }

    function addControlPointsForPath(pathPoints, connection, x1, y1, x2, y2) {
        const svg = document.getElementById('connections-svg');
        
        // Add control points for each path point
        pathPoints.forEach((point, index) => {
            const controlPoint = createControlPoint(point.x, point.y, connection, 'path', index);
            svg.appendChild(controlPoint);
            
            controlPoints.push({
                element: controlPoint,
                connection: connection,
                type: 'path',
                index: index,
                x: point.x,
                y: point.y
            });
        });
        
        // Add midpoint control point between last path point and end node
        const lastPoint = pathPoints.length > 0 ? pathPoints[pathPoints.length - 1] : { x: x1, y: y1 };
        const midX = (lastPoint.x + x2) / 2;
        const midY = (lastPoint.y + y2) / 2;
        
        const midControlPoint = createControlPoint(midX, midY, connection, 'midpoint-end');
        svg.appendChild(midControlPoint);
        
        controlPoints.push({
            element: midControlPoint,
            connection: connection,
            type: 'midpoint-end',
            x: midX,
            y: midY
        });
    }

    function createControlPoint(x, y, connection, type, index = null) {
        const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        circle.setAttribute('cx', x);
        circle.setAttribute('cy', y);
        circle.setAttribute('r', '6');
        circle.setAttribute('class', 'control-point');
        circle.style.fill = '#3b82f6';
        circle.style.stroke = 'white';
        circle.style.strokeWidth = '2';
        circle.style.cursor = 'move';
        circle.style.pointerEvents = 'all';
        
        // Store connection data
        circle.setAttribute('data-connection-id', connection.id);
        circle.setAttribute('data-type', type);
        if (index !== null) {
            circle.setAttribute('data-index', index);
        }
        
        // Add drag event listeners
        circle.addEventListener('mousedown', handleControlPointMouseDown);
        
        return circle;
    }

    function removeNode(node) {
        if (node.id === 'root-node') return; // Don't remove root node
        
        // Remove connections
        connections = connections.filter(conn => 
            conn.from !== node.id && conn.to !== node.id
        );
        
        // Remove from nodes array
        nodes = nodes.filter(n => n.id !== node.id);
        
        // Remove from DOM
        node.remove();
        
        // Clear selections and reset properties panel
        clearAllSelections();
        document.getElementById('properties-panel').innerHTML = '<p class="text-muted">Select an element to edit properties</p>';
        
        updateConnections();
        updateNodeCount();
        
        // Refresh materials list to make the material available again in sidebar
        refreshMaterialsList();
    }

    function clearCanvas() {
        if (confirm('Apakah Anda yakin ingin membersihkan canvas?')) {
            document.querySelectorAll('.mindmap-node:not(#root-node)').forEach(node => node.remove());
            nodes = [];
            connections = [];
            document.getElementById('connections-svg').innerHTML = '';
            updateNodeCount();
            
            // Refresh materials list to make all materials available again in sidebar
            refreshMaterialsList();
        }
    }

    function autoLayout() {
        if (nodes.length === 0) return;
        
        // Calculate viewport center for layout
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const viewportCenterX = canvasArea.clientWidth / 2;
        const viewportCenterY = canvasArea.clientHeight / 2;
        
        // Convert viewport coordinates to canvas coordinates
        const centerX = (viewportCenterX - panOffset.x * zoomLevel) / zoomLevel;
        const centerY = (viewportCenterY - panOffset.y * zoomLevel) / zoomLevel;
        
        const radius = 150;
        const angleStep = (2 * Math.PI) / nodes.length;
        
        nodes.forEach((node, index) => {
            const angle = index * angleStep;
            const x = centerX + radius * Math.cos(angle) - 60;
            const y = centerY + radius * Math.sin(angle) - 20;
            
            const nodeElement = document.getElementById(node.id);
            if (nodeElement) {
                nodeElement.style.left = x + 'px';
                nodeElement.style.top = y + 'px';
                node.x = x;
                node.y = y;
            }
        });
        
        updateConnections();
    }

    function saveMindmap() {
        console.log('saveMindmap called');
        console.log('selectedCategory:', selectedCategory);
        console.log('nodes:', nodes);
        console.log('connections:', connections);

        if (!selectedCategory) {
            alert('Pilih kategori terlebih dahulu');
            return;
        }

        const mindmapData = {
            nodes: nodes.map(node => ({
                id: node.id,
                materialId: node.materialId,
                title: node.title,
                x: node.x,
                y: node.y,
                type: node.type,
                completed: node.completed || false,
                style: node.style || {}
            })),
            connections: connections
        };

        console.log('mindmapData:', mindmapData);

        // Get title from selected category (no root node)
        const categoryBtn = document.querySelector(`[data-category-id="${selectedCategory}"]`);
        const title = categoryBtn ? categoryBtn.querySelector('.category-text').textContent : 'Mind Map';

        console.log('title:', title);

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        console.log('csrfToken:', csrfToken ? csrfToken.getAttribute('content') : 'not found');

        fetch('/mindmap-creator/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
            },
            body: JSON.stringify({
                category_id: selectedCategory,
                title: title,
                mindmap_data: mindmapData
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Unknown error',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error saving mindmap:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan mind map: ' + error.message,
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
    }
</script>
@endsection


@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function () {
            const MENU_KEY = 'nexel-classic-dashboard-menu-mini-theme';
            let previousSidebarState = null;

            function setSidebarMini(isMini) {
                if (isMini) {
                    $('html').addClass('minimenu');
                    $('.logo-full').hide();
                    $('.logo-abbr').show();
                    $('#menu-mini-button').hide();
                    $('#menu-expend-button').show();
                    return;
                }

                $('html').removeClass('minimenu');
                $('.logo-full').show();
                $('.logo-abbr').hide();
                $('#menu-mini-button').show();
                $('#menu-expend-button').hide();
            }

            previousSidebarState = {
                wasMini: $('html').hasClass('minimenu'),
                menuKey: localStorage.getItem(MENU_KEY)
            };

            $('html').addClass('mindmap-mini-sidebar-active');
            setSidebarMini(true);

            // common-init may re-expand sidebar on wide screens; keep mini on this page
            $(window).on('resize.mindmapMiniSidebar', function () {
                if ($('html').hasClass('mindmap-mini-sidebar-active') && !window.__mindmapSidebarExpandedByUser) {
                    setSidebarMini(true);
                }
            });

            $('#menu-expend-button').on('click.mindmapMiniSidebar', function () {
                window.__mindmapSidebarExpandedByUser = true;
            });

            $('#menu-mini-button').on('click.mindmapMiniSidebar', function () {
                window.__mindmapSidebarExpandedByUser = false;
            });

            $(window).on('pagehide', function () {
                if (!previousSidebarState) return;

                setSidebarMini(previousSidebarState.wasMini);

                if (previousSidebarState.menuKey) {
                    localStorage.setItem(MENU_KEY, previousSidebarState.menuKey);
                }

                $('html').removeClass('mindmap-mini-sidebar-active');
                $(window).off('resize.mindmapMiniSidebar');
                $('#menu-expend-button, #menu-mini-button').off('.mindmapMiniSidebar');
            });
        });
    </script>
@endpush