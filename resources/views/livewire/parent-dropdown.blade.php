<div class="form-group">
    <label for="parent_id">Guardian</label>
    <select name="parent_id" class="form-control" id="parent_id">
        <option value="">Guardian</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" {{ old('parent_id') ==  "$parent->id" ? "selected": "" }}>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>