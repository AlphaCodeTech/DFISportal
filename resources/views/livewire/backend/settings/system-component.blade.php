<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>System Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">System Settings</li>
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
                                                <label for="name">School Name</label>
                                                <input wire:model.defer='state.name' type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="name" placeholder="Enter school name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="acr">School Acronym</label>
                                                <input wire:model.defer='state.acr' type="text"
                                                    class="form-control @error('acr') is-invalid @enderror"
                                                    id="acr" placeholder="Enter school acronym">
                                                @error('acr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">School Email</label>
                                                <input wire:model.defer='state.email' type="text"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Enter school email">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">School Phone</label>
                                                <input wire:model.defer='state.phone' type="text"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    id="phone" placeholder="Enter school phone">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="address">School Address</label>
                                                <textarea wire:model.defer='state.address' type="text" class="form-control @error('address') is-invalid @enderror"
                                                    id="address" placeholder="Enter school address"></textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_CA">First CA</label>
                                                <input wire:model='state.first_CA' type="number"
                                                    class="form-control @error('first_CA') is-invalid @enderror"
                                                    id="first_CA" placeholder="Enter First CA Total" >
                                                @error('first_CA')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="second_CA">Second CA</label>
                                                <input wire:model='state.second_CA' type="number"
                                                    class="form-control @error('second_CA') is-invalid @enderror"
                                                    id="second_CA" placeholder="Enter second CA Total">
                                                @error('second_CA')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exam">Exam Score</label>
                                                <input wire:model='state.exam' type="number"
                                                    class="form-control @error('exam') is-invalid @enderror"
                                                    id="exam" placeholder="Enter exam Total" >
                                                @error('exam')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="total">Total Scores</label>
                                                <input wire:model.defer='state.total' type="number"
                                                    class="form-control @error('total') is-invalid @enderror"
                                                    id="total" placeholder="Enter total score" readonly>
                                                @error('total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="logo">School Logo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" wire:model.defer='logo'
                                                            class="custom-file-input @error('logo') is-invalid @enderror"
                                                            id="logo">
                                                        <label class="custom-file-label" for="logo">Choose
                                                            file</label>
                                                    </div>

                                                </div>
                                                @if ($logo)
                                                    <img class="img-thumbnail mt-4" src="{{ $logo->temporaryUrl() }}">
                                                @else
                                                    <img class="img-thumbnail mt-4" src='{{ asset($state['logo']) }}'
                                                        alt="">
                                                @endif

                                            </div>
                                            @error('logo')
                                                <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror

                                            <div class="card-footer text-right">
                                                <button type="submit" class="btn btn-primary">Create</button>
                                            </div>

                                        </div>
                                    </div>



                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>

                    <!--/.col (left) -->

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    @push('extra-js')
        <script>
            $(function() {
                setTimeout(() => {
                    $(".alert").hide('slow');
                }, 5000);

            });
        </script>
    @endpush

</div>
