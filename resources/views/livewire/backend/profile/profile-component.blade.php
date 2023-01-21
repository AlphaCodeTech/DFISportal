<div>

    @push('extra-css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css  ') }}">
        {{-- <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet"
            href="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/css/datepicker.css') }}">
        <!-- Theme style -->
    @endpush


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <a role="button" class="btn btn-success" href="#"
                                    wire:click='edit({{ auth()->id() }})'>Update Profile</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>ID Number</th>
                                            <th>Role</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $users->name }}</td>
                                            <td>{{ $users->staff_ID }}</td>
                                            <td>
                                                @if ($users->roles)
                                                    @foreach ($users->roles as $item)
                                                        <button
                                                            class="btn btn-sm btn-warning font-weight-bold">{{ $item->name }}</button>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center"><img class="img-thumbnail"
                                                    src="{{ asset($users->photo) }}" alt="{{ $users->name }}"
                                                    style="width: 100px; height: 100px;"></td>
                                            <td class="d-flex" style="justify-content: space-evenly; padding-right: 0;">
                                                <button wire:click="show({{ $users->id }})" role="button"
                                                    class="btn btn-warning"><i class="fas fa-eye"
                                                        title="view user"></i></button>
                                            </td>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>ID Number</th>
                                            <th>Role</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="profile" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-6">
                                <!-- general form elements -->
                                <div class="card card-primary">

                                    <!-- form start -->
                                    <form method="POST" wire:submit.prevent='update' enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label for="name">Fullname</label>
                                                <input wire:model.defer='state.name' type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="name" placeholder="Enter surname"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input wire:model.defer='state.email' type="email"
                                                    class="form-control  @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Enter email"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="email">Phone</label>
                                                <input wire:model.defer='detail.phone' type="text"
                                                    class="form-control  @error('phone') is-invalid @enderror"
                                                    id="phone" placeholder="Enter phone"
                                                    value="{{ optional(auth()->user()->detail)->phone }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Gender</label>
                                                <select wire:model.defer="detail.gender"
                                                    class="form-control  @error('gender') is-invalid @enderror"
                                                    id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male"
                                                        {{ optional(auth()->user()->detail)->gender == 'male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="female"
                                                        {{ optional(auth()->user()->detail)->gender == 'female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="bank">Bank</label>
                                                <select wire:model.defer="detail.bank"
                                                    class="form-control  @error('bank') is-invalid @enderror"
                                                    id="bank">
                                                    <option value="">Select Bank</option>
                                                    <option value="Access Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Access Bank Plc' ? 'selected' : '' }}>
                                                        Access
                                                        Bank Plc</option>
                                                    <option value="Citibank Nigeria Limited"
                                                        {{ optional(auth()->user()->detail)->bank == 'Citibank Nigeria Limited' ? 'selected' : '' }}>
                                                        Citibank Nigeria Limited</option>
                                                    <option value="Diamond Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Diamond Bank Plc' ? 'selected' : '' }}>
                                                        Diamond Bank Plc</option>
                                                    <option value="Ecobank Nigeria Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Ecobank Nigeria Plc' ? 'selected' : '' }}>
                                                        Ecobank Nigeria Plc</option>
                                                    <option value="Enterprise Bank"
                                                        {{ optional(auth()->user()->detail)->bank == 'Enterprise Bank' ? 'selected' : '' }}>
                                                        Enterprise Bank</option>
                                                    <option value="Fidelity Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Fidelity Bank Plc' ? 'selected' : '' }}>
                                                        Fidelity Bank Plc</option>
                                                    <option value="First Bank of Nigeria Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'First Bank of Nigeria Plc' ? 'selected' : '' }}>
                                                        First Bank of Nigeria Plc</option>
                                                    <option value="First City Monument Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'First City Monument Bank Plc' ? 'selected' : '' }}>
                                                        First City Monument Bank Plc</option>
                                                    <option value="Guaranty Trust Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Guaranty Trust Bank Plc' ? 'selected' : '' }}>
                                                        Guaranty Trust Bank Plc</option>
                                                    <option value="Heritage Banking Company Ltd"
                                                        {{ optional(auth()->user()->detail)->bank == 'Heritage Banking Company Ltd' ? 'selected' : '' }}>
                                                        Heritage Banking Company Ltd.</option>
                                                    <option value="Key Stone Bank"
                                                        {{ optional(auth()->user()->detail)->bank == 'Key Stone Bank' ? 'selected' : '' }}>
                                                        Key
                                                        Stone Bank</option>
                                                    <option value="MainStreet Bank"
                                                        {{ optional(auth()->user()->detail)->bank == 'MainStreet Bank' ? 'selected' : '' }}>
                                                        MainStreet Bank</option>
                                                    <option value="Skye Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Skye Bank Plc' ? 'selected' : '' }}>
                                                        Skye
                                                        Bank Plc</option>
                                                    <option value="Stanbic IBTC Bank Ltd"
                                                        {{ optional(auth()->user()->detail)->bank == 'Stanbic IBTC Bank Ltd' ? 'selected' : '' }}>
                                                        Stanbic IBTC Bank Ltd.</option>
                                                    <option value="Standard Chartered Bank Nigeria Ltd"
                                                        {{ optional(auth()->user()->detail)->bank == 'Standard Chartered Bank Nigeria Ltd' ? 'selected' : '' }}>
                                                        Standard Chartered Bank Nigeria Ltd.</option>
                                                    <option value="Sterling Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Sterling Bank Plc' ? 'selected' : '' }}>
                                                        Sterling Bank Plc</option>
                                                    <option value="Union Bank of Nigeria Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Union Bank of Nigeria Plc' ? 'selected' : '' }}>
                                                        Union Bank of Nigeria Plc</option>
                                                    <option value="United Bank For Africa Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'United Bank For Africa Plc' ? 'selected' : '' }}>
                                                        United Bank For Africa Plc</option>
                                                    <option value="Unity Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Unity Bank Plc' ? 'selected' : '' }}>
                                                        Unity
                                                        Bank Plc</option>
                                                    <option value="Wema Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Wema Bank Plc' ? 'selected' : '' }}>
                                                        Wema
                                                        Bank Plc</option>
                                                    <option value="Zenith Bank Plc"
                                                        {{ optional(auth()->user()->detail)->bank == 'Zenith Bank Plc' ? 'selected' : '' }}>
                                                        Zenith
                                                        Bank Plc</option>
                                                </select>
                                                @error('bank')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="account_name">Account Name</label>
                                                <input wire:model.defer='detail.account_name' type="text"
                                                    class="form-control  @error('account_name') is-invalid @enderror"
                                                    id="account_name" placeholder="Enter account Name"
                                                    value="{{ optional(auth()->user()->detail)->account_name }}">
                                                @error('account_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="account_number">Account Number</label>
                                                <input wire:model.defer='detail.account_number' type="text"
                                                    class="form-control  @error('account_number') is-invalid @enderror"
                                                    id="account_number" placeholder="Enter account Number"
                                                    value="{{ optional(auth()->user()->detail)->account_number }}">
                                                @error('account_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input wire:model.defer='state.password' name="password"
                                                    type="password"
                                                    class="form-control  @error('password') is-invalid @enderror"
                                                    id="password" placeholder="Enter password"
                                                    autocomplete="new-password">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input wire:model.defer='state.password_confirmation' type="password"
                                                    name="password_confirmation"
                                                    class="form-control  @error('password') is-invalid @enderror"
                                                    id="confirm_password" placeholder="Confirm password">
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

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
                                            <label>Date of Birth: </label>
                                            <div data-date="12-02-2012" data-date-format="dd-mm-yyyy"
                                                class="input-group date  @error('dob') is-invalid @enderror">
                                                <input id="dob" wire:model.defer='detail.dob' type="text"
                                                    class="form-control" autocomplete="off"
                                                    value="{{ optional(auth()->user()->detail)->dob }}" />
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                @error('dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="status">Religion</label>
                                            <select wire:model.defer="detail.religion"
                                                class="form-control  @error('religion') is-invalid @enderror"
                                                id="religion">
                                                <option value="">Select Religion</option>
                                                <option value="christainity"
                                                    {{ optional(auth()->user()->detail)->religion == 'christainity' ? 'selected' : '' }}>
                                                    Christainity</option>
                                                <option value="islam"
                                                    {{ optional(auth()->user()->detail)->religion == 'islam' ? 'selected' : '' }}>
                                                    Islam
                                                </option>
                                            </select>
                                            @error('religion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="marital_status">Marital Status</label>
                                            <select wire:model.defer="detail.marital_status"
                                                class="form-control  @error('marital_status') is-invalid @enderror"
                                                id="marital_status">
                                                <option value="">Select Marital Status</option>
                                                <option value="single"
                                                    {{ optional(auth()->user()->detail)->marital_status == 'single' ? 'selected' : '' }}>
                                                    Single</option>
                                                <option value="married"
                                                    {{ optional(auth()->user()->detail)->marital_status == 'married' ? 'selected' : '' }}>
                                                    Married
                                                </option>
                                            </select>
                                            @error('marital_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="marital_status">Blood Group</label>
                                            <select wire:model.defer="detail.blood_group"
                                                class="form-control  @error('blood_group') is-invalid @enderror"
                                                id="blood_group">
                                                <option value="">Select Blood Group</option>
                                                <option value="A+"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'A+' ? 'selected' : '' }}>
                                                    A+
                                                </option>
                                                <option value="A-"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'A-' ? 'selected' : '' }}>
                                                    A-
                                                </option>
                                                <option value="AB+"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'AB+' ? 'selected' : '' }}>
                                                    AB+
                                                </option>
                                                <option value="AB-"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'AB-' ? 'selected' : '' }}>
                                                    AB-
                                                </option>
                                                <option value="B+"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'B+' ? 'selected' : '' }}>
                                                    B+
                                                </option>
                                                <option value="B-"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'B-' ? 'selected' : '' }}>
                                                    B-
                                                </option>
                                                <option value="O+"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'O+' ? 'selected' : '' }}>
                                                    O+
                                                </option>
                                                <option value="O-"
                                                    {{ optional(auth()->user()->detail)->blood_group == 'O-' ? 'selected' : '' }}>
                                                    O-
                                                </option>
                                            </select>
                                            @error('blood_group')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="nationality">Nationality</label>
                                            <select wire:model.defer="detail.nationality"
                                                class="form-control  @error('nationality') is-invalid @enderror"
                                                id="nationality">
                                                <option value="">Select Nationality</option>
                                                <option value="nigeria"
                                                    {{ optional(auth()->user()->detail)->nationality == 'nigeria' ? 'selected' : '' }}>
                                                    Nigeria</option>
                                                <option value="other"
                                                    {{ optional(auth()->user()->detail)->nationality == 'other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('nationality')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="nationality">Qualification</label>
                                            <select wire:model.defer="detail.qualification"
                                                class="form-control  @error('qualification') is-invalid @enderror"
                                                id="qualification">
                                                <option value="">Select Qualification</option>
                                                <option value="Bsc"
                                                    {{ optional(auth()->user()->detail)->qualification == 'Bsc' ? 'selected' : '' }}>
                                                    Bsc
                                                </option>
                                                <option value="Msc"
                                                    {{ optional(auth()->user()->detail)->qualification == 'Msc' ? 'selected' : '' }}>
                                                    Msc
                                                </option>
                                                <option value="HND"
                                                    {{ optional(auth()->user()->detail)->qualification == 'HND' ? 'selected' : '' }}>
                                                    Hnd
                                                </option>
                                                <option value="OND"
                                                    {{ optional(auth()->user()->detail)->qualification == 'OND' ? 'selected' : '' }}>
                                                    Ond
                                                </option>
                                                <option value="NCE"
                                                    {{ optional(auth()->user()->detail)->qualification == 'NCE' ? 'selected' : '' }}>
                                                    Nce
                                                </option>
                                                <option value="BA"
                                                    {{ optional(auth()->user()->detail)->qualification == 'BA' ? 'selected' : '' }}>
                                                    Ba
                                                </option>
                                                <option value="PGDE"
                                                    {{ optional(auth()->user()->detail)->qualification == 'PGDE' ? 'selected' : '' }}>
                                                    Pgde
                                                </option>
                                                <option value="PROF"
                                                    {{ optional(auth()->user()->detail)->qualification == 'PROF' ? 'selected' : '' }}>
                                                    Prof
                                                </option>
                                                <option value="DR"
                                                    {{ optional(auth()->user()->detail)->qualification == 'DR' ? 'selected' : '' }}>
                                                    Dr
                                                </option>
                                                <option value="KCPE"
                                                    {{ optional(auth()->user()->detail)->qualification == 'KCPE' ? 'selected' : '' }}>
                                                    Kcpe
                                                </option>
                                                <option value="KCSE"
                                                    {{ optional(auth()->user()->detail)->qualification == 'KCSE' ? 'selected' : '' }}>
                                                    Kcse
                                                </option>
                                                <option value="UNDERGRADUATE"
                                                    {{ optional(auth()->user()->detail)->qualification == 'UNDERGRADUATE' ? 'selected' : '' }}>
                                                    Undergraduate
                                                </option>
                                                <option value="ECDE"
                                                    {{ optional(auth()->user()->detail)->qualification == 'ECDE' ? 'selected' : '' }}>
                                                    Ecde
                                                </option>
                                            </select>
                                            @error('qualification')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea wire:model.defer='detail.address' class="form-control  @error('address') is-invalid @enderror" name="address" id="address"
                                                placeholder="Enter Address">{{ optional(auth()->user()->detail)->address }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="photo">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input wire:model.defer='photo' type="file"
                                                        class="custom-file-input  @error('photo') is-invalid @enderror"
                                                        id="photo">
                                                    <label class="custom-file-label" for="photo">Choose
                                                        file</label>
                                                </div>

                                            </div>
                                            @error('photo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        {{--
                                        <livewire:user.user-permission-component /> --}}


                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary">Update</button>
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
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="view">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="{{ asset($selectedUser->photo ?? '') }}"
                                                alt="{{ $selectedUser->name ?? '' }}" class="rounded-circle"
                                                width="150">
                                            <div class="mt-3">
                                                <h4>{{ $selectedUser->name ?? '' }}
                                                </h4>
                                                <p class="text-secondary mb-1">
                                                    {{ $selectedUser->staff_ID ?? '' }}
                                                </p>
                                                <p class="text-muted font-size-sm font-weight-bold">
                                                    {{ $selectedUser->roles[0]->name ?? '' }}
                                                </p>
                                                <button class="btn btn-primary">
                                                    Transfer
                                                </button>
                                                <button class="btn btn-outline-primary">Status</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body text-left">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Full Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords($selectedUser->name) ?? '' }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords($selectedUser->email) ?? '' }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Roles</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                @foreach ($selectedUser->roles as $role)
                                                    <button
                                                        class="btn btn-sm btn-warning font-weight-bold">{{ $role->name }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Permissions</h6>
                                            </div>
                                            
                                            <div class="col-sm-9 text-secondary">
                                                @foreach ($selectedUser->getAllPermissions() as $perm)
                                                    <button
                                                        class="btn btn-sm btn-warning font-weight-bold text-capitalize">{{ $perm->name }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Staff ID</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords($selectedUser->staff_ID) ?? '' }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Gender</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucfirst(optional($selectedUser->detail)->gender) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Date of Birth</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedUser->detail)->dob }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Phone</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedUser->detail)->phone }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Department</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                
                                               {{  ucwords(optional($selectedUser->department)->name) }}
                                                
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Category</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{
                                                ucwords(optional($selectedUser->level)->name
                                                . ' Staff') }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Religion</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->religion) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Marital Status</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->marital_status) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Blood Group</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->blood_group) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Nationality</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->nationality) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Qualification</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->qualification) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Bank</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->bank) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Account Number</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->account_number) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Account Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->account_name) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->detail)->address) }}
                                            </div>
                                        </div>
                                        <hr>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    @push('extra-js')
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/sweetalert.min.js') }}"></script>
        <!-- bs-custom-file-input -->
        <script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

        <script>
            $(function() {
                bsCustomFileInput.init();
            });
        </script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js') }}">
        </script>
        <script>
            $(function() {
                $('.select2').select2({
                    dropdownParent: $('#form')
                });
                //Initialize Select2 Elements
                // $('.select2').select2()

                //Initialize Select2 Elements
                // $('.select2bs4').select2({
                //     theme: 'bootstrap4'
                // })

                //Date picker
                $('#dob').datepicker();
                $('#admission_date').datepicker();

                $('#dob').on('change', function(e) {
                    @this.set('detail.dob', e.target.value);
                });

                setTimeout(() => {
                    $(".alert").hide('slow');
                }, 5000);

            });
        </script>

        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>
    @endpush
</div>
