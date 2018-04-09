<div class="box" style="background-color: {{ $card->color }}" ondblclick="openCard({{ $card->id }})">
    <div class="box-header">
        <small>{{ $card->order }}</small>
        <h5 class="box-title">
            {{ $card->card_name }}
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

    <div class="box-body">


    </div>

    @include('modals.modal')

</div>