<!-- bootstrap css 5.* -->
<link href="{{ asset('frontend/dist/css/bootstrap.min.css') }}" rel="stylesheet">


<section class="Admission-form">
    <div class="container">
        <div class="row" style="height: 100vh;">
            <div class="col-md-12">
                <div class="card text-center" style="margin-top: 20%;">
                    <div class="card-header">
                        Divine Favour International School
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">School Fees Verfication</h5>
                        <p class="card-text">Please enter the reference number sent to you to verfiy your school fees
                        </p>
                        <form action="{{ route('verify') }}" method="POST">
                            @csrf
                            <div class="row text-center">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="ref" type="text" class="form-control"
                                            placeholder="Enter your payment reference number" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Verify</button>
                                    </div>
                                </div>


                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>



{{-- js --> --}}

<script type="text/javascript" src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('frontend/dist/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $(function() {
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    });
</script>
