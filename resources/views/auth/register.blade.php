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
                            <div class="step-dot" id="dot-3"></div>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="w-100" id="registerForm">
                            @csrf

                            <!-- Step 1: Data Dasar -->
                            <div class="step active" id="step-1">
                                <h4 class="fs-13 fw-bold mb-2">Buat Akun Baru</h4>
                                <p class="fs-12 fw-medium text-muted mb-4">Isi data dasar Anda</p>

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
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                                            <div class="input-group-text c-pointer" onclick="togglePassword()">
                                                <i id="passwordIcon" class="feather feather-eye"></i>
                                            </div>
                                        </div>
                                        <div id="client-error-password" class="client-error text-danger small mt-1 d-none"></div>
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                                        <div id="client-error-password_confirmation" class="client-error text-danger small mt-1 d-none"></div>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <button type="button" class="btn btn-lg btn-primary w-100" onclick="nextStep()">Lanjutkan</button>
                                </div>
                            </div>

                            <!-- Step 2: Pilih Role -->
                            <div class="step" id="step-2">
                                <h4 class="fs-13 fw-bold mb-2">Pilih Tipe Akun</h4>
                                <p class="fs-12 fw-medium text-muted mb-4">Pilih role yang sesuai dengan Anda</p>

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

                                <div class="mt-4 d-flex gap-2">
                                    <button type="button" class="btn btn-lg btn-outline-secondary w-50" onclick="prevStep()">Kembali</button>
                                    <button type="button" class="btn btn-lg btn-primary w-50" onclick="nextStep()">Lanjutkan</button>
                                </div>
                            </div>

                            <!-- Step 3: Data Tambahan sesuai Role -->
                            <div class="step" id="step-3">
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
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Jurusan</label>
                                        <input type="text" class="form-control" name="major" placeholder="cth: IPA / IPS / Teknik Informatika" value="{{ old('major') }}">
                                        @error('major')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Kategori yang ingin dipelajari</label>
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
                                        @error('category_interests')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Umum Fields -->
                                <div id="umum-fields" style="display: none;">
                                    <h4 class="fs-13 fw-bold mb-2">Akun Umum</h4>
                                    <p class="fs-12 fw-medium text-muted mb-4">Lengkapi data profil Anda</p>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Pekerjaan</label>
                                        <input type="text" class="form-control" name="occupation" placeholder="cth: Mahasiswa, Karyawan, Freelancer" value="{{ old('occupation') }}">
                                        @error('occupation')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Kategori yang ingin dipelajari</label>
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
                                        @error('category_interests')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
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

                        <div class="mt-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <hr class="flex-grow-1 border-top border-muted opacity-25">
                                <span class="text-muted fs-12">ATAU</span>
                                <hr class="flex-grow-1 border-top border-muted opacity-25">
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ route('social.redirect', 'facebook') }}" class="btn btn-light-brand flex-fill" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Facebook">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                </a>
                                <a href="{{ route('social.redirect', 'google') }}" class="btn btn-light-brand flex-fill" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Google">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 7.474-3.037 7.474-7.181 0-.474-.054-.935-.155-1.368z"/></svg>
                                </a>
                                <a href="{{ route('social.redirect', 'github') }}" class="btn btn-light-brand flex-fill" data-bs-toggle="tooltip" data-bs-trigger="hover" title="GitHub">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div class="mt-4 text-muted text-center">
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
    const isSocialRegistration = {{ $socialRegistration ? 'true' : 'false' }};

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
        document.getElementById('umum-fields').style.display = userType === 'umum' ? 'block' : 'none';
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

    document.querySelectorAll('#step-1 input').forEach(input => {
        input.addEventListener('input', function() {
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
            if (!userType) {
                alert('Harap pilih tipe akun (Siswa, Guru, atau Umum)');
                return;
            }
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
