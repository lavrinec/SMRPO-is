<div class="column level{{ $level }}" id="{{ $column_id }}">
    <div class="box">
        <pre style="width: 100%; text-align: center; line-height: 0.2em;">začasni id: {{ substr($column_id, 0, 6) }}
        </pre>

        <input type="hidden" id="{{ $column_id }}_parent_id"
               name="column{{ $parent_name }}[{{ $column_id }}][parent_id]" value="{{ $parent_id }}">

        <input type="hidden" id="{{ $column_id }}_parent_name"
               name="column{{ $parent_name }}[{{ $column_id }}][parent_name]"
               value="{{ $parent_name }}[{{ $column_id }}]">


        <input type="hidden" id="{{ $column_id }}_left_id" name="column{{ $parent_name }}[{{ $column_id }}][left_id]"
               value="{{ $left_id }}">

        {{--<input type="hidden" id="{{ $column_id }}_column_id" name="{{ $column_id }}_column_id" value="{{ $column_id }}">--}}
        <input type="hidden" id="{{ $column_id }}_column_id" name="column{{ $parent_name }}[{{ $column_id }}][id]"
               value="{{ $column_id }}">

        <input type="hidden" id="{{ $column_id }}_level" name="column{{ $parent_name }}[{{ $column_id }}][level]"
               value="{{ $level }}">

        <div class="box-header">
            <h5 class="box-title">

                {{ $column_name }} &nbsp;[  | {{ $WIP }} ]

                {{--{{ count($cards) }}--}}

            </h5>
            <div>
                {{ $description }}
                <br>
                @if($start_border)
                    <span>
                        Začetni mejni
                    </span>
                    <br>
                @endif

                @if($end_border)
                    <span>
                        Končni mejni
                    </span>
                    <br>
                @endif

                @if($high_priority)
                    <span>
                        Stolpec za nujne kartice
                    </span>
                    <br>
                @endif

                @if($acceptance_testing)
                    <span>
                        Stolpec za sprejemno testiranje
                    </span>
                    <br>
                @endif

                <button type="button" class="btn btn-default col-sm-3" onclick="">
                    tu lahko pride gumb za dodajanje kartice
                </button>
            </div>
        </div>

        <div class="box-body" style="border-top: solid black 1px;">
            <div class="canvas subcanvas row" id="{{ $column_id }}_subcanvas"
                 style="margin-left: 0px; margin-right: 0px">

                {{--{{ $cards }}--}}


                

                @foreach($cards as $card)
                    @include("boards.card", ['card' => (object)$card])

                @endforeach

            </div>
        </div>
    </div>
</div>