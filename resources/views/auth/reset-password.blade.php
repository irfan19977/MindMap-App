<!DOCTYPE html>
<html lang="zxx">

@include('backend.layouts.head')

<body>
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('backend/assets/images/logo-abbr.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Reset Password</h2>
                        <h4 class="fs-13 fw-bold mb-2">Set a new password</h4>
                        <p class="fs-12 fw-medium text-muted">Enter your new password below to reset your account password.</p>
                        <form method="POST" action="{{ route('password.store') }}" class="w-100 mt-4 pt-2">
                            @csrf
                            
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            
                            <div class="mb-4">
                                <input type="email" class="form-control" name="email" placeholder="Email address" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required autocomplete="new-password">
                                    <div class="input-group-text c-pointer" onclick="togglePassword('password')">
                                        <i id="passwordIcon" class="feather feather-eye"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password" required autocomplete="new-password">
                                    <div class="input-group-text c-pointer" onclick="togglePassword('password_confirmation')">
                                        <i id="password_confirmationIcon" class="feather feather-eye"></i>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-lg btn-primary w-100">Reset Password</button>
                            </div>
                        </form>
                        <div class="mt-5 text-muted">
                            <a href="{{ route('login') }}" class="fw-bold">Back to login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
  @include('backend.layouts.scriptcustom')
  <script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const passwordIcon = document.getElementById(fieldId + 'Icon');
        
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
