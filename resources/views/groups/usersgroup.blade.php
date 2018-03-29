@if($users->first() != null)

    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Uporabniki</label>
        <div class="col-sm-10">
            @foreach($users as $user)
            <tr>
                                        <td>
                <label for="users_{{ $user->id }}" class="control-sidebar-subheading">
                    <input id="users_{{ $user->id }}" name="users[]" style="margin-right:15px;"
                           value="{{ $user->id }}" type="checkbox"
                           {{(isset($groups) && $groups->usersGroups->where('user_id', $user->id)->count() > 0) ? 'checked' : '' }}
                           class="pull-left">
                    {{ $user->first_name }}
                </label>
            </td>
            @foreach($user->usersRoles as $role)
                <td>
                <!-- kako nastavim da se disablajo roli dokler ni user nastavljen? -->
                <input id="test" name="{{ $user->id }}[]" style="margin-right:15px;"
                           value="{{ $role->role["id"] }}" type="checkbox"                           
                           {{(isset( $user->id)) ? '':'disabled'  }}
                           
                           
                           >
                       
                {{$role->role["role_name"]}}
                </td>
            @endforeach
            </tr>
            @endforeach
        </div>
    </div>
 
@else
    <div class="form-group">
        <label class="col-sm-2">
            Seznam uporabnikov
        </label>
        <div class="col-sm-10">
            <p>
                Trenutno nimate nobenih uporabnikov
            </p>
        </div>
    </div>
@endif
