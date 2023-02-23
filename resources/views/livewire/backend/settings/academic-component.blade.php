<div>
    @push('extra-css')
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
                        <h1>Academic Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Academic Settings</li>
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
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            <!-- form start -->
                            <form wire:submit.prevent='update'>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="current_session">Set Current Session</label>
                                                <select wire:model.defer='state.current_session'
                                                    class="form-control @error('current_session') is-invalid @enderror"
                                                    id="current_session">
                                                    <option value=""></option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->name }}">
                                                            {{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('current_session')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="term_begins">Term Begins</label>
                                                <div data-date="12-02-2012" data-date-format="dd-mm-yyyy"
                                                    class="input-group date">
                                                    <input wire:model.defer='state.term_begins' id="term_begins"
                                                        type="text"
                                                        class="form-control @error('term_begins') is-invalid @enderror"
                                                        autocomplete="off" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('term_begins')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="term_ends">Term Ends</label>
                                                <div data-date="12-02-2012" data-date-format="dd-mm-yyyy"
                                                    class="input-group date">
                                                    <input wire:model.defer='state.term_ends' id="term_ends"
                                                        type="text"
                                                        class="form-control @error('term_ends') is-invalid @enderror"
                                                        autocomplete="off" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('term_ends')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="lock_exam">Lock Exam</label>
                                                <select wire:model.defer='state.lock_exam'
                                                    class="form-control @error('lock_exam') is-invalid @enderror"
                                                    id="lock_exam">
                                                    <option value=""></option>
                                                    <option value="true">Yes</option>
                                                    <option value="false">No</option>
                                                </select>
                                                @error('lock_exam')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="CR_fees">Creche School Fees</label>
                                                <select wire:model.defer='state.CR_fees'
                                                    class="form-control @error('CR_fees') is-invalid @enderror"
                                                    id="CR_fees">
                                                    <option value=""></option>
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ trim($fee->getRawOriginal('amount')) }}"
                                                            {{ $state['CR_fees'] == trim($fee->getRawOriginal('amount')) ? 'selected' : '' }}>
                                                            {{ $fee->name }} - {{ $fee->amount }}</option>
                                                    @endforeach
                                                </select>
                                                @error('CR_fees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="NU_fees">Nursery School Fees</label>
                                                <select wire:model.defer='state.NU_fees'
                                                    class="form-control @error('NU_fees') is-invalid @enderror"
                                                    id="NU_fees">
                                                    <option value=""></option>
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ trim($fee->getRawOriginal('amount')) }}"
                                                            {{ $state['NU_fees'] == trim($fee->getRawOriginal('amount')) ? 'selected' : '' }}>
                                                            {{ $fee->name }} - {{ $fee->amount }}</option>
                                                    @endforeach
                                                </select>
                                                @error('NU_fees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="PR_fees">Primary School Fees</label>
                                                <select wire:model.defer='state.PR_fees'
                                                    class="form-control @error('PR_fees') is-invalid @enderror"
                                                    id="PR_fees">
                                                    <option value=""></option>
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ trim($fee->getRawOriginal('amount')) }}"
                                                            {{ $state['PR_fees'] == $fee->getRawOriginal('amount') ? 'selected' : '' }}>
                                                            {{ $fee->name }} - {{ $fee->amount }}</option>
                                                    @endforeach
                                                </select>
                                                @error('PR_fees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="JS_fees">Junior Secondary School Fees</label>
                                                <select wire:model.defer='state.JS_fees'
                                                    class="form-control @error('JS_fees') is-invalid @enderror"
                                                    id="JS_fees">
                                                    <option value=""></option>
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ trim($fee->getRawOriginal('amount')) }}"
                                                            {{ $state['JS_fees'] == trim($fee->getRawOriginal('amount')) ? 'selected' : '' }}>
                                                            {{ $fee->name }} - {{ $fee->amount }}</option>
                                                    @endforeach
                                                </select>
                                                @error('JS_fees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="SS_fees">Senior Secondary School Fees</label>
                                                <select wire:model.defer='state.SS_fees'
                                                    class="form-control @error('SS_fees') is-invalid @enderror"
                                                    id="SS_fees">
                                                    <option value=""></option>
                                                    @foreach ($fees as $fee)
                                                        <option value="{{ trim($fee->getRawOriginal('amount')) }}"
                                                            {{ $state['SS_fees'] == trim($fee->getRawOriginal('amount')) ? 'selected' : '' }}>
                                                            {{ $fee->name }} - {{ $fee->amount }}</option>
                                                    @endforeach
                                                </select>
                                                @error('SS_fees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="card-footer text-right">
                                                <button type="submit" class="btn btn-primary">Create</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    @push('extra-js')
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
