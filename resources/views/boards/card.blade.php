<div class="box" style="background-color: {{ $card->color }}" ondblclick="openCard({{ $card->id }})">
    <div class="box-header">
        <small>{{ $card->order }}</small>
        <h5 class="box-title">
            {{ $card->card_name }}
        </h5>
        <button type="button" class="btn btn-default openCard"
                data-card-id="{{ $card->id }}" data-toggle="modal" data-target="#cardModal"
                style="float: right;">
            <i class="fa fa-bars"></i>
        </button>
        <br>
        <small>pooblaščeni (id): {{ $card->user_id }}</small>
        <br>
        <small>Projekt (id): {{ $card->project_id }}</small>

    </div>

    <div class="box-body">


    </div>

    @include('modals.modal')

</div>