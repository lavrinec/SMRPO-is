@extends('default.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            {{--<h1>--}}
            {{--Tabla--}}
            {{--</h1>--}}
        </section>

        @include('layout.error')

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-md-12">

                    {{-- div for data form --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Urejanje table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" method="POST"
                                  action="{{ action('BoardController@update', $board->id) }}">

                                @csrf


                                <div class="form-group">

                                    <div class="col-sm-3">
                                        <label for="test" class="col-sm-3 control-label">Projekti</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="projects[]" id="usersgroupsselect"
                                                    multiple="multiple">

                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                            {{ $board->projects->contains('id', $project->id) ? 'selected' : '' }}
                                                            {{ ($project->deactivated) ? 'disabled' : '' }}
                                                            >{{ $project->board_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="board_name" class="col-sm-2 control-label">Ime</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="board_name" name="board_name"
                                                   value="{{ $board->board_name }}" required>
                                            @if ($errors->has('board_name'))
                                                <span class="help-block">{{ $errors->first('board_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="description" class="col-sm-2 control-label">Opis</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="description" name="description"
                                                   value="{{ $board->description }}" required>
                                            @if ($errors->has('description'))
                                                <span class="help-block">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-primary">Shrani tablo</button>

                                        <a href="{{ action('BoardController@show', $board->id) }}"
                                           class="btn btn-danger">Prekliči</a>
                                    </div>


                                    <div class="col-sm-2">
                                        <button id="buttonFirstColumn" type="button" class="btn btn-success"
                                                onclick="addFirstColumn(this)">
                                            Dodaj začetni stolpec
                                        </button>
                                    </div>

                                </div>




                                <style>
                                    /* The heart of the matter */
                                    .testimonial-group {
                                        width: 100%;
                                        min-height: 100vh;
                                        background: lightgrey;

                                        /*overflow-y: auto;*/
                                    }

                                    .canvas {
                                        overflow-x: auto;
                                        white-space: nowrap;
                                    }

                                    /*.subcanvas {*/
                                    /*overflow-x: hidden;*/
                                    /*}*/

                                    .canvas > .column {
                                        display: inline-block;
                                        /*float: none;*/

                                        min-width: 320px;
                                        min-height: 434px;
                                        /*min-height: 100%;*/

                                        /*padding: 5px;*/
                                        border: 5px solid #69c;
                                        vertical-align: top;
                                    }

                                    /* Decorations */

                                    .column > .box {
                                        /*display: inline-block;*/
                                        margin: 0px;
                                    }

                                    /*.column:nth-child(3n+1) {*/
                                    /*background: #c69;*/
                                    /*}*/

                                    /*.column:nth-child(3n+2) {*/
                                    /*background: #9c6;*/
                                    /*}*/

                                    /*.column:nth-child(3n+3) {*/
                                    /*background: #69c;*/
                                    /*}*/


                                </style>


                                <div class="container testimonial-group">
                                    <div class="row canvas" id="board-canvas">
                                        {{-- Here go the columns! --}}

                                        {{--@include('boards.column')--}}

                                    </div>
                                </div>



                            </form>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->




    <!-- JS needed to enable board manipulation -->
    <!-- adding and deleting columns -->
    <!-- drag&drop functionality between columns -->

    <script>


        window.onload = function () {
            makeExisting();
        };


        /*
         * Create and Show already existing columns (if editing saved board)
         *
         * */

        function makeExisting() {
            var board = {!! $board !!};

            var rootColumns = board.structured_columns_cards;

            if (rootColumns.length > 0) {
                $("#buttonFirstColumn")[0].setAttribute('disabled', 'disabled');

                // sort by order (currently on each level starts from beginning)
                rootColumns.sort(compare);

                // array, location, parent-name, level
                forColumns(rootColumns, 'board-canvas', '', 0);

            }
        }


        function compare(a, b) {
            if (a.order < b.order)
                return -1;
            if (a.order > b.order)
                return 1;
            return 0;
        }


        function forColumns(columns, place, parent_name, level) {
            // just append to the canvas

            columns.sort(compare);

            for (var key in columns) {
                if (columns.hasOwnProperty(key)) {

                    var lvl = Number(level);
                    columns[key]['level'] = lvl;

                    var pn = parent_name.slice(0);
                    columns[key]['parent_name'] = pn;

                    addExistingColumn(columns[key], place);

                    lvl += 1;
                    pn += '['+ columns[key].id + '][childs]';
                    forColumns(columns[key].all_children_cards, columns[key].id + "_subcanvas", pn, lvl);
                }
            }
        }


        function addExistingColumn(columnData, place) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'column_data': columnData
                },
                success: function (data) {
                    $("#" + place).append(data);
                    console.log(columnData);
                }
            });
        }


        /*
         * Addding and deleting columns
         *
         * */

        function addFirstColumn(triggerButton) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "parent_id": null,
                    "parent_name": null,
                    'level': 0
                },
                success: function (data) {
                    // disable [add first column] button
                    triggerButton.setAttribute('disabled', 'disabled');

                    // collapse sidebar and focus the board
                    $('body').addClass('sidebar-collapse');
                    $('html,body').animate({scrollTop: $("#board-canvas").offset().top}, 'slow');

                    $("#board-canvas").append(data);
                }
            });
        }

        function addColumnBefore(column) {
            if (typeof column == 'number') {
                column = $("#" + column)[0];
            }
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': $("#" + column.id + "_parent_id")[0].value,
                    'parent_name': $("#" + column.id + "_parent_name")[0].value.replace('[' + column.id + ']', ''),
                    'level': parseInt($("#" + column.id + "_level")[0].value)
                },
                success: function (data) {
                    $(data).insertBefore($("#" + column.id));
                    redoLeftIds();

                }
            });
        }

        function addColumnAfter(column) {
            console.log(typeof column);

            if (typeof column == 'number') {
                column = $("#" + column)[0];
            }

            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': $("#" + column.id + "_parent_id")[0].value,
                    'parent_name': $("#" + column.id + "_parent_name")[0].value.replace('[' + column.id + ']', ''),
                    'level': parseInt($("#" + column.id + "_level")[0].value)
                },
                success: function (data) {
                    $(data).insertAfter($("#" + column.id));
                    redoLeftIds();
                }
            });
        }


        function addFirstSubColumnTo(column) {
            if (typeof column == 'number') {
                column = $("#" + column)[0];
            }
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': column.id,
                    'parent_name': $("#" + column.id + "_parent_name")[0].value + '[childs]',
                    'level': parseInt($("#" + column.id + "_level")[0].value) + 1
                },
                success: function (data) {
                    // disable [add first subcolumn] button
                    $("#" + column.id + "_addFirstSubcolumn")[0].setAttribute('disabled', 'disabled');
                    $("#" + column.id + "_subcanvas").append(data);
                    redoLeftIds();
                }
            });
        }


        function deleteColumn(column) {
            if (typeof column == 'number') {
                column = $("#" + column)[0];
            }
            var parent = column.parentNode;
            column.parentNode.removeChild(column);
            checkIfEmpty(parent);
            redoLeftIds();
            return false;
        }

        function checkIfEmpty(parent) {
            if ($("#" + parent.id)[0].childElementCount == 0) {
                if (parent.id == 'board-canvas') {
                    $("#buttonFirstColumn")[0].removeAttribute("disabled");
                }

                var splitedID = parent.id.split("_");
                // splitedID[0] = random string = column id
                //splitedID[1] = subcanvas

                if (splitedID[1] == "subcanvas") {
                    console.log(parent.id + "je prazen");
                    $("#" + splitedID[0] + "_addFirstSubcolumn")[0].removeAttribute('disabled');
                }
            }
        }

        function redoLeftIds() {
            $(".column").each(function (i, current) {
                var left_id = null;
                if ($("#" + current.id).prev()[0]) {
                    left_id = $("#" + current.id).prev()[0].id; // left_id
                }

                // set left_id of curr to prev_id
                $("#" + current.id + "_left_id")[0].value = left_id;
            });
        }

        function checkChecked(clickedItem, group) {
            if (typeof clickedItem == 'number') {
                clickedItem = $("#"+clickedItem+"_"+group)[0];
            }
            else{
                clickedItem = $("#"+clickedItem.id+"_"+group)[0];
            }

            var groupItems = $( "input[name*="+group+"]");

            if(clickedItem.checked){
                groupItems.each(function (i, current) {
                    if(current != clickedItem){
                        console.log(current.checked);

                        if(current.checked){
                            if (confirm("Kot " + group + "je že označen drug stolpec." +
                                    "\n Ali želite spremeniti?")) {
                                $("#"+current.id).prop('checked', false);
                            } else {
                                $("#"+clickedItem.id).prop('checked', false);
                            }
                        }

                    }
                });
            }
        }


    </script>



@endsection