<div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{ $users->first_name }} {{ $users->last_name }}</h3>

            <p class="text-muted text-center">{{ $users->email }}</p>

            <h4>Vloge</h4>
            <ul class="list-group list-group-unbordered">
                @foreach($users->roles as $role)
                    <li class="list-group-item">
                        {{ $role['role_name'] }}
                    </li>
                @endforeach


            </ul>

            {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</div>
