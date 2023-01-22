<div class="switch">
    <input id="cmn-toggle-{{ $model->id }}" class="cmn-toggle cmn-toggle-round" type="checkbox" wire:model='isActive'
        {{ $model->status ? 'checked' : '' }}>
    <label for="cmn-toggle-{{ $model->id }}"></label>
</div>
