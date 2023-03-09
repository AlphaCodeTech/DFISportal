<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.layouts.head')
</head>

<body>
    @include('sweetalert::alert')
    {{-- Section Header --}}
    @include('frontend.components.min-navbar')

    @yield('frontend')

    <!--Section Footer begins-->
    @include('frontend.components.footer')

    @include('frontend.layouts.scripts')
</body>

</html>
