<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Role</li>
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
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">

                        <!-- form start -->
                        <form method="POST" action="{{ route('role.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter role" value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                    <h5>Assign Permission</h5>  
                                 
                                   @foreach ($permissions as $permission)
                                    <div class="form-check">  
                                        <input class="form-check-input" type="checkbox" id="checkbox1" name="permission_id[]" value="{{ $permission->id }}" >  
                                        <label class="form-check-label font-weight-bold">{{ $permission->name }}</label>  
                                    </div>  
                              
                                   @endforeach
                                   
                            
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                            <!-- /.card-body -->

                    </div>
                    <!-- /.card -->

                </div>
               
            </form>
              
                <!--/.col (left) -->

                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>