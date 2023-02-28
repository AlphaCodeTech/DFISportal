<div>
    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">

        <link rel="stylesheet" href="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/css/datepicker.css') }}">
        <!-- Theme style -->
    @endpush
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Fix Mark Errors</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Fix Mark Errors</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    @if (!$selected)
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card">
                                <div class="card-header">
                                    Tabulation Sheet</h4>
                                </div>

                                <!-- form start -->
                                <form wire:submit.prevent='batch_update'>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="from_class">Exam</label>

                                                    <select wire:model="selectedExam"
                                                        class="form-control @error('selectedExam') is-invalid @enderror">
                                                        <option value="">Select Exam</option>
                                                        @foreach ($exams as $exam)
                                                            <option value="{{ $exam->id }}">
                                                                {{ $exam->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('selectedExam')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectedClass">Class</label>
                                                    <select wire:model='selectedClass' id="selectedClass"
                                                        class="form-control @error('selectedClass') is-invalid @enderror">
                                                        <option value="">Select Class</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('selectedClass')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectedSection">Section</label>
                                                    <select wire:model='selectedSection'
                                                        class="form-control @error('selectedSection') is-invalid @enderror"
                                                        id="selectedSection">
                                                        <option value="">Select Section</option>
                                                        @if (!is_null($selectedClass))
                                                            @foreach ($sections as $section)
                                                                <option value="{{ $section->id }}">
                                                                    {{ $section->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('selectedSection')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary">Fix</button>
                                        </div>

                                    </div>
                                </form> <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @endif

                    @if ($selected)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title font-weight-bold">Tabulation Sheet For
                                        {{ $class->name . ' ' . $section->name . ' - ' . $exam->name . ' (' . $year . ')' }}
                                    </h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NAMES_OF_STUDENTS_IN_CLASS</th>
                                                @foreach ($subjects as $subject)
                                                    <th title="{{ $subject->name }}" rowspan="2">
                                                        {{ strtoupper($subject->slug ?: $subject->name) }}
                                                    </th>
                                                @endforeach
                                                <th style="color: darkred">Total</th>
                                                <th style="color: darkblue">Average</th>
                                                <th style="color: darkgreen">Position</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td style="text-align: left">
                                                        {{ $student->surname . ' ' . $student->middlename . ' ' . $student->lastname }}
                                                    </td>
                                                    @foreach ($subjects as $subject)
                                                        <td>{{ $marks->where('student_id', $student->id)->where('subject_id', $subject->id)->first()->$tex ?? '-' }}
                                                        </td>
                                                    @endforeach
                                                    <td style="color: darkred">
                                                        {{ $exam_record->where('student_id', $student->id)->first()->total ?? '-' }}
                                                    </td>
                                                    <td style="color: darkblue">
                                                        {{ $exam_record->where('student_id', $student->id)->first()->average ?? '-' }}
                                                    </td>
                                                    <td style="color: darkgreen">{!! Mk::getSuffix($exam_record->where('student_id', $student->id)->first()?->position) ?? '-' !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <div class="card-footer text-right">
                                        <a target="_blank"
                                            href="{{ route('marks.print_tabulation', [$exam_id, $class_id, $section_id]) }}"
                                            class="btn btn-danger">
                                            <i class="fas fa-print"></i>
                                            Print Tabulation Sheet</a>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    @endif

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    @push('extra-js')
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>

        <script src="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/js/bootstrap-datepicker.js') }}"></script>

        <script>
            $(function() {
                setTimeout(() => {
                    $(".alert").hide('slow');
                }, 5000);

            });

            //Date picker
            $('#term_begins').datepicker({
                format: 'yyyy-mm-dd',
            });
            $('#term_begins').on('change', function(e) {
                @this.set('state.term_begins', e.target.value);
            });

            $('#term_ends').datepicker({
                format: 'yyyy-mm-dd',
            });
            $('#term_ends').on('change', function(e) {
                @this.set('state.term_ends', e.target.value);
            });
        </script>
    @endpush

</div>
