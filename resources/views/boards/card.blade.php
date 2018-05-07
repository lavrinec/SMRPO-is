<div class="box grabbable" style="background-color: {{ $card->color }}; " ondblclick="openCard({{ $card->id }})"
     data-card-id="{{ $card->id }}">
    <div class="box-header">
        <small>{{ $card->order }}</small>
        <h5 class="box-title">
            {{ $card->card_name }}


            @if(isset($card->is_silver_bullet) && ($card->is_silver_bullet == 1 || $card->is_silver_bullet == "true"))
                <i class="fa fa-asterisk" title="nujna kartica"></i>
                @else
                ni
            @endif

            @if(isset($card->is_critical) && ($card->is_critical == 1 || $card->is_critical == "true"))
                <i class="fa fa-bell" title="kritična kartica"></i>
                @else
                ni
            @endif

        </h5>
        <br>
        <small>pooblaščeni:
            @if($card->user)
                {{ $card->user["first_name"] }} {{ $card->user["last_name"] }}
            @else
                -
            @endif
        </small>
        <br>
        <small>Projekt: {{ $card->project["board_name"] }}</small>

    </div>

    {{--<div class="box-body">--}}
    {{----}}
    {{--</div>--}}

</div>