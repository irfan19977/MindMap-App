<!DOCTYPE html>
<html lang="en">

<head>
    <title>Daftar - MindMap</title>
    <link rel="icon" href="{{ asset('frontend/images/icon.webp') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="MindMap - Platform Pembelajaran Interaktif" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Files -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/coloring.css') }}" rel="stylesheet" type="text/css">
    <link id="colors" href="{{ asset('frontend/css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    
    <style>
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            background-image: url('{{ asset('frontend/images/background/1.webp') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 20px;
        }
        
        .register-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(245, 245, 245, 0.85);
            z-index: 1;
        }
        
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            position: relative;
            z-index: 2;
        }
        
        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-logo img {
            max-width: 120px;
            height: auto;
        }
        
        .register-title {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-size: 28px;
            font-weight: 700;
        }
        
        .register-subtitle {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #8B9A46;
            box-shadow: 0 0 0 0.2rem rgba(139, 154, 70, 0.25);
        }
        
        .btn-register {
            background: #8B9A46;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }
        
        .btn-register:hover {
            background: #7A8739;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-secondary-outline {
            background: transparent;
            border: 2px solid #8B9A46;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #8B9A46;
            width: 100%;
            transition: all 0.2s;
        }
        
        .btn-secondary-outline:hover {
            background: #8B9A46;
            color: white;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 10;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .role-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }
        
        .role-card:hover {
            border-color: #8B9A46;
            background: #f8f9f0;
        }
        
        .role-card.selected {
            border-color: #8B9A46;
            background: #eef1e0;
        }
        
        .role-card i {
            font-size: 32px;
            margin-bottom: 10px;
            color: #8B9A46;
        }
        
        .role-card h5 {
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        .role-card p {
            font-size: 12px;
            color: #888;
            margin: 0;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }
        
        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ddd;
            margin: 0 5px;
            transition: all 0.3s;
        }
        
        .step-dot.active {
            background: #8B9A46;
            width: 30px;
            border-radius: 5px;
        }
        
        .step { display: none; }
        .step.active { display: block; }
        
        .social-login {
            text-align: center;
            margin-top: 30px;
        }
        
        .social-login .divider {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #999;
            font-size: 13px;
        }
        
        .social-login .divider::before,
        .social-login .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }
        
        .social-login .divider span {
            padding: 0 15px;
        }
        
        .social-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            color: #666;
        }
        
        .social-btn:hover {
            border-color: #8B9A46;
            color: #8B9A46;
            transform: translateY(-2px);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }
        
        .login-link a {
            color: #8B9A46;
            font-weight: 600;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            margin: 0;
            cursor: pointer;
        }
        
        .form-check-label {
            cursor: pointer;
            user-select: none;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-logo">
                <img src="{{ asset('frontend/images/logo.webp') }}" alt="MindMap Logo">
            </div>
            
            <h2 class="register-title">Daftar Akun</h2>
            <p class="register-subtitle">Buat akun MindMap Anda</p>

            <div class="step-indicator">
                <div class="step-dot active" id="dot-1"></div>
                <div class="step-dot" id="dot-2"></div>
                <div class="step-dot" id="dot-3"></div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="w-100" id="registerForm" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Data Dasar -->
                <div class="step active" id="step-1">
                    <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px; color: #333;">Buat Akun Baru</h4>
                    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">Isi data dasar Anda</p>

                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name', $socialRegistration['name'] ?? '') }}" required autofocus autocomplete="name" {{ $socialRegistration ? 'readonly' : '' }}>
                        <div id="client-error-name" class="client-error text-danger small mt-1 d-none"></div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', $socialRegistration['email'] ?? '') }}" required autocomplete="username" {{ $socialRegistration ? 'readonly' : '' }}>
                        <div id="client-error-email" class="client-error text-danger small mt-1 d-none"></div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @if($socialRegistration)
                        <div class="alert alert-info small">Akun {{ ucfirst($socialRegistration['provider']) }} terhubung. Lengkapi pilihan role dan profil Anda.</div>
                    @else
                        <div class="mb-3">
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                                <i class="fa-solid fa-eye password-toggle" onclick="togglePassword()" id="passwordIcon"></i>
                            </div>
                            <div id="client-error-password" class="client-error text-danger small mt-1 d-none"></div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                                <i class="fa-solid fa-eye password-toggle" onclick="toggleConfirmPassword()" id="confirmPasswordIcon"></i>
                            </div>
                            <div id="client-error-password_confirmation" class="client-error text-danger small mt-1 d-none"></div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <button type="button" class="btn btn-register" onclick="nextStep()">Lanjutkan</button>
                    </div>
                </div>

                <!-- Step 2: Pilih Role -->
                <div class="step" id="step-2">
                    <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px; color: #333;">Pilih Tipe Akun</h4>
                    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">Pilih role yang sesuai dengan Anda</p>

                    <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type', '') }}">
                    <div id="client-error-user_type" class="client-error text-danger small mb-2 d-none"></div>
                    @error('user_type')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror

                    <div class="row mb-12">
                        <div class="col-6">
                            <div class="role-card {{ old('user_type') == 'student' ? 'selected' : '' }}" onclick="selectRole('student')">
                                <i class="fa-solid fa-book-open"></i>
                                <h5>Siswa</h5>
                                <p>Belajar dan ikuti kelas</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="role-card {{ old('user_type') == 'teacher' ? 'selected' : '' }}" onclick="selectRole('teacher')">
                                <i class="fa-solid fa-award"></i>
                                <h5>Guru</h5>
                                <p>Mengajar dan buat kelas</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="button" class="btn btn-secondary-outline w-50" onclick="prevStep()">Kembali</button>
                        <button type="button" class="btn btn-register w-50" onclick="nextStep()">Lanjutkan</button>
                    </div>
                </div>

                <!-- Step 3: Data Tambahan sesuai Role -->
                <div class="step" id="step-3">
                    <div id="step2-title"></div>

                    

                    <!-- Teacher Fields -->
                    <div id="teacher-fields" style="display: none;">
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px; color: #333;">Profil Guru</h4>
                        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">Lengkapi data profil pengajar Anda</p>

                        <!-- Profile Photo -->
                        <div class="mb-4">
                            <div class="text-center">
                                <div id="teacher-avatar-preview" style="width: 100px; height: 100px; border-radius: 50%; background: #f0f0f0; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid #8B9A46;">
                                    <i class="fa-solid fa-user" style="font-size: 40px; color: #ccc;"></i>
                                </div>
                                <input type="file" class="form-control" name="avatar" id="teacher-avatar-input" accept="image/*" style="display: none;">
                                <button type="button" class="btn" onclick="document.getElementById('teacher-avatar-input').click()" style="background: #8B9A46; border: none; border-radius: 10px; padding: 8px 20px; font-size: 14px; font-weight: 600; color: white; transition: all 0.2s;">
                                    <i class="fa-solid fa-camera me-2"></i>Upload Foto
                                </button>
                                <p style="font-size: 12px; color: #999; margin-top: 8px;">Format: JPG, PNG, WEBP (Max: 200KB)</p>
                            </div>
                            @error('avatar')
                                <div class="text-danger small mt-1 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Mata Pelajaran / Spesialisasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="specialization" placeholder="cth: Matematika & Fisika" value="{{ old('specialization') }}">
                            <div id="client-error-specialization" class="client-error text-danger small mt-1 d-none"></div>
                            @error('specialization')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Pendidikan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="education" placeholder="cth: S2 Pendidikan, Universitas Indonesia" value="{{ old('education') }}">
                            <div id="client-error-education" class="client-error text-danger small mt-1 d-none"></div>
                            @error('education')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Pengalaman Mengajar</label>
                            <input type="text" class="form-control" name="experience" placeholder="cth: 5+ tahun mengajar di SMA" value="{{ old('experience') }}">
                            @error('experience')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Tentang Saya <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Ceritakan tentang diri Anda, keahlian, dan metode mengajar Anda">{{ old('description') }}</textarea>
                            <div id="client-error-description" class="client-error text-danger small mt-1 d-none"></div>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">LinkedIn URL</label>
                            <input type="url" class="form-control" name="linkedin_url" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin_url') }}">
                            @error('linkedin_url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">GitHub URL</label>
                            <input type="url" class="form-control" name="github_url" placeholder="https://github.com/username" value="{{ old('github_url') }}">
                            @error('github_url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Twitter URL</label>
                            <input type="url" class="form-control" name="twitter_url" placeholder="https://twitter.com/username" value="{{ old('twitter_url') }}">
                            @error('twitter_url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Student Fields -->
                    <div id="student-fields" style="display: none;">
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px; color: #333;">Profil Siswa</h4>
                        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">Lengkapi data profil siswa Anda</p>

                        <!-- Profile Photo -->
                        <div class="mb-4">
                            <div class="text-center">
                                <div id="student-avatar-preview" style="width: 100px; height: 100px; border-radius: 50%; background: #f0f0f0; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid #8B9A46;">
                                    <i class="fa-solid fa-user" style="font-size: 40px; color: #ccc;"></i>
                                </div>
                                <input type="file" class="form-control" name="avatar" id="student-avatar-input" accept="image/*" style="display: none;">
                                <button type="button" class="btn" onclick="document.getElementById('student-avatar-input').click()" style="background: #8B9A46; border: none; border-radius: 10px; padding: 8px 20px; font-size: 14px; font-weight: 600; color: white; transition: all 0.2s;">
                                    <i class="fa-solid fa-camera me-2"></i>Upload Foto
                                </button>
                                <p style="font-size: 12px; color: #999; margin-top: 8px;">Format: JPG, PNG, WEBP (Max: 200KB)</p>
                            </div>
                            @error('avatar')
                                <div class="text-danger small mt-1 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Asal Sekolah / Universitas</label>
                            <input type="text" class="form-control" name="school" placeholder="cth: SMA Negeri 1 Jakarta" value="{{ old('school') }}" required>
                            <div id="client-error-school" class="client-error text-danger small mt-1 d-none"></div>
                            @error('school')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Jurusan</label>
                            <input type="text" class="form-control" name="major" placeholder="cth: IPA / IPS / Teknik Informatika" value="{{ old('major') }}" required>
                            <div id="client-error-major" class="client-error text-danger small mt-1 d-none"></div>
                            @error('major')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Kategori yang ingin dipelajari</label>
                            <div class="row g-2">
                                @forelse($categories as $category)
                                    <div class="col-12">
                                        <label class="form-check border rounded p-2 mb-0">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" name="category_interests[]" value="{{ $category->id }}" {{ in_array($category->id, old('category_interests', [])) ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ $category->name }}</span>
                                        </label>
                                    </div>
                                @empty
                                    <span class="small text-muted">Kategori belum tersedia.</span>
                                @endforelse
                            </div>
                            <div id="client-error-category_interests" class="client-error text-danger small mt-1 d-none"></div>
                            @error('category_interests')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCondition" name="terms" required>
                            <label class="form-check-label" for="termsCondition" style="color: #666;">Saya setuju dengan <a href="#" style="color: #8B9A46;">Syarat & Ketentuan</a> dan <a href="#" style="color: #8B9A46;">Kebijakan Privasi</a></label>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="button" class="btn btn-secondary-outline w-50" onclick="prevStep()">Kembali</button>
                        <button type="submit" class="btn btn-register w-50" onclick="event.preventDefault(); if (validateStep3()) document.getElementById('registerForm').submit();">Buat Akun</button>
                    </div>
                </div>
            </form>

            <div class="social-login">
                <div class="divider">
                    <span>atau daftar dengan</span>
                </div>
                <div class="social-buttons">
                    <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="{{ route('social.redirect', 'google') }}" class="social-btn" title="Google">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="{{ route('social.redirect', 'github') }}" class="social-btn" title="GitHub">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </div>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        let currentStep = 1;
        const selectedRole = '{{ old("user_type", "") }}';
        const isSocialRegistration = {{ $socialRegistration ? 'true' : 'false' }};

        // Avatar preview functionality for teacher
        const teacherAvatarInput = document.getElementById('teacher-avatar-input');
        if (teacherAvatarInput) {
            teacherAvatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('teacher-avatar-preview');
                        preview.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Avatar preview functionality for student
        const studentAvatarInput = document.getElementById('student-avatar-input');
        if (studentAvatarInput) {
            studentAvatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('student-avatar-preview');
                        preview.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // If there were validation errors on biodata fields, go to step 3
        @if($errors->has('specialization') || $errors->has('education') || $errors->has('description') || $errors->has('school') || $errors->has('occupation') || $errors->has('category_interests'))
            document.addEventListener('DOMContentLoaded', function() {
                if (selectedRole) {
                    selectRole(selectedRole);
                    showRoleFields();
                    goToStep(3);
                }
            });
        @endif

        // If there was a validation error on user_type, go to step 2
        @if($errors->has('user_type'))
            document.addEventListener('DOMContentLoaded', function() {
                goToStep(2);
            });
        @endif

        function selectRole(role) {
            document.getElementById('user_type').value = role;
            document.querySelectorAll('.role-card').forEach(card => card.classList.remove('selected'));
            event.currentTarget ? event.currentTarget.classList.add('selected') :
                document.querySelectorAll('.role-card')[role === 'student' ? 0 : (role === 'teacher' ? 1 : 2)].classList.add('selected');
        }

        function showRoleFields() {
            const userType = document.getElementById('user_type').value;
            document.getElementById('teacher-fields').style.display = userType === 'teacher' ? 'block' : 'none';
            document.getElementById('student-fields').style.display = userType === 'student' ? 'block' : 'none';
        }

        function clearClientError(field) {
            const errorEl = document.getElementById('client-error-' + field);
            if (errorEl) {
                errorEl.classList.add('d-none');
                errorEl.textContent = '';
            }
            const input = document.querySelector('[name="' + field + '"]') || document.getElementById(field);
            if (input) input.classList.remove('is-invalid');
        }

        function showClientError(field, message) {
            const errorEl = document.getElementById('client-error-' + field);
            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.remove('d-none');
            }
            const input = document.querySelector('[name="' + field + '"]') || document.getElementById(field);
            if (input) input.classList.add('is-invalid');
        }

        function validateStep1() {
            let valid = true;
            const name = document.querySelector('input[name="name"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const passwordInput = document.getElementById('password');
            const password = passwordInput ? passwordInput.value : '';
            const passwordConfirmInput = document.querySelector('input[name="password_confirmation"]');
            const passwordConfirm = passwordConfirmInput ? passwordConfirmInput.value : '';

            if (!name) {
                showClientError('name', 'Nama lengkap wajib diisi.');
                valid = false;
            }

            if (!email) {
                showClientError('email', 'Email wajib diisi.');
                valid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showClientError('email', 'Format email tidak valid.');
                valid = false;
            }

            if (!isSocialRegistration) {
                if (!password) {
                    showClientError('password', 'Password wajib diisi.');
                    valid = false;
                } else if (password.length < 8) {
                    showClientError('password', 'Password minimal 8 karakter.');
                    valid = false;
                }

                if (!passwordConfirm) {
                    showClientError('password_confirmation', 'Konfirmasi password wajib diisi.');
                    valid = false;
                } else if (password !== passwordConfirm) {
                    showClientError('password_confirmation', 'Password dan konfirmasi password tidak cocok.');
                    valid = false;
                }
            }

            return valid;
        }

        function validateStep2() {
            let valid = true;
            const userType = document.getElementById('user_type').value;

            if (!userType) {
                showClientError('user_type', 'Harap pilih tipe akun (Siswa atau Guru)');
                valid = false;
            }

            return valid;
        }

        function validateStep3() {
            let valid = true;
            const userType = document.getElementById('user_type').value;

            if (userType === 'teacher') {
                const specialization = document.querySelector('input[name="specialization"]').value.trim();
                const education = document.querySelector('input[name="education"]').value.trim();
                const description = document.querySelector('textarea[name="description"]').value.trim();

                if (!specialization) {
                    showClientError('specialization', 'Mata pelajaran / spesialisasi wajib diisi.');
                    valid = false;
                }

                if (!education) {
                    showClientError('education', 'Pendidikan wajib diisi.');
                    valid = false;
                }

                if (!description) {
                    showClientError('description', 'Tentang saya wajib diisi.');
                    valid = false;
                }
            }

            if (userType === 'student') {
                const school = document.querySelector('input[name="school"]').value.trim();
                const major = document.querySelector('input[name="major"]').value.trim();
                const categoryInterests = document.querySelectorAll('input[name="category_interests[]"]:checked');

                if (!school) {
                    showClientError('school', 'Asal sekolah / universitas wajib diisi.');
                    valid = false;
                }

                if (!major) {
                    showClientError('major', 'Jurusan wajib diisi.');
                    valid = false;
                }

                if (categoryInterests.length === 0) {
                    showClientError('category_interests', 'Pilih minimal satu kategori yang ingin dipelajari.');
                    valid = false;
                }
            }

            const termsCheckbox = document.getElementById('termsCondition');
            if (!termsCheckbox.checked) {
                termsCheckbox.classList.add('is-invalid');
                valid = false;
            } else {
                termsCheckbox.classList.remove('is-invalid');
            }

            return valid;
        }

        document.querySelectorAll('#step-1 input').forEach(input => {
            input.addEventListener('input', function() {
                clearClientError(this.name);
            });
        });

        document.querySelectorAll('#step-2 input').forEach(input => {
            input.addEventListener('input', function() {
                clearClientError(this.name);
            });
        });

        document.querySelectorAll('#step-3 input, #step-3 textarea').forEach(input => {
            input.addEventListener('input', function() {
                clearClientError(this.name);
            });
        });

        document.querySelectorAll('#step-3 input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', function() {
                clearClientError(this.name);
            });
        });

        function nextStep() {
            const userType = document.getElementById('user_type').value;

            if (currentStep === 1) {
                if (!validateStep1()) return;
                goToStep(2);
                return;
            }

            if (currentStep === 2) {
                if (!validateStep2()) return;
                showRoleFields();
                goToStep(3);
                return;
            }
        }

        function prevStep() {
            if (currentStep === 3) {
                goToStep(2);
            } else if (currentStep === 2) {
                goToStep(1);
            }
        }

        function goToStep(step) {
            currentStep = step;
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');

            document.querySelectorAll('.step-dot').forEach(d => d.classList.remove('active'));
            document.getElementById('dot-' + step).classList.add('active');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                confirmPasswordIcon.classList.remove('fa-eye');
                confirmPasswordIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                confirmPasswordIcon.classList.remove('fa-eye-slash');
                confirmPasswordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
