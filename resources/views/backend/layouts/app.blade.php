<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.layouts.head')
</head>


<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    @include('sweetalert::alert')
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div> --}}

        @include('backend.layouts.nav')

        @include('backend.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
       {{ $slot }}

        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('backend.layouts.footer')
    </div>
    <!-- ./wrapper -->

    @include('backend.layouts.scripts')
</body>

</html>
