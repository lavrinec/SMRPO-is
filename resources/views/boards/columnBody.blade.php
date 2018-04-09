@foreach($cards as $card)
    @if($card["project_id"] == $project_id)

        @include("boards.card", ['card' => (object)$card])
    @endif
@endforeach