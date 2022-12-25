<div>
    <h5>Assign Permission</h5>
    @foreach ($permissions as $permission)
        <div class="form-check">
            <input wire:click='updatePermission({{ $permission->id }})' class="form-check-input" type="checkbox"
                id="checkbox1" value="{{ $permission->id }}"
                {{ is_array($user->getAllPermissions()->pluck('id')->toArray()) &&in_array($permission->id,$user->getAllPermissions()->pluck('id')->toArray())? 'checked': '' }}>
            <label class="form-check-label font-weight-bold">{{ $permission->name }}</label>
        </div>
    @endforeach
</div>
