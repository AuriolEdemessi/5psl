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
  <main id="content" role="main">
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

      // Datatables initialization
      HSCore.components.HSDatatables.init('#datatable', {
        select: {
          style: 'multi',
          selector: 'td:first-child input[type="checkbox"]'
        }
      });

      // Chart.js initialization
      HSCore.components.HSChartJS.init('.js-chart');
    });
  </script>
</body>

</html>
