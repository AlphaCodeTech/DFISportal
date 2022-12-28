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
                        <h1>Add Session</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add Session</li>
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
                            <form method="POST" action="{{ route('session.store') }}">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter name" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div data-date-format="dd-mm-yyyy" class="input-group date">
                                            <input id="start_date" name="start_date" type="text" class="form-control"
                                                autocomplete="off" value="{{ old('start_date') }}"/>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('start_date')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div data-date-format="dd-mm-yyyy" class="input-group date">
                                            <input id="end_date" name="end_date" type="text" class="form-control"
                                                autocomplete="off" value="{{ old('end_date') }}"/>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('end_date')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                   
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Add</button>
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
