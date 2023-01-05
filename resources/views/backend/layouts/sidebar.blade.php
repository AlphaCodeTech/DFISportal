  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DFIS PORTAL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                {{-- <i class="right fas fa-angle-left"></i> --}}
              </p>
            </a>
           
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Students
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('student.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('student.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Student</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Subjects
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('subject.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Subjects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('subject.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Subject</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Levels
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('level.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Levels</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('level.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Level</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Fees
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('fees.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Fees</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('fees.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Fees</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Categories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Classrooms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('class.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Classrooms</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('class.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add ClassRoom</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Permissions
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('permission.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('permission.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Permission</p>
                </a>
              </li>
              
            </ul>
          </li>
        
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Roles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('role.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Role</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Session
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('session.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Sessions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('session.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Session</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Terms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('term.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Terms</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('term.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Terms</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('termtype.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add TermType</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Guardians
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('parent.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Parents</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{ route('term.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Parents</p>
                </a>
              </li> --}}
              
            </ul>
          </li>
         
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
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
              {{-- <li class="nav-item">
                <a href="{{ route('term.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Parents</p>
                </a>
              </li> --}}
              
            </ul>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>