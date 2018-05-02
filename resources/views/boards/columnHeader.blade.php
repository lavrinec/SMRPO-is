<pre style="width: 100%; text-align: center; line-height: 0.2em;">id: {{ substr($column["id"], 0, 6) }}</pre>

{{--<input type="hidden" id="{{ $column->column_id }}_parent_id"--}}
       {{--name="column{{ $column->parent_name }}[{{ $column->column_id }}][parent_id]" value="{{ $column->parent_id }}">--}}

{{--<input type="hidden" id="{{ $column->column_id }}_parent_name"--}}
       {{--name="column{{ $column->parent_name }}[{{ $column->column_id }}][parent_name]"--}}
       {{--value="{{ $column->parent_name }}[{{ $column->column_id }}]">--}}


{{--<input type="hidden" id="{{ $column->column_id }}_left_id" name="column{{ $column->parent_name }}[{{ $column->column_id }}][left_id]"--}}
       {{--value="{{ $column->left_id }}">--}}

{{--<input type="hidden" id="{{ $column_id }}_column_id" name="{{ $column_id }}_column_id" value="{{ $column_id }}">--}}
{{--<input type="hidden" id="{{ $column->column_id }}_column_id" name="column{{ $column->parent_name }}[{{ $column_id }}][id]"--}}
       {{--value="{{ $column->column_id }}">--}}

{{--<input type="hidden" id="{{ $column->column_id }}_level" name="column{{ $column->parent_name }}[{{ $column->column_id }}][level]"--}}
       {{--value="{{ $column->level }}">--}}

    <div class="box-body">
        <h4>
            {{ $column["column_name"] }}
        </h4>
        {{--<br>--}}

        {{ $column["description"] }}
        <br>
        WIP: {{ $column["WIP"] }}
        <br>

        <hr>
        testiranje izrazov: <br>
        isset: {{ isset($column['high_priority']) }} <br>
        ==1: {{ $column['high_priority'] == 1 }} <br>
        ==true: {{ $column['high_priority'] == true }} <br>
        ==1 OR ==true: {{ ($column['high_priority'] == 1 || $column['high_priority'] == true) }} <br>
        isset AND (==1 OR ==true): {{ isset($column['high_priority']) && ($column['high_priority'] == 1 || $column['high_priority'] == true) }}
        <br>

        konec testiranja izrazov
        <hr>
        <br>



        @if(isset($column['high_priority']) && ($column['high_priority'] == 1 || $column['high_priority'] == true))
            Stolpec za nujne kartice
            <br>
        @endif

        @if(isset($column['start_border']) && ($column['start_border'] == 1 || $column['start_border'] == true))
            Začetni mejni
            <br>
        @endif
       
        @if(isset($column['end_border']) && ($column['end_border'] == 1 || $column['end_border'] == true))
            Končni mejni
            <br>
        @endif

        @if(isset($column['acceptance_testing']) && ($column['acceptance_testing'] == 1 || $column['acceptance_testing'] == true))
            Stolpec za sprejemno testiranje
        @endif

    </div>
