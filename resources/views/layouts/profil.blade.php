<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required Meta Tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>5psl | Admin Space</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('profil/favicon.ico') }}">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="{{ asset('profil/assets/css/vendor.min.css') }}">

  <!-- CSS Front Template -->
  <link rel="stylesheet" href="{{ asset('profil/assets/css/theme.min.css') }}?v=1.0">
  <link rel="stylesheet" href="{{ asset('profil/assets/css/theme-dark.min.css') }}">

  <style>
    /* Responsive fixes for admin layout */
    @media (max-width: 1199.98px) {
      main#content {
        padding-left: 0 !important;
        margin-left: 0 !important;
      }
      .navbar-vertical-aside {
        margin-left: -16.875rem;
        transition: margin-left 0.3s ease;
      }
      .navbar-vertical-aside.show {
        margin-left: 0;
      }
    }
    @media (min-width: 1200px) {
      main#content {
        padding-left: 16.875rem;
      }
      .navbar-vertical-aside-mini-mode main#content {
        padding-left: 5.75rem;
      }
    }
    main#content {
      min-height: 100vh;
    }
    .content.container-fluid {
      padding-top: 1.75rem;
      padding-bottom: 1.75rem;
    }
    /* Toast Notifications */
    .toast-notification {
      background: #fff;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 10px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.12);
      border-left: 4px solid #ccc;
      animation: toastSlideIn 0.4s ease-out;
      transition: opacity 0.4s ease, transform 0.4s ease;
    }
    .toast-notification.toast-hiding {
      opacity: 0;
      transform: translateX(40px);
    }
    .toast-success { border-left-color: #059669; }
    .toast-error { border-left-color: #dc2626; }
    .toast-warning { border-left-color: #f59e0b; }
    .toast-info { border-left-color: #377dff; }
    .toast-icon {
      width: 32px; height: 32px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; font-size: 14px;
    }
    @keyframes toastSlideIn {
      from { opacity: 0; transform: translateX(40px); }
      to { opacity: 1; transform: translateX(0); }
    }
  </style>

  <script>
    window.hs_config = {
      "autopath": "/",
      "themeAppearance": {
        "layoutSkin": "default",
        "sidebarSkin": "default"
      },
      "languageDirection": { "lang": "en" }
    };
  </script>
</head>

<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset">

  <!-- Theme Appearance -->
  <script src="{{ asset('profil/assets/js/hs.theme-appearance.js') }}"></script>
  <script src="{{ asset('profil/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js') }}"></script>

  <!-- HEADER -->
  @include('layouts.header')

  <!-- SIDEBAR -->
  @include('layouts.aside')

  <!-- MAIN CONTENT -->
  <main id="content" role="main" class="main">
    <!-- Global Toast Notifications -->
    @if(session('success') || session('error') || session('warning') || session('info'))
    <div id="globalToastContainer" style="position:fixed;top:20px;right:20px;z-index:10000;max-width:420px;width:100%;">
      @if(session('success'))
      <div class="toast-notification toast-success" role="alert">
        <div class="d-flex align-items-start">
          <div class="toast-icon bg-success text-white">
            <i class="bi-check-lg"></i>
          </div>
          <div class="flex-grow-1 ms-3">
            <strong class="d-block mb-1">Succès</strong>
            <span class="text-muted" style="font-size:13px;">{{ session('success') }}</span>
          </div>
          <button type="button" class="btn-close ms-2" onclick="this.closest('.toast-notification').remove()"></button>
        </div>
      </div>
      @endif
      @if(session('error'))
      <div class="toast-notification toast-error" role="alert">
        <div class="d-flex align-items-start">
          <div class="toast-icon bg-danger text-white">
            <i class="bi-x-lg"></i>
          </div>
          <div class="flex-grow-1 ms-3">
            <strong class="d-block mb-1">Erreur</strong>
            <span class="text-muted" style="font-size:13px;">{{ session('error') }}</span>
          </div>
          <button type="button" class="btn-close ms-2" onclick="this.closest('.toast-notification').remove()"></button>
        </div>
      </div>
      @endif
      @if(session('warning'))
      <div class="toast-notification toast-warning" role="alert">
        <div class="d-flex align-items-start">
          <div class="toast-icon bg-warning text-white">
            <i class="bi-exclamation-triangle"></i>
          </div>
          <div class="flex-grow-1 ms-3">
            <strong class="d-block mb-1">Attention</strong>
            <span class="text-muted" style="font-size:13px;">{{ session('warning') }}</span>
          </div>
          <button type="button" class="btn-close ms-2" onclick="this.closest('.toast-notification').remove()"></button>
        </div>
      </div>
      @endif
      @if(session('info'))
      <div class="toast-notification toast-info" role="alert">
        <div class="d-flex align-items-start">
          <div class="toast-icon bg-info text-white">
            <i class="bi-info-lg"></i>
          </div>
          <div class="flex-grow-1 ms-3">
            <strong class="d-block mb-1">Information</strong>
            <span class="text-muted" style="font-size:13px;">{{ session('info') }}</span>
          </div>
          <button type="button" class="btn-close ms-2" onclick="this.closest('.toast-notification').remove()"></button>
        </div>
      </div>
      @endif
    </div>
    @endif
    @if($errors->any())
    <div id="globalToastContainer" style="position:fixed;top:20px;right:20px;z-index:10000;max-width:420px;width:100%;">
      <div class="toast-notification toast-error" role="alert">
        <div class="d-flex align-items-start">
          <div class="toast-icon bg-danger text-white">
            <i class="bi-x-lg"></i>
          </div>
          <div class="flex-grow-1 ms-3">
            <strong class="d-block mb-1">Erreur de validation</strong>
            @foreach($errors->all() as $err)
              <span class="text-muted d-block" style="font-size:13px;">• {{ $err }}</span>
            @endforeach
          </div>
          <button type="button" class="btn-close ms-2" onclick="this.closest('.toast-notification').remove()"></button>
        </div>
      </div>
    </div>
    @endif

    @yield('content')
  </main>
  <!-- END MAIN CONTENT -->

  <!-- FOOTER -->
  <footer>
    <!-- Optional footer content -->
  </footer>

  <!-- JS Implementing Plugins -->
  <script src="{{ asset('profil/assets/js/vendor.min.js') }}"></script>
  <script src="{{ asset('profil/assets/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js') }}"></script>

  <!-- JS Front -->
  <script src="{{ asset('profil/assets/js/theme.min.js') }}"></script>

  <!-- Initialization Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Navbar vertical aside initialization
      new HSSideNav('.js-navbar-vertical-aside').init();

      // Mobile sidebar toggle
      var toggler = document.querySelector('.js-navbar-vertical-aside-toggle-invoker');
      var sidebar = document.querySelector('.js-navbar-vertical-aside');
      if (toggler && sidebar) {
        toggler.addEventListener('click', function() {
          sidebar.classList.toggle('show');
        });
      }
    });
  </script>

  <!-- Toast auto-dismiss -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.toast-notification').forEach(function(toast) {
        setTimeout(function() {
          toast.classList.add('toast-hiding');
          setTimeout(function() { toast.remove(); }, 400);
        }, 5000);
      });
    });
  </script>

  @stack('scripts')
</body>

</html>
