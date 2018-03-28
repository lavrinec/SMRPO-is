<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center">{{ $groups->group_name }}</h3>

        <p class="text-muted text-center">{{ $groups->description }}</p>

        <h4>Uporabniki v skupini</h4>
        @if(isset($groups) && isset($groups->users) && $groups->users->first() != null)
            <ul class="list-group list-group-unbordered">
                @foreach($groups->users as $user)
                    {{--@dd($role['group_id'])--}}
                    <li class="list-group-item">
                        {{ $user->first_name }}
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


