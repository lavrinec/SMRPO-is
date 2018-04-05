@if($users->first() != null)
    <div class="form-group">

        <label class="col-sm-2 control-label">Uporabniki</label>
        <div class="col-sm-10">
            <select class="col-sm-12" id="usersgroupsselect" multiple="multiple">
                {{--@foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                @endforeach--}}
            </select>
            <script type="text/javascript">
                var allUsers = [],
                    allRoles = [],
                    allUsersGroups = [],
                    usersAndRoles = [];
                (function () {
                    console.log('to je input');
                    console.log($('#usersgroups-input').val());

                    function setEditValues(dataFromDatabase, dataFromSelect) {
                        for (var value of Object.values(dataFromDatabase)) {
                            if (parseInt(value.id) === parseInt(dataFromSelect.id)) {
                                return true;
                            }
                        }
                        return false;
                    }

                    $.ajax({
                        type: 'GET',
                        url: "{{action('GroupController@getUsersGroupInitialData')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "group_id": '1'
                        },
                        success: function (data) {
                            allRoles = data.roles;
                            allUsers = data.users;
                            allUsersGroups = data.usersGroups;
                            usersAndRoles = data.usersAndRoles;
                            var currentUsersGroupsRoles = @json($currentUsersGroupsRoles);
                            var oldDataToSend = $('#usersgroups-input').val();
                            if(oldDataToSend !== null && oldDataToSend !== undefined && oldDataToSend !== ''){
                                dataToSend = JSON.parse(oldDataToSend);
                            }
                            else if (currentUsersGroupsRoles !== undefined && currentUsersGroupsRoles !== null
                                && currentUsersGroupsRoles !== {} && currentUsersGroupsRoles !== []) {
                                dataToSend = currentUsersGroupsRoles;
                                $('#usersgroups-input').val(JSON.stringify(dataToSend));
                            }
                            var ids = [];
                            var results = $.map(data.users, function (user) {
                                var defaultSelected = false;
                                if (dataToSend !== null && dataToSend !== undefined && dataToSend !== {} && dataToSend.users !== undefined && dataToSend !== null) {
                                    defaultSelected = setEditValues(dataToSend.users, user);
                                    if(defaultSelected){
                                        ids.push(user.id);
                                        var dynamicCard = createCard(user.id, user.last_name + " " + user.first_name);
                                        $('#usersCards .groups-no-roles-selected').css('display', 'none');
                                        var usersCards = $('#usersCards');
                                        usersCards.css('display', 'block');
                                        usersCards.append(dynamicCard);

                                    }
                                }
                                return {
                                    text: user.last_name + " " + user.first_name,
                                    id: user.id,
                                    selected:defaultSelected
                                };
                            });
                            $('#usersgroupsselect').select2({data: results});
                            $('#usersgroupsselect').trigger('change');
                            if (currentUsersGroupsRoles === null || currentUsersGroupsRoles === undefined ||
                                currentUsersGroupsRoles === {}) {
                            }
                        }
                    });
                })();

            </script>
        </div>

        {{--<label class="col-sm-2 control-label">Dodaj uporabnika v skupino</label>--}}
        {{--<div class="col-sm-10">--}}
        {{--<input type="checkbox"/>--}}
        {{--</div>--}}

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


    <div class="form-group" id="usersCards">
        <div class="groups-no-roles-selected col-sm-12">
            <p>
                Trenutno nimate izbranega nobenega uporabnika. Prosimo izberite enega uporabnika in nato boste lahko
                izbirali
                vloge za posameznega uporabnika.
            </p>
        </div>
    </div>

    {{--
    <div class="form-group">
        @foreach($roles as $role)
            <div class="col-sm-12">
                <div class="col-sm-2"></div>
                <label for="test{{$role->id}}" class="form-check col-sm-2">
                    {{$role->role_name}}
                </label>
                <input name="test{{$role->id}}" type="checkbox" class="form-input"/>
            </div>
            {{-<input type="checkbox" class="pull-left" />-}}
        @endforeach
    </div>--}}

    <script type="text/javascript">

        (function () {
            'use strict;'

            /*
            * Idea: We can try to pass group_id throught laravel -- by calling some javascript inside *.blade.php file.
            * this way we can send through double '{}' , laravel value
            * */
            $('#usersgroupsselect').on('select2:select', function (e) {
                // Do something
                //get user id = e.params.data.id
                var userid = e.params.data.id;
                var username = e.params.data.text;
                if(dataToSend === undefined || dataToSend === null || (dataToSend.users === null || dataToSend.users === undefined)){
                    dataToSend = { users:{}};
                }
                dataToSend.users[userid] = {id: userid, roles: {}};


                /*this is where we need to call createCard to create front-end representation of a card*/
                var dynamicCard = createCard(userid, username);
                console.log(dynamicCard);
                $('#usersCards .groups-no-roles-selected').css('display', 'none');
                var usersCards = $('#usersCards');
                usersCards.css('display', 'block');
                usersCards.append(dynamicCard);

                $('#usersgroups-input').val(JSON.stringify(dataToSend));

            });

            $('#usersgroupsselect').on('select2:unselect', function (e) {
                /*
                * e.params.data.id ---> user id
                * e.params.data.text ---> firstname + lastname
                * */
                delete dataToSend.users[e.params.data.id];
                $('#user-' + e.params.data.id + '-roles-card').remove();
                if ($('#usersCards').find('.col-sm-3').length === 0) {
                    $('#usersCards .groups-no-roles-selected').css('display', 'block');
                }
                $('#usersgroups-input').val(JSON.stringify(dataToSend));
            });


        })();

        function createCard(userid, username) {
            var dynamicCard = "" +
                "<div id='user-" + userid + "-roles-card' class='col-sm-3'>" +
                "<div class='box box-primary'>" +
                "<h2 class='profile-username text-center'>" + username + "</h2>" + createRoles(userid, allRoles, usersAndRoles) +
                "</div>" +
                "</div>";
            return dynamicCard;
        }

        function createRoles(userid, roles, usersAndRoles) {
            var usersToCheck = null;
            if(dataToSend.users !== undefined && dataToSend.users !== null){
                usersToCheck = dataToSend.users;
            }
            var checboxesToReturn = "";
            // for (var i = 0; i < roles.length; i++) {
            //     var roleExists = false;
            //     if(roles[i].id === 1) {
            //         continue;
            //     }
            //     if(usersToCheck !== null && usersToCheck[userid].roles[roles[i].id] !== undefined &&
            //         usersToCheck[userid].roles[roles[i].id] !== null &&
            //         parseInt(usersToCheck[userid].roles[roles[i].id])===parseInt(roles[i].id)){
            //         roleExists=true;
            //     }
            //     checboxesToReturn += "<div class='col-sm-12'><label class='col-sm-8' for='user-" + userid + "-role-checkbox'>" + roles[i].role_name + "</label> <div id='user-" + userid + "-role-checkbox' class='col-sm-4'> <input "+(roleExists === true ? "checked":"")+" onchange='roleCheckboxChange(" + userid + "," + roles[i].id + ")' type='checkbox' /></div></div>"
            // }
            for (var i = 0; i < usersAndRoles.length; i++) {
                var roleExists = false;
                if(parseInt(usersAndRoles[i].user_id) === parseInt(userid)) {
                    if (usersAndRoles[i].role_id === 1) {
                        continue;
                    }
                    if (usersToCheck !== null && usersToCheck[userid].roles[usersAndRoles[i].role_id] !== undefined &&
                        usersToCheck[userid].roles[usersAndRoles[i].role_id] !== null &&
                        parseInt(usersToCheck[userid].roles[usersAndRoles[i].role_id]) === parseInt(usersAndRoles[i].role_id)) {
                        roleExists = true;
                    }
                    checboxesToReturn += "<div class='col-sm-12'><label class='col-sm-8' for='user-" + userid + "-role-checkbox'>" + usersAndRoles[i].role_name + "</label> <div id='user-" + userid + "-role-checkbox' class='col-sm-4'> <input " + (roleExists === true ? "checked" : "") + " onchange='roleCheckboxChange(" + userid + "," + usersAndRoles[i].role_id + ")' type='checkbox' /></div></div>"
                }else{
                    continue;
                }
            }
            return checboxesToReturn;
        }

        function roleCheckboxChange(userid, roleid) {
            if (dataToSend.users[userid].roles[roleid] !== undefined && dataToSend.users[userid].roles[roleid] !== null) {
                delete dataToSend.users[userid].roles[roleid];
            } else {
                dataToSend.users[userid].roles[roleid] = roleid;//"Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\n" +
                "\n";
            }
            $('#usersgroups-input').val(JSON.stringify(dataToSend));

        }
    </script>
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
