@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="overlay"></div>
      <div class="intro-body">
        <h1>{{ __('messages.contact_page_title') }}</h1>
        <h4>{{ __('messages.contact_page_subtitle') }}</h4><a class="page-scroll" href="#contact"><span class="mouse"><span><i class="icon ion-ios-arrow-down"></i></span></span></a>
      </div>
    </header>
     <!-- Contact Section-->
    <section class="section-small" id="contact">
    <!-- Map Section-->
      <div class="map-responsive">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.030260978886!2d112.58391187500612!3d-7.891902892130814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7881b06537d8cf%3A0xe4616380276b51a3!2sMa%E2%80%99had%20Tahfizhul%20Qur%E2%80%99an%20Al-Firqoh%20An-Najiyah!5e0!3m2!1sid!2sid!4v1783683722695!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-4 alert alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3><i class="fa fa-phone"></i> {{ __('messages.contact_phone_number') }}
            </h3>
            <form id="contactForm" name="sentMessage" novalidate="">
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="name">{{ __('messages.contact_name') }}</label>
                  <input class="form-control" id="name" type="text" placeholder="{{ __('messages.contact_name') }}" required="" data-validation-required-message="Please enter name"><span class="help-block text-danger"></span>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="email">{{ __('messages.contact_email') }}</label>
                  <input class="form-control" id="email" type="email" placeholder="{{ __('messages.contact_email') }}" required="" data-validation-required-message="Please enter email"><span class="help-block text-danger"></span>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                  <label class="sr-only control-label" for="message">{{ __('messages.contact_message') }}</label>
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