@extends('frontend.layouts.app')

@push('css')
    <!-- bootstrap css 5.* -->
    <link href="{{ asset('frontend/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- js -->
    <script src="{{ asset('frontend/dist/js/bootstrap.bundle.min.js') }}"></script>
@endpush
@section('frontend')
    <livewire:purchase-form-component />
@endsection
