@extends('layouts.access')

@section('content')

<!-- Start Main -->
<main>



<!-- start contact-section-layout-1 -->
<div class="contact-section-layout-1 section-padding-2">
   <div class="container">
      <div class="row gutter-30 justify-content-between align-items-center">
         <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="300ms" data-wow-duration="800ms">
            <div class="contact-wrap-area-1">

               <div class="rt-section-heading-style-2">
                  <span class="sub-title">How may we help you</span>
                  <h2 class="heading-tilte">
                     Office Information
                  </h2>
                  <p>
                     Mhen an unknown printer took a galley of type and scrambled it to make a type
                     specimen book. It has survived not only five centuries, but also the leap into
                     remaining essentially unchanged.
                  </p>
               </div>

               <div class="contact-list-area-1 ">
                  <ul class="contact-list-style-1 clearfix">
                     <li class="list-item media">
                        <div class="list-icon">
                           <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="list-content">
                           <span>Theodore Lowe, Ap #867-859</span>
                           <span>Sit Rd, Azusa New York</span>
                        </div>
                     </li>
                     <li class="list-item media">
                        <div class="list-icon">

                           <i class="far fa-envelope"></i>
                        </div>
                        <div class="list-content">
                           <span>
                              <a href="mailto:infonouka@gmail.com">infonouka@gmail.com</a>
                           </span>
                        </div>
                     </li>
                     <li class="list-item media">
                        <div class="list-icon">
                           <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="list-content">
                           <span><a href="tel:+1238895600">+123 88 956 00</a></span>
                           <span><a href="tel:+1238895600">+123 88 956 00</a></span>
                        </div>
                     </li>
                     <li class="list-item media">
                        <div class="list-icon">
                           <i class="fas fa-globe-americas"></i>
                        </div>
                        <div class="list-content">
                           <span>
                              <a href="https://www.radiustheme.com/" rel="nofollow">www.radiustheme.com</a>
                           </span>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- end col -->

         <div class="col-xl-5 col-lg-6 wow fadeInUp" data-wow-delay="600ms" data-wow-duration="800ms">
            <form method="POST" action="{{ route('login') }}"  class="contact-form-style-1 rt-contact-form">
               
            @csrf
            
                <h4 class="form-title">Content de te revoir !</h4>
               
               <div class="form-group">
                  <input type="email" class="form-control rt-form-control" placeholder="E-mail *"
                     name="email" id="email" data-error="Email field is required" required>
                  <div class="help-block with-errors"></div>
               </div>
               
               <div class="form-group">
                  <input type="password" class="form-control rt-form-control" placeholder="Mot de passe *" name="password"
                     id="password" data-error="Valid pass is required" required>
                  <div class="help-block with-errors"></div>
               </div>

               
               <button type="submit" class="submit-btn">Se Connecter</button>
               <div class="form-response"></div>
            </form>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->
   </div>
   <!-- end container -->
</div>
<!-- end contact-section-layout-1 -->

<!-- start  Map Section -->
<div class="map-section-style-1">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="map-wrapper map-style-1">
               <iframe class="map"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8385385572983!2d144.95358331584498!3d-37.81725074201705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4dd5a05d97%3A0x3e64f855a564844d!2s121%20King%20St%2C%20Melbourne%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sbd!4v1623138767707!5m2!1sen!2sbd"
                  style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End  Map Section -->

</main>
<!-- End Main -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
