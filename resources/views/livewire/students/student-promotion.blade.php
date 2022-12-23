{{-- {{ dd($student->level->id) }} --}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Promote Student</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Promote Student</li>
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
                        <form method="POST" action="{{ route('student.promote', $student->id) }}">

                            @csrf
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="old_level_name">Old Level</label>
                                    <input readonly type="text" name="old_level_name" class="form-control" value="{{ $student->level->name }}">
                                </div>
                                @error('old_level_name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="old_class_name">Old Class</label>
                                    <input readonly type="text" name="old_class_name" class="form-control" value="{{ $student->class->name }}">
                                </div>
                                @error('old_class_name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror


                            </div>
                            <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">

                        <div class="card-body">

                            <div class="form-group">
                                <label for="new_level_id">New Level</label>
                                <select name="new_level_id" class="form-control" wire:change="updateLevel($event.target.value)">
                                    <option value="">Select New Class</option>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}" {{ $student->level->id == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('new_level_id')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label for="new_class_id">New class</label>
                                <select name="new_class_id" class="form-control">
                                    <option value="">Select New Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ $student->class->id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('new_class_id')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Promote</button>
                            </div>

                        </div>
                        <!-- /.card-body -->


                    </div>
                    <!-- /.card -->
                </form>
                </div>
                <!--/.col (left) -->
               
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
