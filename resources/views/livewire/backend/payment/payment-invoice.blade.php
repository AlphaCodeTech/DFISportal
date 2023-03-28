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
                        <h1>Manage Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Manage Payments</li>
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
                                Manage Payment Records for
                                <b>{{ $studentRecord->surname . ' ' . $studentRecord->middlename . ' ' . $studentRecord->lastname }}
                                </b>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <ul class="nav nav-tabs nav-tabs-highlight">
                                    <li class="nav-item"><a wire:click='fetchUncleared'
                                            class="nav-link {{ $isIncomplete ? 'active' : '' }}">Incomplete
                                            Payments</a></li>
                                    <li class="nav-item">
                                        <a wire:click='fetchCleared' href="#"
                                            class="nav-link {{ $isComplete ? 'active' : '' }}">Completed
                                            Payments</a>
                                    </li>
                                </ul>

                                @if ($isIncomplete)
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Pay_Ref</th>
                                                <th>Amount</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th>Pay Now</th>
                                                <th>Receipt_No</th>
                                                <th>Year</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($uncleared as $uc)
                                                <tr>
                                                    <td>{{ $uc->payment->title }}</td>
                                                    <td>{{ $uc->payment->ref_no }}</td>

                                                    {{-- Amount --}}
                                                    <td class="font-weight-bold" id="amt-{{ $uc->id }}"
                                                        data-amount="{{ $uc->payment->amount }}">
                                                        {{ $uc->payment->amount }}</td>

                                                    {{-- Amount Paid --}}
                                                    <td id="amount_paid-{{ $uc->id }}"
                                                        data-amount="{{ $uc->amount_paid ?: 0 }}"
                                                        class="text-blue font-weight-bold">
                                                        {{ $uc->amount_paid ?: '0.00' }}
                                                    </td>

                                                    {{-- Balance --}}
                                                    <td id="bal-{{ $uc->id }}"
                                                        class="text-danger font-weight-bold">
                                                        {{ $uc->balance ?: $uc->payment->amount }}</td>

                                                    {{-- Pay Now Form --}}
                                                    <td>
                                                        <form wire:submit.prevent='pay_now("{{ $uc->id }}")'>
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-7">
                                                                    <input wire:model.defer='state.amount_paid'
                                                                        min="1"
                                                                        max="{{ $uc->balance ?: $uc->payment->amount }}"
                                                                        id="val-{{ $uc->id }}"
                                                                        class="form-control @error('amount_paid') is-invalid @enderror"
                                                                        required placeholder="Pay Now" title="Pay Now"
                                                                        name="amount_paid" type="number">
                                                                    @error('amount_paid')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <button data-text="Pay" class="btn btn-primary"
                                                                        type="submit">Pay <i
                                                                            class="icon-paperplane ml-2"></i></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    {{-- Receipt No --}}
                                                    <td>{{ $uc->ref_no }}</td>

                                                    <td>{{ $uc->year }}</td>

                                                    {{-- Action --}}
                                                    <td class="d-flex"
                                                        style="justify-content: space-evenly; padding-right: 0;">

                                                        {{-- Reset Payment --}}
                                                        <a wire:click="confirmReset('{{ $uc->id }}')"
                                                            href="#" class="btn btn-danger"><i
                                                                class="fas fa-undo"></i>
                                                            Reset Payment
                                                        </a>
                                                        {{-- Receipt --}}
                                                        <a target="_blank"
                                                            href="{{ route('payments.receipts', $uc->id) }}"
                                                            class="btn btn-success"><i class="fas fa-print"></i>
                                                            Print Receipt</a>
                                                        {{-- PDF Receipt --}}
                                                        {{-- <a href="{{ route('payments.pdf_receipts', $uc->id) }}"
                                                            class="btn btn-warning btn-sm"><i
                                                                class="fas fa-download"></i> Download Receipt</a> --}}

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Pay_Ref</th>
                                                <th>Amount</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th>Pay Now</th>
                                                <th>Receipt_No</th>
                                                <th>Year</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @endif

                                @if ($isComplete)
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Pay_Ref</th>
                                                <th>Amount</th>
                                                <th>Receipt_No</th>
                                                <th>Year</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cleared as $cl)
                                                <tr>
                                                    <td>{{ $cl->payment->title }}</td>
                                                    <td>{{ $cl->payment->ref_no }}</td>

                                                    {{-- Amount --}}
                                                    <td class="font-weight-bold">{{ $cl->payment->amount }}</td>
                                                    {{-- Receipt No --}}
                                                    <td>{{ $cl->ref_no }}</td>

                                                    <td>{{ $cl->year }}</td>

                                                    {{-- Action --}}
                                                    <td class="text-center">
                                                        <div class="list-icons">
                                                            <div class="dropdown">
                                                                <a href="#" class="list-icons-item"
                                                                    data-toggle="dropdown"><i class="icon-menu9"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-left">

                                                                    {{-- Reset Payment --}}
                                                                    <a id="{{ $cl->id }}"
                                                                        onclick="confirmReset(this.id)" href="#"
                                                                        class="dropdown-item"><i class="icon-reset"></i>
                                                                        Reset Payment</a>
                                                                    <form method="post"
                                                                        id="item-reset-{{ $cl->id }}"
                                                                        action="{{ route('payments.reset_record', $cl->id) }}"
                                                                        class="hidden">@csrf @method('delete')</form>

                                                                    {{-- Receipt --}}
                                                                    <a target="_blank"
                                                                        href="{{ route('payments.receipts', $cl->id) }}"
                                                                        class="dropdown-item"><i
                                                                            class="icon-printer"></i>
                                                                        Print Receipt</a>

                                                                    {{-- PDF Receipt --}}
                                                                    {{-- <a href="{{ route('payments.pdf_receipts', $uc->id) }}"
                                                                        class="btn btn-warning"><i
                                                                            class="fas fa-download"></i> Download
                                                                        Receipt</a> --}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Pay_Ref</th>
                                                <th>Amount</th>
                                                <th>Receipt_No</th>
                                                <th>Year</th>
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
