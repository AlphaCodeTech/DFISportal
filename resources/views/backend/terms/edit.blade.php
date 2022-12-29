{{-- {{ dd($term->session->id) }} --}}
@extends('backend.layouts.app')

@push('extra-css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/css/datepicker.css') }}">
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Term</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Term</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            <!-- form start -->
                            <form method="POST" action="{{ route('term.update',$term->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="term_type_id">Term Type</label>
                                        @php
                                            $termtypes = App\Models\TermType::all();
                                        @endphp

                                        <select name="term_type_id" class="form-control" id="term_type_id">
                                            <option value="">Select Term Type</option>
                                            @foreach ($termtypes as $tt)
                                                <option value="{{ $tt->id }}" {{ $term->term_type->id == $tt->id ? "selected": "" }}>{{ $tt->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('term_type_id')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="term_type_id">Session</label>
                                        @php
                                            $sessions = App\Models\Session::all();
                                        @endphp

                                        <select name="session_id" class="form-control" id="session_id">
                                            <option value="">Select Term Type</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}" {{ $term->session->id == $session->id ? "selected": "" }}>{{ $session->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('session_id')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                                </div>
                                <!-- /.card-body -->

                        </div>
                        <!-- /.card -->

                    </div>
                   
                
                    <!--/.col (left) -->

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('extra-js')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
   
    <script>
        $(function() {
           
            $('#start_date').datepicker({
                format: "dd/mm/yyyy"
            });
            $('#end_date').datepicker({
                format: "dd/mm/yyyy"
            });

            setTimeout(() => {
                $(".alert").hide('slow');
            }, 5000);

        });
    </script>
@endpush
