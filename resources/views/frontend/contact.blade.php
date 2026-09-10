@extends('frontend.layouts.app')

@section('content')
        <section class="jarallax relative overflow-hidden z-1000 mt-80">
            <img src="{{ asset('frontend/images/slider/2.png') }}" class="jarallax-img" alt="">
            <div class="sw-overlay op-2"></div>
            <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
            <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
            <div class="container relative z-2">
                <div class="row wow fadeInRight">
                    <div class="col-lg-10">
                        <h1 class="fs-sm-10vw mb-0">
                            Hubungi Kami
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Beranda</a></li>
                            <li class="active">Hubungi Kami</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative">
            <div class="container">
              <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="subtitle">Tulis Pesan</div>
                    <h2 class="wow fadeInUp">Hubungi Kami</h2>

                    <p class="col-lg-8">Punya pertanyaan, saran, atau hanya ingin menyapa? Kami di sini dan senang mendengar dari Anda!</p>

                    <div class="spacer-single"></div>

                    <div class="row g-4">
                        <div class="col-md-12">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-map-marker-alt"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Alamat</h4>
                                Kec. Karang Ploso, Kabupaten Malang, Jawa Timur
                            </div>
                        </div>

                        <div class="col-md-12">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-envelope"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Email</h4>
                                mindmapeducation1997@gmail.com
                            </div>
                        </div>

                        <div class="col-md-12">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-instagram"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Instagram</h4>
                                @official_mindmapedu
                            </div>
                        </div>

                        <div class="col-md-12">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-clock"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Jam Operasional</h4>
                                24/7 - Akses Pembelajaran Kapan Saja
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="bg-color-op-1 rounded-1 p-40 relative">
                        <form name="contactForm" id="contact_form" method="post" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h5>Nama</h5>
                                <input type="text" name="name" id="name" class="bg-white form-control" placeholder="Nama Anda" required>
                            </div>

                            <div class="col-md-6">
                                <h5>Email</h5>
                                <input type="email" name="email" id="email" class="bg-white form-control" placeholder="Email Anda" required>
                            </div>

                            <div class="col-md-12">
                                <h5>Telepon</h5>
                                <input type="text" name="phone" id="phone" class="bg-white form-control" placeholder="Nomor Telepon Anda">
                            </div>

                            <div class="col-md-12">
                                <h5>Pesan</h5>
                                <textarea name="message" id="message" class="bg-white form-control h-100px" placeholder="Pesan Anda" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <div id='submit'>
                                    <input type='submit' id='send_message' value='Kirim Pesan' class="btn-main">
                                </div>

                                <div id="success_message" class='success'>
                                    Pesan Anda telah berhasil dikirim. Refresh halaman ini jika Anda ingin mengirim pesan lagi.
                                </div>
                                <div id="error_message" class='error'>
                                    Maaf, terjadi kesalahan saat mengirim formulir Anda.
                                </div>
                            </div>
                        </div>


                    </form>
                    </div>
                </div>
              </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for success message in session
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#7C815D',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-2',
                            confirmButton: 'btn-main'
                        }
                    });
                @endif

                // Check for error message in session
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#7C815D',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-2',
                            confirmButton: 'btn-main'
                        }
                    });
                @endif

                // Handle form submission with AJAX for better UX
                const contactForm = document.getElementById('contact_form');
                if (contactForm) {
                    contactForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(this);
                        const submitBtn = document.getElementById('send_message');
                        const originalText = submitBtn.value;
                        
                        // Show loading state
                        submitBtn.value = 'Sedang Mengirim...';
                        submitBtn.disabled = true;

                        fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message || 'Pesan berhasil dikirim.',
                                    confirmButtonColor: '#7C815D',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'rounded-2',
                                        confirmButton: 'btn-main'
                                    }
                                }).then(() => {
                                    contactForm.reset();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat mengirim pesan.',
                                    confirmButtonColor: '#7C815D',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'rounded-2',
                                        confirmButton: 'btn-main'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                                confirmButtonColor: '#7C815D',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'rounded-2',
                                    confirmButton: 'btn-main'
                                }
                            });
                        })
                        .finally(() => {
                            submitBtn.value = originalText;
                            submitBtn.disabled = false;
                        });
                    });
                }
            });
        </script>
@endsection