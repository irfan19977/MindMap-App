@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="overlay"></div>
      <div class="intro-body">
        <h1>Kelas Pembelajaran</h1>
        <h4>Pilih kategori materi yang ingin Anda pelajari</h4><a class="page-scroll" href="#kelas"><span class="mouse"><span><i class="icon ion-ios-arrow-down"></i></span></span></a>
      </div>
    </header>
    
    <!-- Kelas Block-->
    <section class="section-small" id="kelas">
      <div class="container">
        <div class="row grid-pad">
          <div class="col-md-8">
            <div class="row">
              <!-- Matematika -->
              <div class="col-sm-6">
                <a href="/kelas/matematika">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/0.jpg') }}" alt="Matematika">
                  <h5><i class="fa fa-calculator"></i> Matematika</h5>
                </a>
                <p>Pelajari konsep matematika dari dasar hingga lanjut dengan metode pembelajaran yang interaktif dan mudah dipahami.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/matematika">Lihat Kelas</a>
              </div>
              
              <!-- Fisika -->
              <div class="col-sm-6">
                <a href="/kelas/fisika">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/42.jpg') }}" alt="Fisika">
                  <h5><i class="fa fa-atom"></i> Fisika</h5>
                </a>
                <p>Jelajahi dunia fisika dengan simulasi interaktif dan eksperimen virtual untuk pemahaman konsep yang lebih mendalam.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/fisika">Lihat Kelas</a>
              </div>
              
              <!-- Kimia -->
              <div class="col-sm-6">
                <a href="/kelas/kimia">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/41.jpg') }}" alt="Kimia">
                  <h5><i class="fa fa-flask"></i> Kimia</h5>
                </a>
                <p>Pahami reaksi kimia dan struktur molekul dengan animasi 3D dan laboratorium virtual yang menarik.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/kimia">Lihat Kelas</a>
              </div>
              
              <!-- Biologi -->
              <div class="col-sm-6">
                <a href="/kelas/biologi">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/11.jpg') }}" alt="Biologi">
                  <h5><i class="fa fa-dna"></i> Biologi</h5>
                </a>
                <p>Eksplorasi kehidupan dari sel hingga ekosistem dengan materi visual dan studi kasus yang relevan.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/biologi">Lihat Kelas</a>
              </div>
              
              <!-- Programming -->
              <div class="col-sm-6">
                <a href="/kelas/programming">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/32.jpg') }}" alt="Programming">
                  <h5><i class="fa fa-code"></i> Programming</h5>
                </a>
                <p>Belajar coding dari dasar hingga mahir dengan project-based learning dan mentor dari industri.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/programming">Lihat Kelas</a>
              </div>
              
              <!-- Web Design -->
              <div class="col-sm-6">
                <a href="/kelas/web-design">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/38.jpg') }}" alt="Web Design">
                  <h5><i class="fa fa-palette"></i> Web Design</h5>
                </a>
                <p>Kuasai seni desain web modern dengan tools terkini dan portfolio project yang menarik.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/web-design">Lihat Kelas</a>
              </div>
              
              <!-- Digital Marketing -->
              <div class="col-sm-6">
                <a href="/kelas/digital-marketing">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/57.jpg') }}" alt="Digital Marketing">
                  <h5><i class="fa fa-bullhorn"></i> Digital Marketing</h5>
                </a>
                <p>Pelajari strategi pemasaran digital dengan case study nyata dan tools analytics terkini.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/digital-marketing">Lihat Kelas</a>
              </div>
              
              <!-- Data Science -->
              <div class="col-sm-6">
                <a href="/kelas/data-science">
                  <img class="img-responsive center-block" src="{{ asset('frontend/img/main/49.jpg') }}" alt="Data Science">
                  <h5><i class="fa fa-chart-bar"></i> Data Science</h5>
                </a>
                <p>Analisis data dan machine learning dengan project nyata dan dataset industri terkini.</p>
                <a class="btn btn-gray btn-xs" href="/kelas/data-science">Lihat Kelas</a>
              </div>
            </div>
          </div>
          
          <div class="col-md-3 col-md-offset-1">
            <form class="form-inline subscribe-form" action="#" method="post">
              <div class="input-group input-group-lg">
                <input class="form-control" type="search" name="search" placeholder="Cari kelas...">
                <span class="input-group-btn">
                  <button class="btn btn-dark" type="submit" name="search"><i class="fa fa-search fa-lg"></i></button>
                </span>
              </div>
            </form>
            
            <hr>
            <h4>Kategori Pembelajaran</h4>
            <ul class="list-unstyled">
              <li><a href="/kategori/akademik"><i class="fa fa-graduation-cap"></i> Akademik</a></li>
              <li><a href="/kategori/digital"><i class="fa fa-laptop"></i> Digital</a></li>
              <li><a href="/kategori/bisnis"><i class="fa fa-briefcase"></i> Bisnis</a></li>
              <li><a href="/kategori/bahasa"><i class="fa fa-language"></i> Bahasa</a></li>
              <li><a href="/kategori/seni"><i class="fa fa-paint-brush"></i> Seni & Desain</a></li>
              <li><a href="/kategori/keterampilan"><i class="fa fa-tools"></i> Keterampilan</a></li>
            </ul>
            
            <hr>
            <h4>Level Pembelajaran</h4>
            <ul class="list-unstyled">
              <li><a href="/level/pemula"><span class="label label-success">Pemula</span></a></li>
              <li><a href="/level/menengah"><span class="label label-warning">Menengah</span></a></li>
              <li><a href="/level/lanjutan"><span class="label label-danger">Lanjutan</span></a></li>
            </ul>
            
            <hr>
            <h4>Subscribe</h4>
            <p>Dapatkan informasi kelas terbaru dan penawaran khusus.</p>
            <form class="form-inline subscribe-form" id="mc-embedded-subscribe-form" action="#" method="post" name="mc-embedded-subscribe-form" target="_blank" novalidate="">
              <div class="input-group input-group-lg">
                <input class="form-control" id="mce-EMAIL" type="email" name="EMAIL" placeholder="Email address...">
                <span class="input-group-btn">
                  <button class="btn btn-dark" id="mc-embedded-subscribe" type="submit" name="subscribe">Subscribe</button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- Pagination-->
    <div class="section section-small bg-white">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <nav>
              <ul class="pagination">
                <li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">&middot;&middot;&middot;</a><a href="#">38</a></li>
                <li><a href="#" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <!-- Action Section-->
    <section class="section-small bg-gray2 action">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h2 class="no-pad">Siap Memulai?</h2>
          </div>
          <div class="col-md-4 col-md-offset-1">
            <p class="no-pad">Bergabunglah dengan ribuan siswa yang telah meningkatkan kemampuan mereka melalui platform MindMap.</p>
          </div>
          <div class="col-md-2 col-md-offset-1">
            <a class="btn btn-dark btn-lg" href="/register">Daftar Sekarang</a>
          </div>
        </div>
      </div>
    </section>
@endsection