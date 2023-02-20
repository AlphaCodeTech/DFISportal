<div>
    <div class="form-group">
        <select wire:model="promotion.status"
            class="form-control @error('promotion.status') is-invalid @enderror" id="promote">
            <option value=""></option>
            <option value="P" selected>Promote</option>
            <option value="D">Don't Promote</option>
            <option value="G">Graduated</option>
        </select>
        @error('promotion.status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
