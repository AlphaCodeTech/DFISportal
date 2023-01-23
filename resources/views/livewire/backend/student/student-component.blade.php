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

        <style>
            .cmn-toggle {
                position: absolute;
                margin-left: -9999px;
                visibility: hidden;
            }

            .cmn-toggle+label {
                /* display: block; */
                position: relative;
                cursor: pointer;
                outline: none;
                user-select: none;
            }

            input.cmn-toggle-round+label {
                padding: 2px;
                width: 100px;
                height: 45px;
                background-color: #dddddd;
                border-radius: 40px;
            }

            input.cmn-toggle-round+label:before,
            input.cmn-toggle-round+label:after {
                display: block;
                position: absolute;
                top: 1px;
                left: 1px;
                bottom: 1px;
                content: "";
            }

            input.cmn-toggle-round+label:before {
                right: 1px;
                background-color: #f20c0c;
                border-radius: 50px;
                transition: background 0.4s;
            }

            input.cmn-toggle-round+label:after {
                width: 45px;
                background-color: #fff;
                border-radius: 100%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                transition: margin 0.4s;
            }

            input.cmn-toggle-round:checked+label:before {
                background-color: #8ce196;
            }

            input.cmn-toggle-round:checked+label:after {
                margin-left: 60px;
            }
        </style>
    @endpush


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Students</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Students</li>
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
                                @can('create student')
                                    <a role="button" class="btn btn-primary" href="#" wire:click='create'>Add
                                        Student</a>
                                @endcan
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Admission Number</th>
                                            <th>Class</th>
                                            <th>Photo</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td class="text-capitalize">
                                                    {{ $student->surname . ' ' . $student->middlename . ' ' . $student->lastname }}
                                                </td>
                                                <td>{{ $student->admno }}</td>
                                                <td>{{ $student->class->name }}</td>
                                                <td class="text-center"><img class="img-thumbnail"
                                                        src="{{ asset($student->photo) }}" alt="{{ $student->name }}"
                                                        style="width: 100px; height: 100px;"></td>
                                                <td class="text-center">
                                                    <livewire:backend.status-button :model="$student" field="status"
                                                        key="{{ $student->id }}">
                                                </td>
                                                <td class="d-flex"
                                                    style="justify-content: space-evenly; padding-right: 0;">
                                                    @can('edit student')
                                                        <a title="edit" wire:click="edit({{ $student }})"
                                                            role="button" class="btn btn-success"><i
                                                                class="fas fa-edit"></i></a>
                                                    @endcan
                                                    <button wire:click="show({{ $student }})" role="button"
                                                        class="btn btn-warning"><i class="fas fa-eye"
                                                            title="view student"></i></button>
                                                    @can('delete student')
                                                        <button wire:click='confirmDelete({{ $student->id }})'
                                                            title="delete" type="submit" role="button"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                    @endcan

                                                    @can('promote student')
                                                        <button wire:click='showPromote({{ $student->id }})'
                                                            title="promote" type="submit" role="button"
                                                            class="btn btn-info"><i
                                                                class="fas fa-level-up-alt"></i></button>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Admission Number</th>
                                            <th>Class</th>
                                            <th>Photo</th>
                                            <th>Status</th>
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
                    <h4 class="modal-title">{{ $isEditing ? 'Edit Student' : 'Add New Student' }}</h4>
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
                                                <label for="surname">Surname</label>
                                                <input type="text" wire:model.defer='state.surname'
                                                    class="form-control @error('surname') is-invalid @enderror"
                                                    id="surname" placeholder="Enter surname"
                                                    value="{{ old('surname') }}">
                                                @error('surname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="middlename">Middlename</label>
                                                <input wire:model.defer='state.middlename' type="text"
                                                    class="form-control @error('middlename') is-invalid @enderror"
                                                    id="middlename" placeholder="Enter middlename"
                                                    value="{{ old('middlename') }}">
                                                @error('middlename')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="lastname">Lastname</label>
                                                <input wire:model.defer='state.lastname' type="text"
                                                    class="form-control @error('lastname') is-invalid @enderror"
                                                    id="lastname" placeholder="Enter lastname"
                                                    value="{{ old('lastname') }}">
                                                @error('lastname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select wire:model.defer='state.gender'
                                                    class="form-control @error('status') is-invalid @enderror"
                                                    id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male"
                                                        {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="female"
                                                        {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                                    </option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="blood_group">Blood Group</label>
                                                <select wire:model.defer='state.blood_group'
                                                    class="form-control @error('blood_group') is-invalid @enderror">
                                                    <label for="blood_group">Blood Group</label>
                                                    <option value="">Blood Group</option>
                                                    <option value="A+"
                                                        {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A RhD
                                                        Positive (A+) </option>
                                                    <option value="A-"
                                                        {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-
                                                        RhD
                                                        Negative (A-) </option>
                                                    <option value="B+"
                                                        {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+
                                                        RhD
                                                        Positive (B+) </option>
                                                    <option value="B-"
                                                        {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-
                                                        RhD
                                                        Negative (B-) </option>
                                                    <option value="O+"
                                                        {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+
                                                        RhD
                                                        Positive (O+) </option>
                                                    <option value="O-"
                                                        {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-
                                                        RhD
                                                        Negative (O-) </option>
                                                    <option value="AB+"
                                                        {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+
                                                        RhD
                                                        Positive (AB+) </option>
                                                    <option value="AB-"
                                                        {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-
                                                        RhD
                                                        Negative (AB-) </option>
                                                </select>
                                                @error('blood_group')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select wire:model.defer='state.status'
                                                    class="form-control @error('status') is-invalid @enderror"
                                                    id="status">
                                                    <option value="">Select Status</option>
                                                    <option value="1"
                                                        {{ old('status') == '1' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0"
                                                        {{ old('status') == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="genotype">Genotype</label>
                                                <select wire:model.defer='state.genotype'
                                                    class="form-control @error('genotype') is-invalid @enderror"
                                                    id="genotype">
                                                    <option value="">Select Genotype</option>
                                                    <option value="AA"
                                                        {{ old('genotype') == 'AA' ? 'selected' : '' }}>AA
                                                    </option>
                                                    <option value="AS"
                                                        {{ old('genotype') == 'AS' ? 'selected' : '' }}>AS
                                                    </option>
                                                    <option value="AC"
                                                        {{ old('genotype') == 'AC' ? 'selected' : '' }}>AC
                                                    </option>
                                                    <option value="SS"
                                                        {{ old('genotype') == 'SS' ? 'selected' : '' }}>SS
                                                    </option>
                                                    <option value="SC"
                                                        {{ old('genotype') == 'SC' ? 'selected' : '' }}>SC
                                                    </option>
                                                </select>
                                                @error('genotype')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="introducer">Who Introduced Him</label>
                                                <input type="text" wire:model.defer='state.introducer'
                                                    class="form-control @error('introducer') is-invalid @enderror"
                                                    id="introducer" value="{{ old('introducer') }}">
                                                @error('introducer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="driver">Driver</label>
                                                <input type="text" wire:model.defer='state.driver'
                                                    class="form-control @error('driver') is-invalid @enderror"
                                                    id="driver" value="{{ old('driver') }}">
                                                @error('driver')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label>Date of Birth: </label>
                                                <div data-date="12-02-2012" data-date-format="dd-mm-yyyy"
                                                    class="input-group date">
                                                    <input wire:model.defer='state.dob' id="dob" type="text"
                                                        class="form-control @error('dob') is-invalid @enderror"
                                                        autocomplete="off" value="{{ old('dob') }}" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('dob')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
                                            <label>Admission Date</label>
                                            <div data-date="12-02-2012" data-date-format="dd-mm-yyyy"
                                                class="input-group date">
                                                <input wire:model.defer='state.admission_date' id="admission_date"
                                                    type="text"
                                                    class="form-control @error('admission_date') is-invalid @enderror"
                                                    autocomplete="off" value="{{ old('admission_date') }}" />
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @error('admission_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="parent_id">Guardian</label>
                                            <select wire:model.defer='state.parent_id'
                                                class="form-control @error('parent_id') is-invalid @enderror"
                                                id="parent_id">
                                                <option value="">Guardian</option>
                                                @foreach ($parents as $parent)
                                                    <option value="{{ $parent->id }}"
                                                        {{ old('parent_id') == "$parent->id" ? 'selected' : '' }}>
                                                        {{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="class_id">Class</label>
                                            <select wire:model.defer='state.class_id'
                                                class="form-control @error('class_id') is-invalid @enderror"
                                                id="class_id">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('class_id') == "$class->id" ? 'selected' : '' }}>
                                                        {{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="allergies">Allergies</label>
                                            <input type="text" wire:model.defer='state.allergies'
                                                class="form-control @error('allergies') is-invalid @enderror"
                                                id="allergies" placeholder="Enter allergies"
                                                value="{{ old('allergies') }}">
                                            @error('allergies')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="disabilities">Disabilities</label>
                                            <input type="text" wire:model.defer='state.disabilities'
                                                class="form-control @error('disabilities') is-invalid @enderror"
                                                id="disabilities" placeholder="Enter disabilities"
                                                value="{{ old('disabilities') }}">
                                        </div>
                                        @error('disabilities')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="prevSchool">Previous School</label>
                                            <input type="text" wire:model.defer='state.prevSchool'
                                                class="form-control @error('prevSchool') is-invalid @enderror"
                                                id="prevSchool" placeholder="Enter previous School"
                                                value="{{ old('prevSchool') }}">
                                        </div>
                                        @error('prevSchool')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="reason">Reason For Leaving Your Formal School</label>
                                            <textarea wire:model.defer='state.reason' class="form-control @error('reason') is-invalid @enderror" id="reason">{{ old('reason') }}</textarea>
                                        </div>
                                        @error('reason')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror


                                        <div class="form-group">
                                            <label for="photo">Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" wire:model.defer='photo'
                                                        class="custom-file-input @error('photo') is-invalid @enderror"
                                                        id="photo">
                                                    <label class="custom-file-label" for="photo">Choose
                                                        file</label>
                                                </div>

                                            </div>
                                        </div>
                                        @error('photo')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="birth_certificate">Birth Certificate if Available</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" wire:model.defer='birth_certificate'
                                                        class="custom-file-input @error('birth_certificate') is-invalid @enderror"
                                                        id="birth_certificate">
                                                    <label class="custom-file-label" for="birth_certificate">Choose
                                                        file</label>
                                                </div>

                                            </div>
                                        </div>
                                        @error('birth_certificate')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="immunization_card">Immunization Card if Available</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" wire:model.defer='immunization_card'
                                                        class="custom-file-input @error('immunization_card') is-invalid @enderror"
                                                        id="immunization_card">
                                                    <label class="custom-file-label" for="immunization_card">Choose
                                                        file</label>
                                                </div>

                                            </div>
                                        </div>
                                        @error('immunization_card')
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


    <div class="modal fade" id="view" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Student</h4>
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
                                            <img src="{{ asset(optional($selectedStudent)->photo) }}" alt="Admin"
                                                class="rounded-circle" width="150">
                                            <div class="mt-3">
                                                <h4>{{ optional($selectedStudent)->surname . ' ' . optional($selectedStudent)->middlename }}
                                                </h4>
                                                <p class="text-secondary mb-1">
                                                    {{ optional($selectedStudent)->admno }}
                                                </p>

                                                <button class="btn btn-primary">
                                                    Promote
                                                </button>

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
                                                {{ ucwords(optional($selectedStudent)->surname . ' ' . optional($selectedStudent)->middlename . ' ' . optional($selectedStudent)->lastname) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Gender</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucfirst(optional($selectedStudent)->gender) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Date of Birth</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedStudent)->dob }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Blood Group</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedStudent)->blood_group }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Genotype</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedStudent)->genotype }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Allergies</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedStudent)->allergies }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Admission Date</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ optional($selectedStudent)->admission_date }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Guardian</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent->parent)->name ?? null) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Disabilities</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent)->disabilities) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Previous School</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent)->prevSchool) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Why Student Left Formal School</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent)->reason) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Who Introduced Student</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent)->introducer) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Driver</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent)->driver) }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Immunization Card</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <a wire:click='viewImmunizationCard' class="btn btn-sm btn-info">View
                                                    Immunization Card</a>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Birth Certificate</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <a wire:click='viewBirthCertificate' class="btn btn-sm btn-info">View
                                                    Birth Certificate</a>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Class</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedStudent->class)->name) }}
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

    <div class="modal fade" id="promote" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Promote Student</h4>
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
                                    <form wire:submit.prevent='promote'>
                    
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label for="old_level_name">Old Level</label>
                                                <input readonly type="text" name="old_level_name"
                                                    class="form-control" value="{{ optional($selectedStudent->level)->name }}">
                                            </div>
                                            @error('old_level_name')
                                                <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror

                                            <div class="form-group">
                                                <label for="old_class_name">Old Class</label>
                                                <input readonly type="text" name="old_class_name"
                                                    class="form-control" value="{{ optional($selectedStudent->class)->name }}">
                                            </div>
                                            @error('old_class_name')
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
                                            <label for="new_level_id">New Level</label>
                                            <select wire:model.defer='promoteData.new_level_id' class="form-control">
                                                <option value="" selected>Select New Level</option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}"
                                                        {{ optional($selectedStudent->level)->id == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('new_level_id')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="new_class_id">New class</label>
                                            <select wire:model.defer='promoteData.new_class_id' class="form-control">
                                                <option value="" selected>Select New Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ optional($selectedStudent->class)->id == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('new_class_id')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-success">Promote</button>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->


                                </div>
                                <!-- /.card -->
                                </form>
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
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                //Date picker
                $('#dob').datepicker();
                $('#admission_date').datepicker();


                $('#dob').on('change', function(e) {
                    @this.set('state.dob', e.target.value);
                });


                $('#admission_date').on('change', function(e) {
                    @this.set('state.admission_date', e.target.value);
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
