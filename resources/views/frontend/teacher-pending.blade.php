@extends('frontend.layouts.app')



@section('content')
    <section style="min-height: calc(100vh - 54px); display: flex; align-items: center; margin-top: 54px; padding: 32px 0; background: linear-gradient(rgba(245, 245, 245, 0.85), rgba(245, 245, 245, 0.85)), url('{{ asset('frontend/images/slider/1.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="text-center" style="background: #fff; border-radius: 20px; padding: 56px 48px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);">
                        <div style="width: 76px; height: 76px; margin: 0 auto 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #eaf0ff; color: #3454d1; font-size: 34px;">
                            <i data-feather="clock" style="width: 40px; height: 40px;"></i>
                        </div>
                        @if($verificationStatus === 'rejected')
                            <span style="display: inline-block; margin-bottom: 14px; padding: 7px 14px; border-radius: 20px; background: #feecec; color: #b42318; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;">Pendaftaran Ditolak</span>
                            <h2 style="margin: 0 0 16px; color: #333; font-size: 28px; font-weight: 700;">Pendaftaran pengajar belum dapat disetujui</h2>
                            <p class="lead" style="max-width: 560px; margin: 0 auto 30px; color: #666; line-height: 1.7; font-size: 16px;">Profil pengajar Anda tidak disetujui pada tahap verifikasi. Silakan hubungi admin jika Anda memerlukan informasi lebih lanjut.</p>
                        @else
                            <span style="display: inline-block; margin-bottom: 14px; padding: 7px 14px; border-radius: 20px; background: #fff4d8; color: #946200; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;">Menunggu Verifikasi</span>
                            <h2 style="margin: 0 0 16px; color: #333; font-size: 28px; font-weight: 700;">Pendaftaran pengajar sedang ditinjau</h2>
                            <p class="lead" style="max-width: 560px; margin: 0 auto 30px; color: #666; line-height: 1.7; font-size: 16px;">Terima kasih telah mendaftar sebagai pengajar. Admin akan memverifikasi profil dan kualifikasi Anda sebelum akses mengajar diaktifkan.</p>
                            <div style="max-width: 470px; margin: 0 auto 32px; padding: 18px 22px; border-radius: 10px; background: #f7f9fc; color: #53627c; text-align: left; font-size: 14px;">
                                <i data-feather="info" style="color: #3454d1; margin-right: 8px; width: 18px; height: 18px; vertical-align: middle;"></i>Anda akan dapat mengakses dashboard dan membuat kelas setelah akun disetujui.
                            </div>
                        @endif
                        <a href="{{ url('/') }}" style="background: #8B9A46; border: none; border-radius: 10px; padding: 12px 30px; font-size: 16px; font-weight: 600; color: white; transition: all 0.2s; text-decoration: none; display: inline-block; cursor: pointer;">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
@endpush
