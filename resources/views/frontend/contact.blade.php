@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="overlay"></div>
      <div class="intro-body">
        <h1>Contact</h1>
        <h4>Hubungi kami untuk pertanyaan atau bantuan</h4><a class="page-scroll" href="#contact"><span class="mouse"><span><i class="icon ion-ios-arrow-down"></i></span></span></a>
      </div>
    </header>
     <!-- Contact Section-->
    <section class="section-small" id="contact">
    <!-- Map Section-->
      <div id="map"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-4 alert alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3><i class="fa fa-phone"></i> 085802733781 - Irfan
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