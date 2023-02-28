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
                        <h1>Team Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Team Settings</li>
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
                                                <label for="name">Name</label>
                                                <select wire:model='state.name'
                                                    class="form-control @error('name') is-invalid @enderror">
                                                    <option>Select a Team</option>
                                                    @foreach ($teams as $team)
                                                        <option value="{{ $team }}">{{ $team }}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            @if (!empty($rolesInTeam))
                                                <h5>Select the roles in the team</h5>
                                                @foreach ($roles as $role)
                                                    <div class="form-check">
                                                        <input wire:model.defer='rolesInTeam'
                                                            class="form-check-input  @error('roles') is-invalid @enderror"
                                                            type="checkbox" value="{{ $role->name }}"
                                                            {{ in_array($role->name, $rolesInTeam) ? 'checked' : '' }}>
                                                        <label
                                                            class="form-check-label font-weight-bold">{{ $role->name }}</label>
                                                        @error('roles')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                                <hr>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form> <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>

                    <!--/.col (right) -->
                    <div class="col-md-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>People in Team</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($settings as $setting)
                                            <tr>
                                                <td>{{ Str::headline($setting->name) }}</td>
                                                <td>
                                                    @foreach ($setting->roles as $item)
                                                        <button
                                                            class="btn btn-info">{{ Str::upper($item . 's') }}</button>
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>People in Team</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
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
