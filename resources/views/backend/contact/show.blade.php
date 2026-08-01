@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pesan Contact</h5>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Nama:</label>
                            </div>
                            <div class="col-md-9">
                                <p>{{ $contact->name }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Email:</label>
                            </div>
                            <div class="col-md-9">
                                <p>{{ $contact->email }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Pesan:</label>
                            </div>
                            <div class="col-md-9">
                                <p>{{ $contact->message }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Status:</label>
                            </div>
                            <div class="col-md-9">
                                <span class="badge {{ $contact->is_read ? 'bg-success' : 'bg-warning' }}">
                                    {{ $contact->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tanggal:</label>
                            </div>
                            <div class="col-md-9">
                                <p>{{ $contact->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
