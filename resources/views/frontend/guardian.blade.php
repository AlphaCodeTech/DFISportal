@extends('frontend.layouts.minor')

@section('frontend')
   <livewire:guardian-store-component />

    <!--Modals-->
    @include('frontend.components.modal')
@endsection
