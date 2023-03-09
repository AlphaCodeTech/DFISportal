@extends('frontend.layouts.minor')

@push('css')
    <!-- bootstrap css 5.* -->
    <link href="{{ asset('frontend/dist/css/bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('frontend')
    <livewire:purchase-form-component :guardian="$guardian_id" :phone="$phone"/>

    <!--Modals-->
    @include('frontend.components.modal')
@endsection
