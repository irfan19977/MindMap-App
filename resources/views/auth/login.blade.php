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
                        <a href="{{ old('intended', session()->get('url.intended', '/')) }}">
                            <img src="{{ asset('backend/assets/images/logo-abbr.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">{{ __('messages.auth_login_title') }}</h2>
                        <h4 class="fs-13 fw-bold mb-2">{{ __('messages.auth_login_subtitle') }}</h4>
                        <p class="fs-12 fw-medium text-muted">{{ __('messages.auth_login_desc') }}</p>
                        
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="w-100 mt-4 pt-2">
                            @csrf
                            <input type="hidden" name="intended" value="{{ old('intended', session()->get('url.intended', url()->previous())) }}">
                            
                            <div class="mb-4">
                                <input type="email" class="form-control" name="email" placeholder="{{ __('messages.auth_email_username') }}" value="{{ old('email') }}" required autofocus autocomplete="username">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('messages.auth_password') }}" required autocomplete="current-password">
                                    <div class="input-group-text c-pointer" onclick="togglePassword()">
                                        <i id="passwordIcon" class="feather feather-eye"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label c-pointer" for="rememberMe">{{ __('messages.auth_remember_me') }}</label>
                                    </div>
                                </div>
                                <div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="fs-11 text-primary">{{ __('messages.auth_forget_password') }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-lg btn-primary w-100">{{ __('messages.auth_login_btn') }}</button>
                            </div>
                        </form>
                        <div class="w-100 mt-5 text-center mx-auto">
                            <div class="mb-4 border-bottom position-relative"><span class="small py-1 px-3 text-uppercase text-muted bg-white position-absolute translate-middle">{{ __('messages.auth_or') }}</span></div>
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
                        <div class="mt-5 text-muted">
                            <span>{{ __('messages.auth_no_account') }}</span>
                            <a href="{{ route('register') }}" class="fw-bold">{{ __('messages.auth_create_account') }}</a>
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
