@extends('backend.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Level</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Level</li>
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
                            <form method="POST" action="{{ route('level.update',$level->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter name" value="{{ $level->name }}">
                                    </div>
                                    @error('name')
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
