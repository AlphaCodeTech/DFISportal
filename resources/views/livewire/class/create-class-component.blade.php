<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Classroom</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Classroom</li>
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
                        <form method="POST" action="{{ route('class.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter name" value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                              
                                <div class="form-group">
                                    <label for="level_id">Level</label>
                                    <select name="level_id" class="form-control" id="level_id">
                                        <option value="">Select Level</option>
                                       @foreach ($levels as $level)
                                           <option value="{{ $level->id }}">{{ $level->name }}</option>
                                       @endforeach
                                    </select>
                                </div>
                                @error('level_id')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                              
                            </div>
                            <!-- /.card-body -->

                    </div>
                    <!-- /.card -->

                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Teacher</label>
                            <select name="user_id" class="form-control" id="user_id">
                                <option value="">Select Teacher</option>
                               @foreach ($teachers as $teacher)
                                   <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                               @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <p class="alert alert-danger">{{ $message }}</p>
                        @enderror
                  
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>

                    </div>
                    </div>
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