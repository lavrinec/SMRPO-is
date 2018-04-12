<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        {{--<h3 class="profile-username text-center">{{ $groups->group_name }}</h3>--}}

        {{--<p class="text-muted text-center">{{ $groups->description }}</p>--}}

        <h3 class="profile-username text-center">Uporabniki v skupini</h3>
        @if(isset($usersGroup) && $usersGroup->first() != null)
            <ul class="list-group list-group-unbordered list-unstyled">

                @foreach($usersGroup as $user)
                    {{--@dd($role['group_id'])--}}
                    <li class="">
                        @if(!Auth::user()->isAdmin())
                            <h5 class="text-bold text-muted">{{ $user->first_name }} {{ $user->last_name }}</h5>
                        @else
                            <h5 class="text-bold text-muted"><a href="/users/{{$user->id}}/show">{{ $user->first_name }} {{ $user->last_name }}</a></h5>
                        @endif
                        @if(isset($usersGroupRoles) && $usersGroupRoles->first() != null)
                            {{--<h4>--}}
                                {{--<small>--}}
                                    {{--Vloge--}}
                                {{--</small>--}}
                            {{--</h4>--}}
                            <ul class="" style="list-style: none;">
                                @foreach($usersGroupRoles as $userGroupRole)
                                    {{--@dd($userGroupRole)--}}
                                    @if($userGroupRole->user_id == $user->id && $userGroupRole->deleted_at == null)
                                        <li><p>
                                                <small>
                                                    {{$userGroupRole->role_name}}
                                                </small>
                                            </p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach


            </ul>
        @else
            <p class="text-muted">
                Noben uporabnik ni določen k tej skupini.
            </p>
        @endif

        {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


