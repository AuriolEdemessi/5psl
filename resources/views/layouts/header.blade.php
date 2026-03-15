<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white">
    <div class="navbar-nav-wrap">
      <!-- Logo -->
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="5PSL Admin">
        <span style="font-size: 20px; font-weight: 900; letter-spacing: -1px;"><span style="color: #377dff;">5</span>PSL</span>
      </a>
      <!-- End Logo -->

      <div class="navbar-nav-wrap-content-start">
        <!-- Navbar Vertical Toggle (desktop) -->
        <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
          <i class="bi-arrow-bar-left navbar-toggler-short-align"></i>
          <i class="bi-arrow-bar-right navbar-toggler-full-align"></i>
        </button>
        <!-- End Navbar Vertical Toggle -->
      </div>

      <div class="navbar-nav-wrap-content-end">
        <!-- Navbar -->
        <ul class="navbar-nav">
          <!-- Member Dashboard Link -->
          <li class="nav-item d-none d-sm-inline-block">
            <a class="btn btn-ghost-secondary btn-icon rounded-circle" href="{{ route('investment.dashboard') }}" title="Espace Membre">
              <i class="bi-speedometer2"></i>
            </a>
          </li>

          <!-- Account -->
          <li class="nav-item">
            <div class="dropdown">
              <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                <div class="avatar avatar-sm avatar-primary avatar-circle">
                  <span class="avatar-initials">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                  <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                </div>
              </a>

              <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
                <div class="dropdown-item-text">
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm avatar-primary avatar-circle">
                      <span class="avatar-initials">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h5 class="mb-0">{{ Auth::user()->name ?? 'Admin' }}</h5>
                      <p class="card-text text-body">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                  </div>
                </div>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('investment.dashboard') }}">
                  <i class="bi-speedometer2 dropdown-item-icon"></i> Espace Membre
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi-box-arrow-right dropdown-item-icon"></i> Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </div>
            </div>
            <!-- End Account -->
          </li>
        </ul>
        <!-- End Navbar -->
      </div>
    </div>
</header>
