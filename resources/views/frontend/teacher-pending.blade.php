@extends('frontend.layouts.app')

@section('navbar_class', 'navbar-solid')

@section('content')
    <section style="min-height: calc(100vh - 54px); display: flex; align-items: center; margin-top: 54px; padding: 32px 0; background: linear-gradient(135deg, #f6f8fc 0%, #eef3fb 100%);">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="text-center" style="background: #fff; border-radius: 16px; padding: 56px 48px; box-shadow: 0 18px 50px rgba(30, 53, 87, .12);">
              <div style="width: 76px; height: 76px; margin: 0 auto 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #eaf0ff; color: #3454d1; font-size: 34px;">
                <i class="ion-ios-clock-outline"></i>
              </div>
              @if($verificationStatus === 'rejected')
                <span style="display: inline-block; margin-bottom: 14px; padding: 7px 14px; border-radius: 20px; background: #feecec; color: #b42318; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;">Pendaftaran Ditolak</span>
                <h2 style="margin: 0 0 16px; color: #1d2b4f;">Pendaftaran pengajar belum dapat disetujui</h2>
                <p class="lead" style="max-width: 560px; margin: 0 auto 30px; color: #667085; line-height: 1.7;">Profil pengajar Anda tidak disetujui pada tahap verifikasi. Silakan hubungi admin jika Anda memerlukan informasi lebih lanjut.</p>
              @else
                <span style="display: inline-block; margin-bottom: 14px; padding: 7px 14px; border-radius: 20px; background: #fff4d8; color: #946200; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;">Menunggu Verifikasi</span>
                <h2 style="margin: 0 0 16px; color: #1d2b4f;">Pendaftaran pengajar sedang ditinjau</h2>
                <p class="lead" style="max-width: 560px; margin: 0 auto 30px; color: #667085; line-height: 1.7;">Terima kasih telah mendaftar sebagai pengajar. Admin akan memverifikasi profil dan kualifikasi Anda sebelum akses mengajar diaktifkan.</p>
                <div style="max-width: 470px; margin: 0 auto 32px; padding: 18px 22px; border-radius: 10px; background: #f7f9fc; color: #53627c; text-align: left;">
                  <i class="ion-ios-information-outline" style="color: #3454d1; margin-right: 8px;"></i>Anda akan dapat mengakses dashboard dan membuat kelas setelah akun disetujui.
                </div>
              @endif
              <a class="btn btn-dark" href="{{ url('/') }}">Kembali ke Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
