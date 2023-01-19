<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('backend/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('backend/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/dist/js/demo.js') }}"></script>
{{-- Toastr --}}
<script src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('backend/dist/js/pages/dashboard2.js') }}"></script>
@stack('extra-js')

<script>
    window.addEventListener('show-form', function() {
        $('#form').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    });

    window.addEventListener('show-view', function() {
        $('#view').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    });

    window.addEventListener('hide-modal', function(event) {
        $('#form').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    });

    window.addEventListener('show-confirm', function(event) {
        toastr.success(event.detail.message, 'Success!');
    });

    window.addEventListener('delete-modal', (e) => {
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                Livewire.emit('delete')
            }
        });
    });
</script>
@livewireScripts
