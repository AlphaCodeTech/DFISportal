@extends('backend.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Fee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Fee</li>
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
                            <form method="POST" action="{{ route('fees.update',$fee->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="full_fees">Full Payment</label>
                                        <input type="text" name="full_fees" class="form-control" id="full_fees"
                                            placeholder="Enter Full Payment" value="{{ $fee->full_fees }}">
                                    </div>
                                    @error('full_fees')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                   
                                    <div class="form-group">
                                        <label for="part_fees">Part Payment</label>
                                        <input type="text" name="part_fees" class="form-control" id="part_fees"
                                            placeholder="Enter Part Payment" value="{{ $fee->part_fees }}">
                                    </div>
                                    @error('part_fees')
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
