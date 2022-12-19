<div class="form-group">
    <label for="class_id">Class</label>
    <select name="class_id" class="form-control" id="class_id">
        <option value="">Select Class</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ old('class_id') == "$class->id" ? "selected": "" }}>{{ $class->name }}</option>
        @endforeach
    </select>
</div>