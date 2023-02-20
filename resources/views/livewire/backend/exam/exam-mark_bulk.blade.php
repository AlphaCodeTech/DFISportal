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
                        <h1>Student Marksheet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Marksheet</li>
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
                                    <h4 class="text-uppercase fontweight-bold"> Select Student Marksheet </h4>
                                </div>

                                <!-- form start -->
                                <form wire:submit.prevent='bulk_select'>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="from_class">From Class</label>

                                                    <select wire:model="selectedClass"
                                                        class="form-control @error('selectedClass') is-invalid @enderror">
                                                        <option value="">Select Class</option>
                                                        @foreach ($classes as $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('selectedClass')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="selectedSection">From Section</label>
                                                    <select wire:model='selectedSection' id="selectedSection"
                                                        class="form-control @error('selectedSection') is-invalid @enderror">
                                                        <option value="">Select Section</option>
                                                        @if (!is_null($selectedClass))
                                                            @foreach ($sections as $section)
                                                                <option value="{{ $section->id }}">{{ $section->name }}
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
                                            <button type="submit" class="btn btn-primary">Continue</button>
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
                                    <h5 class="card-title font-weight-bold"> Select Student Marksheet </h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form wire:submit.prevent='promote' method="POST">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Photo</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $key => $student)
                                                    <tr wire:key='{{ $student->id }}'>
                                                        <td class="text-capitalize">
                                                            {{ $student->surname . ' ' . $student->middlename . ' ' . $student->lastname }}
                                                        </td>
                                                        <td>{{ $student->admno }}</td>
                                                        <td class="text-center"><img class="img-thumbnail"
                                                                src="{{ asset($student->photo) }}"
                                                                alt="{{ $student->name }}"
                                                                style="width: 100px; height: 100px;"></td>
                                                        <td><a class="btn btn-danger"
                                                                href="{{ route('marks.year_selector',$student->id) }}">View
                                                                Marksheet</a></td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Photo</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-success">Promote</button>
                                        </div>
                                    </form>
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
