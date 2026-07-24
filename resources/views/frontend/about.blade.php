@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="img/main/11.jpg">
      <div class="overlay"></div>
      <div class="intro-body">
        <h1>{{ __('messages.about_page_title') }}</h1>
        <h4>{{ __('messages.about_page_subtitle') }}</h4><a class="page-scroll" href="#about"><span class="mouse"><span><i class="icon ion-ios-arrow-down"></i></span></span></a>
      </div>
    </header>
    <!-- Slider-->
    <section class="section-small section-offcet bg-gray" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <h2>{{ __('messages.about_what_we_do') }}</h2>
            <p>{{ __('messages.about_what_we_do_desc') }}</p>
            <div class="classic">{{ __('messages.about_page_team') }}</div>
          </div>
          <div class="col-lg-7 carousel-item wow zoomIn" data-wow-duration="2s" data-wow-delay=".2s">
            <div class="carousel slide carousel-fade" id="carousel-light2">
              <ol class="carousel-indicators">
                <li class="active" data-target="#carousel-light2" data-slide-to="0"></li>
                <li data-target="#carousel-light2" data-slide-to="1"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                <div class="item active"><img class="center-block" src="img/misc/11.png" alt=""></div>
                <div class="item"><img class="center-block" src="img/misc/10.png" alt=""></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Facts section-->
    <section class="facts bg-img-custom-small" style="background-image: url('img/main/4.jpg');">
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
@endsection