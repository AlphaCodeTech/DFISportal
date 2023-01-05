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
            <h1>Bursaries</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Bursaries</li>
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
                <a role="button" class="btn btn-primary" href="{{ route('bursary.create') }}">Pay Fees</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Student Name</th>
                    <th>Total Fees</th>
                    <th>Amount Paid</th>
                    <th>Amount UnPaid</th>
                    <th>Term Paid</th>
                    <th>Verified</th>
                    <th>Reference</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($bursaries as $class)
                    <tr>
                        <td>{{ $class->student->surname . ' '. $class->student->middlename. ' '. $class->student->lastname }}</td>
                        <td>{{ $class->total_fees }}</td>
                        <td>{{ $class->amount_paid }}</td>
                        <td>{{ $class->amount_unpaid }}</td>
                        <td>{{ $class->term->term_type->name . ' '. $class->term->session->name  }}</td>
                        <td>{{ $class->status ? 'Verified' : 'Unverified' }}</td>
                        <td>{{ $class->transaction_ref }}</td>
                        <td class="d-flex" style="justify-content: space-evenly; padding-right: 0;">
                            <a title="edit" href="{{ route('class.edit',$class->id) }}" role="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a role="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-xl{{ $class->id }}"><i class="fas fa-eye" title="view class"></i>
                              <div class="modal fade" id="modal-xl{{ $class->id }}" data-keyboard="false" data-backdrop="static"  >
                                <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                                  <div class="modal-content">
                                    <div class="modal-header  text-center">
                                      <h4 class="modal-title">View Details</h4>
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
                                              {{-- <img src="{{ asset($class->photo) }}" alt="Admin" class="rounded-circle" width="150"> --}}
                                              <div class="mt-3">
                                                <h4>{{ $class->student->surname . ' '. $class->student->middlename  }}</h4>
                                                <p class="text-secondary mb-1">{{ $class->transaction_ref  }}</p>
                                                
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
                                                <h6 class="mb-0 font-weight-bold">Student Name</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->student->surname . ' '. $class->student->middlename. ' '. $class->student->lastname ) }}
                                              </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Total Fees</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->total_fees ) }}
                                              </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Amount Paid</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->amount_paid ) }}
                                              </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Amount Not Paid</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->amount_unpaid ) }}
                                              </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Perm Paid For</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->term->term_type->name . ' '. $class->term->session->name  ) }}
                                              </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Verified</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->status ? 'Verified' : 'Unverified'  ) }}
                                              </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                              <div class="col-sm-3">
                                                <h6 class="mb-0 font-weight-bold">Reference Number</h6>
                                              </div>
                                              <div class="col-sm-9 text-secondary">
                                                {{ ucwords($class->transaction_ref  ) }}
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
                            <form action="{{ route('bursary.destroy', $class->id)}}" class="deleteForm" method="post">
                              @csrf
                              @method('DELETE')
                              <button title="delete" type="submit" role="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                              {{-- <button class="btn btn-danger" type="submit">Delete</button> --}}
                            </form>
                

                        </td>
                      </tr>
                    @endforeach
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Student Name</th>
                    <th>Total Fees</th>
                    <th>Amount Paid</th>
                    <th>Amount UnPaid</th>
                    <th>Term Paid</th>
                    <th>Verified</th>
                    <th>Reference</th>
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