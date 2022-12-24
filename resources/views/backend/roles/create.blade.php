@extends('backend.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <livewire:role.create-role-component />
@endsection

@push('extra-js')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
   
    <script>
        $(function() {
            

            setTimeout(() => {
                $(".alert").hide('slow');
            }, 5000);

        });
    </script>
@endpush
