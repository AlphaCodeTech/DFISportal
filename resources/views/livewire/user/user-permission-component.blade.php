<div>
    <h5>Assign Permission</h5>
    @foreach ($permissions as $permission)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox1" name="permission_id[]"
                value="{{ $permission->id }}">
            <label class="form-check-label font-weight-bold">{{ $permission->name }}</label>
        </div>
    @endforeach
</div>
