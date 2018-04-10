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


<div class="row">

    <div class="col-sm-3">
        <h4 class="">
            {{ $column["column_name"] }}
        </h4>
        <br>
        {{ $column["description"] }}
        <br>
        WIP: {{ $column["WIP"] }}
        <br>
        &nbsp;
    </div>

    <div class="col-sm-9">
        @if($column["start_border"])
            Začetni mejni
        @endif
        <br>

        @if($column["end_border"])
            Končni mejni
        @endif
        <br>

        @if($column["high_priority"])
            Stolpec za nujne kartice
        @endif
        <br>

        @if($column["acceptance_testing"])
            Stolpec za sprejemno testiranje
        @endif

    </div>

</div>