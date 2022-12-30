@extends('frontend.layouts.app')

@section('frontend')

    {{-- Section Admission --}}
    @include('frontend.components.admission')

    <!--Section program begins-->
    @include('frontend.components.programs')
    <!--Section program ends-->


    <!--Section About begins-->
    @include('frontend.components.about')
    <!--Section About ends-->

    <!--Section Gallery begins-->
    @include('frontend.components.gallery')
    <!--Section Gallery ends-->

    <!--Section Result begins-->
    @include('frontend.components.result')
    <!--Section Result ends-->

    <!--Section Advert begins-->
    @include('frontend.components.advert')
    <!--Section Advert ends-->


    <!--Section Contact begins-->
    @include('frontend.components.contact')
    <!--Section Contact Ends-->


    <!--Section Map Begins-->
    @include('frontend.components.map')
    <!--Section Map ends-->

    <!--Section Faq Begins-->
    @include('frontend.components.faqs')


@endsection
