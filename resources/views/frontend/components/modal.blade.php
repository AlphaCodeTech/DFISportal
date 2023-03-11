<!--First Modal -->
<div class="modal fade" id="register" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="registerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerLabel">ENTER TRANSACTION REF NUMBER TO CONTINUE REGISTRATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('form.continue') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="transaction_ref" class="col-form-label">
                            Enter Transaction Reference Number
                        </label>
                        <input type="text" name="transaction_ref" style="height: 50px;" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <a class="float-start btn bg-success text-white" href="{{ route('guardian.create') }}">Purchase New Form</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-primary text-white">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
