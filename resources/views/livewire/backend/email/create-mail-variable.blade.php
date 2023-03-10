<div>
    <div class="modal fade" tabindex="-1" id="email" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="mail-variable-form" wire:submit.prevent="submit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ !$itemId ? 'Create Variable' : 'Update Variable' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Key</label>
                            <input type="text" class="form-control @error('key') is-invalid @enderror" name="key"
                                wire:model.lazy="key" />
                            @error('key')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            
                            <div class="text-muted">
                                Tip: Template variable keys must be unique and enclosed with two square brackets,
                                <br />
                                <ul>
                                    <li>for static variables use uppercase letters like [WEBSITE_URL]</li>
                                    <li>for input variables use [INPUT:field_name] like [INPUT:name]</li>
                                    <li>for dynamic data use [DYNAMIC:$data]</li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" name="value" wire:model.lazy="value" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">{{ !$itemId ? 'Save' : 'Update' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
