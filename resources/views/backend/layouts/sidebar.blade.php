  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
          <img src="{{ asset($appSettings->logo) ?? asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light ">{{ Str::upper($appSettings->acr ) ?? 'PORTAL'}}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->

          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset(auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ ucwords(Auth::user()->getRoleNames()[0] ?? 'User') }}</a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item">
                      <a href="{{ route('backend.index') }}"
                          class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                              {{-- <i class="right fas fa-angle-left"></i> --}}
                          </p>
                      </a>

                  </li>
                  @if (Nav::userCanSeeStudent())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/students') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-graduation-cap"></i>
                              <p>
                                  Students
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.students', ['user' => auth()->user()]) }}"
                                      class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Students</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="#" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Students Informations</p>
                                  </a>
                                  <ul class="nav nav-treeview">
                                      @foreach (App\Models\Clazz::orderBy('name')->get() as $class)
                                          <li class="nav-item ml-4">
                                              <a href="{{ route('students.list', ['class' => $class->id ]) }}"
                                                  class="nav-link">
                                                  <i class="far fa-circle nav-icon"></i>
                                                  <p>{{ $class->name }}</p>
                                              </a>
                                          </li>
                                      @endforeach
                                  </ul>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeSubject())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/subjects') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-book"></i>
                              <p>
                                  Subjects
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.subjects') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Subjects</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeLevel())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/levels') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-battery-half"></i>
                              <p>
                                  Levels
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.levels') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Levels</p>
                                  </a>
                              </li>


                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeFee())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/fees') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-sort-amount-up"></i>
                              <p>
                                  Fees
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.fees') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Fees</p>
                                  </a>
                              </li>


                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeDepartment())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/departments') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-list-alt"></i>
                              <p>
                                  Departments
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.departments') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Department</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeClassroom())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/classrooms') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-school"></i>
                              <p>
                                  Classrooms
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.classrooms') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Classrooms</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeUser())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-users"></i>
                              <p>
                                  Users
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.users') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Users</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeProfile())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-users"></i>
                              <p>
                                  Profile
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.profile', auth()->user()) }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Profile</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeePermission())
                      <li class="nav-item">
                          <a href="#"
                              class="nav-link {{ request()->is('admin/permissions') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-ban"></i>
                              <p>
                                  Permissions
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.permissions') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Permissions</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeRole())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/roles') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-tasks"></i>
                              <p>
                                  Roles
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.roles') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Roles</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeSession())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/sessions') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-calendar"></i>
                              <p>
                                  Sessions
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.sessions') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Sessions</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeTerm())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/terms') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-calendar-alt"></i>
                              <p>
                                  Terms
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.terms') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Terms</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeGuardian())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/parents') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-user-tie"></i>
                              <p>
                                  Guardians
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.parents') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Parents</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeBursary())
                      <li class="nav-item">
                          <a href="#" class="nav-link {{ request()->is('admin/bursaries') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-credit-card"></i>
                              <p>
                                  Bursary
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('bursary.index') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Bursary</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeAdmission())
                      <li class="nav-item">
                          <a href="#"
                              class="nav-link {{ request()->is('admin/admission-management') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-university"></i>
                              <p>
                                  Admissions
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('admission.index') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Applications</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeEvent())
                      <li class="nav-item">
                          <a href="#"
                              class="nav-link {{ request()->is('admin/admission-management') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-calendar"></i>
                              <p>
                                  Events
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('backend.events') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>View Events</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif
                  @if (Nav::userCanSeeSetting())
                      <li class="nav-item">
                          <a href="#"
                              class="nav-link {{ request()->is('admin/admission-management') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-cog"></i>
                              <p>
                                  Settings
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('setting.system') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>System Settings</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('setting.academic') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Academic Settings</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endif

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
