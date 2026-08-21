@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Manajemen Kelas</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item">Kelas</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('classes.create') }}" class="btn btn-primary">
                        <i class="feather-plus me-2"></i>
                        <span>Tambah Kelas</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- [ Main Content ] start -->
    <div class="main-content">
        <!-- Pending Collaboration Invitations -->
        @if($pendingCollaborations->count() > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="card stretch stretch-full border-warning">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="feather-bell me-2"></i>Undangan Kolaborasi
                            <span class="badge bg-warning ms-2">{{ $pendingCollaborations->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Dari</th>
                                        <th>Kelas</th>
                                        <th>Permissions</th>
                                        <th>Tanggal</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingCollaborations as $collab)
                                        <tr>
                                            <td><span class="fw-semibold">{{ $collab->admin->name ?? '-' }}</span></td>
                                            <td><span class="fw-semibold">{{ $collab->class->name ?? '-' }}</span></td>
                                            <td>
                                                @if($collab->permissions)
                                                    @foreach($collab->permissions as $perm)
                                                        <span class="badge bg-soft-primary text-primary me-1">{{ ucfirst($perm) }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $collab->invited_at ? $collab->invited_at->format('d M Y H:i') : '-' }}</td>
                                            <td class="text-end">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <form id="accept-collab-{{ $collab->id }}" method="POST" action="{{ route('collaborations.my.accept', $collab->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="button" class="avatar-text avatar-md border-0" style="background-color: rgba(40, 199, 111, 0.15); color: #28c76f;" data-bs-toggle="tooltip" title="Terima" onclick="acceptCollaboration('{{ $collab->id }}', '{{ $collab->class->name ?? '' }}')">
                                                            <i class="feather-check"></i>
                                                        </button>
                                                    </form>
                                                    <form id="reject-collab-{{ $collab->id }}" method="POST" action="{{ route('collaborations.my.reject', $collab->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="button" class="avatar-text avatar-md border-0" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;" data-bs-toggle="tooltip" title="Tolak" onclick="rejectCollaboration('{{ $collab->id }}', '{{ $collab->class->name ?? '' }}')">
                                                            <i class="feather-x"></i>
                                                        </button>
                                                    </form>
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
        </div>
        @endif

        <!-- Class List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="classList">
                                <thead>
                                    <tr>
                                        <th class="wd-30 text-center">
                                            <div class="custom-control custom-checkbox ms-1">
                                                <input type="checkbox" class="custom-control-input" id="checkAllClass">
                                                <label class="custom-control-label" for="checkAllClass"></label>
                                            </div>
                                        </th>
                                        <th class="text-center">Nama Kelas</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Jenjang</th>
                                        <th class="text-center">Guru</th>
                                        <th class="text-center">Tipe</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Siswa</th>
                                        <th class="text-center">Perlu Approve</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $class)
                                        <tr class="single-item">
                                            <td>
                                                <div class="item-checkbox ms-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox" id="checkBox_{{ $class->id }}">
                                                        <label class="custom-control-label" for="checkBox_{{ $class->id }}"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ $class->cover_image_url }}" alt="{{ $class->name }}" class="avatar-text avatar-lg rounded" style="object-fit: cover;">
                                                    <div>
                                                        <span class="text-truncate-1-line fw-bold d-block">{{ $class->name }}</span>
                                                        <small class="text-muted">{{ $class->slug }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-soft-primary text-primary">{{ $class->category->name ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-soft-info text-info">{{ $class->subcategory->formatted_grade_level ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $class->teacher->name ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($class->id, $collaborationClassIds))
                                                    <span class="badge bg-soft-info text-info">Kolaborasi</span>
                                                @else
                                                    <span class="badge bg-soft-success text-success">Pemilik</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-soft-{{ $class->status === 'publish' ? 'success' : ($class->status === 'draft' ? 'secondary' : 'warning') }} text-{{ $class->status === 'publish' ? 'success' : ($class->status === 'draft' ? 'secondary' : 'warning') }}">
                                                    {{ $class->formatted_status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-soft-success text-success">
                                                    {{ $class->activeEnrollments()->count() }} / {{ $class->capacity ?? '&infin;' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($class->pendingEnrollments()->count() > 0)
                                                    <span class="badge bg-primary text-white rounded-pill ms-2">
                                                        {{ $class->pendingEnrollments()->count() }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="hstack gap-2 justify-content-end">
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0)" class="avatar-text avatar-md" data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                            <i class="feather feather-more-horizontal"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('classes.show', $class->id) }}">
                                                                    <i class="feather feather-eye me-3"></i>
                                                                    <span>Detail</span>
                                                                </a>
                                                            </li>
                                                            @if(!in_array($class->id, $collaborationClassIds))
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('classes.edit', $class->id) }}">
                                                                    <i class="feather feather-edit-3 me-3"></i>
                                                                    <span>Edit</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('classes.collaboration', $class->id) }}">
                                                                    <i class="feather feather-users me-3"></i>
                                                                    <span>Ajak Kolaborasi</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteClass('{{ $class->id }}', '{{ $class->name }}')">
                                                                    <i class="feather feather-trash-2 me-3"></i>
                                                                    <span>Hapus</span>
                                                                </a>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
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
    <script src="{{ asset('backend/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
    <script>
        // Define functions globally before DOM ready
        window.acceptCollaboration = function(id, className) {
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 tidak ter-load. Silakan refresh halaman.');
                return;
            }
            Swal.fire({
                title: 'Terima Kolaborasi?',
                text: 'Yakin ingin menerima undangan kolaborasi untuk kelas "' + className + '"?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, terima!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28c76f',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                const isConfirmed = result.isConfirmed || result.value === true;
                if (isConfirmed) {
                    const form = document.getElementById('accept-collab-' + id);
                    if (form) {
                        form.submit();
                    } else {
                        Swal.fire('Error!', 'Form tidak ditemukan', 'error');
                    }
                }
            });
        };

        window.rejectCollaboration = function(id, className) {
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 tidak ter-load. Silakan refresh halaman.');
                return;
            }
            Swal.fire({
                title: 'Tolak Kolaborasi?',
                text: 'Yakin ingin menolak undangan kolaborasi untuk kelas "' + className + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, tolak!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                const isConfirmed = result.isConfirmed || result.value === true;
                if (isConfirmed) {
                    const form = document.getElementById('reject-collab-' + id);
                    if (form) {
                        form.submit();
                    } else {
                        Swal.fire('Error!', 'Form tidak ditemukan', 'error');
                    }
                }
            });
        };

        window.deleteClass = function(id, name) {
            if (typeof Swal === 'undefined') {
                alert('SweetAlert2 tidak ter-load. Silakan refresh halaman.');
                return;
            }
            Swal.fire({
                title: 'Hapus Kelas?',
                text: 'Yakin ingin menghapus kelas "' + name + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route('classes.index') }}/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire('Terhapus!', 'Kelas berhasil dihapus.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus kelas.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    });
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined') {
                $('#classList').DataTable({
                    responsive: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        emptyTable: "Tidak ada data",
                        zeroRecords: "Data tidak ditemukan"
                    },
                    order: [[1, 'asc']]
                });
            }
        });
    </script>
@endpush
