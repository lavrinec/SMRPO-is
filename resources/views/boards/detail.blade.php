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

            @if(Auth::user()->isPO() || Auth::user()->isKM())
                <form action="{{ route('boards.copy', ['board' => $board]) }}" method="POST">
                    <input type="hidden" class="form-control" id="_token" name="_token" value="{{ csrf_token() }}">
                    <button type="submit"
                       class="btn btn-primary btn-block">
                        <b>Kopiraj</b>
                    </button>
                </form>
                <hr>
                <button type="button" class="btn btn-primary openCard" data-card-id="0"
                        data-board-id="{{ $board->id }}">Dodaj kartico
                </button>
            @endif
            <br><br>
        @foreach($board->cards as $card)
            <p>
                <button type="button" class="btn btn-primary openCard"
                        data-card-id="{{ $card->id }}">{{ $card->card_name }}</button>
            </p>
            @endforeach

            @include('modals.modal')
            </p>


            <a href="{{ action('BoardController@focus', $board->id) }}"
               class="btn btn-success btn-block">
                <b>Prikaži</b>
            </a>



            {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


