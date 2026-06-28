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
                        <h2 class="fs-20 fw-bolder mb-4">Verify Email</h2>
                        <h4 class="fs-13 fw-bold mb-2">Check Your Email</h4>
                        <p class="fs-12 fw-medium text-muted">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
                        
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                A new verification link has been sent to your email.
                            </div>
                        @endif

                        <div class="mt-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-lg btn-primary w-100 mb-3">Resend Verification Email</button>
                            </form>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-lg btn-secondary w-100">Log Out</button>
                            </form>
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
