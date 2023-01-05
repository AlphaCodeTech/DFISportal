@extends('backend.layouts.app')

@push('extra-css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
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
                        <h1>Add Guardian</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add Guardian</li>
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
                            <form method="POST" action="{{ route('parent.store') }}" enctype="multipart/form-data">
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
                                        <label for="email">Email</label>
                                        <input type="text" name="email" class="form-control" id="email"
                                            placeholder="Enter email" value="{{ old('email')  }}">
                                    </div>
                                    @error('email')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="Enter phone" value="{{ old('phone')  }}">
                                    </div>
                                    @error('phone')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" name="state" class="form-control" id="state"
                                            placeholder="Enter state" value="{{ old('state')  }}">
                                    </div>
                                    @error('state')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="lga">LGA</label>
                                        <input type="text" name="lga" class="form-control" id="lga"
                                            placeholder="Enter local Govt of Origin" value="{{ old('lga')  }}">
                                    </div>
                                    @error('lga')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="religion">Religion</label>
                                       <input name="religion" class="form-control" type="text" value="{{ old('religion')  }}">
                                    </div>
                                    @error('religion')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="nationality">Nationality</label>
                                       <input name="nationality" class="form-control" type="text" value="{{ old('nationality')  }}">
                                    </div>
                                    @error('nationality')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                    

                                </div>
                                <!-- /.card-body -->

                        </div>
                        <!-- /.card -->

                    </div>
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="occupation">Occupation</label>
                                   <input name="occupation" class="form-control" type="text" value="{{ old('occupation')  }}">
                                </div>
                                @error('occupation')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

        
                                <div class="form-group">
                                    <label for="relationship">Relationship With Ward</label>
                                   <input name="relationship" class="form-control" type="text" value="{{ old('relationship')  }}">
                                </div>
                                @error('relationship')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label>Residential Address </label>
                                   <textarea class="form-control" name="residential_address">{{ old('residential_address')  }}</textarea>
                                </div>
                                @error('residential_address')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label>Business Address </label>
                                   <textarea class="form-control" name="business_address">{{ old('business_address')  }}</textarea>
                                </div>
                                @error('business_address')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label>Family History </label>
                                   <textarea class="form-control" name="family_history">{{ old('family_history')  }}</textarea>
                                </div>
                                @error('family_history')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>

                            </div>
                            <!-- /.card-body -->


                            </form>
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
    {{-- <script src="{{ asset('backend/plugins/moment/moment.min.js')}}"></script> --}}
    {{-- <script src="{{ asset('backend/plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
    <script src="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js') }}"></script>
    <script>
        $(function() {
            //Date picker
            $('#dob').datepicker();
            $('#admission_date').datepicker();

            setTimeout(() => {
                $(".alert").hide('slow');
            }, 5000);

        });
    </script>
@endpush
