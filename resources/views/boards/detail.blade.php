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

        <p>

            @if(Auth::user()->isPO() || Auth::user()->isKM())
                <button type="button" class="btn btn-primary openCard" data-card-id="0" data-board-id="{{ $board->id }}">Dodaj kartico</button>
            @endif
            <button type="button" class="btn btn-primary openCard" data-card-id="1">Uredi kartico 1</button>
            <button type="button" class="btn btn-primary openCard" data-card-id="2">Uredi kartico 2</button>
            @include('modals.modal')
        </p>
        {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


