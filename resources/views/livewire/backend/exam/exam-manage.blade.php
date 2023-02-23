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
                        <h1>Manage Exam Marks</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Manage Exam Marks</li>
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
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <h6 class="card-title"><strong>Subject: </strong>
                                            {{ $firstMark->subject->name }}</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="card-title"><strong>Class: </strong>
                                            {{ $firstMark->class->name . ' ' . $firstMark->section->name }}</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="card-title"><strong>Exam: </strong>
                                            {{ $firstMark->examination->name . ' - ' . $firstMark->year }}</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form
                                    wire:submit.prevent="update({{ $exam_id }}, {{ $class_id }}, {{ $section_id }}, {{ $subject_id }})">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Admission Number</th>
                                                <th>1ST CA({{ $appSettings->first_CA }})</th>
                                                <th>2ND CA({{ $appSettings->second_CA }})</th>
                                                <th>Exam ({{ $appSettings->exam }})</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($marks->sortBy('user.name') as $key => $mark)
                                                <tr>
                                                    <td class="text-capitalize">
                                                        {{ $mark->student->surname . ' ' . $mark->student->middlename . ' ' . $mark->student->lastname }}
                                                    </td>
                                                    <td>{{ $mark->student->admno }}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input title="1ST CA" min="1"
                                                                class="text-center form-control @error('marks.' . $key . '.t1') is-invalid @enderror"
                                                                wire:model.defer="marks.{{ $key }}.t1"
                                                                type="number">
                                                            @error('marks.' . $key . '.t1')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input title="2ND CA" min="1"
                                                                class="text-center form-control @error('marks.' . $key . '.t2') is-invalid @enderror"
                                                                wire:model.defer="marks.{{ $key }}.t2"
                                                                type="number">
                                                            @error('marks.' . $key . '.t2')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input title="EXAM" min="1"
                                                                class="text-center form-control @error('marks.' . $key . '.exam') is-invalid @enderror"
                                                                wire:model.defer="marks.{{ $key }}.exam"
                                                                type="number">
                                                            @error('marks.' . $key . '.exam')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Admission Number</th>
                                                <th>1ST CA({{ $appSettings->first_CA }})</th>
                                                <th>2ND CA({{ $appSettings->second_CA }})</th>
                                                <th>Exam ({{ $appSettings->exam }})</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="card-footer text-center mt-2">
                                        <button type="submit" class="btn btn-primary">Update Marks</i></button>
                                    </div>
                                </form>
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
    @endpush
</div>
