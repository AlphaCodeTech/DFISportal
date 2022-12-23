@extends('backend.layouts.app')
@push('extra-css')
     <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Theme style -->
@endpush

@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Students</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Students</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
         
            <div class="card">
              <div class="card-header">
                <a role="button" class="btn btn-primary" href="{{ route('student.create') }}">Add Student</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
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
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->surname ." ". $student->middlename }}</td>
                        <td>{{ $student->admno }}</td>
                        <td>{{ $student->class->name }}</td>
                        <td class="text-center"><img class="img-thumbnail" src="{{ asset($student->photo) }}" alt="{{ $student->surname }}" style="width: 100px; height: 100px;"></td>
                        <td class="d-flex" style="justify-content: space-evenly; padding-right: 0;">
                            <a title="edit" href="{{ route('student.edit',$student->id) }}" role="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a role="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-xl{{ $student->id }}"><i class="fas fa-eye" title="view student"></i>
                              <div class="modal fade" id="modal-xl{{ $student->id }}" data-keyboard="false" data-backdrop="static"  >
                                <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                                  <div class="modal-content">
                                    <div class="modal-header  text-center">
                                      <h4 class="modal-title">View Student</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                      <div class="col-md-4 mb-3">
                                        <div class="card">
                                          <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                              <img src="{{ asset($student->photo) }}" alt="Admin" class="rounded-circle" width="150">
                                              <div class="mt-3">
                                                <h4>{{ $student->surname .' '. $student->middlename }}</h4>
                                                <p class="text-secondary mb-1">{{ $student->admno }}</p>
                                                <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                                                <button class="btn btn-primary">
                                                  Promote
                                                </button>
                                                <button class="btn btn-outline-primary">Status</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-8">
                                        <div class="card mb-3">
                                          <div class="card-body text-left">
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Full Name</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($student->surname .' '. $student->middlename . ' ' . $student->lastname) }}
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Gender</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucfirst($student->gender) }}
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Date of Birth</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ $student->dob }}
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Admission Date</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ $student->admission_date }}
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Guardian</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($student->parent->surname .' '. $student->parent->middlename . ' ' . $student->parent->lastname) }}
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Class</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($student->class->name) }}
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Address</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($student->address) }}
                                              </div>
                                            </div>
                                            <hr>
                                            
                                          </div>
                                        </div>
                                      </div>
                                    
                                    </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
                            </a>
                            <form action="{{ route('student.destroy', $student->id)}}" class="deleteForm" method="post">
                              @csrf
                              @method('DELETE')
                              <button title="delete" type="submit" role="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              {{-- <button class="btn btn-danger" type="submit">Delete</button> --}}
                            </form>
                            <a title="promote" href="{{ route('student.showPromotion',$student->id) }}" role="button" class="btn btn-primary"><i class="fas fa-level-up-alt"></i></a>

                        </td>
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
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@push('extra-js')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/sweetalert.min.js')}}"></script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

  const deleteForms = document.querySelectorAll('.deleteForm'); 
    deleteForms.forEach(form => {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
            form.submit();
        }
    });
      });
    });
</script>  
@endpush