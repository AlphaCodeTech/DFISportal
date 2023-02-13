<div class="switch">
    <input id="cmn-toggl-{{ $model->id }}" class="cmn-toggle cmn-toggle-round" type="checkbox" wire:model='isResultPublished'
        {{ $model->publish_result ? 'checked' : '' }}>
    <label for="cmn-toggl-{{ $model->id }}"></label>
</div>
