@extends('layouts.profiluser')

@section('content')




<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
      <div class="row justify-content-lg-center">
        <div class="col-lg-10">
          <!-- Profile Cover -->
          <div class="profile-cover">
            <div class="profile-cover-img-wrapper">
              <img class="profile-cover-img" src="profil/assets/img/1920x400/img2.jpg" alt="Image Description">
            </div>
          </div>
          <!-- End Profile Cover -->

          <!-- Profile Header -->
          <div class="text-center mb-5">
            <!-- Avatar -->
            <div class="avatar avatar-xxl avatar-circle profile-cover-avatar">
              <img class="avatar-img" src="profil/assets/svg/user2.svg" alt="Image Description">
              <span class="avatar-status avatar-status-success"></span>
            </div>
            <!-- End Avatar -->

            <h1 class="page-header-title">{{ Auth::user()->name }}  <i class="bi-patch-check-fill fs-2 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Top endorsed"></i></h1>

            <!-- List -->
            <ul class="list-inline list-px-2">
              <li class="list-inline-item">
                <i class="bi-building me-1"></i>
                <span>Htmlstream</span>
              </li>

              <li class="list-inline-item">
                <i class="bi-geo-alt me-1"></i>
                <a href="#">San Francisco,</a>
                <a href="#">US</a>
              </li>

              <li class="list-inline-item">
                <i class="bi-calendar-week me-1"></i>
                <span>Joined March 2017</span>
              </li>
            </ul>
            <!-- End List -->
          </div>
          <!-- End Profile Header -->

          <!-- Nav -->
          @include("layouts.usernav")
          <!-- End Nav -->

          <div class="row">
            <div class="col-lg-4">
              <!-- Card -->
              <div class="card card-lg mb-3 mb-lg-5">
                <!-- Body -->
                <div class="card-body text-center">
                  <div class="mb-4">
                    <img class="avatar avatar-xl avatar-4x3" src="profil/assets/svg/illustrations/oc-unlock.svg" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="avatar avatar-xl avatar-4x3" src="profil/assets/svg/illustrations-light/oc-unlock.svg" alt="Image Description" data-hs-theme-appearance="dark">
                  </div>

                  <div class="mb-3">
                    <h3>2-step verification</h3>
                    <p>Protect your account now and enable 2-step verification in the settings.</p>
                  </div>

                  <a class="btn btn-primary" href="account-settings.html#twoStepVerificationSection">Enable now</a>
                </div>
                <!-- End Body -->
              </div>
              <!-- End Card -->

              <!-- Card -->
              <div class="card mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header card-header-content-between">
                  <h4 class="card-header-title">Profile</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                  <ul class="list-unstyled list-py-2 text-dark mb-0">
                    <li class="pb-0"><span class="card-subtitle">About</span></li>
                    <li><i class="bi-person dropdown-item-icon"></i> {{ Auth::user()->name }}</li>
                    <li><i class="bi-briefcase dropdown-item-icon"></i> No department</li>
                    <li><i class="bi-building dropdown-item-icon"></i> Pixeel Ltd.</li>

                    <li class="pt-4 pb-0"><span class="card-subtitle">Contacts</span></li>
                    <li><i class="bi-at dropdown-item-icon"></i> mark@site.com</li>
                    <li><i class="bi-phone dropdown-item-icon"></i> +1 (555) 752-01-10</li>

                    <li class="pt-4 pb-0"><span class="card-subtitle">Teams</span></li>
                    <li class="fs-6 text-body"><i class="bi-people dropdown-item-icon"></i> You are not a member of any teams</li>
                    <li class="fs-6 text-body"><i class="bi-stickies dropdown-item-icon"></i> You are not working on any projects</li>
                  </ul>
                </div>
                <!-- End Body -->
              </div>
              <!-- End Card -->

              <!-- Card -->
              
              <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-lg-8">
              <!-- Card -->
              <div class="card card-centered mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header card-header-content-between">
                  <h4 class="card-header-title">Activity stream</h4>

                  <!-- Dropdown -->
                  <div class="dropdown">
                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="contentActivityStreamDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi-three-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="contentActivityStreamDropdown">
                      <span class="dropdown-header">Settings</span>

                      <a class="dropdown-item" href="#">
                        <i class="bi-share-fill dropdown-item-icon"></i> Share connections
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="bi-info-circle dropdown-item-icon"></i> Suggest edits
                      </a>

                      <div class="dropdown-divider"></div>

                      <span class="dropdown-header">Feedback</span>

                      <a class="dropdown-item" href="#">
                        <i class="bi-chat-left-dots dropdown-item-icon"></i> Report
                      </a>
                    </div>
                  </div>
                  <!-- End Dropdown -->
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body card-body-height">
                  <img class="avatar avatar-xxl mb-3" src="profil/assets/svg/illustrations/oc-error.svg" alt="Image Description" data-hs-theme-appearance="default">
                  <img class="avatar avatar-xxl mb-3" src="profil/assets/svg/illustrations-light/oc-error.svg" alt="Image Description" data-hs-theme-appearance="dark">
                  <p class="card-text">No data to show</p>
                  <a class="btn btn-white btn-sm" href="index-2.html#">Start your Activity</a>
                </div>
                <!-- End Body -->
              </div>
              <!-- End Card -->

              <!-- Card -->
              <div class="card card-centered mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header card-header-content-between">
                  <h4 class="card-header-title">Projects</h4>

                  <!-- Dropdown -->
                  <div class="dropdown">
                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="projectReportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi-three-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="projectReportDropdown">
                      <span class="dropdown-header">Settings</span>

                      <a class="dropdown-item" href="#">
                        <i class="bi-share-fill dropdown-item-icon"></i> Share connections
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="bi-info-circle dropdown-item-icon"></i> Suggest edits
                      </a>

                      <div class="dropdown-divider"></div>

                      <span class="dropdown-header">Feedback</span>

                      <a class="dropdown-item" href="#">
                        <i class="bi-chat-left-dots dropdown-item-icon"></i> Report
                      </a>
                    </div>
                  </div>
                  <!-- End Dropdown -->
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body card-body-height card-body-centered">
                  <img class="avatar avatar-xxl mb-3" src="profil/assets/svg/illustrations/oc-error.svg" alt="Image Description" data-hs-theme-appearance="default">
                  <img class="avatar avatar-xxl mb-3" src="profil/assets/svg/illustrations-light/oc-error.svg" alt="Image Description" data-hs-theme-appearance="dark">
                  <p class="card-text">No data to show</p>
                  <a class="btn btn-white btn-sm" href="projects.html">Start your Projects</a>
                </div>
                <!-- End Body -->
              </div>
              <!-- End Card -->
            </div>
            <!-- End Col -->
          </div>
          <!-- End Row -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
          <!-- End Row -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
    <!-- End Content -->

    <!-- Footer -->

    <div class="footer">
      <div class="row justify-content-between align-items-center">
        <div class="col">
          <p class="fs-6 mb-0">&copy; Front. <span class="d-none d-sm-inline-block">2022 Htmlstream.</span></p>
        </div>
        <!-- End Col -->

        <div class="col-auto">
          <div class="d-flex justify-content-end">
            <!-- List Separator -->
            <ul class="list-inline list-separator">
              <li class="list-inline-item">
                <a class="list-separator-link" href="#">FAQ</a>
              </li>

              <li class="list-inline-item">
                <a class="list-separator-link" href="#">License</a>
              </li>

              <li class="list-inline-item">
                <!-- Keyboard Shortcuts Toggle -->
                <button class="btn btn-ghost-secondary btn btn-icon btn-ghost-secondary rounded-circle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKeyboardShortcuts" aria-controls="offcanvasKeyboardShortcuts">
                  <i class="bi-command"></i>
                </button>
                <!-- End Keyboard Shortcuts Toggle -->
              </li>
            </ul>
            <!-- End List Separator -->
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>

    <!-- End Footer -->
  </main>

  @stop