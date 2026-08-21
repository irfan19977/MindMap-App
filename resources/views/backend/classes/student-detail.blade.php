@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail Siswa</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes.show', $class->id) }}">{{ $class->name }}</a></li>
                <li class="breadcrumb-item active">Detail Siswa</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('classes.show', $class->id) }}" class="btn btn-secondary">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- [ Main Content ] start -->
    <div class="main-content">
        <div class="row">
            <!-- Left Column: Student Info -->
            <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="avatar-text avatar-xl bg-soft-primary text-primary rounded-circle mx-auto mb-3">
                                {{ strtoupper(substr($student->user->name ?? '?', 0, 1)) }}
                            </div>
                            <h5 class="card-title mb-2">{{ $student->user->name ?? '-' }}</h5>
                            <p class="text-muted mb-0">{{ $student->user->email ?? '-' }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-semibold mb-3">Informasi Kelas</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Kelas</span>
                                <span class="fw-semibold">{{ $class->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Kategori</span>
                                <span class="fw-semibold">{{ $class->category->name ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Sub Kategori</span>
                                <span class="fw-semibold">{{ $class->subcategory->name ?? '-' }}</span>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-semibold mb-3">Progres Pembelajaran</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-soft-{{ $enrollment->status === 'active' ? 'success' : ($enrollment->status === 'pending' ? 'warning' : ($enrollment->status === 'completed' ? 'info' : 'danger')) }} text-{{ $enrollment->status === 'active' ? 'success' : ($enrollment->status === 'pending' ? 'warning' : ($enrollment->status === 'completed' ? 'info' : 'danger')) }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Progres</span>
                                    <span class="fw-semibold">{{ $enrollment->progress_percentage }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Materi Selesai</span>
                                <span class="fw-semibold">{{ $enrollment->completed_materials_count ?? 0 }} / {{ $class->materials->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tanggal Bergabung</span>
                                <span class="fw-semibold">{{ $enrollment->updated_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: MindMap Canvas -->
            <div class="col-lg-8 col-md-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">MindMap - {{ $class->subcategory->name ?? 'Bahasa Indonesia' }}</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($mindmap)
                            <div class="drawio-layout" style="height: 600px;">
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
                        @else
                            <div class="alert alert-info text-center" style="margin: 20px;">
                                <i class="feather-info fs-3 d-block mb-2"></i>
                                <h5>Mindmap belum tersedia</h5>
                                <p class="text-muted">Mindmap untuk pelajaran ini belum dibuat.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>
@endsection

<!-- Quiz Answers Modal -->
<div class="modal fade" id="quizAnswersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jawaban Quiz - <span id="modalMaterialTitle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="quizAnswersContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat jawaban...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('backend/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
    @if($mindmap)
    <script>
        // Mindmap data
        const mindmapData = @json($mindmap->structure);
        
        // Completed materials
        const completedMaterialIds = @json($completedMaterialIds ?? []);
        
        // Student and class IDs for API calls
        const studentId = '{{ $student->id }}';
        const classId = '{{ $class->id }}';
        
        // State
        const nodes = [];
        const connections = [];
        let zoomLevel = 1;
        const READ_ONLY = true;
        
        const canvas = document.getElementById('mindmap-canvas');
        const viewport = document.querySelector('.canvas-viewport');
        const connectionsSvg = document.getElementById('connections-svg');
        const loadingEl = document.getElementById('mindmap-loading');
        
        // Initialize mindmap
        function initMindmap() {
            if (!mindmapData || !mindmapData.nodes || !mindmapData.connections) {
                loadingEl.innerHTML = '<p class="text-muted">Tidak ada data mindmap</p>';
                return;
            }
            
            loadingEl.style.display = 'none';
            
            renderMindmap(mindmapData);
            autoCenterMindmap();
        }
        
        function renderMindmap(structure) {
            if (structure.nodes) {
                structure.nodes.forEach(nodeData => {
                    const node = document.createElement('div');
                    let nodeClass = `mindmap-node ${nodeData.type || 'material'}`;
                    
                    // Check if material is completed
                    const isCompleted = nodeData.materialId && completedMaterialIds.includes(nodeData.materialId);
                    
                    // Add gray class if not completed
                    if (!isCompleted && nodeData.materialId) {
                        nodeClass += ' uncompleted';
                    }
                    
                    node.className = nodeClass;
                    node.id = nodeData.id;
                    node.style.left = nodeData.x + 'px';
                    node.style.top = nodeData.y + 'px';
                    node.innerHTML = `<span class="node-label">${nodeData.title}</span>`;
                    
                    // Add click event for completed materials
                    if (isCompleted && nodeData.materialId) {
                        node.style.cursor = 'pointer';
                        node.addEventListener('click', function(e) {
                            e.stopPropagation();
                            showQuizAnswers(nodeData.materialId, nodeData.title);
                        });
                    }
                    
                    canvas.appendChild(node);
                    
                    nodes.push({
                        id: nodeData.id,
                        materialId: nodeData.materialId,
                        title: nodeData.title,
                        x: nodeData.x,
                        y: nodeData.y,
                        type: nodeData.type || 'material',
                        completed: isCompleted
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

            const mindmapWidth = maxX - minX;
            const mindmapHeight = maxY - minY;

            // Calculate optimal zoom level to fit the mindmap within the viewport
            const scaleX = viewportWidth / mindmapWidth;
            const scaleY = viewportHeight / mindmapHeight;
            zoomLevel = Math.min(scaleX, scaleY, 1); // Don't zoom in more than 100% initially

            // Apply the initial zoom
            updateZoom();

            // Recalculate mindmap dimensions with the new zoom level
            let scaledMinX = Infinity, scaledMaxX = -Infinity, scaledMinY = Infinity, scaledMaxY = -Infinity;
            nodes.forEach(node => {
                const nodeEl = document.getElementById(node.id);
                if (nodeEl) {
                    const width = nodeEl.offsetWidth * zoomLevel;
                    const height = nodeEl.offsetHeight * zoomLevel;
                    scaledMinX = Math.min(scaledMinX, node.x * zoomLevel);
                    scaledMaxX = Math.max(scaledMaxX, (node.x * zoomLevel) + width);
                    scaledMinY = Math.min(scaledMinY, node.y * zoomLevel);
                    scaledMaxY = Math.max(scaledMaxY, (node.y * zoomLevel) + height);
                }
            });

            const scaledMindmapWidth = scaledMaxX - scaledMinX;
            const scaledMindmapHeight = scaledMaxY - scaledMinY;

            // Center the mindmap
            const scrollLeft = scaledMinX + (scaledMindmapWidth / 2) - (viewportWidth / 2);
            const scrollTop = scaledMinY + (scaledMindmapHeight / 2) - (viewportHeight / 2);

            canvasViewport.scrollLeft = scrollLeft;
            canvasViewport.scrollTop = scrollTop;
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
            autoCenterMindmap();
        }
        
        function updateZoom() {
            canvas.style.zoom = zoomLevel;
            const scaledGridSize = 20 * zoomLevel;
            canvas.style.backgroundSize = `${scaledGridSize}px ${scaledGridSize}px`;
            document.querySelector('.zoom-level').textContent = Math.round(zoomLevel * 100) + '%';
            updateConnections();
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', initMindmap);
        
        // Function to show quiz answers modal
        function showQuizAnswers(materialId, materialTitle) {
            const modal = document.getElementById('quizAnswersModal');
            const modalTitle = document.getElementById('modalMaterialTitle');
            const modalContent = document.getElementById('quizAnswersContent');
            
            modalTitle.textContent = materialTitle;
            modalContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat jawaban...</p>
                </div>
            `;
            
            // Show modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            
            // Fetch quiz answers
            fetch(`/classes/${classId}/students/${studentId}/quiz-answers/${materialId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayQuizAnswers(data.attempts, data.total_attempts);
                    } else {
                        modalContent.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="feather-alert-circle me-2"></i>
                                Gagal memuat jawaban quiz.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching quiz answers:', error);
                    modalContent.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="feather-alert-circle me-2"></i>
                            Terjadi kesalahan saat memuat jawaban.
                        </div>
                    `;
                });
        }
        
        function displayQuizAnswers(attempts, totalAttempts) {
            const modalContent = document.getElementById('quizAnswersContent');
            
            if (attempts.length === 0) {
                modalContent.innerHTML = `
                    <div class="alert alert-info">
                        <i class="feather-info me-2"></i>
                        Tidak ada jawaban quiz ditemukan untuk materi ini.
                    </div>
                `;
                return;
            }
            
            let html = `
                <div class="mb-3">
                    <span class="badge bg-primary">${totalAttempts} Percobaan</span>
                </div>
                <div class="row" id="attemptsContainer">
            `;
            
            attempts.forEach((attempt, index) => {
                const statusBadge = attempt.status === 'passed' 
                    ? '<span class="badge bg-success">Lulus</span>' 
                    : '<span class="badge bg-danger">Tidak Lulus</span>';
                
                html += `
                    <div class="col-md-4 mb-3">
                        <div class="card attempt-card" data-attempt-index="${index}" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Percobaan ${attempt.attempt_number}</h5>
                                <p class="card-text mb-2">Skor: ${attempt.score}</p>
                                <p class="card-text mb-2">${statusBadge}</p>
                                <small class="text-muted">${attempt.attempt_date}</small>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `
                </div>
                <div id="attemptDetails" class="mt-4" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 id="attemptDetailsTitle">Detail Percobaan</h6>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="hideAttemptDetails()">
                            <i class="feather-x"></i> Tutup Detail
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban Siswa</th>
                                    <th>Status</th>
                                    <th>Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody id="attemptDetailsBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            
            modalContent.innerHTML = html;
            
            // Add click events to attempt cards
            document.querySelectorAll('.attempt-card').forEach(card => {
                card.addEventListener('click', function() {
                    const attemptIndex = this.getAttribute('data-attempt-index');
                    showAttemptDetails(attempts[attemptIndex]);
                });
                
                // Add hover effect
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        }
        
        function showAttemptDetails(attempt) {
            const detailsContainer = document.getElementById('attemptDetails');
            const detailsTitle = document.getElementById('attemptDetailsTitle');
            const detailsBody = document.getElementById('attemptDetailsBody');
            
            detailsTitle.textContent = `Detail Percobaan ${attempt.attempt_number} - Skor: ${attempt.score}`;
            
            let html = '';
            attempt.answers.forEach((answer, index) => {
                const statusBadge = answer.is_correct 
                    ? '<span class="badge bg-success">Benar</span>' 
                    : '<span class="badge bg-danger">Salah</span>';
                
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${answer.question}</td>
                        <td>${answer.user_answer}</td>
                        <td>${statusBadge}</td>
                        <td>${answer.explanation}</td>
                    </tr>
                `;
            });
            
            detailsBody.innerHTML = html;
            detailsContainer.style.display = 'block';
            
            // Scroll to details
            detailsContainer.scrollIntoView({ behavior: 'smooth' });
        }
        
        function hideAttemptDetails() {
            const detailsContainer = document.getElementById('attemptDetails');
            detailsContainer.style.display = 'none';
        }
    </script>
    
    <style>
        :root {
            --mm-primary: #3454d1;
            --mm-success: #059669;
            --mm-border: #e2e8f0;
            --mm-canvas-bg: #f1f5f9;
            --mm-grid: #cbd5e1;
        }
        
        .attempt-card {
            border: 2px solid var(--mm-border);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .attempt-card:hover {
            border-color: var(--mm-primary);
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .attempt-card .card-body {
            padding: 1.5rem;
        }
        
        .attempt-card .card-title {
            font-weight: 600;
            color: var(--mm-primary);
            margin-bottom: 0.5rem;
        }
        
        #attemptDetails {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid var(--mm-border);
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
        
        .mindmap-node.material { background: #fde047; border-color: #ca8a04; color: #1a1a1a; }
        .mindmap-node.main-topic { background: #60a5fa; border-color: #1d4ed8; color: #fff; }
        .mindmap-node.sub-topic { background: #86efac; border-color: #15803d; color: #1a1a1a; }
        .mindmap-node.uncompleted { 
            background: #e2e8f0; 
            border-color: #94a3b8; 
            color: #64748b; 
            opacity: 0.7;
        }
        .mindmap-node.uncompleted:hover {
            opacity: 0.8;
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
        
        .connection-line.solid-line { stroke: #667eea; stroke-width: 2.5; }
        .connection-line.dashed-line { stroke: #ef4444; stroke-width: 2.5; stroke-dasharray: 10, 6; }
        .connection-line.dotted-line { stroke: #10b981; stroke-width: 2.5; stroke-dasharray: 3, 6; }
        .connection-line.curved-line { stroke: #f59e0b; stroke-width: 2.5; fill: none; }
        .connection-line.thick-line { stroke: #8b5cf6; stroke-width: 5; }
        
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
        
        .drawio-layout {
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--mm-border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
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
            color: #64748b;
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
            -webkit-overflow-scrolling: touch;
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
            color: #64748b;
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
            background: #fff;
            border: 1px solid var(--mm-border);
            border-radius: 10px;
            padding: 4px;
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
        
        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .drawio-layout {
                height: 500px;
            }
            
            .canvas-viewport {
                overflow-x: auto;
                overflow-y: auto;
            }
            
            .zoom-controls {
                bottom: 44px;
                right: 10px;
            }
            
            .canvas-chrome__hint {
                font-size: 10px;
            }
        }
    </style>
    @endif
@endpush
