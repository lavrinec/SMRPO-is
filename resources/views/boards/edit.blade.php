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
                                        <label for="test" class="col-sm-2 control-label">Projekti</label>
                                        <div class="col-sm-10">
                                        <select class="form-control" name="projects[]" id="usersgroupsselect" multiple="multiple">
        
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}"
                                                    {{ $board->projects->contains('id', $project->id) ? 'selected' : '' }}
                                                    {{ $project->deactivated ? 'disabled' : '' }}>{{ $project->board_name }}</option>
                                        @endforeach
                                        </select>
                                            </div>
                                    </div>

                                     

                                    <div class="col-sm-3">
                                        <label for="board_name" class="col-sm-2 control-label">Ime</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="test" name="board_name"
                                                   value="{{ $board->board_name }}" required>
                                            @if ($errors->has('board_name'))
                                                <span class="help-block">{{ $errors->first('board_name') }}</span>
                                            @endif
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


                                    <div class="col-sm-offset-1 col-sm-2">
                                        <button id="buttonFirstColumn" type="button" class="btn btn-success"
                                                onclick="addFirstColumn(this)">
                                            Dodaj začetni stolpec
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


                                <div style="height:200px;"></div>


                                <!--DEMO DIVs FOR DRAG & DROP -->
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
                                <!--DEMO DIVs FOR DRAG & DROP -->


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

        function addFirstColumn(obj) {
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
                    obj.setAttribute('disabled', 'disabled');

                    // collapse sidebar and focus the board
                    $('body').addClass('sidebar-collapse');
                    $('html,body').animate({scrollTop: $("#board-canvas").offset().top}, 'slow');

                    $("#board-canvas").append(data);
                }
            });
        }

        function addColumnBefore(column) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': $("#"+column.id+"_parent_id")[0].value,
                    'parent_name': $("#"+column.id+"_parent_name")[0].value.replace('[' + column.id + ']',''),
                    'level': parseInt($("#"+column.id+"_level")[0].value)
                },
                success: function (data) {
                    $(data).insertBefore($("#" + column.id));
                    redoLeftIds();

                }
            });
        }

        function addColumnAfter(column) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': $("#"+column.id+"_parent_id")[0].value,
                    'parent_name': $("#"+column.id+"_parent_name")[0].value.replace('[' + column.id + ']',''),
                    'level': parseInt($("#"+column.id+"_level")[0].value)
                },
                success: function (data) {
                    $(data).insertAfter($("#" + column.id));
                    redoLeftIds();
                }
            });
        }


        function addFirstSubColumnTo(column) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': column.id,
                    'parent_name': $("#"+column.id+"_parent_name")[0].value + '[childs]',
                    'level': parseInt($("#"+column.id+"_level")[0].value)+1
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
            $(".column").each(function(i, current) {
                var left_id = null;
                if($("#" + current.id).prev()[0]) {
                    left_id = $("#" + current.id).prev()[0].id; // left_id
                }

                // set left_id of curr to prev_id
                $("#"+current.id+"_left_id")[0].value = left_id;
            });
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