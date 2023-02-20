<div>
    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">

        <link rel="stylesheet" href="{{ asset('backend/plugins/vitalets-bootstrap-datepicker-c7af15b/css/datepicker.css') }}">
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
                        <h1>Promote Students</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Promote Students</li>
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
                                    <h4 class="text-uppercase fontweight-bold">Promote Students from <span
                                            class="text-danger">{{ $data['old_year'] }}</span> to <span
                                            class="text-success">{{ $data['new_year'] }}</span> </h4>
                                </div>

                                <!-- form start -->
                                <form wire:submit.prevent='selector'>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="from_class">From Class</label>

                                                    <select wire:model="selectedCurrentClass"
                                                        class="form-control @error('selectedCurrentClass') is-invalid @enderror">
                                                        <option value="">Select Class</option>
                                                        @foreach ($currentClasses as $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('selectedCurrentClass')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectedCurrentSection">From Section</label>
                                                    <select wire:model='selectedCurrentSection'
                                                        id="selectedCurrentSection"
                                                        class="form-control @error('selectedCurrentSection') is-invalid @enderror">
                                                        <option value="">Select Section</option>
                                                        @if (!is_null($selectedCurrentClass))
                                                            @foreach ($currentSections as $section)
                                                                <option value="{{ $section->id }}">{{ $section->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('selectedCurrentSection')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectedNextClass">To Class</label>
                                                    <select wire:model='selectedNextClass'
                                                        class="form-control @error('selectedNextClass') is-invalid @enderror"
                                                        id="selectedNextClass">
                                                        <option value="">Select Class</option>
                                                        @foreach ($nextClasses as $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('selectedNextClass')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectedNextSection">To Section</label>
                                                    <select wire:model='selectedNextSection'
                                                        class="form-control @error('selectedNextSection') is-invalid @enderror"
                                                        id="selectedNextSection">
                                                        <option value="">Select Section</option>
                                                        @if (!is_null($selectedNextClass))
                                                            @foreach ($nextSections as $section)
                                                                <option value="{{ $section->id }}">
                                                                    {{ $section->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('selectedNextSection')
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
                                    <h5 class="card-title font-weight-bold">Promote Students From <span
                                            class="text-teal">({{ $fromText }})</span> TO <span
                                            class='text-primary'>({{ $toText }})</span> </h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form wire:submit.prevent='promote' method="POST">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Class</th>
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
                                                        <td>{{ $student->class->name }}</td>
                                                        <td class="text-center"><img class="img-thumbnail"
                                                                src="{{ asset($student->photo) }}"
                                                                alt="{{ $student->name }}"
                                                                style="width: 100px; height: 100px;"></td>
                                                        <td wire:key='$student->id'>
                                                            {{-- {{ dd($P) }} --}}
                                                            <div class="form-check">
                                                                <input name="P.{{ $student->id }}" title="Promote"
                                                                    class="text-center form-check-input @error('P.' . $student->id) is-invalid @enderror"
                                                                    wire:click="updateP('P',{{ $student->id }})"
                                                                    type="radio" value="P" wire:model.defer='P.{{ $student->id }}'>
                                                                <label class="form-check-label" for="">
                                                                    Promote
                                                                </label>
                                                                @error('P.' . $student->id)
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-check">
                                                                <input name="P.{{ $student->id }}"
                                                                    title="Don't Promote"
                                                                    class="text-center form-check-input @error('P.' . $student->id) is-invalid @enderror"
                                                                    wire:click="updateP('D',{{ $student->id }})"
                                                                    type="radio" value="D" wire:model.defer='P.{{ $student->id }}'>
                                                                <label class="form-check-label" for="">
                                                                    Don't Promote
                                                                </label>
                                                                @error('P.' . $student->id)
                                                                    <div class="invalid-feedback">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-check">
                                                                <input name="P.{{ $student->id }}" title="Graduated"
                                                                    class="text-center form-check-input @error('P.' . $student->id) is-invalid @enderror"
                                                                    wire:click="updateP('G',{{ $student->id }})"
                                                                    type="radio" value="G" wire:model.defer='P.{{ $student->id }}'
                                                                    class="form-check-input @error('P.' . $student->id) is-invalid @enderror">
                                                                <label class="form-check-label" for="">
                                                                    Graduated
                                                                </label>
                                                                @error('P.' . $student->id)
                                                                    <div class="invalid-feedback">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </td>



                                                        {{-- <td style="justify-content: space-evenly; padding-right: 0;">
                                                            <div class="form-group">
                                                                <select 
                                                                    wire:model="promotion.{{ $student->id }}"
                                                                    class="form-control @error('promotion.' . $student->id) is-invalid @enderror" id="promote">
                                                                    <option value=""></option>
                                                                    <option value="P">Promote</option>
                                                                    <option value="D">Don't Promote</option>
                                                                    <option value="G">Graduated</option>
                                                                </select>
                                                                @error('promotion.' . $student->id)
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Class</th>
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
