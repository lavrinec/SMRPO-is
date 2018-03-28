<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center">{{ $board->board_name }}</h3>

        <p class="text-muted text-center">{{ $board->description }}</p>

        <h4>Projekti na tabli</h4>
        <ul class="list-group list-group-unbordered">
            {{--@foreach($users->usersRoles as $role)--}}
                <li class="list-group-item">
                    Projekti na tabli TODO
                </li>
            {{--@endforeach--}}


        </ul>

        {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


