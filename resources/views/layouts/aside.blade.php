@php
    $pendingKycCount = \App\Models\User::where('kyc_status', 'pending')->count();
    $pendingTxCount = \App\Models\Transaction::where('statut', 'en_attente')->count();
    $openTickets = \App\Models\SupportTicket::where('status', '!=', 'closed')->count();
@endphp
<aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white">
    <div class="navbar-vertical-container">
      <div class="navbar-vertical-footer-offset">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="5PSL Admin">
          <span style="font-size: 22px; font-weight: 900; letter-spacing: -1px;"><span style="color: #377dff;">5</span>PSL</span>
          <span class="badge bg-soft-primary text-primary ms-2" style="font-size: 10px;">ADMIN</span>
        </a>
        <!-- End Logo -->

        <!-- Navbar Vertical Toggle -->
        <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
          <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
          <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
        </button>
        <!-- End Navbar Vertical Toggle -->

        <!-- Content -->
        <div class="navbar-vertical-content">
          <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">

            <!-- Dashboard -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi-house-door nav-icon"></i>
                <span class="nav-link-title">Tableau de bord</span>
              </a>
            </div>

            <span class="dropdown-header mt-4">GESTION DU CLUB</span>
            <small class="bi-three-dots nav-subtitle-replacer"></small>

            <!-- Gestion Club -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('investment.admin.*') ? 'active' : '' }}" href="{{ route('investment.admin.index') }}">
                <i class="bi-speedometer2 nav-icon"></i>
                <span class="nav-link-title">Gestion Club</span>
                @if($pendingTxCount > 0)
                  <span class="badge bg-soft-danger text-danger rounded-pill ms-auto">{{ $pendingTxCount }}</span>
                @endif
              </a>
            </div>

            <!-- Utilisateurs -->
            <div class="nav-item">
              <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="#navAdminUsers" role="button" data-bs-toggle="collapse" data-bs-target="#navAdminUsers" aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                <i class="bi-people nav-icon"></i>
                <span class="nav-link-title">Utilisateurs</span>
              </a>
              <div id="navAdminUsers" class="nav-collapse collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Liste des membres</a>
                <a class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">Créer un compte</a>
              </div>
            </div>

            <!-- KYC -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.kyc.*') ? 'active' : '' }}" href="{{ route('admin.kyc.index') }}">
                <i class="bi-person-check nav-icon"></i>
                <span class="nav-link-title">Vérifications KYC</span>
                @if($pendingKycCount > 0)
                  <span class="badge bg-soft-warning text-warning rounded-pill ms-auto">{{ $pendingKycCount }}</span>
                @endif
              </a>
            </div>

            <!-- Opportunités -->
            <div class="nav-item">
              <a class="nav-link dropdown-toggle {{ request()->routeIs('opportunities.*') ? 'active' : '' }}" href="#navAdminOpportunities" role="button" data-bs-toggle="collapse" data-bs-target="#navAdminOpportunities" aria-expanded="{{ request()->routeIs('opportunities.*') ? 'true' : 'false' }}">
                <i class="bi-lightbulb nav-icon"></i>
                <span class="nav-link-title">Opportunités</span>
              </a>
              <div id="navAdminOpportunities" class="nav-collapse collapse {{ request()->routeIs('admin.opportunities.*') || request()->routeIs('opportunities.create') ? 'show' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.opportunities.index') ? 'active' : '' }}" href="{{ route('admin.opportunities.index') }}">Toutes les opportunités</a>
                <a class="nav-link {{ request()->routeIs('opportunities.create') ? 'active' : '' }}" href="{{ route('opportunities.create') }}">Créer une opportunité</a>
              </div>
            </div>

            <!-- Actifs du Club -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}" href="{{ route('admin.assets.index') }}">
                <i class="bi-briefcase nav-icon"></i>
                <span class="nav-link-title">Actifs du Club</span>
              </a>
            </div>

            <span class="dropdown-header mt-4">FINANCE</span>
            <small class="bi-three-dots nav-subtitle-replacer"></small>

            <!-- Portefeuilles Centraux -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.wallets.*') ? 'active' : '' }}" href="{{ route('admin.wallets.index') }}">
                <i class="bi-wallet2 nav-icon"></i>
                <span class="nav-link-title">Portefeuilles Centraux</span>
              </a>
            </div>

            <!-- Adresses Crypto -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.crypto.*') ? 'active' : '' }}" href="{{ route('admin.crypto.index') }}">
                <i class="bi-currency-bitcoin nav-icon"></i>
                <span class="nav-link-title">Adresses Dépôts</span>
              </a>
            </div>

            <span class="dropdown-header mt-4">SUPPORT</span>
            <small class="bi-three-dots nav-subtitle-replacer"></small>

            <!-- Support -->
            <div class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.support.*') ? 'active' : '' }}" href="{{ route('admin.support.index') }}">
                <i class="bi-headset nav-icon"></i>
                <span class="nav-link-title">Tickets Support</span>
                @if($openTickets > 0)
                  <span class="badge bg-soft-info text-info rounded-pill ms-auto">{{ $openTickets }}</span>
                @endif
              </a>
            </div>

            <span class="dropdown-header mt-4">FORMATION</span>
            <small class="bi-three-dots nav-subtitle-replacer"></small>

            <!-- Cours -->
            <div class="nav-item">
              <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="#navAdminCourses" role="button" data-bs-toggle="collapse" data-bs-target="#navAdminCourses" aria-expanded="{{ request()->routeIs('admin.courses.*') ? 'true' : 'false' }}">
                <i class="bi-book nav-icon"></i>
                <span class="nav-link-title">Cours</span>
              </a>
              <div id="navAdminCourses" class="nav-collapse collapse {{ request()->routeIs('admin.courses.*') ? 'show' : '' }}">
                <a class="nav-link" href="{{ route('admin.courses.index') }}">Gestion des cours</a>
                <a class="nav-link" href="{{ route('admin.courses.create') }}">Créer un cours</a>
              </div>
            </div>

          </div>
        </div>
        <!-- End Content -->

        <!-- Footer -->
        <div class="navbar-vertical-footer">
          <ul class="navbar-vertical-footer-list">
            <li class="navbar-vertical-footer-list-item">
              <a class="btn btn-ghost-secondary btn-icon rounded-circle" href="{{ route('investment.dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Espace Membre">
                <i class="bi-box-arrow-up-right"></i>
              </a>
            </li>
            <li class="navbar-vertical-footer-list-item">
              <div class="dropdown dropup">
                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle" id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                  <i class="bi-moon-stars"></i>
                </button>
                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="selectThemeDropdown">
                  <a class="dropdown-item" href="#" data-icon="bi-brightness-high" data-value="default">
                    <i class="bi-brightness-high me-2"></i>
                    <span class="text-truncate">Mode clair</span>
                  </a>
                  <a class="dropdown-item active" href="#" data-icon="bi-moon" data-value="dark">
                    <i class="bi-moon me-2"></i>
                    <span class="text-truncate">Mode sombre</span>
                  </a>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </aside>