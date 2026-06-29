<!DOCTYPE html>
<html lang="zxx">

@include('backend.layouts.head')

<body>
    <style>
        .step { display: none; }
        .step.active { display: block; }
        .role-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .role-card:hover {
            border-color: #3454d1;
            background: #f8f9ff;
        }
        .role-card.selected {
            border-color: #3454d1;
            background: #eef1ff;
        }
        .role-card i {
            font-size: 36px;
            margin-bottom: 10px;
            color: #3454d1;
        }
        .role-card h5 {
            margin-bottom: 5px;
            font-weight: 600;
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
            background: #3454d1;
            width: 30px;
            border-radius: 5px;
        }
    </style>

    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('backend/assets/images/logo-abbr.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Register</h2>

                        <div class="step-indicator">
                            <div class="step-dot active" id="dot-1"></div>
                            <div class="step-dot" id="dot-2"></div>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="w-100" id="registerForm">
                            @csrf

                            <!-- Step 1: Data Dasar + Pilih Role -->
                            <div class="step active" id="step-1">
                                <h4 class="fs-13 fw-bold mb-2">Buat Akun Baru</h4>
                                <p class="fs-12 fw-medium text-muted mb-4">Isi data dasar Anda dan pilih tipe akun</p>

                                <div class="mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus autocomplete="name">
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                                        <div class="input-group-text c-pointer" onclick="togglePassword()">
                                            <i id="passwordIcon" class="feather feather-eye"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                                </div>

                                <label class="fs-13 fw-bold mb-3">Daftar sebagai:</label>
                                <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type', '') }}">
                                @error('user_type')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror

                                <div class="row mb-4">
                                    <div class="col-4">
                                        <div class="role-card {{ old('user_type') == 'student' ? 'selected' : '' }}" onclick="selectRole('student')">
                                            <i class="feather feather-book-open"></i>
                                            <h5>Siswa</h5>
                                            <p>Belajar dan ikuti kelas</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="role-card {{ old('user_type') == 'teacher' ? 'selected' : '' }}" onclick="selectRole('teacher')">
                                            <i class="feather feather-award"></i>
                                            <h5>Guru</h5>
                                            <p>Mengajar dan buat kelas</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="role-card {{ old('user_type') == 'umum' ? 'selected' : '' }}" onclick="selectRole('umum')">
                                            <i class="feather feather-users"></i>
                                            <h5>Umum</h5>
                                            <p>Akses konten publik</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="button" class="btn btn-lg btn-primary w-100" onclick="nextStep()">Lanjutkan</button>
                                </div>
                            </div>

                            <!-- Step 2: Data Tambahan sesuai Role -->
                            <div class="step" id="step-2">
                                <div id="step2-title"></div>

                                <!-- Teacher Fields -->
                                <div id="teacher-fields" style="display: none;">
                                    <h4 class="fs-13 fw-bold mb-2">Profil Guru</h4>
                                    <p class="fs-12 fw-medium text-muted mb-4">Lengkapi data profil pengajar Anda</p>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Mata Pelajaran / Spesialisasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="specialization" placeholder="cth: Matematika & Fisika" value="{{ old('specialization') }}">
                                        @error('specialization')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Pendidikan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="education" placeholder="cth: S2 Pendidikan, Universitas Indonesia" value="{{ old('education') }}">
                                        @error('education')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Pengalaman Mengajar</label>
                                        <input type="text" class="form-control" name="experience" placeholder="cth: 5+ tahun mengajar di SMA" value="{{ old('experience') }}">
                                        @error('experience')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Tentang Saya <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Ceritakan tentang diri Anda, keahlian, dan metode mengajar Anda">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">LinkedIn URL</label>
                                        <input type="url" class="form-control" name="linkedin_url" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin_url') }}">
                                        @error('linkedin_url')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">GitHub URL</label>
                                        <input type="url" class="form-control" name="github_url" placeholder="https://github.com/username" value="{{ old('github_url') }}">
                                        @error('github_url')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Twitter URL</label>
                                        <input type="url" class="form-control" name="twitter_url" placeholder="https://twitter.com/username" value="{{ old('twitter_url') }}">
                                        @error('twitter_url')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Student Fields -->
                                <div id="student-fields" style="display: none;">
                                    <h4 class="fs-13 fw-bold mb-2">Profil Siswa</h4>
                                    <p class="fs-12 fw-medium text-muted mb-4">Lengkapi data profil siswa Anda</p>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Asal Sekolah / Universitas</label>
                                        <input type="text" class="form-control" name="school" placeholder="cth: SMA Negeri 1 Jakarta" value="{{ old('school') }}">
                                        @error('school')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Umum Fields -->
                                <div id="umum-fields" style="display: none;">
                                    <h4 class="fs-13 fw-bold mb-2">Akun Umum</h4>
                                    <p class="fs-12 fw-medium text-muted mb-4">Akun Anda siap dibuat! Klik tombol di bawah untuk menyelesaikan pendaftaran.</p>
                                </div>

                                <div class="mt-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="termsCondition" name="terms" required>
                                        <label class="custom-control-label c-pointer text-muted" for="termsCondition" style="font-weight: 400 !important">Saya setuju dengan <a href="">Syarat & Ketentuan</a> dan <a href="">Kebijakan Privasi</a></label>
                                    </div>
                                </div>

                                <div class="mt-4 d-flex gap-2">
                                    <button type="button" class="btn btn-lg btn-outline-secondary w-50" onclick="prevStep()">Kembali</button>
                                    <button type="submit" class="btn btn-lg btn-primary w-50">Buat Akun</button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-5 text-muted">
                            <span>Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="fw-bold">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

  @include('backend.layouts.scriptcustom')
  <script>
    let currentStep = 1;
    const selectedRole = '{{ old("user_type", "") }}';

    // If there were validation errors on step 2 fields, go to step 2
    @if($errors->has('specialization') || $errors->has('education') || $errors->has('description') || $errors->has('school'))
        document.addEventListener('DOMContentLoaded', function() {
            if (selectedRole) {
                selectRole(selectedRole);
                goToStep(2);
            }
        });
    @endif

    function selectRole(role) {
        document.getElementById('user_type').value = role;
        document.querySelectorAll('.role-card').forEach(card => card.classList.remove('selected'));
        event.currentTarget ? event.currentTarget.classList.add('selected') :
            document.querySelectorAll('.role-card')[role === 'student' ? 0 : (role === 'teacher' ? 1 : 2)].classList.add('selected');
    }

    function nextStep() {
        const name = document.querySelector('input[name="name"]').value;
        const email = document.querySelector('input[name="email"]').value;
        const password = document.getElementById('password').value;
        const passwordConfirm = document.querySelector('input[name="password_confirmation"]').value;
        const userType = document.getElementById('user_type').value;

        if (!name || !email || !password || !passwordConfirm) {
            alert('Harap isi semua field yang diperlukan');
            return;
        }
        if (password !== passwordConfirm) {
            alert('Password dan konfirmasi password tidak cocok');
            return;
        }
        if (!userType) {
            alert('Harap pilih tipe akun (Siswa, Guru, atau Umum)');
            return;
        }

        // Show/hide role-specific fields
        document.getElementById('teacher-fields').style.display = userType === 'teacher' ? 'block' : 'none';
        document.getElementById('student-fields').style.display = userType === 'student' ? 'block' : 'none';
        document.getElementById('umum-fields').style.display = userType === 'umum' ? 'block' : 'none';

        goToStep(2);
    }

    function prevStep() {
        goToStep(1);
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
            passwordIcon.classList.remove('feather-eye');
            passwordIcon.classList.add('feather-eye-off');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('feather-eye-off');
            passwordIcon.classList.add('feather-eye');
        }
    }
  </script>
</body>

</html>
