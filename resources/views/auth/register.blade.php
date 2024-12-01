@extends('layouts.access')

@section('content')
<!-- Start Main -->
<main>

<!-- Start inner page Banner -->

<!-- End inner page Banner -->

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
         <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->
   </div>
   <!-- end container -->
</div>
<!-- end contact-section-layout-1 -->

<!-- start  Map Section -->

<!-- End  Map Section -->

</main>
<!-- End Main -->


@endsection
