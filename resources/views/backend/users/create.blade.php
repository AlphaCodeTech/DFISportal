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
                        <h1>Add User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add User</li>
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
                            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="surname">Surname</label>
                                        <input type="text" name="surname" class="form-control" id="surname"
                                            placeholder="Enter surname" value="{{ old('surname') }}">
                                    </div>
                                    @error('surname')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="middlename">Middlename</label>
                                        <input type="text" name="middlename" class="form-control" id="middlename"
                                            placeholder="Enter middlename" value="{{ old('middlename') }}">
                                    </div>
                                    @error('middlename')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" name="lastname" class="form-control" id="lastname"
                                            placeholder="Enter lastname" value="{{ old('lastname') }}">
                                    </div>
                                    @error('lastname')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter email" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Enter password" value="{{ old('password') }}">
                                    </div>
                                    @error('password')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="phone" name="phone" class="form-control" id="phone"
                                            placeholder="Enter phone number" value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" class="form-control" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old("gender") == 'male' ? "selected": "" }}>Male</option>
                                            <option value="female" {{ old("gender") == 'female' ? "selected": "" }}>Female</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">Select Status</option>
                                            <option value="active" {{ old("status") == 'active' ? "selected": "" }}>Active</option>
                                            <option value="inactive" {{ old("status") == 'inactive' ? "selected": "" }}>Inactive</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label>Date of Birth: </label>
                                        <div data-date="12-02-2012" data-date-format="dd-mm-yyyy" class="input-group date">
                                            <input id="dob" name="dob" type="text" class="form-control"
                                                autocomplete="off" value="{{ old('dob') }}"/>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('dob')
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
                                    <label for="category">Employee Category</label>
                                    <select name="category" class="form-control" id="category">
                                        <option value="">Employee Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category') ==  "$category->id" ? "selected": "" }}>{{ $category->surname ." " . $parent->middlename . " ". $parent->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="class_id">Class</label>
                                    <select name="class_id" class="form-control" id="class_id">
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == "$class->id" ? "selected": "" }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('class_id')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" placeholder="Enter Address">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                                <div class="form-group">
                                    <label for="photo">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="photo" class="custom-file-input"
                                                id="photo">
                                            <label class="custom-file-label" for="photo">Choose file</label>
                                        </div>

                                    </div>
                                </div>
                                @error('photo')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
