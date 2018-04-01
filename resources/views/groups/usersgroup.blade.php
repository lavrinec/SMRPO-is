@if($users->first() != null)

    <div class="form-group">
        <script type="text/javascript">
            var allUsers = [],
                allRoles = [],
                allGroups = [];
            (function(){
                'use strict;'
                $.ajax({
                    type: 'GET',
                    url: "{{action('GroupController@getUsersGroupInitialData')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "group_id":''
                    },
                    success: function (data) {
                        console.log((data));
                    }
                })
            })();



            console.log(window);

            function testme() {
                alert("hua");
            }
        </script>
        <label class="col-sm-2 control-label">Uporabniki</label>
        <div class="col-sm-10">
            <select class="col-sm-12 js-example-basic-single" name="state" onchange="testme()">
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->first_name}}</option>
                @endforeach
            </select>
        </div>
        <label class="col-sm-2 control-label">Dodaj uporabnika v skupino</label>
        <div class="col-sm-10">
            <input type="checkbox"/>
        </div>

        {{--<div class="col-sm-10">--}}
        {{--@foreach($users as $user)--}}
        {{--<tr>--}}
        {{--<td>--}}
        {{--<label for="users_{{ $user->id }}" class="control-sidebar-subheading">--}}
        {{--<input id="users_{{ $user->id }}" name="users[]" style="margin-right:15px;"--}}
        {{--value="{{ $user->id }}" type="checkbox"--}}
        {{--{{(isset($groups) && $groups->usersGroups->where('user_id', $user->id)->count() > 0) ? 'checked' : '' }}--}}
        {{--class="pull-left">--}}
        {{--{{ $user->first_name }}--}}
        {{--</label>--}}
        {{--</td>--}}
        {{--@foreach($user->usersRoles as $role)--}}
        {{--<td>--}}
        {{--<!-- kako nastavim da se disablajo roli dokler ni user nastavljen? -->--}}
        {{--<input id="test" name="{{ $user->id }}[]" style="margin-right:15px;"--}}
        {{--value="{{ $role->role["id"] }}" type="checkbox"--}}
        {{--{{(isset( $user->id)) ? '':'disabled'  }}--}}


        {{-->--}}

        {{--{{$role->role["role_name"]}}--}}
        {{--</td>--}}
        {{--@endforeach--}}
        {{--</tr>--}}
        {{--@endforeach--}}
        {{--</div>--}}
    </div>
    <hr/>
    <div class="form-group">
        @foreach($roles as $role)
            <div class="col-sm-12">
                <div class="col-sm-2"></div>
                <label for="test{{$role->id}}" class="form-check col-sm-2">
                    {{$role->role_name}}
                </label>
                <input name="test{{$role->id}}" type="checkbox" class="form-input"/>
            </div>
            {{--<input type="checkbox" class="pull-left" />--}}
        @endforeach
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
