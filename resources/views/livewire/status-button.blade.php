<div>
    <input type="checkbox" wire:check.prevent="changeStatus('{{ $student->id }}')" {{ $student->status ? 'checked' : ''}} data-bootstrap-switch data-off-color="danger" data-on-color="primary">
</div>
