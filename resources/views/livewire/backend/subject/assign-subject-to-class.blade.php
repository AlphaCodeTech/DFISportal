<div>

    @push('extra-css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
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
                        <h1>Class Subjects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Class Subjects</li>
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
                                {{--  --}}
                            </div>
                            <!-- /.card-header -->
                            @foreach ($classes as $class)
                                @if (count($class->subjects) > 0)
                                    <div class="card-body">
                                        <h4 class="p-4 bg-primary mb-4">{{ $class->name }} Subjects</h4>

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Subjects</th>
                                                    <th>Teacher</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($class->subjects as $subject)
                                                    <tr>
                                                        <td>
                                                            <div class="row">
                                                                {{-- @foreach ($class->subjects as $subject) --}}
                                                                <div class="col-md-3 mb-2">
                                                                    <button
                                                                        class="btn btn-sm btn-warning">{{ $subject->name }}</button>
                                                                </div>
                                                                {{-- @endforeach --}}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                @php
                                                                    $teacher = $subject
                                                                        ->teachers()
                                                                        ->where('subject_id', $subject->id)
                                                                        ->first();
                                                                @endphp
                                                                <div class="col-md-4 mb-2">
                                                                    <button
                                                                        class="btn btn-sm btn-dark">{{ $teacher->name }}</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="d-flex"
                                                            style="justify-content: space-evenly; padding-right: 0;">
                                                            {{-- @can('edit class')
                                                            <a title="edit" wire:click="edit({{ $class->id }})"
                                                                role="button" class="btn btn-success"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endcan --}}
                                                            <button wire:click="show({{ $class->id }})"
                                                                role="button" class="btn btn-warning"><i
                                                                    class="fas fa-eye" title="view role"></i></button>
                                                            {{-- @can('delete class')
                                                            <button wire:click='confirmDelete({{ $class->id }})'
                                                                title="delete" type="submit" role="button"
                                                                class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                        @endcan --}}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Subjects</th>
                                                    <th>Teacher</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
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
                    <h4 class="modal-title">
                        {{ $isEditing ? 'Edit Assigned Subject To Class' : 'Assign New Subject To Class' }}</h4>
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
                                                <label for="class_id">Class</label>
                                                <select wire:model.defer='state.id'
                                                    class="form-control @error('class_id') is-invalid @enderror"
                                                    id="class_id">
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">
                                                            {{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('class_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <h5>Assign Subjects</h5>

                                            @foreach ($subjects as $subject)
                                                <div class="form-check">
                                                    <input wire:model.defer='subjectIDS' class="form-check-input"
                                                        type="checkbox" value="{{ $subject->id }}"
                                                        {{ $isEditing ? (in_array($subject->id, $subjectIDS) ? 'checked' : '') : '' }}>
                                                    <label
                                                        class="form-check-label font-weight-bold">{{ $subject->name }}</label>
                                                </div>
                                            @endforeach


                                            {{-- @if (!is_null($selectedClass))
                                                <div class="form-group">
                                                    <label for="section_id">Section</label>
                                                    <select wire:model='state.section_id'
                                                        class="form-control @error('section_id') is-invalid @enderror"
                                                        id="section_id">
                                                        <option value="" selected>Select Section</option>
                                                        @foreach ($classSections as $section)
                                                            <option value="{{ $section->id }}"
                                                                {{ old('section_id') == "$section->id" ? 'selected' : '' }}>
                                                                {{ $section->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('section_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif --}}

                                            <div class="card-footer text-right">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ $isEditing ? 'Update' : 'Create' }}</button>
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
                    <h4 class="modal-title">View Subject</h4>
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

                                            <div class="mt-3">
                                                <h4>{{ Str::headline(optional($selectedClass)->name) ?? '' }}
                                                </h4>

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
                                                    Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{ ucwords(optional($selectedClass)->name) ?? '' }}
                                            </div>
                                        </div>
                                        <hr>

                                        @if (!is_null($selectedClass))
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Subjects</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <div class="row">
                                                        @foreach ($selectedClass->subjects as $subject)
                                                            <div class="col-md-4 mb-2">
                                                                <button
                                                                    class="btn btn-warning">{{ $subject->name }}</button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endif
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

                $('.select2').select2({
                    dropdownParent: $('#form')
                });

                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $('#form'),
                });

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
