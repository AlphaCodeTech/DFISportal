@extends('frontend.layouts.app')

@push('css')
    <!-- bootstrap css 5.* -->
    <link href="{{ asset('frontend/dist/css/bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('frontend')
    <livewire:purchase-form-component />
@endsection
