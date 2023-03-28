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
                        <h1>Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Payments</li>
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

                        <div class="card" >

                            <div class="card-body" >
                                <form method="post" wire:submit.prevent='select_year'>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="year"
                                                            class="col-form-label font-weight-bold">Select Year <span
                                                                class="text-danger">*</span></label>
                                                        <select wire:model='year'
                                                            class="form-control @error('year') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($years as $year)
                                                                <option
                                                                    {{ $selected && $year == $year->year ? 'selected' : '' }}
                                                                    value="{{ $year->year }}">{{ $year->year }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mt-4">
                                                    <div class="text-right mt-1">
                                                        <button type="submit" class="btn btn-primary">Submit <i
                                                                class="icon-paperplane ml-2"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                @can('create level')
                                    <a role="button" class="btn btn-primary" href="#" wire:click='create'>Create
                                        Payment</a>
                                @endcan
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                @if ($selected)
                                <ul class="nav nav-tabs nav-tabs-highlight">
                                    <li class="nav-item"><a wire:click='fetchAll' class="nav-link active">All Classes</a></li>
                                    <li class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Class Payments</a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @foreach($classes as $class)
                                                <a wire:click='filter("{{ $class->id }}")' class="dropdown-item" data-toggle="tab">{{ $class->name }}</a>
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>Ref_No</th>
                                                <th>Class</th>
                                                <th>Method</th>
                                                <th>Info</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->title }}</td>
                                                    <td>{{ $payment->amount }}</td>
                                                    <td>{{ $payment->ref_no }}</td>
                                                    <td>{{ $payment->class_id ? $payment->class->name : '' }}</td>
                                                    <td>{{ ucwords($payment->method) }}</td>
                                                    <td>{{ $payment->description }}</td>

                                                    <td class="d-flex"
                                                        style="justify-content: space-evenly; padding-right: 0;">
                                                        @can('edit payment')
                                                            <a title="edit" wire:click="edit({{ $payment->id }})"
                                                                role="button" class="btn btn-success"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endcan
                                                       
                                                        @can('delete payment')
                                                            <button wire:click='confirmDelete({{ $payment->id }})'
                                                                title="delete" type="submit" role="button"
                                                                class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>Ref_No</th>
                                                <th>Class</th>
                                                <th>Method</th>
                                                <th>Info</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @endif

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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $isEditing ? 'Edit Payment' : 'Add New Payment' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-primary">

                                    <!-- form start -->
                                    <form method="POST" wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input wire:model.defer='state.title' type="text"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    id="title" placeholder="eg: School fees">
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="class">Class</label>
                                                <select wire:model='state.class_id'
                                                    class="form-control @error('class_id') is-invalid @enderror">
                                                    <option value="">All Classes</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">{{ $class->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('class_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="method">Payment Method</label>
                                                <select wire:model='state.method'
                                                    class="form-control @error('method') is-invalid @enderror">
                                                    <option value="">All Method</option>
                                                    @foreach (['Cash', 'Online'] as $method)
                                                        <option value="{{ $method }}">{{ $method }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('method')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input wire:model.defer='state.amount' type="text"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    id="amount" placeholder="Enter amount">
                                                @error('amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <input wire:model.defer='state.description' type="text"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    id="description" placeholder="Enter description"
                                                    value="{{ old('description') }}">
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

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
                    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
