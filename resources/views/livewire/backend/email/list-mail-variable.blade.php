<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex justify-content-around">
                        <h1>Mail Variables</h1>
                        <a href="{{ route('email.view.template') }}" class="btn btn-primary">View Email Templates</a>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Mail Variables</li>
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
                                <button type="button" class="btn btn-secondary create-btn" style="float: left"
                                    wire:click="$emit('showCreateModal')"><i class="fa fa-plus"></i> Create</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Variable Key</th>
                                            <th>Variable Value</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($allVariables as $item)
                                            <tr>
                                                <td>{{ $item->key }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-edit"
                                                        wire:click="$emit('showCreateModalForUpdate', {{ $item->id }})"><i
                                                            class="fa fa-edit"></i> Edit</button>
                                                </td>
                                                <td>
                                                    <form method="post" action="#"
                                                        wire:submit.prevent="deleteVariable({{ $item->id }})">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('are you sure?')"><i
                                                                class="fa fa-remove"></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">No variables</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $allVariables->links() }}
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
    <livewire:backend.email.create-mail-variable />


    @push('extra-js')
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/sweetalert.min.js') }}"></script>
    @endpush
</div>
