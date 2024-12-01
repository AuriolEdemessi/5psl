@extends('layouts.profiluser')

@section('content')


  <!-- End Section -->
  @include("layouts.usernav")

  <div class="row">
          
        <div class="row align-items-center mb-5">
            <div class="col">
              <h3 class="mb-0">8 projects</h3>
            </div>
            <!-- End Col -->

            <div class="col-auto">
              <!-- Nav -->
              <ul class="nav nav-segment" id="projectsTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="grid-tab" data-bs-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="true" title="Column view">
                    <i class="bi-grid"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false" title="List view">
                    <i class="bi-view-list"></i>
                  </a>
                </li>
              </ul>
              <!-- End Nav -->
            </div>
            <!-- End Col -->
          </div>

          <div class="tab-content" id="projectsTabContent">
            <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
              <div class="row row-cols-1 row-cols-md-2">
                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <div class="card-progress-wrap">
                      <!-- Progress -->
                      <div class="progress card-progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <!-- End Progress -->
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-secondary text-secondary p-2">To do</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown8" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown8">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <img class="avatar avatar-lg" src="assets/svg/brands/google-webdev-icon.svg" alt="Image Description">
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Webdev</h2>

                        <span class="fs-5">Updated 2 hours ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                            <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                            <span class="avatar-initials">B</span>
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Adam Keep">
                            <span class="avatar-initials">A</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">19</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">33</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">10</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-primary text-primary p-2">In progress</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown1">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <img class="avatar avatar-lg" src="assets/svg/brands/spec-icon.svg" alt="Image Description">
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Get a complete store audit</h2>

                        <span class="fs-5">Updated 1 day ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ella Lauda">
                            <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="David Harrison">
                            <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Antony Taylor">
                            <span class="avatar-initials">A</span>
                          </a>
                          <a class="avatar avatar-soft-info" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sara Iwens">
                            <span class="avatar-initials">S</span>
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                            <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                            <span class="avatar-initials">+3</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">4</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">8</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">18</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-success text-success p-2">Completed</span>
                        </div>

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown6" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown6">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <img class="avatar avatar-lg" src="assets/svg/brands/capsule-icon.svg" alt="Image Description">
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Build stronger customer relationships</h2>

                        <span class="fs-5">Updated 1 day ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                            <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="David Harrison">
                            <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-info" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Lisa Iston">
                            <span class="avatar-initials">L</span>
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart">
                            <img class="avatar-img" src="assets/img/160x160/img4.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Zack Ins">
                            <span class="avatar-initials">Z</span>
                          </a>
                          <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Lewis Clarke, Chris Mathew and 3 more">
                            <span class="avatar-initials">+5</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">7</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">7</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">0</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-primary text-primary p-2">In progress</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown2">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <img class="avatar avatar-lg" src="assets/svg/brands/prosperops-icon.svg" alt="Image Description">
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Cloud computing</h2>

                        <span class="fs-5">Updated 2 days ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                            <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                            <span class="avatar-initials">B</span>
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Linda Bates">
                            <img class="avatar-img" src="assets/img/160x160/img8.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ella Lauda">
                            <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">4</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">8</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">30</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar" role="progressbar" style="width: 59%" aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-primary text-primary p-2">In progress</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown4" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown4">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <img class="avatar avatar-lg" src="assets/svg/brands/mailchimp-icon.svg" alt="Image Description">
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Update subscription method</h2>

                        <span class="fs-5">Updated 2 days ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                            <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Adam Keep">
                            <span class="avatar-initials">A</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">25</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">30</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">20</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-secondary text-secondary p-2">To do</span>
                        </div>

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown7" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown7">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <span class="avatar avatar-lg avatar-soft-info avatar-circle">
                          <span class="avatar-initials">I</span>
                        </span>
                        <!-- End Avatar -->
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Improve social banners</h2>

                        <span class="fs-5">Updated 1 week ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                            <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-info" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                            <span class="avatar-initials">B</span>
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart">
                            <img class="avatar-img" src="assets/img/160x160/img4.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-primary" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Daniel Cs.">
                            <span class="avatar-initials">D</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">9</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">16</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">21</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-success text-success p-2">Completed</span>
                        </div>

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown3" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown3">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <img class="avatar avatar-lg" src="assets/svg/brands/figma-icon.svg" alt="Image Description">
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Create a new theme</h2>

                        <span class="fs-5">Updated 1 week ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                            <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Zack Ins">
                            <span class="avatar-initials">Z</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">7</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">7</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">0</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                      <div class="progress card-progress">
                        <div class="progress-bar" role="progressbar" style="width: 77%" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                      <div class="row align-items-center text-start mb-4">
                        <div class="col">
                          <span class="badge bg-soft-primary text-primary p-2">In progress</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                          <!-- Dropdown -->
                          <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown5" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown5">
                              <a class="dropdown-item" href="#">Rename project </a>
                              <a class="dropdown-item" href="#">Add to favorites</a>
                              <a class="dropdown-item" href="#">Archive project</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                          </div>
                          <!-- End Dropdown -->
                        </div>
                        <!-- End Col -->
                      </div>

                      <div class="d-flex justify-content-center mb-2">
                        <!-- Avatar -->
                        <span class="avatar avatar-lg avatar-soft-dark avatar-circle">
                          <span class="avatar-initials">N</span>
                        </span>
                        <!-- End Avatar -->
                      </div>

                      <div class="mb-4">
                        <h2 class="mb-1">Notifications</h2>

                        <span class="fs-5">Updated 1 week ago</span>
                      </div>

                      <small class="card-subtitle">Members</small>

                      <div class="d-flex justify-content-center">
                        <!-- Avatar Group -->
                        <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart">
                            <img class="avatar-img" src="assets/img/160x160/img4.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-danger" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Teresa Eyker">
                            <span class="avatar-initials">T</span>
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                            <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                          </a>
                          <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="David Harrison">
                            <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                          </a>
                          <a class="avatar avatar-soft-warning" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Olivier L.">
                            <span class="avatar-initials">O</span>
                          </a>
                          <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Brian Halligan, Rachel Doe and 7 more">
                            <span class="avatar-initials">+9</span>
                          </a>
                        </div>
                        <!-- End Avatar Group -->
                      </div>

                      <a class="stretched-link" href="#"></a>
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                      <!-- Stats -->
                      <div class="row col-divider">
                        <div class="col">
                          <span class="h4">9</span>
                          <span class="d-block fs-5">Tasks</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">16</span>
                          <span class="d-block fs-5">Completed</span>
                        </div>
                        <!-- End Col -->

                        <div class="col">
                          <span class="h4">21</span>
                          <span class="d-block fs-5">Days left</span>
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Stats -->
                    </div>
                    <!-- End Footer -->
                  </div>
                  <!-- End Card -->
                </div>
              </div>
              <!-- End Row -->
            </div>

            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
              <div class="row row-cols-1">
                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <div class="flex-shrink-0 me-3 me-lg-4">
                        <img class="avatar" src="assets/svg/brands/google-webdev-icon.svg" alt="Image Description">
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-secondary text-secondary p-2 mb-2">To do</span>

                            <h3 class="mb-1">Webdev</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                                <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                                <span class="avatar-initials">B</span>
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Adam Keep">
                                <span class="avatar-initials">A</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown1">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">2 hours ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">19</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">33</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">10</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <div class="flex-shrink-0 me-3 me-lg-4">
                        <img class="avatar" src="assets/svg/brands/spec-icon.svg" alt="Image Description">
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                            <h3 class="mb-1">Get a complete store audit</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ella Lauda">
                                <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-info" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sara Iwens">
                                <span class="avatar-initials">S</span>
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                                <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                                <span class="avatar-initials">+5</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown2">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">1 day ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">4</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">8</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">18</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <div class="flex-shrink-0 me-3 me-lg-4">
                        <img class="avatar" src="assets/svg/brands/capsule-icon.svg" alt="Image Description">
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-success text-success p-2 mb-2">Completed</span>

                            <h3 class="mb-1">Build stronger customer relationships</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                                <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="David Harrison">
                                <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Zack Ins">
                                <span class="avatar-initials">Z</span>
                              </a>
                              <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Lewis Clarke, Chris Mathew and 3 more">
                                <span class="avatar-initials">+5</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown3" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown3">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">1 day ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">7</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">7</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">0</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <div class="flex-shrink-0 me-3 me-lg-4">
                        <img class="avatar" src="assets/svg/brands/prosperops-icon.svg" alt="Image Description">
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                            <h3 class="mb-1">Cloud computing</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                                <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                                <span class="avatar-initials">B</span>
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Linda Bates">
                                <img class="avatar-img" src="assets/img/160x160/img8.jpg" alt="Image Description">
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ella Lauda">
                                <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown4" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown4">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">2 hours ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">4</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">8</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">30</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <div class="flex-shrink-0 me-3 me-lg-4">
                        <img class="avatar" src="assets/svg/brands/mailchimp-icon.svg" alt="Image Description">
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                            <h3 class="mb-1">Update subscription method</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                                <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Adam Keep">
                                <span class="avatar-initials">A</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown5" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown5">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">2 days ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">25</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">30</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">20</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 59%" aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <span class="avatar avatar-soft-info avatar-circle me-3 me-lg-4">
                        <span class="avatar-initials">I</span>
                      </span>
                      <!-- End Avatar -->

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-secondary text-secondary p-2 mb-2">To do</span>

                            <h3 class="mb-1">Improve social banners</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                                <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart">
                                <img class="avatar-img" src="assets/img/160x160/img4.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-primary" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Daniel Cs.">
                                <span class="avatar-initials">D</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown6" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown6">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">1 week ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">9</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">16</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">21</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <div class="flex-shrink-0 me-3 me-lg-4">
                        <img class="avatar" src="assets/svg/brands/figma-icon.svg" alt="Image Description">
                      </div>

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-success text-success p-2 mb-2">Completed</span>

                            <h3 class="mb-1">Create a new theme</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                                <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Zack Ins">
                                <span class="avatar-initials">Z</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown7" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown7">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">1 week ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">7</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">7</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">0</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>

                <div class="col mb-3 mb-lg-5">
                  <!-- Card -->
                  <div class="card card-body">
                    <div class="d-flex">
                      <!-- Avatar -->
                      <span class="avatar avatar-soft-dark avatar-circle me-3 me-lg-4">
                        <span class="avatar-initials">N</span>
                      </span>
                      <!-- End Avatar -->

                      <div class="flex-grow-1 ms-3">
                        <div class="row align-items-sm-center">
                          <div class="col">
                            <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                            <h3 class="mb-1">Notifications</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                              <a class="avatar avatar-soft-danger" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Teresa Eyker">
                                <span class="avatar-initials">T</span>
                              </a>
                              <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                                <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                              </a>
                              <a class="avatar avatar-soft-warning" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Olivier L.">
                                <span class="avatar-initials">O</span>
                              </a>
                              <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Brian Halligan, Rachel Doe and 7 more">
                                <span class="avatar-initials">+9</span>
                              </a>
                            </div>
                            <!-- End Avatar Group -->
                          </div>

                          <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="dropdown">
                              <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown8" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                              </button>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown8">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>
                        <!-- End Row -->

                        <!-- Stats -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <span class="fs-5">Updated:</span>
                            <span class="fw-semi-bold text-dark">1 week ago</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Tasks:</span>
                            <span class="fw-semi-bold text-dark">9</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Completed:</span>
                            <span class="fw-semi-bold text-dark">16</span>
                          </li>

                          <li class="list-inline-item">
                            <span class="fs-5">Days left:</span>
                            <span class="fw-semi-bold text-dark">21</span>
                          </li>
                        </ul>
                        <!-- End Stats -->

                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 77%" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <a class="stretched-link" href="#"></a>
                      </div>
                    </div>
                  </div>
                  <!-- End Card -->
                </div>
              </div>
              <!-- End Row -->
            </div>
          </div>


</div>
  
<div class="container">
    <h1>Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Project</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Goal Amount</th>
                <th>Current Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->goal_amount }}</td>
                <td>{{ $project->current_amount }}</td>
                <td>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info">View</a>
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
