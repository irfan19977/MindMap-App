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
              @forelse($categories as $category)
              <div class="col-sm-6">
                <a href="{{ route('kelas.show', $category->slug) }}">
                  <div style="position: relative; display: inline-block;">
                    @if($category->cover_image)
                      <img class="img-responsive center-block" src="{{ $category->cover_image_url }}" alt="{{ $category->name }}" style="max-width: 300px; height: 200px; object-fit: cover;">
                    @else
                      <img class="img-responsive center-block" src="{{ asset('frontend/img/main/0.jpg') }}" alt="{{ $category->name }}" style="max-width: 300px; height: 200px; object-fit: cover;">
                    @endif
                    @if($category->is_free)
                      <span class="label label-success" style="position: absolute; top: 10px; left: 10px; font-size: 12px; font-weight: bold;">
                        <i class="fa fa-gift"></i> GRATIS
                      </span>
                    @else
                      <span class="label label-warning" style="position: absolute; top: 10px; left: 10px; font-size: 12px; font-weight: bold;">
                        <i class="fa fa-money"></i> BERBAYAR
                      </span>
                    @endif
                  </div>
                  <h5>
                    @if($category->grade_level == 'sd')
                      <i class="fa fa-calculator text-primary"></i>
                    @elseif($category->grade_level == 'smp')
                      <i class="fa fa-atom text-success"></i>
                    @elseif($category->grade_level == 'sma')
                      <i class="fa fa-flask text-warning"></i>
                    @else
                      <i class="fa fa-code text-info"></i>
                    @endif
                    {{ $category->name }}
                  </h5>
                </a>
                <p>{{ Str::limit($category->description, 100) ?? 'Pelajari materi pembelajaran berkualitas dengan metode yang interaktif dan mudah dipahami.' }}</p>
                <a class="btn btn-gray btn-xs" href="{{ route('kelas.show', $category->slug) }}">Lihat Kelas</a>
              </div>
            @empty
              <div class="col-sm-12">
                <div class="alert alert-info text-center">
                  <i class="fa fa-info-circle fa-2x"></i>
                  <h4>Belum Ada Kelas</h4>
                  <p>Belum ada kategori kelas yang tersedia saat ini. Silakan kembali lagi nanti.</p>
                </div>
              </div>
            @endforelse
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
              @forelse($categories as $category)
                <li>
                  <a href="{{ route('kelas.show', $category->slug) }}">
                    @if($category->grade_level == 'sd')
                      <i class="fa fa-calculator text-primary"></i>
                    @elseif($category->grade_level == 'smp')
                      <i class="fa fa-atom text-success"></i>
                    @elseif($category->grade_level == 'sma')
                      <i class="fa fa-flask text-warning"></i>
                    @else
                      <i class="fa fa-code text-info"></i>
                    @endif
                    {{ $category->name }}
                  </a>
                </li>
              @empty
                <li><a href="javascript:void(0);"><i class="fa fa-info-circle"></i> Belum ada kategori</a></li>
              @endforelse
            </ul>
            
            <hr>
            <h4>Level Pembelajaran</h4>
            <ul class="list-unstyled">
              <li>
                <a href="javascript:void(0);" onclick="filterByLevel('sd')">
                  <span class="label label-success">SD</span>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" onclick="filterByLevel('smp')">
                  <span class="label label-warning">SMP</span>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" onclick="filterByLevel('sma')">
                  <span class="label label-danger">SMA</span>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" onclick="filterByLevel('umum')">
                  <span class="label label-info">UMUM</span>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" onclick="showAllCategories()">
                  <span class="label label-default">Semua Level</span>
                </a>
              </li>
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

<script>
function filterByLevel(level) {
    // Get all categories with their children from database
    const categories = @json($categories);
    console.log('Filtering by level:', level);
    console.log('Categories data:', categories);
    
    // Find sub-categories with specified level from all parents
    let allSubCategories = [];
    let parentGroups = {};
    
    categories.forEach(parent => {
        if (parent.children && parent.children.length > 0) {
            parent.children.forEach(child => {
                if (child.grade_level === level) {
                    // Group by parent
                    if (!parentGroups[parent.name]) {
                        parentGroups[parent.name] = {
                            name: parent.name,
                            slug: parent.slug,
                            icon: getIconForLevel(child.grade_level),
                            children: []
                        };
                    }
                    parentGroups[parent.name].children.push({
                        ...child,
                        parent_name: parent.name
                    });
                }
            });
        }
    });
    
    // Update the main content area
    const contentArea = document.querySelector('.col-md-8 .row');
    
    if (Object.keys(parentGroups).length === 0) {
        contentArea.innerHTML = `
            <div class="col-sm-12">
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle fa-2x"></i>
                    <h4>Tidak Ada Sub-Kategori</h4>
                    <p>Belum ada sub-kategori untuk level ${level.toUpperCase()} saat ini.</p>
                </div>
            </div>
        `;
    } else {
        let html = '';
        Object.values(parentGroups).forEach(parent => {
            // Parent category header
            html += `
                <div class="col-sm-12">
                    <div class="page-header">
                        <h3><i class="fa ${parent.icon}"></i> ${parent.name}</h3>
                        <hr>
                    </div>
                </div>
            `;
            
            // Add all children of this parent
            parent.children.forEach(child => {
                const imageUrl = child.cover_image ? `/storage/${child.cover_image}` : '/frontend/img/main/0.jpg';
                html += `
                    <div class="col-sm-6" style="margin-left: 20px;">
                        <a href="/kelas/${child.slug}">
                            <img class="img-responsive center-block" src="${imageUrl}" alt="${child.name}" style="max-width: 280px; height: 180px; object-fit: cover;">
                            <h5><i class="fa fa-chevron-right text-muted"></i> ${child.name}</h5>
                        </a>
                        <p>${child.description ? child.description.substring(0, 80) + '...' : 'Sub-kategori dari ' + child.parent_name}</p>
                        <a class="btn btn-gray btn-xs" href="/kelas/${child.slug}">Lihat Detail</a>
                    </div>
                `;
            });
        });
        contentArea.innerHTML = html;
    }
    
    // Scroll to top of content
    document.getElementById('kelas').scrollIntoView({ behavior: 'smooth' });
}

function getIconForLevel(level) {
    switch(level) {
        case 'sd': return 'fa-calculator text-primary';
        case 'smp': return 'fa-atom text-success';
        case 'sma': return 'fa-flask text-warning';
        case 'umum': return 'fa-code text-info';
        default: return 'fa-certificate text-default';
    }
}

function showAllCategories() {
    location.reload();
}
</script>
@endsection