@extends('frontend.layouts.app')

@section('content')
    <style>
        .edit-profile-section { padding: 60px 0; }
        .edit-profile-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 30px;
        }
        .edit-profile-card h3 {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }
        .form-group .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .form-group .invalid-feedback {
            display: block;
            color: #e53935;
            font-size: 13px;
            margin-top: 5px;
        }
        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .avatar-upload {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .avatar-preview {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            background: #333;
            color: #fff;
            font-size: 42px;
            line-height: 110px;
            text-align: center;
            font-weight: bold;
            flex-shrink: 0;
        }
        .avatar-upload-actions .form-control { max-width: 280px; }
        .avatar-upload-actions .form-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        .file-upload-wrapper {
            position: relative;
            display: inline-block;
        }
        .file-upload-wrapper input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .file-upload-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #333;
            color: #fff;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .file-upload-wrapper:hover .file-upload-button { background: #111; }
        .file-upload-filename {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: #666;
        }
        .remove-avatar-check {
            margin-top: 8px;
            font-size: 13px;
        }
        .remove-avatar-check input { margin-right: 6px; }
    </style>

    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Edit <span class="label classic">Profil</span></h1>
                        <p class="lead">Perbarui informasi pribadi kamu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="edit-profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    @if (session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="edit-profile-card">
                        <h3><i class="fas fa-user-edit"></i> Informasi Pribadi</h3>

                        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="avatar-upload">
                                @if($student->avatar_url)
                                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="avatar-preview" id="avatarPreview">
                                @else
                                    <div class="avatar-preview" id="avatarPreview">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                                @endif

                                <div class="avatar-upload-actions">
                                    <div class="file-upload-wrapper">
                                        <span class="file-upload-button">
                                            <i class="fas fa-upload"></i> Pilih Foto
                                        </span>
                                        <input type="file" id="avatar" name="avatar" accept="image/png,image/jpeg,image/webp">
                                    </div>
                                    <span class="file-upload-filename" id="avatarFilename">Belum ada file dipilih</span>
                                    <div class="form-text">JPG, PNG, atau WEBP. Maks. 2MB.</div>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($student->avatar_url)
                                        <label class="remove-avatar-check">
                                            <input type="checkbox" name="remove_avatar" value="1">
                                            Hapus foto profil saat ini
                                        </label>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="form-control"
                                       value="{{ old('name', $student->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="school">Sekolah</label>
                                <input type="text" id="school" name="school" class="form-control"
                                       value="{{ old('school', $student->school) }}">
                                @error('school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="grade">Kelas</label>
                                        <input type="text" id="grade" name="grade" class="form-control"
                                               value="{{ old('grade', $student->grade) }}">
                                        @error('grade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="major">Jurusan</label>
                                        <input type="text" id="major" name="major" class="form-control"
                                               value="{{ old('major', $student->major) }}">
                                        @error('major')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="learning_interest">Minat Belajar</label>
                                <input type="text" id="learning_interest" name="learning_interest" class="form-control"
                                       value="{{ old('learning_interest', $student->learning_interest) }}">
                                @error('learning_interest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birth_date">Tanggal Lahir</label>
                                        <input type="date" id="birth_date" name="birth_date" class="form-control"
                                               value="{{ old('birth_date', optional($student->birth_date)->format('Y-m-d')) }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">No. Telepon</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                               value="{{ old('phone', $student->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea id="address" name="address" class="form-control" rows="3">{{ old('address', $student->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('student.profile') }}" class="btn btn-dark-border">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('avatar').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            document.getElementById('avatarFilename').textContent = file.name;

            const reader = new FileReader();
            reader.onload = function (event) {
                const preview = document.getElementById('avatarPreview');
                const img = document.createElement('img');
                img.src = event.target.result;
                img.alt = 'Preview';
                img.className = 'avatar-preview';
                img.id = 'avatarPreview';
                preview.replaceWith(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection