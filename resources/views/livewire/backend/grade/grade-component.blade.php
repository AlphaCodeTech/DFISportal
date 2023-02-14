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
                        <h1>Grades</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Grades</li>
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
                            <div class="card-header d-flex justify-content-between align-items-center">
                                @can('create grade')
                                    <a role="button" class="btn btn-primary" href="#" wire:click='create'>Add
                                        Grade</a>
                                @endcan
                                <h5 class="ml-3 bg-warning p-3">NOTE: If The grade you are creating applies to all class levels, select NOT APPLICABLE. Otherwise select the Class Level That the grade applies to</h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Class Level</th>
                                            <th>Range</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grades as $grade)
                                            <tr>
                                                <td>{{ Str::headline($grade->name) }}</td>
                                                <td>{{ $grade->level->name ?? 'NOT APPLICABLE' }}</td>
                                                </td>
                                                <td>{{ Str::ucfirst($grade->mark_from . ' - ' . $grade->mark_to) }}</td>
                                                <td>{{ Str::ucfirst($grade->remark) }}</td>

                                                <td class="d-flex"
                                                    style="justify-content: space-evenly; padding-right: 0;">
                                                    @can('edit grade')
                                                        <a title="edit" wire:click="edit({{ $grade }})"
                                                            role="button" class="btn btn-success"><i
                                                                class="fas fa-edit"></i></a>
                                                    @endcan
                                                    <button wire:click="show({{ $grade->id }})" role="button"
                                                        class="btn btn-warning"><i class="fas fa-eye"
                                                            title="view role"></i></button>
                                                    @can('delete grade')
                                                        <button wire:click='confirmDelete({{ $grade->id }})'
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
                                            <th>Class Level</th>
                                            <th>Range</th>
                                            <th>Remark</th>
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
                    <h4 class="modal-title">{{ $isEditing ? 'Edit Grade' : 'Add New Grade' }}</h4>
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
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form method="POST"
                                            wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input wire:model.defer='state.name' type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="name" placeholder="Eg: A, B, C, D">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="level_id">Select Level</label>
                                                <select wire:model.defer='state.level_id'
                                                    class="form-control @error('level_id') is-invalid @enderror">
                                                    <option value="">NOT APPLICABLE</option>
                                                    @foreach ($levels as $level)
                                                        <option value="{{ $level->id }}">{{ $level->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('level_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="mark_from">Mark From</label>
                                                <input wire:model.defer='state.mark_from' type="number" min="0"
                                                    max="100"
                                                    class="form-control @error('mark_from') is-invalid @enderror"
                                                    id="mark_from" placeholder="0">
                                                @error('mark_from')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                    </div>
                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card -->

                            </div>

                            <!--/.col (left) -->
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="mark_to">Mark To</label>
                                            <input wire:model.defer='state.mark_to' type="number" min="0"
                                                max="100"
                                                class="form-control @error('mark_to') is-invalid @enderror"
                                                id="mark_to" placeholder="0">
                                            @error('mark_to')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="remark">Select Remark</label>
                                            <select wire:model.defer='state.remark'
                                                class="form-control @error('remark') is-invalid @enderror">
                                                <option value="">Select Remark</option>
                                                @foreach (Mk::getRemarks() as $remark)
                                                    <option value="{{ $remark }}">{{ $remark }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('remark')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="card-footer text-right">
                                            <button type="submit"
                                                class="btn btn-primary">{{ $isEditing ? 'Update' : 'Create' }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
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

    @if (!is_null($selectedGrade))
        <div class="modal fade" id="view">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Grade</h4>
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
                                                    <h4>{{ Str::ucfirst($selectedGrade->name) }}
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
                                                        Level</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedGrade->level->name) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Mark From</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedGrade->mark_from) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Mark To</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedGrade->mark_to) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Remark</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedGrade->remark) }}
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
    @endif


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
                $('#start_date').datepicker({
                    format: 'dd-mm-yyyy'
                });
                $('#end_date').datepicker({
                    format: 'dd-mm-yyyy'
                });

                $('#start_date').on('change', function(e) {
                    @this.set('state.start_date', e.target.value);
                });

                $('#end_date').on('change', function(e) {
                    @this.set('state.end_date', e.target.value);
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
