<div>
    <div class="modal fade" tabindex="-1" id="email" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" wire:submit.prevent="submit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Send Test Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="variable_value" wire:model.lazy="email"
                                required />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
