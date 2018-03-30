@if(Auth::user()->isAdmin())
    <div class="form-group">
        <label class="col-sm-2 control-label">Vloge</label>
        <div class="col-sm-10">
            @foreach($roles as $role)
                <label for="roles_{{ $role->id }}" class="control-sidebar-subheading">
                    <input id="roles_{{ $role->id }}" name="roles[]"
                           value="{{ $role->id }}" type="checkbox"
                           {{ (isset($users) && $users->usersRoles->where('role_id', $role->id)->count() > 0) ? 'checked' : '' }}
                           class="pull-left">
                    {{ $role->role_name }}
                </label>

            @endforeach
        </div>
    </div>
@endif