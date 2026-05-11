@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="intro-body">
        <div class="overlay"></div>
        <div class="container text-left">
          <div class="row">
            <div class="col-md-2 col-lg-offset-3 text-center"><img class="logolanding" src="{{ asset('frontend/img/logo.png') }}" alt=""></div>
            <div class="col-md-6">
              <h1 class="no-pad bold">MindMap <span class="label classic">Pembelajaran</span><br>Inter<span class="light">aktif</span>
              </h1>
              <p class="lead">Platform pembelajaran modern dengan alur pembelajaran terstruktur dan materi interaktif untuk meningkatkan pemahaman konsep Anda</p><a class="page-scroll" href="#about"><span class="mouse"><span><i class="ion-ios-arrow-thin-down"></i></span></span></a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- Teaser-->
    <div class="container text-center box-shadow showcase"  id="about">
      <div class="row">
        <div class="col-lg-4">
          <h3><i class="ion-ios-analytics-outline icon-big"></i> Alur Pembelajaran</h3>
          <p class="no-pad">Sistem pembelajaran terstruktur dengan tahapan yang jelas untuk memudahkan pemahaman konsep secara bertahap</p>
        </div>
        <div class="col-lg-4 border">
          <h3><i class="ion-ionic icon-big fa-spin"></i>
            <!--i.ion-load-c.icon-big.text-gradient.fa-spin--> Materi Interaktif
          </h3>
          <p class="no-pad">Materi pembelajaran yang engaging dan interaktif dengan berbagai media untuk meningkatkan daya ingat dan pemahaman</p>
        </div>
        <div class="col-lg-4">
          <h3><i class="ion-ios-stopwatch-outline icon-big"></i> Tracking Progress</h3>
          <p class="no-pad">Pantau perkembangan pembelajaran Anda secara real-time dengan sistem pelacakan progress yang komprehensif</p>
        </div>
      </div>
    </div>
    <!-- About Section-->
    <section class="showcase section-small">
      <div class="container">
        <div class="row v-center">
          <div class="col-lg-6">
            <h2>Tentang MindMap</h2>
            <p>MindMap adalah platform pembelajaran inovatif yang dirancang untuk membantu Anda memahami konsep-konsep kompleks dengan cara yang lebih mudah dan menyenangkan. Dengan sistem alur pembelajaran yang terstruktur dan materi yang interaktif, kami berkomitmen untuk meningkatkan kualitas pembelajaran Anda.</p>
            <p>Platform kami menggabungkan teknologi modern dengan metode pembelajaran efektif untuk memberikan pengalaman belajar yang optimal dan personal.</p>
            <div class="classic">MindMap Team</div> <small>&mdash; Platform Pembelajaran Digital</small>
          </div>
          <div class="col-lg-6"><img class="wow slideInRight center-block" src="{{ asset('frontend/img/misc/7.png') }}" alt="" data-wow-duration="2s" animation-duration="2s"></div>
        </div>
      </div>
    </section>
    <!-- News-->
    <section class="bg-gray" id="blog">
      <div class="container">
        <h2 class="no-pad">Fitur Unggulan<a class="fa fa-plus-circle fa-fw gray" href="#features" title="Lihat Semua"></a></h2>
        <div class="row grid-pad">
          <div class="col-sm-4"><a href="#features"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/58.jpg') }}" alt="">
              <h4>Alur Pembelajaran Adaptif</h4></a>
            <p>Sistem pembelajaran yang menyesuaikan dengan kemampuan dan kecepatan belajar setiap pengguna untuk hasil yang optimal.</p><a class="btn btn-dark-border" href="#features">Pelajari Lebih</a>
          </div>
          <div class="col-sm-4"><a href="#features"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/59.jpg') }}" alt="">
              <h4>Materi Multimedia</h4></a>
            <p>Konten pembelajaran kaya dengan video, animasi, dan simulasi interaktif untuk pemahaman yang lebih mendalam.</p><a class="btn btn-dark-border" href="#features">Pelajari Lebih</a>
          </div>
          <div class="col-sm-4"><a href="#features"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/25.jpg') }}" alt="">
              <h4>Assessment Otomatis</h4></a>
            <p>Sistem evaluasi otomatis yang memberikan feedback langsung untuk membantu Anda meningkatkan pemahaman secara berkelanjutan.</p><a class="btn btn-dark-border" href="#features">Pelajari Lebih</a>
          </div>
        </div>
      </div>
    </section>
    <!-- Services Section-->
    <section class="text-center bg-img-custom bg-white" id="services" style="background-image: url('{{ asset('frontend/img/main/31.jpg') }}');">
      <div class="overlay-white"></div>
      <div class="container text-center">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <h2>Layanan Pembelajaran</h2>
            <p>Platform MindMap menyediakan berbagai layanan pembelajaran yang komprehensif untuk mendukung perkembangan akademik dan profesional Anda</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".2s">
            <h4><i class="ion-ios-pie-outline icon-big"></i> Analitik Pembelajaran</h4>
            <p>Analisis mendalam tentang progress pembelajaran dan identifikasi area yang perlu ditingkatkan.</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".3s">
            <h4><i class="ion-ios-basketball-outline icon-big"></i> Kurikulum Interaktif</h4>
            <p>Materi pembelajaran yang dirancang dengan pendekatan visual dan interaktif untuk pemahaman optimal.</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".4s">
            <h4><i class="ion-ios-monitor-outline icon-big"></i> Konsultasi Akademik</h4>
            <p>Dukungan dari tutor ahli untuk membantu mengatasi kesulitan dalam pembelajaran.</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".5s">
            <h4><i class="ion-ios-stopwatch-outline icon-big"></i> Sertifikasi</h4>
            <p>Sertifikat kompetensi yang dapat digunakan untuk meningkatkan nilai akademik dan profesional.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".6s">
            <h4><i class="ion-ios-analytics-outline icon-big"></i>Progress Tracking</h4>
            <p>Pemantauan perkembangan pembelajaran secara real-time dengan dashboard yang informatif.</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".7s">
            <h4><i class="ion-ios-medical-outline icon-big"></i>Quiz & Assessment</h4>
            <p>Berbagai jenis evaluasi untuk mengukur pemahaman dan penguasaan materi.</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".8s">
            <h4><i class="ion-ios-clock-outline icon-big"></i>Flexible Learning</h4>
            <p>Pembelajaran yang dapat diakses kapan saja dan di mana saja sesuai dengan kebutuhan Anda.</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".9s">
            <h4><i class="ion-ios-settings icon-big"></i>Personalisasi</h4>
            <p>Pengalaman belajar yang disesuaikan dengan gaya belajar dan kebutuhan individual.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Action video-->
    <div class="container text-center box-shadow offcet showcase">
      <div class="row v-center">
        <div class="col-lg-6 no-pad"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/3.jpg') }}" alt=""></div>
        <div class="col-lg-6"><a class="swipebox-video" href="https://vimeo.com/188716447" data-rel="video2"><i class="ion-ios-play-outline icon-big text-gradient-gray"></i></a>
          <h2>Tonton Cerita Kami</h2>
          <h5 class="no-pad">Youtube / Vimeo</h5>
        </div>
      </div>
    </div>
    <!-- Portfolio-->
    <section class="section-small no-pad-btm" id="portfolio">
      <div class="container">
        <h2 class="pull-left">Portfolio</h2>
        <div class="pull-right">
          <h5 class="no-pad">
            <ul class="list-inline"><span class="portfolio-sorting">
                <li><a class="active" href="{{ asset('frontend/portfolio-single.html') }}" data-group="all">Semua</a></li></span><span class="portfolio-sorting">
                <li><a href="{{ asset('frontend/portfolio-single.html') }}" data-group="photo">Foto</a></li></span><span class="portfolio-sorting">
                <li><a href="{{ asset('frontend/portfolio-single.html') }}" data-group="design">Desain</a></li></span><span class="portfolio-sorting">
                <li><a href="{{ asset('frontend/portfolio-single.html') }}" data-group="branding">Branding</a></li></span><span class="portfolio-sorting2">
                <li><a href="{{ asset('frontend/portfolio-masonry-4.html') }}" data-group="">Semua Portfolio</a></li></span></ul>
          </h5>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="container-fluid">
        <div class="row portfolio-items" id="grid">
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;branding&quot;, &quot;design&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/17.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;photo&quot;, &quot;branding&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/16.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/26.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;design&quot;, &quot;photo&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/29.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;branding&quot;, &quot;design&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/21.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;photo&quot;, &quot;design&quot;, &quot;branding&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/40.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
          <div class="col-md-3 col-sm-6 no-pad" data-groups="[&quot;photo&quot;]">
            <div class="portfolio-item"><a href="{{ asset('frontend/portfolio-single.html') }}"><img src="{{ asset('frontend/img/main/10.jpg') }}" alt="">
                <div class="portfolio-overlay">
                  <div class="caption">
                    <h5>Form Image Creative</h5><span>Lorem ipsum dolor sit amet</span>
                  </div>
                </div></a></div>
          </div>
        </div>
      </div>
    </section>
    <!-- Testimoni Section-->
    <section id="testimonials">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h2>Testimoni</h2>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/5.jpg') }}" alt=""></div>
          <div class="col-md-6">
            <h2 class="dark-gray">Platform pembelajaran terbaik untuk meningkatkan pemahaman konsep</h2>
            <p>MindMap telah membantu saya memahami materi yang sulit dengan cara yang visual dan interaktif. Alur pembelajaran yang terstruktur membuat proses belajar menjadi lebih efektif dan menyenangkan.</p>
            <div class="classic">Sarah Amanda</div> <small>&mdash; Mahasiswa</small>
          </div>
        </div>
        <div class="row grid-pad">
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/1.jpg') }}" alt="">
            <h4>Budi Santoso</h4>
            <p class="no-pad">Platform ini sangat membantu dalam memahami konsep-konsep kompleks. Materi interaktif dan tracking progress yang detail membuat pembelajaran lebih terukur.</p>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/2.jpg') }}" alt="">
            <h4>Maya Putri</h4>
            <p class="no-pad">Saya sangat puas dengan MindMap! Sistem pembelajaran adaptifnya membantu saya belajar sesuai dengan kecepatan saya sendiri.</p>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/3.jpg') }}" alt="">
            <h4>Rizki Ahmad</h4>
            <p class="no-pad">MindMap mengubah cara saya belajar. Materi multimedia dan assessment otomatisnya sangat membantu dalam persiapan ujian.</p>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/4.jpg') }}" alt="">
            <h4>Diana Wijaya</h4>
            <p class="no-pad">Platform pembelajaran yang luar biasa! Dukungan tutor ahli dan sistem sertifikatnya sangat membantu karir akademik saya.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Slider-->
    <section class="section-small section-offcet bg-gray">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <h2>Apa Yang Kami Lakukan</h2>
            <p>Kami menciptakan platform pembelajaran digital yang inovatif. Pengembangan alur pembelajaran, desain materi interaktif, manajemen konten, perencanaan strategis, dan pengujian usability untuk pengalaman belajar terbaik.</p>
            <div class="classic">Tim MindMap</div>
          </div>
          <div class="col-lg-7 carousel-item wow zoomIn" data-wow-duration="2s" data-wow-delay=".2s">
            <div class="carousel slide carousel-fade" id="carousel-light2">
              <ol class="carousel-indicators">
                <li class="active" data-target="#carousel-light2" data-slide-to="0"></li>
                <li data-target="#carousel-light2" data-slide-to="1"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                <div class="item active"><img class="center-block" src="{{ asset('frontend/img/misc/11.png') }}" alt=""></div>
                <div class="item"><img class="center-block" src="{{ asset('frontend/img/misc/10.png') }}" alt=""></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Tim Section-->
    <section id="team">
      <div class="container text-center">
        <h2>Tim Kami</h2>
        <div class="row">
          <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar3.jpg') }}" alt="">
            <h5>
              <ul class="list-inline">
                <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                <li><a href="/"><i class="fab fa-behance fa-2x"></i></a></li>
              </ul>Dr. Ahmad Rizki
              <div class="small">CEO & Founder</div>
            </h5>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar2.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-youtube fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-vimeo-v fa-2x"></i></a></li>
                  </ul>Siti Nurhaliza
                  <div class="small">Manager Operasional</div>
                </h5>
              </div>
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar1.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-instagram fa-2x"></i></a></li>
                  </ul>Budi Pratama
                  <div class="small">Lead Designer</div>
                </h5>
              </div>
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar4.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-github fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-pinterest fa-2x"></i></a></li>
                  </ul>Dewi Lestari
                  <div class="small">Content Developer</div>
                </h5>
              </div>
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar5.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-github fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-linkedin fa-2x"></i></a></li>
                  </ul>Fajar Hidayat
                  <div class="small">Business Development</div>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Quotes-->
    <section class="bg-gray showcase no-pad">
      <div class="container-fluid text-center no-pad">
        <div class="row v-center">
          <div class="col-lg-6 no-pad"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/5.jpg') }}" alt=""><a class="badge price">MORE INFO</a><a class="badge price new">CONCEPT</a></div>
          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-8 col-lg-offset-2"><i class="ion-ios-infinite-outline icon-big"></i>
                <h3>Pembelajaran Adalah Perjalanan Tanpa Akhir. Teruslah Bergerak Maju untuk Meraih Kesuksesan.</h3>
                <h4 class="classic">Tim MindMap</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Tabel Harga-->
    <section>
      <div class="container pricing text-center">
        <h2>Harga</h2>
        <div class="row">
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4>PELAJAR</h4>
              </div>
              <div class="panel-body">Paket dasar untuk pelajar dengan akses ke materi pembelajaran fundamental.</div>
              <ul class="list-group">
                <li class="list-group-item">50+ Materi Pembelajaran</li>
                <li class="list-group-item">Mobile Optimized</li>
                <li class="list-group-item">Akses dari mana saja</li>
                <li class="list-group-item"><span class="number"><sup>Rp</sup>99K</span><sub>/BULAN</sub></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default box-shadow">
              <div class="panel-heading">
                <h4>PROFESIONAL</h4>
              </div>
              <div class="panel-body">Paket lengkap untuk profesional dengan fitur premium dan dukungan tutor.</div>
              <ul class="list-group">
                <li class="list-group-item">Unlimited Materi Pembelajaran</li>
                <li class="list-group-item">Mobile Optimized <span class="label label-danger">PREMIUM</span>
                </li>
                <li class="list-group-item">Dukungan Tutor 24/7</li>
                <li class="list-group-item"><span class="number"><sup>Rp</sup>199K</span><sub>/BULAN</sub></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4>INSTITUSI</h4>
              </div>
              <div class="panel-body">Paket khusus untuk institusi pendidikan dengan fitur manajemen kelas dan laporan lengkap.</div>
              <ul class="list-group">
                <li class="list-group-item">Unlimited User & Kelas</li>
                <li class="list-group-item">Admin Dashboard</li>
                <li class="list-group-item">Laporan & Analytics</li>
                <li class="list-group-item"><span class="number"><sup>CUSTOM</sup></span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Facts section-->
    <section class="facts bg-img-custom-small" style="background-image: url('{{ asset('frontend/img/main/4.jpg') }}');">
      <div class="overlay"></div>
      <div class="container text-center">
        <div class="row">
          <div class="col-sm-3"><i class="ion-ios-stopwatch-outline icon-big"></i><span class="numscroller" data-min="0" data-max="78" data-delay="5" data-increment="1">0</span>Completed project</div>
          <div class="col-sm-3"><i class="ion-ios-gear-outline icon-big fa-spin"></i><span class="numscroller" data-min="0" data-max="29" data-delay="5" data-increment="1">0</span>Themes released</div>
          <div class="col-sm-3"><i class="ion-ios-body-outline icon-big"></i><span class="numscroller" data-min="0" data-max="2785" data-delay="5" data-increment="3">0</span>Happy Customers</div>
          <div class="col-sm-3"><i class="ion-ios-nutrition-outline icon-big"></i><span class="numscroller" data-min="0" data-max="12" data-delay="5" data-increment="1">0</span>Winning awards</div>
        </div>
      </div>
    </section>
    <!-- Action Section-->
    <section class="section-small bg-gray2">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h2 class="no-pad">Mulai Sekarang</h2>
          </div>
          <div class="col-md-4 col-md-offset-1">
            <p class="no-pad">MindMap adalah platform pembelajaran sempurna untuk kesuksesan akademik Anda! Saatnya meningkatkan pembelajaran Anda.</p>
          </div>
          <div class="col-md-2 col-md-offset-1"><a class="btn btn-lg btn-dark" href="/">Info Lebih Lanjut</a></div>
        </div>
      </div>
    </section>
    <!-- Contact Section-->
    <section class="section-small" id="contact">
      <!-- Map Section-->
      <div id="map"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-4 alert alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3><i class="fa fa-phone"></i> 1-800-CONCEPT
            </h3>
            <!-- Contact Form - Enter your email address on line 17 of the mail/contact_me.php file to make this form work. For more information on how to do this please visit the Docs!-->
            <form id="contactForm" name="sentMessage" novalidate="">
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="name">You Name</label>
                  <input class="form-control" id="name" type="text" placeholder="You Name" required="" data-validation-required-message="Please enter name"><span class="help-block text-danger"></span>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="email">You Email</label>
                  <input class="form-control" id="email" type="email" placeholder="You Email" required="" data-validation-required-message="Please enter email"><span class="help-block text-danger"></span>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="message">Message</label>
                  <textarea class="form-control" id="message" rows="2" placeholder="Message" required="" data-validation-required-message="Please enter a message." aria-invalid="false"></textarea><span class="help-block text-danger"></span>
                </div>
              </div>
              <div id="success"></div>
              <button class="btn btn-dark" type="submit">Send</button>
            </form>
          </div>
        </div>
      </div>
    
    </section>
@endsection