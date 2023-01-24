<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Class Data</title>
    <link rel="stylesheet" href="{{ public_path('backend/dist/css/adminlte.min.css') }}">

</head>
<body>
    
<div class="container-fluid">
    <div class="row">
      <div class="col-12">
     
        <div class="card">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <img class="img-fluid img-thumbnail" src="{{ $image }}" alt="" style="width: 200px;">
            </div>
            <div class="col-md-3"></div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">DIVINE FAVOUR INTERNATIONAL SCHOOL</h1>
            </div>
            <div class="col-md-12">
                <h4 class="text-center">OPPOSITE HOLY TRINITY CATHOLIC CHURCH</h4>
            </div>
            <div class="col-md-12">
                <h4 class="text-center">AWAKA, OWERRI-UMUOHIA ROAD</h4>
            </div>
            <div class="col-md-12">
                <h4 class="text-center">OWERRI NORTH, IMO STATE</h4>
            </div>
            <div class="col-md-12">
                <h4 class="text-center text-uppercase">{{ $class->name }} Students</h4>
            </div>
          </div>
          
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered">
              <thead>
              <tr>
                <th>Name</th>
                <th>Admission Number</th>
                <th>Level</th>
                <th>Class</th>
                <th>Date of Birth</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($class->students as $student)
                <tr>
                    <td>{{ ucwords($student->surname .' '.$student->middlename .' '.$student->lastname) }}</td>
                    <td>{{ $student->admno }}</td>
                    <td>{{ $student->level->name }}</td>
                    <td>{{ $student->class->name }}</td>
                    <td>{{ $student->dob }}</td>
                  </tr>
                @endforeach
              </tbody>
            
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
</body>
</html>