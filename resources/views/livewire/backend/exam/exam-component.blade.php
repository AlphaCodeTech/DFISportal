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
                        <h1>Exams</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Exams</li>
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
                                @can('create exam')
                                    <a role="button" class="btn btn-primary" href="#" wire:click='create'>Add
                                        Exam</a>
                                @endcan
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Term</th>
                                            <th>Session</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Active</th>
                                            <th>Publish Result</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exams as $exam)
                                            <tr>
                                                <td>{{ Str::headline($exam->name) }}</td>
                                                <td>{{ Str::headline($exam->term->type) }}</td>
                                                <td>{{ Str::ucfirst($exam->term->session->name) }}</td>
                                                <td>{{ Str::ucfirst($exam->start_date->format('d-m-Y')) }}</td>
                                                <td>{{ Str::ucfirst($exam->end_date->format('d-m-Y')) }}</td>
                                                <td class="text-center">
                                                    <livewire:backend.status-button :model="$exam" field="active"
                                                        key="{{ $exam->id }}">
                                                </td>
                                                <td class="text-center">
                                                    <livewire:backend.publish-button :model="$exam"
                                                        field="publish_result" key="{{ $exam->id }}">
                                                </td>
                                                <td class="d-flex"
                                                    style="justify-content: space-evenly; padding-right: 0;">
                                                    @can('edit exam')
                                                        <a title="edit" wire:click="edit({{ $exam }})"
                                                            role="button" class="btn btn-success"><i
                                                                class="fas fa-edit"></i></a>
                                                    @endcan
                                                    <button wire:click="show({{ $exam->id }})" role="button"
                                                        class="btn btn-warning"><i class="fas fa-eye"
                                                            title="view role"></i></button>
                                                    @can('delete exam')
                                                        <button wire:click='confirmDelete({{ $exam->id }})'
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
                                            <th>Term</th>
                                            <th>Session</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Active</th>
                                            <th>Publish Result</th>
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
                    <h4 class="modal-title">{{ $isEditing ? 'Edit Exam' : 'Add New Exam' }}</h4>
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
                                                    id="name" placeholder="Enter name"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Start Date: </label>
                                                <div class="input-group date">
                                                    <input wire:model.defer='state.start_date' id="start_date"
                                                        type="text"
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        autocomplete="off" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>End Date: </label>
                                                <div class="input-group date">
                                                    <input wire:model.defer='state.end_date' id="end_date"
                                                        type="text"
                                                        class="form-control @error('end_date') is-invalid @enderror"
                                                        autocomplete="off" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
                                            <label for="description">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" wire:model.defer='state.description'
                                                id="description"></textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="type">Select Term</label>
                                            <select wire:model.defer='state.term_id'
                                                class="form-control @error('term_id') is-invalid @enderror">
                                                <option value="">Select Term</option>
                                                @foreach ($terms as $term)
                                                    <option value="{{ $term->id }}">{{ $term->type }}</option>
                                                @endforeach

                                            </select>
                                            @error('term_id')
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

    @if (!is_null($selectedExam))
        <div class="modal fade" id="view">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Exam</h4>
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
                                                    <h4>{{ Str::ucfirst($selectedExam->name) }}
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
                                                        Session</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedExam->term->session->name) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Term Name</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedExam->term->type) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Start Date</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedExam->start_date->format('d-m-Y')) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        End Date</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedExam->end_date->format('d-m-Y')) }}
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        Description</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ ucwords($selectedExam->description) }}
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
