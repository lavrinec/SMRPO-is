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
                            <h3 class="box-title">{{ $board->board_name }}</h3>
                            <div>
                                {{ $board->description }}
                            </div>
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
                                                            {{ $project->deactivated ? 'disabled' : '' }}>{{ $project->board_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                        /*min-height: 434px;*/
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


        /*
         * Drag&Drop functionality provided by Dragula
         *
         * array of divs that should be drag&drop enabled
         * */
        var containers = [
        ];

        var drake = dragula({
            containers: containers
        });


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
            // structuredColumnsCards
            
            if (rootColumns.length > 0) {

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

                    addExistingCards(columns[key].cards, columns[key].id + "_subcanvas");


                    lvl += 1;
                    pn += '['+ columns[key].id + '][childs]';
                    forColumns(columns[key].all_children_cards, columns[key].id + "_subcanvas", pn, lvl);
                    // allChildrenCards
                }
            }
        }


        function addExistingColumn(columnData, place) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@columnShow') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'column_data': columnData
                },
                success: function (data) {
                    $("#" + place).append(data);

                    // allChildrenCards
                    if(columnData.all_children_cards.length == 0){
                        var container = $("#"+columnData.id+"_subcanvas")[0];
                        drake.containers.push(container);
                    }

                }
            });
        }


        function addExistingCards(cards, place) {
            console.log("function for viewing the cards");
            console.log(cards);
            console.log(place);
        }





    </script>



@endsection