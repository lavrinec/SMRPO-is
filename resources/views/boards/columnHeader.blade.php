{{--<pre style="width: 100%; text-align: center; margin: 0px; padding: 0px;">--}}
    {{--id: {{ substr($column["id"], 0, 6) }}--}}
{{--</pre>--}}

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
    <h4 style="margin-top: 0px;">

        <small>({{ substr($column["id"], 0, 6) }})</small>
        {{ $column["column_name"] }}
        [ <span id="numOfAllCards_{{$column["id"]}}"></span> / {{ $column["WIP"] }} ]
        <span style="float: right;"><i class="fa fa-compress"></i></span>
    </h4>

    {{ $column["description"] }}
    <br>

    @if(isset($column['high_priority']) && ($column['high_priority'] == 1 || $column['high_priority'] == "true"))
        Stolpec za nujne kartice
        <br>
    @endif

    @if(isset($column['start_border']) && ($column['start_border'] == 1 || $column['start_border'] == "true"))
        Začetni mejni
        <br>
    @endif

    @if(isset($column['end_border']) && ($column['end_border'] == 1 || $column['end_border'] == "true"))
        Končni mejni
        <br>
    @endif

    @if(isset($column['acceptance_testing']) && ($column['acceptance_testing'] == 1 || $column['acceptance_testing'] == "true"))
        Stolpec za sprejemno testiranje
    @endif

</div>


<script>

    $( document ).ready(function() {
        var numOfCards = sumAllChildrenCardsHeader('{!!$column["id"]!!}');

        $("#numOfAllCards_{!!$column["id"]!!}")[0].innerText = numOfCards;
        console.log($("#numOfAllCards_{!!$column["id"]!!}")[0]);

    });




    function sumAllChildrenCardsHeader(columnid) {
        var column = allColumns.find(function (element) {
            return element.id == columnid;
        });

        var currNumOfCards = column.cards.length;

        if(column.all_children_cards.length > 0){
            $.each(column.all_children_cards, function (i, currentChild) {
                var childNumOfCards = sumAllChildrenCards(currentChild.id);
                currNumOfCards += childNumOfCards;
            });
        }

        return currNumOfCards;
    }
</script>