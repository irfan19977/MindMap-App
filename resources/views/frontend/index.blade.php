@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="intro-body">
        <div class="overlay"></div>
        <div class="container text-left">
          <div class="row">
            <div class="col-md-2 col-lg-offset-3 text-center"><img class="logolanding" src="{{ asset('frontend/img/logo.png') }}" alt=""></div>
            <div class="col-md-6">
              <h1 class="no-pad bold">{{ __('messages.hero_title') }}</h1>
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
        <div class="col-lg-6"><a class="swipebox-video" href="https://vimeo.com/188716447" data-rel="video2"><i class="ion-ios-play-outline icon-big text-gradient-gray"></i></a>
          <h2>{{ __('messages.watch_our_story') }}</h2>
          <h5 class="no-pad">{{ __('messages.video_platform') }}</h5>
        </div>
      </div>
    </div>
    <!-- Portfolio-->
    <section class="section-small no-pad-btm" id="portfolio">
      <div class="container">
        <h2 class="pull-left">{{ __('messages.portfolio_title') }}</h2>
        <div class="pull-right">
          <h5 class="no-pad">
            <ul class="list-inline"><span class="portfolio-sorting">
                <li><a class="active" href="{{ asset('frontend/portfolio-single.html') }}" data-group="all">{{ __('messages.portfolio_all') }}</a></li></span><span class="portfolio-sorting">
                <li><a href="{{ asset('frontend/portfolio-single.html') }}" data-group="photo">{{ __('messages.portfolio_photo') }}</a></li></span><span class="portfolio-sorting">
                <li><a href="{{ asset('frontend/portfolio-single.html') }}" data-group="design">{{ __('messages.portfolio_design') }}</a></li></span><span class="portfolio-sorting">
                <li><a href="{{ asset('frontend/portfolio-single.html') }}" data-group="branding">{{ __('messages.portfolio_branding') }}</a></li></span><span class="portfolio-sorting2">
                <li><a href="{{ asset('frontend/portfolio-masonry-4.html') }}" data-group="">{{ __('messages.portfolio_all_portfolio') }}</a></li></span></ul>
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
            <h2>{{ __('messages.testimonials_title') }}</h2>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/5.jpg') }}" alt=""></div>
          <div class="col-md-6">
            <h2 class="dark-gray">{{ __('messages.testimonial_main_title') }}</h2>
            <p>{{ __('messages.testimonial_main_desc') }}</p>
            <div class="classic">{{ __('messages.testimonial_main_name') }}</div> <small>&mdash; {{ __('messages.testimonial_main_role') }}</small>
          </div>
        </div>
        <div class="row grid-pad">
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/1.jpg') }}" alt="">
            <h4>{{ __('messages.testimonial_1_name') }}</h4>
            <p class="no-pad">{{ __('messages.testimonial_1_desc') }}</p>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/2.jpg') }}" alt="">
            <h4>{{ __('messages.testimonial_2_name') }}</h4>
            <p class="no-pad">{{ __('messages.testimonial_2_desc') }}</p>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/3.jpg') }}" alt="">
            <h4>{{ __('messages.testimonial_3_name') }}</h4>
            <p class="no-pad">{{ __('messages.testimonial_3_desc') }}</p>
          </div>
          <div class="col-md-3"><img class="center-block img-responsive" src="{{ asset('frontend/img/testimonials/4.jpg') }}" alt="">
            <h4>{{ __('messages.testimonial_4_name') }}</h4>
            <p class="no-pad">{{ __('messages.testimonial_4_desc') }}</p>
          </div>
        </div>
      </div>
    </section>
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
          <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar3.jpg') }}" alt="">
            <h5>
              <ul class="list-inline">
                <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                <li><a href="/"><i class="fab fa-behance fa-2x"></i></a></li>
              </ul>Dr. Ahmad Rizki
              <div class="small">{{ __('messages.team_ceo') }}</div>
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
                  <div class="small">{{ __('messages.team_ops_manager') }}</div>
                </h5>
              </div>
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar1.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-instagram fa-2x"></i></a></li>
                  </ul>Budi Pratama
                  <div class="small">{{ __('messages.team_lead_designer') }}</div>
                </h5>
              </div>
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar4.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-twitter fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-github fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-pinterest fa-2x"></i></a></li>
                  </ul>Dewi Lestari
                  <div class="small">{{ __('messages.team_content_dev') }}</div>
                </h5>
              </div>
              <div class="col-md-6 shadow"><img class="img-responsive center-block" src="{{ asset('frontend/img/team/avatar5.jpg') }}" alt="">
                <h5>
                  <ul class="list-inline">
                    <li><a href="/"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-github fa-2x"></i></a></li>
                    <li><a href="/"><i class="fab fa-linkedin fa-2x"></i></a></li>
                  </ul>Fajar Hidayat
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
    <!-- Tabel Harga-->
    <section>
      <div class="container pricing text-center">
        <h2>{{ __('messages.pricing_title') }}</h2>
        <div class="row">
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4>{{ __('messages.pricing_student') }}</h4>
              </div>
              <div class="panel-body">{{ __('messages.pricing_student_desc') }}</div>
              <ul class="list-group">
                <li class="list-group-item">{{ __('messages.pricing_student_1') }}</li>
                <li class="list-group-item">{{ __('messages.pricing_student_2') }}</li>
                <li class="list-group-item">{{ __('messages.pricing_student_3') }}</li>
                <li class="list-group-item"><span class="number"><sup>Rp</sup>{{ __('messages.pricing_student_price') }}</span><sub>{{ __('messages.pricing_month') }}</sub></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default box-shadow">
              <div class="panel-heading">
                <h4>{{ __('messages.pricing_professional') }}</h4>
              </div>
              <div class="panel-body">{{ __('messages.pricing_professional_desc') }}</div>
              <ul class="list-group">
                <li class="list-group-item">{{ __('messages.pricing_professional_1') }}</li>
                <li class="list-group-item">{{ __('messages.pricing_professional_2') }} <span class="label label-danger">{{ __('messages.pricing_premium') }}</span>
                </li>
                <li class="list-group-item">{{ __('messages.pricing_professional_3') }}</li>
                <li class="list-group-item"><span class="number"><sup>Rp</sup>{{ __('messages.pricing_professional_price') }}</span><sub>{{ __('messages.pricing_month') }}</sub></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4>{{ __('messages.pricing_institution') }}</h4>
              </div>
              <div class="panel-body">{{ __('messages.pricing_institution_desc') }}</div>
              <ul class="list-group">
                <li class="list-group-item">{{ __('messages.pricing_institution_1') }}</li>
                <li class="list-group-item">{{ __('messages.pricing_institution_2') }}</li>
                <li class="list-group-item">{{ __('messages.pricing_institution_3') }}</li>
                <li class="list-group-item"><span class="number"><sup>{{ __('messages.pricing_custom') }}</sup></span></li>
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
                  <input class="form-control" id="name" type="text" placeholder="{{ __('messages.contact_name') }}" required="" data-validation-required-message="Please enter name"><span class="help-block text-danger"></span>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="email">You Email</label>
                  <input class="form-control" id="email" type="email" placeholder="{{ __('messages.contact_email') }}" required="" data-validation-required-message="Please enter email"><span class="help-block text-danger"></span>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="message">Message</label>
                  <textarea class="form-control" id="message" rows="2" placeholder="{{ __('messages.contact_message') }}" required="" data-validation-required-message="Please enter a message." aria-invalid="false"></textarea><span class="help-block text-danger"></span>
                </div>
              </div>
              <div id="success"></div>
              <button class="btn btn-dark" type="submit">{{ __('messages.contact_send') }}</button>
            </form>
          </div>
        </div>
      </div>
    
    </section>
@endsection