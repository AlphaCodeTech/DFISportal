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
                        <h1>Pins</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Pins</li>
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
                                    @can('create pin')
                                        <li class="nav-link">
                                            <a role="button" class="btn btn-primary" href="#" wire:click='create'>Add
                                                Pin</a>
                                        </li>
                                    @endcan
                                    <li class="nav-item">
                                        <a href="#valid-pins" class="nav-link active" data-toggle="tab">Valid Pins</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#used-pins" class="nav-link" data-toggle="tab">Used Pins</a>
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="valid-pins">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-center p-2 mb-2 alert-info border-0 alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert"></button>

                                                    <span>There are <strong>{{ $pin_count }}</strong> valid pins that
                                                        have not been used</span>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach ($valid_pins->chunk(4) as $chunk)
                                            <div class="row">
                                                @foreach ($chunk as $vp)
                                                    <div class="col-md-3 mb-2">
                                                        <input type="hidden" value="{{ $vp->code }}"
                                                            id="copy_{{ $vp->id }}">
                                                        <button onclick="copyToClipboard('copy_{{ $vp->id }}')"
                                                            class="btn btn-sm btn-success">{{ $vp->code }}</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach

                                    </div>

                                    {{-- Used Pins --}}
                                    <div class="tab-pane fade" id="used-pins">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="p-2 mb-2 alert-info border-0 alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                    </button>

                                                    <div class="text-center"> <span>A total of
                                                            <strong>{{ $used_pins->count() }}</strong> pin(s) have been
                                                            used and may no longer be valid </span>

                                                        <a id="used-pins" wire:click="confirmDelete"
                                                            class="btn btn-danger btn-sm ml-2"><i
                                                                class="icon-trash mr-1"></i> Delete ALL Used Pins</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Pin</th>
                                                            <th>Used By</th>
                                                            <th>User Type</th>
                                                            <th>Used for Student</th>
                                                            <th>Date Used</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($used_pins as $pin)
                                                            <tr>
                                                                <td>{{ Str::upper($pin->code) }}</td>
                                                                <td>
                                                                    @php
                                                                        $display = $pin->user instanceof App\Models\Student ? $pin->student->surname . ' ' . $pin->student->middlename . ' ' . $pin->student->lastname : $pin->user->name;
                                                                    @endphp
                                                                    {{ $display }}

                                                                </td>
                                                                <td>{{ Str::ucfirst($pin->user->getRoleNames()[0]) ?? '_' }}
                                                                </td>
                                                                <td>
                                                                    {{ $pin->student->surname . ' ' . $pin->student->middlename . ' ' . $pin->student->lastname }}
                                                                </td>
                                                                <td>{{ $pin->updated_at->diffForHumans() }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Pin</th>
                                                            <th>Used By</th>
                                                            <th>User Type</th>
                                                            <th>Used for Student</th>
                                                            <th>Date Used</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

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
                    <h4 class="modal-title">{{ $isEditing ? 'Edit Pin' : 'Add New Pin' }}</h4>
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
                                                <label for="name">Generate Pins (Enter Amount of Pins you
                                                    Need)</label>
                                                <input wire:model.defer='state.pin_count' type="text"
                                                    class="form-control @error('pin_count') is-invalid @enderror"
                                                    id="pin_count" placeholder="Enter number between 10 and 500"
                                                    value="{{ old('pin_count') }}">
                                                @error('pin_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            <div class="card-footer text-right">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ $isEditing ? 'Update' : 'Submit' }}</button>
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
                    <h4 class="modal-title">View Pin</h4>
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
                                                <h4>{{ Str::headline(optional($selectedPin)->code) ?? '' }}
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
                                                {{ ucwords(optional($selectedPin)->name) ?? '' }}
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

        <script>
            function copyToClipboard(id) {
                text = document.getElementById(id).value;
                navigator.clipboard.writeText(text);
                toastr.success('Pin copied to clipboard', 'Success!');
                // console.log(document.execCommand('copy'));
            }
        </script>
    @endpush
</div>
