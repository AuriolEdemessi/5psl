<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from radiustheme.com/demo/html/neeon/index7.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Dec 2022 11:46:49 GMT -->
<head>
   <!-- Meta Data -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title> 5psl | Dashboard </title>

   <!-- Favicon -->
   <link rel="shortcut icon" type="image/x-icon" href="media/favicon.png">

   <!-- Dependency Stylesheet -->
   <link rel="stylesheet" type="text/css" href="dependencies/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="dependencies/fontawesome/css/all.min.css">
   <link rel="stylesheet" type="text/css" href="dependencies/animate/animate.min.css">
   <link rel="stylesheet" type="text/css" href="dependencies/swiper/css/swiper.min.css">
   <link rel="stylesheet" type="text/css" href="dependencies/magnific-popup/css/magnific-popup.css">

   <!-- Site Stylesheet -->
   <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>

   <!-- Start wrapper -->
   <div id="wrapper" class="wrapper">

      <!-- start perloader -->
      <div class="pre-loader" id="preloader">
         <div class="loader"></div>
      </div>
      <!-- end perloader -->

      <!-- Start main-content -->
      <div id="main_content" class="footer-fixed">

         <!-- Header style-7 -->
         <header class="rt-header rt-header-style-7 sticky-on">

            <!-- sticky-placeholder -->
            <div id="sticky-placeholder"></div>

            <!-- start  topbar -->
            <div class="topbar topbar-style-1" id="topbar-wrap">
               <div class="container">
                  <div class="row align-items-center">

                     <div class="col-lg-7">
                        <div class="rt-trending rt-trending-style-1">
                           <p class="trending-title">
                              <i class="fas fa-bolt icon"></i>
                              Trending
                           </p>
                           <div class="rt-treding-slider1 swiper-container">
                              <div class="swiper-wrapper">
                                 <div class="swiper-slide">
                                    <div class="item">
                                       <p class="trending-slide-title">
                                          newsan unknown printer took a galley of
                                          type andscrambled.
                                       </p>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="item">
                                       <p class="trending-slide-title">
                                          newsan unknown printer took a galley of
                                          type andscrambled.
                                       </p>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="item">
                                       <p class="trending-slide-title">
                                          newsan unknown printer took a galley of
                                          type andscrambled.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end col -->

                     <div class="col-lg-5">
                        <div class="rt-topbar-right">
                           <div class="meta-wrap">
                              <span class="rt-meta">
                                 <i class="far fa-calendar-alt icon"></i>
                                 <span class="currentDate">
                                    DECEMBER 9, 2022
                                 </span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <!-- end col -->

                  </div>
                  <!-- end row -->
               </div>
               <!-- end container -->
            </div>
            <!-- end topbar -->

            <!-- Header Main -->
            <div class="header-main header-main-style-7 navbar-wrap" id="navbar-wrap">
               <div class="container">
                  <div class="header-main-inner d-flex align-items-center justify-content-between">

                     <div class="logo-wrapper">
                        <div class="humburger-area">
                           <div class="item humburger offcanvas-menu-btn menu-status-open">
                              <span></span>
                           </div>
                        </div>
                        <div class="logo-area">
                           <a href="index-2.html">
                              <img width="162" height="52" src="media/logo/logoweb.svg" alt="neeon">
                           </a>
                        </div>

                     </div>
                     <!-- end logo-wrapper -->

                     <div class="menu-wrapper">
                        <div class="main-menu">
                           <nav class="main-menu__nav">
                              <ul>
                                 <li class="main-menu active">
                                    <a class="animation" href="/">Accueil</a>
                                    
                                 </li>
                                 <li class="main-menu__nav_sub list">
                                    <a class="animation" href="javascript:void(0)">Formations</a>
                                    <ul class="main-menu__dropdown">
                                       <li class="main-menu__nav_sub">
                                          <a href="javascript:void(0)">
                                             Initiation au Trading
                                          </a>
                                          <ul>
                                             <li><a href="single-post1.html">Analyse Fondamentale</a></li>
                                             <li><a href="single-post2.html">Analyse Technique</a></li>
                                             <li><a href="single-post3.html">Gestion des risques</a></li>
                                          </ul>
                                       </li>
                                       <li><a href="author.html">Approfondir le Trading</a></li>
                                       <li><a href="author.html">Blockchain & Cryptomonnaies</a></li>
                                    </ul>
                                 </li>
                                 <li class="main-menu active">
                                    <a class="animation" href="/">Actualités</a>
                                    
                                 </li>
                                 <li class="main-menu__nav_sub list">
                                    <a class="animation" href="javascript:void(0)">Offres </a>
                                    <ul class="main-menu__dropdown">
                                       <li><a href="life-style.html">Traders Hub</a></li>
                                       <li><a href="technology.html">Traders Programs</a></li>
                                       <li><a href="gaming.html">Investment Club</a></li>
                                       <li><a href="graphics.html">Social Trading</a></li>
                                    </ul>
                                 </li>
                                 
                                 <li class="main-menu__nav_sub list">
                                    <a class="animation" href="javascript:void(0)">Recommandations</a>
                                    <ul class="main-menu__dropdown">
                                       <li><a href="shop.html">Brokers</a></li>
                                       <li><a href="single-shop.html">Portefeuilles</a></li>
                                    </ul>
                                 </li>

                                 @if(auth()->check() && auth()->user()->role === 'admin')
                                 <a href="/admin">Admin Dashboard</a>
                             @endif
                             
                              </ul>
                           </nav>
                        </div>
                     </div>
                     <!-- end menu-wrapper -->

                     <div class="search-wrapper search-wrapper-style-1">
                        <form action="#" class="form search-form-box">
                           <div class="form-group">
                              <input type="text" name="sarch" id="search" placeholder="Search . . . "
                                 class="form-control rt-search-control">
                              <button type="submit" class="search-submit">
                                 <i class="fas fa-search"></i>
                              </button>
                           </div>
                        </form>
                     </div>
                     <!-- end search-wrapper -->
                  </div>
                  <!-- end row -->
               </div>
               <!-- end container -->
            </div>
            <!-- End Header Main -->

         </header>
         <!-- end header style-7 -->

         <!-- start rt-mobile-header -->
         <div class="rt-mobile-header mobile-sticky-on">

            <div id="mobile-sticky-placeholder"></div>
            <!-- end mobile-sticky-placeholder -->

            <div class="mobile-top-bar" id="mobile-top-bar">
               <ul class="mobile-top-list">
                  <li>
                     <span class="rt-meta">
                        <i class="far fa-calendar-alt icon"></i>
                        <span class="currentDate">DECEMBER 9, 2022</span>
                     </span>
                  </li>
                  <li>
                     <span class="rt-meta">
                        <i class="fas fa-map-marker-alt icon"></i>
                        Chicago 12, Melborne City, USA
                     </span>
                  </li>
               </ul>
            </div>
            <!-- end mobile-top-bar -->

            <div class="mobile-menu-bar-wrap" id="mobile-menu-bar-wrap">
               <div class="mobile-menu-bar">
                  <div class="logo">
                     <a href="/">
                        <img src="media/logo/logovertical.svg" alt="neeon" width="80" height="20">
                     </a>
                  </div>
                  <span class="sidebarBtn">
                     <span class="bar"></span>
                     <span class="bar"></span>
                     <span class="bar"></span>
                     <span class="bar"></span>
                  </span>
               </div>
               <div class="rt-slide-nav">
                  <div class="offscreen-navigation">
                     <nav class="menu-main-primary-container">
                        <ul class="menu">
                           <li class="list menu-item">
                              <a class="animation" href="/">Home</a>
                              
                           </li>
                           <li class="list menu-item-has-children">
                              <a class="animation" href="javascript:void(0)">Formations</a>
                                    
                              <ul class="main-menu__dropdown sub-menu">
                                 <li class="list menu-item-has-children">
                                    <a href="javascript:void(0)">
                                       Initiation au trading
                                    </a>
                                    <ul class="main-menu__dropdown sub-menu">
                                       <li><a href="single-post1.html">Analyse Fondamentale</a></li>
                                       <li><a href="single-post2.html">Analyse Technique</a></li>
                                       <li><a href="single-post3.html">Gestion des risques</a></li>
                                    </ul>
                                 </li>
                                 <li><a href="author.html">Approfondir le Trading</a></li>
                                       <li><a href="author.html">Blockchain & Cryptomonnaies</a></li>
                              </ul>

                           </li>
                           <li class="list menu-item">
                              <a class="animation" href="/">Actualités</a>
                              
                           </li>
                           <li class="list menu-item-has-children">
                              <a class="animation" href="javascript:void(0)">Offres</a>
                              <ul class="main-menu__dropdown sub-menu">
                                 <li><a href="life-style.html">Traders Hub</a></li>
                                       <li><a href="technology.html">Traders Programs</a></li>
                                       <li><a href="gaming.html">Investment Club</a></li>
                                       <li><a href="graphics.html">Social Trading</a></li>
                              </ul>
                           </li>
                           <li class="list menu-item-has-children">
                              <a class="animation" href="javascript:void(0)">Recommandations</a>
                              <ul class="main-menu__dropdown sub-menu">
                                <li><a href="shop.html">Brokers</a></li>
                                       <li><a href="single-shop.html">Portefeuilles</a></li>

                              </ul>
                           </li>
                           
                        </ul>
                     </nav>
                  </div>
               </div>
            </div>



         </div>
         <!-- end rt-mobile-header -->

         <!-- Start Main -->
         @yield('content')
         <!-- End Main -->

         <!-- Start Footer -->
         <footer class="footer footer-style-4 layout-2">

            <div class="container">
               <div
                  class="footer-widget-style-2 d-flex align-items-center justify-content-center text-center flex-column">

                  <div class="logo wow fadeInDown" data-wow-delay="200ms" data-wow-duration="800ms">
                     <a href="index-2.html">
                        <img src="media/logo/logo-classic.png" alt="logo-classic" width="170" height="50">
                     </a>
                  </div>

                  <ul class="footer-menu-style-2 wow fadeInUp" data-wow-delay="300ms" data-wow-duration="800ms">
                     <li>
                        <a href="index-2.html">Home</a>
                     </li>
                     <li>
                        <a href="about.html">About</a>
                     </li>
                     <li>
                        <a href="technology.html">Categories</a>
                     </li>
                     <li>
                        <a href="about.html">Privacy</a>
                     </li>
                     <li>
                        <a href="about.html">Terms</a>
                     </li>
                     <li>
                        <a href="contact.html">Contact</a>
                     </li>
                  </ul>

                  <div class="social-wrapper-line-style">
                     <span class="wrapper-line wow zoomIn" data-wow-delay="400ms" data-wow-duration="800ms"></span>
                     <ul class="footer-social mb-0 wow fadeInUp" data-wow-delay="600ms" data-wow-duration="800ms">
                        <li class="social-item">
                           <a href="https://www.facebook.com/" class="social-link fb" target="_blank">
                              <i class="fab fa-facebook-f"></i>
                           </a>
                        </li>
                        <li class="social-item">
                           <a href="https://twitter.com/" class="social-link tw" target="_blank">
                              <i class="fab fa-twitter"></i>
                           </a>
                        </li>
                        <li class="social-item">
                           <a href="https://vimeo.com/" class="social-link vm" target="_blank">
                              <i class="fab fa-vimeo-v"></i>
                           </a>
                        </li>
                        <li class="social-item">
                           <a href="https://www.pinterest.com/" class="social-link pn" target="_blank">
                              <i class="fab fa-pinterest-p"></i>
                           </a>
                        </li>
                        <li class="social-item">
                           <a href="https://www.whatsapp.com/" class="social-link wh" target="_blank">
                              <i class="fab fa-whatsapp"></i>
                           </a>
                        </li>
                     </ul>
                     <span class="wrapper-line wow zoomIn" data-wow-delay="700ms" data-wow-duration="800ms"></span>
                  </div>

                  <p class="copyright-text mb-0 wow fadeInUp" data-wow-delay="800ms" data-wow-duration="800ms">
                     <span class="currentYear"></span> © neeon all right reserved by
                     <a href="https://www.radiustheme.com/" rel="nofollow">RadiusTheme</a>
                  </p>

               </div>
               <!-- end footer-widget-style-2 -->
            </div>

         </footer>
         <!-- End  Footer -->

      </div>
      <!-- End main-content -->

      <!-- Start  offcanvas menu -->
      <div class="offcanvas-menu-wrap" id="offcanvas-wrap" data-position="right">

         <div class="offcanvas-content">
            <div class="offcanvas-header">
               <div class="offcanvas-logo">
                  <div class="site-branding">
                     <a class="dark-logo" href="index-2.html"><img width="162" height="52" src="media/logo/logo-dark.svg"
                           alt="neeon"></a>
                     <a class="light-logo" href="index-2.html"><img width="162" height="52"
                           src="media/logo/logo-light.svg" alt="neeon"></a>
                  </div>
               </div>
               <div class="close-btn offcanvas-close">
                  <a href="javascript:void(0)">
                     <i class="fas fa-times"></i>
                  </a>
               </div>
            </div>

            <div class="offcanvas-widget">
               <h3 class="offcanvas-widget-title">About Us</h3>
               <p>
                  The argument in favor of using filler text
                  goes something like this: If you use arey
                  real content in the Consulting Process
                  anytime you reachtent.
               </p>
            </div>

            <div class="offcanvas-widget">
               <h3 class="offcanvas-widget-title">Instagram</h3>
               <div class="insta-gallery">
                  <div class="galleryitem">
                     <a href="https://www.instagram.com/">
                        <img src="media/gallery/ins-gallery_1.jpg" width="100" height="90" alt="gallery1">
                     </a>
                  </div>
                  <div class="galleryitem">
                     <a href="https://www.instagram.com/">
                        <img src="media/gallery/ins-gallery_2.jpg" width="100" height="90" alt="gallery2">
                     </a>
                  </div>
                  <div class="galleryitem">
                     <a href="https://www.instagram.com/">
                        <img src="media/gallery/ins-gallery_3.jpg" width="100" height="90" alt="gallery3">
                     </a>
                  </div>
                  <div class="galleryitem">
                     <a href="https://www.instagram.com/">
                        <img src="media/gallery/ins-gallery_4.jpg" width="100" height="90" alt="gallery4">
                     </a>
                  </div>
                  <div class="galleryitem">
                     <a href="https://www.instagram.com/">
                        <img src="media/gallery/ins-gallery_5.jpg" width="100" height="90" alt="gallery5">
                     </a>
                  </div>
                  <div class="galleryitem">
                     <a href="https://www.instagram.com/">
                        <img src="media/gallery/ins-gallery_6.jpg" width="100" height="90" alt="gallery6">
                     </a>
                  </div>
               </div>
            </div>

            <div class="offcanvas-widget footer-widget">
               <h3 class="offcanvas-widget-title">Contact Info</h3>
               <ul class="contact-info-list widget-list">
                  <li class="widget-list-item">
                     <i class="fas fa-map-marker-alt list-icon"></i>
                     Chicago 12, Melborne City, USA
                  </li>
                  <li class="widget-list-item">
                     <i class="fas fa-phone-alt list-icon"></i>
                     <a href="tel:123333000999" class="widget-list-link">
                        (123) 333-000-999
                     </a>
                  </li>
                  <li class="widget-list-item">
                     <i class="fas fa-envelope list-icon"></i>
                     <a href="mailto:info@example.com" class="widget-list-link">
                        neeon@gmail.com
                     </a>
                  </li>
               </ul>
               <ul class="footer-social style-2 gutter-15">
                  <li class="social-item">
                     <a href="https://www.facebook.com/" class="social-link fb" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                     </a>
                  </li>
                  <li class="social-item">
                     <a href="https://twitter.com/" class="social-link tw" target="_blank">
                        <i class="fab fa-twitter"></i>
                     </a>
                  </li>
                  <li class="social-item">
                     <a href="https://vimeo.com/" class="social-link vm" target="_blank">
                        <i class="fab fa-vimeo-v"></i>
                     </a>
                  </li>
                  <li class="social-item">
                     <a href="https://www.pinterest.com/" class="social-link pn" target="_blank">
                        <i class="fab fa-pinterest-p"></i>
                     </a>
                  </li>
                  <li class="social-item">
                     <a href="https://www.whatsapp.com/" class="social-link wh" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <!-- End  offcanvas menu -->

      <!-- Start Cart Wrap -->
      <div class="cart-wrap" id="cart-wrap" data-position="left">
         <div class="cart-content">
            <div class="cart-header">
               <span class="cart-title d-inlie-block">Cart</span>
               <button type="button" class="cart-menu-btn menu-close-btn">
                  <span class="menu-btn-icon">
                     <i class="fas fa-times"></i>
                  </span>
               </button>
            </div>
            <ul class="cart-items ">
               <li class="d-flex ">
                  <div class="item-figure">
                     <a href="#">
                        <img src="media/gallery/ins-gallery_1.jpg" alt="Cart" width="100" height="90">
                     </a>
                     <div class="item-dismiss">
                        <a href="#"><i class="fas fa-times"></i></a>
                     </div>
                  </div>
                  <div class="item-description">
                     <span class="item-main-title"><a href="#">Animal</a></span>
                     <span class="item-amount d-flex align-items-center"><span class="item-quantity">1</span>X<span
                           class="item-price">$12.00</span></span>
                  </div>
               </li>
               <li class="d-flex">
                  <div class="item-figure">
                     <a href="#">
                        <img src="media/gallery/ins-gallery_2.jpg" alt="Cart" width="100" height="90">
                     </a>
                     <div class="item-dismiss">
                        <a href="#"><i class="fas fa-times"></i></a>
                     </div>
                  </div>
                  <div class="item-description">
                     <span class="item-main-title"><a href="#">Sports</a></span>
                     <span class="item-amount d-flex align-items-center"><span class="item-quantity">1</span>X<span
                           class="item-price">$18.00</span></span>
                  </div>
               </li>
               <li class="d-flex">
                  <div class="item-figure">
                     <a href="#">
                        <img src="media/gallery/ins-gallery_3.jpg" alt="Cart" width="100" height="90">
                     </a>
                     <div class="item-dismiss">
                        <a href="#"><i class="fas fa-times"></i></a>
                     </div>
                  </div>
                  <div class="item-description">
                     <span class="item-main-title"><a href="#">Fashion</a></span>
                     <span class="item-amount d-flex align-items-center"><span class="item-quantity">1</span>X<span
                           class="item-price">$20.00</span></span>
                  </div>

               </li>
            </ul>
            <div class="cart-footer">
               <ul class="total-amount">
                  <li class="title">Subtotal:</li>
                  <li class="amount">$50.00</li>
               </ul>
               <ul class="action-buttons">
                  <li><a href="#" class="rt-submit-btn">VIEW CART</a></li>
                  <li><a href="#" class="rt-submit-btn">CHECKOUT</a></li>
               </ul>
            </div>
         </div>
      </div>
      <!-- End Cart Wrap -->

      <!-- Start Search  -->
      <div id="template-search" class="template-search">
         <button type="button" class="close">×</button>
         <form class="search-form">
            <input type="search" value="" placeholder="Search" />
            <button type="submit" class="search-btn btn-ghost style-1">
               <i class="flaticon-search"></i>
            </button>
         </form>
      </div>
      <!-- End Search -->

      <!-- theme-switch-box -->
      <div class="theme-switch-box-wrap">
         <div class="theme-switch-box">
            <span class="theme-switch-box__theme-status"><i class="fas fa-cog"></i></span>
            <label class="theme-switch-box__label" for="themeSwitchCheckbox">
               <input class="theme-switch-box__input" type="checkbox" name="themeSwitchCheckbox"
                  id="themeSwitchCheckbox">
               <span class="theme-switch-box__main"></span>
            </label>
            <span class="theme-switch-box__theme-status"><i class="fas fa-moon"></i></span>
         </div>
      </div>
      <!-- end theme-switch-box -->


      <!-- start back to top -->
      <a href="javascript:void(0)" id="back-to-top">
         <i class="fas fa-angle-double-up"></i>
      </a>
      <!-- End back to top -->

   </div>
   <!-- End wrapper -->


   <!-- Dependency Scripts -->
   <script src="dependencies/jquery/jquery.min.js"></script>
   <script src="dependencies/popper.js/popper.min.js"></script>
   <script src="dependencies/bootstrap/js/bootstrap.min.js"></script>
   <script src="dependencies/appear/appear.min.js"></script>
   <script src="dependencies/swiper/js/swiper.min.js"></script>
   <script src="dependencies/masonry/masonry.min.js"></script>
   <script src="dependencies/magnific-popup/js/magnific-popup.min.js"></script>
   <script src="dependencies/theia-sticky-sidebar/resize-sensor.min.js"></script>
   <script src="dependencies/theia-sticky-sidebar/theia-sticky-sidebar.min.js"></script>
   <script src="dependencies/validator/validator.min.js"></script>
   <script src="dependencies/tween-max/tween-max.js"></script>
   <script src="dependencies/wow/js/wow.min.js"></script>

   <!-- custom -->
   <script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from radiustheme.com/demo/html/neeon/index7.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Dec 2022 11:47:39 GMT -->
</html>