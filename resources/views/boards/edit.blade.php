@extends('default.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tabla
            </h1>
        </section>

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


                                    <div class="col-sm-offset-1 col-sm-2">
                                        <button type="button" class="btn btn-success" onclick="addColumn()">
                                            Dodaj stolpec
                                        </button>
                                    </div>


                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-primary">Shrani tablo</button>

                                        <a href="{{ action('BoardController@show', $board->id) }}"
                                           class="btn btn-danger">Prekliči</a>
                                    </div>
                                </div>


                                <style>
                                    /* The heart of the matter */
                                    .testimonial-group {
                                        width: 100%;
                                    }

                                    .canvas {
                                        overflow-x: auto;
                                        white-space: nowrap;
                                    }

                                    .subcanvas {
                                        overflow-x: hidden;
                                    }

                                    .canvas > .column {
                                        display: inline-block;
                                        /*float: none;*/
                                        min-width: 320px;
                                        padding: 5px;
                                        background: #69c;
                                    }

                                    /* Decorations */
                                    .column {

                                    }

                                    .column > .box {
                                        display: inline-block;
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


                                <div style="height:200px;"></div>


                                <div class="container" style="width: 100%;">

                                    <div class="box" style="float:left;">
                                        <div class="box-header">stolpec 0</div>

                                        <div id="column0" class="container box-body"
                                             style="border: solid black 1px; width: 150px; height: 200px; float: left;">
                                            <div style="background: lightblue;">test1</div>
                                            <div style="background: lightgreen;">test2</div>
                                            <div style="background: lightgrey;">test3</div>

                                        </div>
                                    </div>


                                    <div class="row" style="float:left;">
                                        <div class="col-sm-12">stolpec 1</div>

                                        <div id="column1" class="container col-sm-12"
                                             style="border: solid black 1px; width: 150px; height: 200px; float: left;">
                                            <div style="background: lightblue;">test1</div>
                                            <div style="background: lightgreen;">test2</div>
                                            <div style="background: lightgrey;">test3</div>

                                        </div>
                                    </div>


                                    <div class="row" style="float:left;">
                                        <div class="col-sm-12">stolpec 2</div>
                                        <div id="column2" class="container col-sm-12"
                                             style="border: solid black 1px; width: 150px; height: 200px; float: left;">


                                            <div class="row" style="float:left; width: 80px;">
                                                <div class="col-sm-12">st 2_1</div>
                                                <div id="column21" class="container col-sm-12"
                                                     style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                                </div>
                                            </div>

                                            <div class="row" style="float:left; width: 70px;">
                                                <div class="col-sm-12">st 2_2</div>
                                                <div id="column22" class="container col-sm-12"
                                                     style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" style="float:left;">
                                        <div class="col-sm-12">stolpec 3</div>

                                        <div id="column3" class="container col-sm-12"
                                             style="border: solid black 1px; width: 150px; height: 200px; float: left;">

                                        </div>
                                    </div>


                                    <div class="row" style="float:left;">
                                        <div class="col-sm-12">stolpec 4</div>
                                        <div id="column4" class="container col-sm-12"
                                             style="border: solid black 1px; width: 150px; height: 200px; float: left;">


                                            <div class="row" style="float:left; width: 80px;">
                                                <div class="col-sm-12">st 4_1</div>
                                                <div id="column41" class="container col-sm-12"
                                                     style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                                </div>
                                            </div>

                                            <div class="row" style="float:left; width: 70px;">
                                                <div class="col-sm-12">st 4_2</div>
                                                <div id="column42" class="container col-sm-12"
                                                     style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                                </div>
                                            </div>

                                        </div>
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
         * Addding and deleting columns
         *
         * */

        function addColumn() {

            $.ajax({
                type: 'GET',
                url: "{{ action('BoardController@addColumn') }}",
                success: function (data) {
                    $("#board-canvas").append(data);
                }
            });
        }

        function addColumnBefore(column) {

//            $( "p" ).insertBefore( "#foo" ); // add <p> before #foo

            $.ajax({
                type: 'GET',
                url: "{{ action('BoardController@addColumn') }}",
                success: function (data) {
//                    $("#board-canvas").append(data);

                    $(data).insertBefore($("#" + column.id));

                }
            });
        }

        function addColumnAfter(column) {

            $.ajax({
                type: 'GET',
                url: "{{ action('BoardController@addColumn') }}",
                success: function (data) {
//                    $("#board-canvas").append(data);

                    $(data).insertAfter($("#" + column.id));
                }
            });
        }


        function addSubColumnTo(column) {
            $.ajax({
                type: 'GET',
                url: "{{ action('BoardController@addColumn') }}",
                success: function (data) {
                    $("#" + column.id + "_subcanvas").append(data);

                    var currentParrentWidth = $("#" + column.id).width();
                    console.log(currentParrentWidth);

                    if(currentParrentWidth>320) {
//                        $("#" + column.id).css({"min-width": currentParrentWidth + 20 + "px"});
                    }
                }
            });
        }


        function deleteColumn(column) {
            console.log(column);
            column.parentNode.removeChild(column);
            return false;
        }


        /*
         * Drag&Drop functionality provided by Dragula
         *
         * array of divs that should be drag&drop enabled
         * */
        dragula([
            document.querySelector('#column0'),
            document.querySelector('#column1'),
            // document.querySelector('#column2'),
            document.querySelector('#column21'),
            document.querySelector('#column22'),

            document.querySelector('#column3'),
            // document.querySelector('#column4'),
            document.querySelector('#column41'),
            document.querySelector('#column42'),
        ]);


    </script>



@endsection