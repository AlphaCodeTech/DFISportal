<div>

    @push('extra-css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Users</li>
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

                                <ul class="nav nav-tabs nav-tabs-highlight">
                                    @can('create user')
                                        <a role="button" class="btn btn-primary" href="#" wire:click='create'>Add
                                            User</a>
                                    @endcan
                                    <a href="#" class="nav-link dropdown-toggle ml-4" data-toggle="dropdown">Filter
                                        Users</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a wire:click="getAllUsers" class="dropdown-item">All Users</a>
                                        @foreach ($roles as $role)
                                            <a wire:click='reloadInfo("{{ $role->name }}")' class="dropdown-item"
                                                data-toggle="tab">{{ Str::ucfirst($role->name) }}</a>
                                        @endforeach
                                    </div>
                                    </li>
                                </ul>
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
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->staff_ID }}</td>
                                                <td>
                                                    @if ($user->roles)
                                                        @foreach ($user->roles as $item)
                                                            <button
                                                                class="btn btn-sm btn-warning font-weight-bold text-capitalize">{{ $item->name }}</button>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="text-center"><img class="img-thumbnail"
                                                        src="{{ asset($user->photo) }}" alt="{{ $user->name }}"
                                                        style="width: 100px; height: 100px;"></td>
                                                <td class="d-flex"
                                                    style="justify-content: space-evenly; padding-right: 0;">
                                                    @can('edit user')
                                                        <a title="edit" wire:click="edit({{ $user->id }})"
                                                            role="button" class="btn btn-success"><i
                                                                class="fas fa-edit"></i></a>
                                                    @endcan
                                                    <button wire:click="show({{ $user->id }})" role="button"
                                                        class="btn btn-warning"><i class="fas fa-eye"
                                                            title="view user"></i></button>
                                                    @can('delete user')
                                                        <button wire:click='confirmDelete({{ $user->id }})'
                                                            title="delete" type="submit" role="button"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach

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

    <div class="modal fade" id="form" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $isEditing ? 'Edit User' : 'Add New User' }}</h4>
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
                                    <form method="POST" wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}"
                                        enctype="multipart/form-data">
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

                                            @if (!$isEditing)
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input wire:model.defer='state.password' name="password"
                                                        type="password"
                                                        class="form-control  @error('password') is-invalid @enderror"
                                                        id="password" placeholder="Enter password">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input wire:model.defer='state.password_confirmation'
                                                        type="password" name="password_confirmation"
                                                        class="form-control  @error('password') is-invalid @enderror"
                                                        id="confirm_password" placeholder="Confirm password">
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select wire:model.defer="state.status"
                                                    class="form-control  @error('status') is-invalid @enderror"
                                                    id="status">
                                                    <option value="">Select Status</option>
                                                    <option value="1"
                                                        @if ($isEditing) {{ $state['status'] == '1' ? 'selected' : '' }}@else {{ old('status') == '1' ? 'selected' : '' }} @endif>
                                                        Active</option>
                                                    <option value="0"
                                                        @if ($isEditing) {{ $state['status'] == '0' ? 'selected' : '' }}@else {{ old('status') == '0' ? 'selected' : '' }} @endif>
                                                        Inactive</option>
                                                </select>
                                                @error('status')
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
                                            <label for="category">Employee Department</label>
                                            @php
                                                $departments = App\Models\Department::all();
                                            @endphp
                                            <select wire:model.defer='state.department_id'
                                                class="form-control  @error('department_id') is-invalid @enderror"
                                                id="category">
                                                <option value="">Employee Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="level_id">Category</label>
                                            @php
                                                $levels = App\Models\Level::all();
                                            @endphp
                                            <select wire:model.defer='state.level_id' name="level_id"
                                                class="form-control  @error('level_id') is-invalid @enderror"
                                                id="class_id">
                                                <option value="">Select Category</option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}"
                                                        {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('level_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="role">Role or Postion</label>

                                            @foreach ($roles as $ro)
                                                <div class="form-check">
                                                    <input wire:model.defer='rl' class="form-check-input"
                                                        type="checkbox" value="{{ $ro->id }}"
                                                        {{ $isEditing ? (in_array($ro->id, $rl) ? 'checked' : '') : '' }}>
                                                    <label
                                                        class="form-check-label font-weight-bold">{{ $ro->name }}</label>
                                                </div>
                                            @endforeach

                                            @error('rl')
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
                                                <div class=" alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="card-footer text-right">
                                            <button type="submit"
                                                class="btn btn-primary">{{ $isEditing ? 'Update' : 'Create' }}</button>
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
                                                        class="btn btn-sm btn-warning font-weight-bold text-capitalize">{{ $role->name }}</button>
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

                                                {{ ucwords(optional($selectedUser->department)->name) }}

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Category</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedUser->level)->name) }}
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
        <script src="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js') }}"></script>
        <script>
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                //Date picker
                $('#dob').datepicker();
                $('#admission_date').datepicker();

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
