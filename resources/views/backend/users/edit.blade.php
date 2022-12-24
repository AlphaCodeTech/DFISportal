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
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                            <form method="POST" action="{{ route('user.update',$user->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="name">Surname</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter surname" value="{{ $user->name }}">
                                    </div>
                                    @error('name')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="middlename">Middlename</label>
                                        <input type="text" name="middlename" class="form-control" id="middlename"
                                            placeholder="Enter middlename" value="{{ $user->middlename }}">
                                    </div>
                                    @error('middlename')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" name="lastname" class="form-control" id="lastname"
                                            placeholder="Enter lastname" value="{{ $user->lastname }}">
                                    </div>
                                    @error('lastname')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter email" value="{{ $user->email }}">
                                    </div>
                                    @error('email')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="Enter phone number" value="{{ $user->phone }}">
                                    </div>
                                    @error('phone')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" class="form-control" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ $user->gender == 'male' ? "selected": "" }}>Male</option>
                                            <option value="female" {{ $user->gender == 'female' ? "selected": "" }}>Female</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">Select Status</option>
                                            <option value="1" {{ $user->status == 'active' ? "selected": "" }}>Active</option>
                                            <option value="0" {{ $user->status == 'inactive' ? "selected": "" }}>Inactive</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label>Date of Birth: </label>
                                        <div data-date="12-02-2012" data-date-format="dd-mm-yyyy" class="input-group date">
                                            <input id="dob" name="dob" type="text" class="form-control"
                                                autocomplete="off" value="{{ $user->dob }}"/>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('dob')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="bank">Bank</label> 
                                        <select name="bank" class="form-control" id="bank">
                                            <option value="">Select Bank</option>
                                            <option value="Access Bank Plc" {{ $user->bank == 'Access Bank Plc' ? "selected" : "" }}>Access Bank Plc</option>
                                            <option value="Citibank Nigeria Limited" {{ $user->bank == 'Citibank Nigeria Limited' ? "selected" : "" }}>Citibank Nigeria Limited</option>
                                            <option value="Diamond Bank Plc" {{ $user->bank == 'Diamond Bank Plc' ? "selected" : "" }}>Diamond Bank Plc</option>
                                            <option value="Ecobank Nigeria Plc" {{ $user->bank == 'Ecobank Nigeria Plc' ? "selected" : "" }}>Ecobank Nigeria Plc</option>
                                            <option value="Enterprise Bank" {{ $user->bank == 'Enterprise Bank' ? "selected" : "" }}>Enterprise Bank</option>
                                            <option value="Fidelity Bank Plc" {{ $user->bank == 'Fidelity Bank Plc' ? "selected" : "" }}>Fidelity Bank Plc</option>
                                            <option value="First Bank of Nigeria Plc" {{ $user->bank == 'First Bank of Nigeria Plc' ? "selected" : "" }}>First Bank of Nigeria Plc</option>
                                            <option value="First City Monument Bank Plc" {{ $user->bank == 'First City Monument Bank Plc' ? "selected" : "" }}>First City Monument Bank Plc</option>
                                            <option value="Guaranty Trust Bank Plc" {{ $user->bank == 'Guaranty Trust Bank Plc' ? "selected" : "" }}>Guaranty Trust Bank Plc</option>
                                            <option value="Heritage Banking Company Ltd" {{ $user->bank == 'Heritage Banking Company Ltd' ? "selected" : "" }}>Heritage Banking Company Ltd.</option>
                                            <option value="Key Stone Bank" {{ $user->bank == 'Key Stone Bank' ? "selected" : "" }}>Key Stone Bank</option>
                                            <option value="MainStreet Bank" {{ $user->bank == 'MainStreet Bank' ? "selected" : "" }}>MainStreet Bank</option>
                                            <option value="Skye Bank Plc" {{ $user->bank == 'Skye Bank Plc' ? "selected" : "" }}>Skye Bank Plc</option>
                                            <option value="Stanbic IBTC Bank Ltd" {{ $user->bank == 'Stanbic IBTC Bank Ltd' ? "selected" : "" }}>Stanbic IBTC Bank Ltd.</option>
                                            <option value="Standard Chartered Bank Nigeria Ltd" {{ $user->bank == 'Standard Chartered Bank Nigeria Ltd' ? "selected" : "" }}>Standard Chartered Bank Nigeria Ltd.</option>
                                            <option value="Sterling Bank Plc" {{ $user->bank == 'Sterling Bank Plc' ? "selected" : "" }}>Sterling Bank Plc</option>
                                            <option value="Union Bank of Nigeria Plc" {{ $user->bank == 'Union Bank of Nigeria Plc' ? "selected" : "" }}>Union Bank of Nigeria Plc</option>
                                            <option value="United Bank For Africa Plc" {{ $user->bank == 'United Bank For Africa Plc' ? "selected" : "" }}>United Bank For Africa Plc</option>
                                            <option value="Unity Bank Plc" {{ $user->bank == 'Unity Bank Plc' ? "selected" : "" }}>Unity Bank Plc</option>
                                            <option value="Wema Bank Plc" {{ $user->bank == 'Wema Bank Plc' ? "selected" : "" }}>Wema Bank Plc</option>
                                            <option value="Zenith Bank Plc" {{ $user->bank == 'Zenith Bank Plc' ? "selected" : "" }}>Zenith Bank Plc</option>
                                        </select>
                                    </div>
                                    @error('bank')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
    
                                    <div class="form-group">
                                        <label for="account_name">Account Name</label>
                                        <input type="text" name="account_name" class="form-control" id="account_name"
                                            placeholder="Enter account name" value="{{ $user->account_name }}">
                                    </div>
                                    @error('account_name')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group">
                                        <label for="account_number">Account Number</label>
                                        <input type="text" name="account_number" class="form-control" id="account_number"
                                            placeholder="Enter account number" value="{{ $user->account_number }}">
                                    </div>
                                    @error('account_number')
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
                                    @php
                                        $categories = App\Models\Category::all();
                                    @endphp
                                    <select name="category_id" class="form-control" id="category">
                                        <option value="">Employee Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $user->category_id ==  $category->id ? "selected": "" }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="level_id">Department</label>
                                        @php
                                            $levels = App\Models\Level::all();
                                        @endphp 
                                    <select name="level_id" class="form-control" id="class_id">
                                        <option value="">Select Department</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}" {{ $user->level_id == $level->id ? "selected" : "" }}>{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('level_id')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="religion">Religion</label> 
                                    <select name="religion" class="form-control" id="religion">
                                        <option value="">Select Religion</option>
                                        <option value="christainity" {{ $user->religion == 'christainity' ? "selected" : "" }}>Christainity</option>
                                        <option value="islam" {{ $user->religion == 'islam' ? "selected" : "" }}>Islam</option>
                                    </select>
                                </div>
                                @error('religion')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="marital_status">Marital Status</label> 
                                    <select name="marital_status" class="form-control" id="marital_status">
                                        <option value="">Select Marital Status</option>
                                        <option value="single" {{ $user->marital_status == 'single' ? "selected" : "" }}>Single</option>
                                        <option value="married" {{ $user->marital_status == 'married' ? "selected" : "" }}>Married</option>
                                    </select>
                                </div>
                                @error('marital_status')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="blood_group">Blood Group</label> 
                                    <select name="blood_group" class="form-control" id="blood_group">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+" {{ $user->blood_group == 'A+' ? "selected" : "" }}>A+</option>
                                        <option value="A-" {{ $user->blood_group == 'A-' ? "selected" : "" }}>A-</option>
                                        <option value="AB+" {{ $user->blood_group == 'AB+' ? "selected" : "" }}>AB+</option>
                                        <option value="AB-" {{ $user->blood_group == 'AB-' ? "selected" : "" }}>AB-</option>
                                        <option value="B+" {{ $user->blood_group == 'B+' ? "selected" : "" }}>B+</option>
                                        <option value="B-" {{ $user->blood_group == 'B-' ? "selected" : "" }}>B-</option>
                                        <option value="O+" {{ $user->blood_group == 'O+' ? "selected" : "" }}>O+</option>
                                        <option value="O-" {{ $user->blood_group == 'O-' ? "selected" : "" }}>O-</option>
                                    </select>
                                </div>
                                @error('blood_group')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="nationality">Nationality</label> 
                                    <select name="nationality" class="form-control" id="nationality">
                                        <option value="">Select Nationality</option>
                                        <option value="nigeria" {{ $user->nationality == 'nigeria' ? "selected" : "" }}>Nigeria</option>
                                        <option value="other" {{ $user->nationality == 'other' ? "selected" : "" }}>Other</option>
                                    </select>
                                </div>
                                @error('nationality')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                             <div class="form-group">
                                    <label for="qualification">Qualification</label> 
                                    <select name="qualification" class="form-control" id="qualification">
                                        <option value="">Select Qualification</option>
                                        <option value="Bsc" {{ $user->qualification == 'Bsc' ? "selected" : "" }}>Bsc</option>
                                        <option value="Msc" {{ $user->qualification == 'Msc' ? "selected" : "" }}>Msc</option>
                                        <option value="HND" {{ $user->qualification == 'HND' ? "selected" : "" }}>Hnd</option>
                                        <option value="OND" {{ $user->qualification == 'OND' ? "selected" : "" }}>Ond</option>
                                        <option value="NCE" {{ $user->qualification == 'NCE' ? "selected" : "" }}>Nce</option>
                                        <option value="BA" {{ $user->qualification == 'BA' ? "selected" : "" }}>Ba</option>
                                        <option value="PGDE" {{ $user->qualification == 'PGDE' ? "selected" : "" }}>Pgde</option>
                                        <option value="PROF" {{ $user->qualification == 'PROF' ? "selected" : "" }}>Prof</option>
                                        <option value="DR" {{ $user->qualification == 'DR' ? "selected" : "" }}>Dr</option>
                                        <option value="KCPE" {{ $user->qualification == 'KCPE' ? "selected" : "" }}>Kcpe</option>
                                        <option value="KCSE" {{ $user->qualification == 'KCSE' ? "selected" : "" }}>Kcse</option>
                                        <option value="UNDERGRADUATE" {{ $user->qualification == 'UNDERGRADUATE' ? "selected" : "" }}>Undergraduate</option>
                                        <option value="ECDE" {{ $user->qualification == 'ECDE' ? "selected" : "" }}>Ecde</option>
                                    </select>
                                </div>
                                @error('qualification')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" placeholder="Enter Address">{{ $user->address }}</textarea>
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
