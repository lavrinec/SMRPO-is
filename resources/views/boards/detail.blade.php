<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center">{{ $board->board_name }}</h3>

        <p class="text-muted text-center">{{ $board->description }}</p>

        <h4>Projekti na tabli</h4>
        <ul class="list-group list-group-unbordered">
        @if($board->projects->first()!=null)
            @foreach($board->projects as $project)
                <li class="list-group-item">
                    {{$project->board_name}}
                </li>
            @endforeach
        @else
            {{"Tej tabli še ni dodeljen projekt"}}
        @endif
    


        </ul>

        <p>

            <button type="button" class="btn btn-primary openCard" data-card-id="0" data-collumn-id="1" data-board-id="{{ $board->id }}">Dodaj kartico</button>
            <button type="button" class="btn btn-primary openCard" data-card-id="1">Uredi kartico</button>
            @include('modals.modal')
        </p>
        {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


