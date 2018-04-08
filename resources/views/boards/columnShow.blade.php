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
            <div class="row">

                <div class="col-sm-4">
                    <h5 class="box-title">
                        {{ $column_name }}
                    </h5>
                    <br>
                    {{ $description }}
                    <br>
                    WIP: {{ $WIP }}
                    <br>
                    &nbsp;
                </div>

                <div class="col-sm-8">
                    @if($start_border)
                        Začetni mejni
                    @endif
                    <br>

                    @if($end_border)
                        Končni mejni
                    @endif
                    <br>

                    @if($high_priority)
                        Stolpec za nujne kartice
                    @endif
                    <br>

                    @if($acceptance_testing)
                        Stolpec za sprejemno testiranje
                    @endif

                </div>

            </div>
            {{--<button type="button" class="btn btn-default col-sm-3" onclick="">--}}
            {{--tu lahko pride gumb za dodajanje kartice--}}
            {{--</button>--}}
        </div>

        <div class="box-body" style="border-top: solid black 1px;">
            <div class="canvas subcanvas row" id="{{ $column_id }}_subcanvas"
                 style="margin-left: 0px; margin-right: 0px">


                @foreach($projects as $project)

                    <div class="box-body" id="{{ $column_id }}_{{ $project['id'] }}_subsubcanvas" style="border: 1px solid black;">

                        <script>
                            var container = $("#"+{{ $column_id }}+"_"+{{ $project['id'] }}+"_subsubcanvas")[0];
                            drake.containers.push(container);

                        </script>

                        @foreach($cards as $card)
                            @if($card["project_id"] == $project['id'])

                                @include("boards.card", ['card' => (object)$card])
                            @endif
                        @endforeach
                    </div>

                @endforeach


            </div>
        </div>
    </div>
</div>