@extends('backend.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
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
                            <form method="POST" action="{{ route('subject.assign') }}">
                                @csrf
                                <div class="card-body">
                                  
                                    <div class="form-group">
                                        <label for="class_id">Class</label>
                                        @php
                                            $classes  = App\Models\Clazz::all();
                                        @endphp
                                        <select name="class_id" class="form-control" id="class_id">
                                            <option value="">Select Class</option>
                                           @foreach ($classes as $class)
                                               <option value="{{ $class->id }}">{{ $class->name }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @error('class_id')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                    <h5>Assign Subjects To Class</h5>
                                    @php
                                            $subjects = App\Models\Subject::all();
                                    @endphp
                                    @foreach ($subjects as $subject)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkbox1" name="subject_id[]"
                                                value="{{ $subject->id }}">
                                            <label class="form-check-label font-weight-bold">{{ $subject->name }}</label>
                                        </div>
                                    @endforeach
                                    @error('subject_id')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror

                                            
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Assign</button>
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
@endsection

@push('extra-js')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
   
    <script>
        $(function() {
            

            setTimeout(() => {
                $(".alert").hide('slow');
            }, 5000);

        });
    </script>
@endpush
