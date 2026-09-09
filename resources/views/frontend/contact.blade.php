@extends('frontend.layouts.app')

@section('content')
        <section class="jarallax relative overflow-hidden z-1000 mt-80">
            <img src="{{ asset('frontend/images/background/1.webp') }}" class="jarallax-img" alt="">
            <div class="sw-overlay op-2"></div>
            <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
            <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
            <div class="container relative z-2">
                <div class="row wow fadeInRight">
                    <div class="col-lg-10">
                        <h1 class="fs-sm-10vw mb-0">
                            Contact Us
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Home</a></li>
                            <li class="active">Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative">
            <div class="container">
              <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="subtitle">Write a Message</div>
                    <h2 class="wow fadeInUp">Get In Touch</h2>

                    <p class="col-lg-8">Have a question, suggestion, or just want to say hi? We're here and happy to hear from you!</p>

                    <div class="spacer-single"></div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-map-marker-alt"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Address</h4>
                                Jl. Pendidikan No. 123, Jakarta
                            </div>
                        </div>

                        <div class="col-md-6">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-envelope"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Email</h4>
                                contact@mindmap.com
                            </div>
                        </div>

                        <div class="col-md-6">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-phone"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Phone</h4>
                                (021) 123-4567
                            </div>
                        </div>

                        <div class="col-md-6">
                            <i class="abs fs-28 p-3 bg-color text-light rounded-1 fa fa-instagram"></i>
                            <div class="ms-80px">
                                <h4 class="mb-0">Instagram</h4>
                                mindmap_learning
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
                                <h5>Name</h5>
                                <input type="text" name="name" id="name" class="bg-white form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6">
                                <h5>Email</h5>
                                <input type="email" name="email" id="email" class="bg-white form-control" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <h5>Phone</h5>
                                <input type="text" name="phone" id="phone" class="bg-white form-control" placeholder="Your Phone">
                            </div>

                            <div class="col-md-12">
                                <h5>Message</h5>
                                <textarea name="message" id="message" class="bg-white form-control h-100px" placeholder="Your Message" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <div id='submit'>
                                    <input type='submit' id='send_message' value='Send Message' class="btn-main">
                                </div>

                                <div id="success_message" class='success'>
                                    Your message has been sent successfully. Refresh this page if you want to send more messages.
                                </div>
                                <div id="error_message" class='error'>
                                    Sorry there was an error sending your form.
                                </div>
                            </div>
                        </div>


                    </form>
                    </div>
                </div>
              </div>
            </div>
        </section>
@endsection