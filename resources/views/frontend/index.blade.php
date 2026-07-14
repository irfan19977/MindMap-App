@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="intro-body">
        <div class="overlay"></div>
        <div class="container text-left">
          <div class="row">
            <div class="col-md-2 col-lg-offset-3 text-center"><img class="logolanding" src="{{ asset('frontend/img/logo.png') }}" alt=""></div>
            <div class="col-md-6">
              <h1 class="no-pad bold">{!! __('messages.hero_title') !!}</h1>
              <p class="lead">{{ __('messages.hero_subtitle') }}</p><a class="page-scroll" href="#about"><span class="mouse"><span><i class="ion-ios-arrow-thin-down"></i></span></span></a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- Teaser-->
    <div class="container text-center box-shadow showcase"  id="about">
      <div class="row">
        <div class="col-lg-4">
          <h3><i class="ion-ios-analytics-outline icon-big"></i> {{ __('messages.teaser_1_title') }}</h3>
          <p class="no-pad">{{ __('messages.teaser_1_desc') }}</p>
        </div>
        <div class="col-lg-4 border">
          <h3><i class="ion-ionic icon-big fa-spin"></i>
            <!--i.ion-load-c.icon-big.text-gradient.fa-spin--> {{ __('messages.teaser_2_title') }}
          </h3>
          <p class="no-pad">{{ __('messages.teaser_2_desc') }}</p>
        </div>
        <div class="col-lg-4">
          <h3><i class="ion-ios-stopwatch-outline icon-big"></i> {{ __('messages.teaser_3_title') }}</h3>
          <p class="no-pad">{{ __('messages.teaser_3_desc') }}</p>
        </div>
      </div>
    </div>
    <!-- About Section-->
    <section class="showcase section-small">
      <div class="container">
        <div class="row v-center">
          <div class="col-lg-6">
            <h2>{{ __('messages.about_title') }}</h2>
            <p>{{ __('messages.about_desc_1') }}</p>
            <p>{{ __('messages.about_desc_2') }}</p>
            <div class="classic">{{ __('messages.about_team') }}</div> <small>&mdash; {{ __('messages.about_subtitle') }}</small>
          </div>
          <div class="col-lg-6"><img class="wow slideInRight center-block" src="{{ asset('frontend/img/misc/7.png') }}" alt="" data-wow-duration="2s" animation-duration="2s"></div>
        </div>
      </div>
    </section>
    <!-- News-->
    <section class="bg-gray" id="blog">
      <div class="container">
        <h2 class="no-pad">{{ __('messages.features_title') }}<a class="fa fa-plus-circle fa-fw gray" href="#features" title="Lihat Semua"></a></h2>
        <div class="row grid-pad">
          <div class="col-sm-4"><a href="#features"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/58.jpg') }}" alt="">
              <h4>{{ __('messages.feature_1_title') }}</h4></a>
            <p>{{ __('messages.feature_1_desc') }}</p><a class="btn btn-dark-border" href="#features">{{ __('messages.learn_more') }}</a>
          </div>
          <div class="col-sm-4"><a href="#features"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/59.jpg') }}" alt="">
              <h4>{{ __('messages.feature_2_title') }}</h4></a>
            <p>{{ __('messages.feature_2_desc') }}</p><a class="btn btn-dark-border" href="#features">{{ __('messages.learn_more') }}</a>
          </div>
          <div class="col-sm-4"><a href="#features"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/25.jpg') }}" alt="">
              <h4>{{ __('messages.feature_3_title') }}</h4></a>
            <p>{{ __('messages.feature_3_desc') }}</p><a class="btn btn-dark-border" href="#features">{{ __('messages.learn_more') }}</a>
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
            <h2>{{ __('messages.services_title') }}</h2>
            <p>{{ __('messages.services_desc') }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".2s">
            <h4><i class="ion-ios-pie-outline icon-big"></i> {{ __('messages.service_1_title') }}</h4>
            <p>{{ __('messages.service_1_desc') }}</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".3s">
            <h4><i class="ion-ios-basketball-outline icon-big"></i> {{ __('messages.service_2_title') }}</h4>
            <p>{{ __('messages.service_2_desc') }}</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".4s">
            <h4><i class="ion-ios-monitor-outline icon-big"></i> {{ __('messages.service_3_title') }}</h4>
            <p>{{ __('messages.service_3_desc') }}</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".5s">
            <h4><i class="ion-ios-stopwatch-outline icon-big"></i> {{ __('messages.service_4_title') }}</h4>
            <p>{{ __('messages.service_4_desc') }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".6s">
            <h4><i class="ion-ios-analytics-outline icon-big"></i>{{ __('messages.service_5_title') }}</h4>
            <p>{{ __('messages.service_5_desc') }}</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".7s">
            <h4><i class="ion-ios-medical-outline icon-big"></i>{{ __('messages.service_6_title') }}</h4>
            <p>{{ __('messages.service_6_desc') }}</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".8s">
            <h4><i class="ion-ios-clock-outline icon-big"></i>{{ __('messages.service_7_title') }}</h4>
            <p>{{ __('messages.service_7_desc') }}</p>
          </div>
          <div class="col-lg-3 col-sm-6 wow fadeIn" data-wow-delay=".9s">
            <h4><i class="ion-ios-settings icon-big"></i>{{ __('messages.service_8_title') }}</h4>
            <p>{{ __('messages.service_8_desc') }}</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Action video-->
    <div class="container text-center box-shadow offcet showcase">
      <div class="row v-center">
        <div class="col-lg-6 no-pad"><img class="img-responsive center-block" src="{{ asset('frontend/img/main/3.jpg') }}" alt=""></div>
        <div class="col-lg-6"><a class="swipebox-video" href="" data-rel="video2"><i class="ion-ios-play-outline icon-big text-gradient-gray"></i></a>
          <h2>{{ __('messages.watch_our_story') }}</h2>
          <h5 class="no-pad">{{ __('messages.video_platform') }}</h5>
        </div>
      </div>
    </div>
    <!-- Slider-->
    <section class="section-small section-offcet bg-gray">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <h2>{{ __('messages.what_we_do_title') }}</h2>
            <p>{{ __('messages.what_we_do_desc') }}</p>
            <div class="classic">{{ __('messages.mindmap_team') }}</div>
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
        <h2>{{ __('messages.team_title') }}</h2>
        <div class="row">
          <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/irfan.jpeg') }}" alt="">
            <h5>
              <ul class="list-inline">
                <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                <li><a href="https://github.com/irfan19977" target="_blank"><i class="fab fa-github fa-2x"></i></a></li>
              </ul>Irfan Adi Prastyo
              <div class="small">{{ __('messages.team_ceo') }}</div>
            </h5>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-sm-6 shadow" style="padding:5px;"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/bili.jpeg') }}" alt="" style="width:100%;height:350px;object-fit:cover;object-position:top;">
                <h5 style="font-size:13px;">
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="/"><i class="fab fa-youtube"></i></a></li>
                    <li><a href="https://github.com/BielCre4tive" target="_blank"><i class="fab fa-github"></i></a></li>
                  </ul>Muhammad Fadhli Robbi Elhami
                  <div class="small">{{ __('messages.team_ops_manager') }}</div>
                </h5>
              </div>
              <div class="col-sm-6 shadow" style="padding:5px;"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/bisma.jpeg') }}" alt="" style="width:100%;height:350px;object-fit:cover;object-position:top;">
                <h5 style="font-size:13px;">
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="/"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://github.com/ajaajasada03-cmyk" target="_blank"><i class="fab fa-github"></i></a></li>
                  </ul>Faishal Danurweda Bisma
                  <div class="small">{{ __('messages.team_lead_designer') }}</div>
                </h5>
              </div>
              <div class="col-sm-6 shadow" style="padding:5px;"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/arkan.jpeg') }}" alt="" style="width:100%;height:350px;object-fit:cover;object-position:top;">
                <h5 style="font-size:13px;">
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://github.com/thooreqkerjo-star" target="_blank"><i class="fab fa-github"></i></a></li>
                    <li><a href="/"><i class="fab fa-pinterest"></i></a></li>
                  </ul>Arkan Thaariq Asadullah
                  <div class="small">{{ __('messages.team_content_dev') }}</div>
                </h5>
              </div>
              <div class="col-sm-6 shadow" style="padding:5px;"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/mishaal.jpeg') }}" alt="" style="width:100%;height:350px;object-fit:cover;object-position:top;">
                <h5 style="font-size:13px;">
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://github.com/muhammadmishaal2204-del" target="_blank"><i class="fab fa-github"></i></a></li>
                    <li><a href="/"><i class="fab fa-linkedin"></i></a></li>
                  </ul>Muhammad Mishaal
                  <div class="small">{{ __('messages.team_biz_dev') }}</div>
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
                <h3>{{ __('messages.quote_text') }}</h3>
                <h4 class="classic">{{ __('messages.mindmap_team') }}</h4>
              </div>
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
          <div class="col-sm-3"><i class="ion-ios-stopwatch-outline icon-big"></i><span class="numscroller" data-min="0" data-max="78" data-delay="5" data-increment="1">0</span>{{ __('messages.facts_completed') }}</div>
          <div class="col-sm-3"><i class="ion-ios-gear-outline icon-big fa-spin"></i><span class="numscroller" data-min="0" data-max="29" data-delay="5" data-increment="1">0</span>{{ __('messages.facts_themes') }}</div>
          <div class="col-sm-3"><i class="ion-ios-body-outline icon-big"></i><span class="numscroller" data-min="0" data-max="2785" data-delay="5" data-increment="3">0</span>{{ __('messages.facts_customers') }}</div>
          <div class="col-sm-3"><i class="ion-ios-nutrition-outline icon-big"></i><span class="numscroller" data-min="0" data-max="12" data-delay="5" data-increment="1">0</span>{{ __('messages.facts_awards') }}</div>
        </div>
      </div>
    </section>
    <!-- Action Section-->
    <section class="section-small bg-gray2">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h2 class="no-pad">{{ __('messages.cta_title') }}</h2>
          </div>
          <div class="col-md-4 col-md-offset-1">
            <p class="no-pad">{{ __('messages.cta_desc') }}</p>
          </div>
          <div class="col-md-2 col-md-offset-1"><a class="btn btn-lg btn-dark" href="/">{{ __('messages.cta_button') }}</a></div>
        </div>
      </div>
    </section>
@endsection