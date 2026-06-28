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
                        <h2 class="fs-20 fw-bolder mb-4">Reset</h2>
                        <h4 class="fs-13 fw-bold mb-2">Reset to your username/password</h4>
                        <p class="fs-12 fw-medium text-muted">Enter your email and a reset link will sent to you, let's access our the best recommendation for you.</p>
                        
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="w-100 mt-4 pt-2">
                            @csrf
                            
                            <div class="mb-4">
                                <input type="email" class="form-control" name="email" placeholder="Email or Username" value="{{ old('email') }}" required autofocus autocomplete="email">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-lg btn-primary w-100">Reset Now</button>
                            </div>
                        </form>
                        <div class="mt-5 text-muted">
                            <span>Don't have an account?</span>
                            <a href="{{ route('register') }}" class="fw-bold">Create an Account</a>
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
</body>

</html>
