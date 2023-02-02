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
                        <h1>{{ Str::headline($section->class->name . ' ' . $section->name) }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">
                                {{ Str::headline($section->class->name . ' ' . $section->name) }}</li>
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
                                {{-- ok --}}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Teacher</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Str::headline($section->name) }}</td>
                                            <td>{{ Str::headline($section->class->name) }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning font-weight-bold text-capitalize"
                                                    href="">{{ $section->teacher->name }}</a>

                                            </td>
                                            <td>{{ $section->active ? 'Active' : 'Inactive' }}</td>
                                            <td class="d-flex" style="justify-content: space-evenly; padding-right: 0;">
                                                @can('edit class')
                                                    <a title="edit" wire:click="edit({{ $section->id }})" role="button"
                                                        class="btn btn-success"><i class="fas fa-edit"></i></a>
                                                @endcan

                                                <button wire:click="show({{ $section->id }})" role="button"
                                                    class="btn btn-warning"><i class="fas fa-eye"
                                                        title="view role"></i></button>
                                                @can('delete class')
                                                    <button wire:click='confirmDelete({{ $section->id }})' title="delete"
                                                        type="submit" role="button" class="btn btn-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                @endcan
                                            </td>

                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Teacher</th>
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


    <div class="modal fade" id="section" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Section</h4>
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
                                    <form method="POST" wire:submit.prevent="updateSection"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label for="name">Name of Section</label>
                                                <input wire:model.defer='state.name' type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="s_name" placeholder="Eg. A,B">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="user_id">Teacher</label>
                                                <select wire:model.defer='state.user_id'
                                                    class="form-control @error('user_id') is-invalid @enderror"
                                                    id="user_id">
                                                    <option value="">Select Teacher</option>
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="active">Status</label>
                                                <select wire:model.defer='state.active'
                                                    class="form-control @error('active') is-invalid @enderror"
                                                    id="active">
                                                    <option value="">Select Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('active')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

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
                    <h4 class="modal-title">View Section</h4>
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
                                                <h4>{{ Str::headline(optional($section)->name) ?? '' }}
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
                                                {{ ucwords(optional($section)->name) ?? '' }}
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Class</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                @if ($section != null)
                                                    {{ ucwords(optional($section->class)->name) ?? '' }}
                                                @endif
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    Teacher</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                @if ($section != null)
                                                    {{ ucwords(optional($section->teacher)->name) ?? '' }}
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        @if (count($section->class->students) > 0)
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Print Section Data</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    @can('assign subject')
                                                        <a role="button" class="btn btn-info"
                                                            wire:click='printData({{ optional($section)->id }})'>Print</a>
                                                    @endcan
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
