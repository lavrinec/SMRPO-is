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

                    <div class="box">
                        <div class="box-header">

                            @if(($isKM = Auth::user()->isKM()) || Auth::user()->isPO())
                                @if($isKM)
                                    <a href="{{ action('BoardController@edit', $board->id) }}"
                                       class="btn btn-primary pull-right">
                                        <b>Uredi</b>
                                    </a>
                                    <div class="pull-right">&nbsp;&nbsp;&nbsp;</div>
                                @endif
                                <button type="button" class="btn btn-primary openCard pull-right" data-card-id="0"
                                        data-board-id="{{ $board->id }}">Dodaj kartico
                                </button>
                            @endif
                            <h3 class="box-title">{{ $board->board_name }}</h3>
                            <div>
                                {{ $board->description }}
                                <br>
                                <div>Projekti:
                                    @foreach($board->projects as $project)
                                        {{ $project->board_name }},
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">


                            <style>
                                /* The heart of the matter */
                                .testimonial-group {
                                    width: 100%;
                                    min-height: 100vh;
                                    /*background: lightgrey;*/

                                    /*overflow-y: auto;*/
                                }

                                #board-holder.fullscreen{
                                    z-index: 9999;
                                    width: 100%;
                                    height: 100%;
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }

                                .canvas {
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }

                                .subcanvas {
                                    min-height: 200px;
                                }

                                .canvas > .column {
                                    display: inline-block;
                                    /*float: none;*/

                                    min-width: 320px;
                                    /*min-height: 434px;*/
                                    /*min-height: 100vh;*/

                                    /*padding: 5px;*/
                                    border: 5px solid #69c;
                                    vertical-align: top;
                                }

                                .column > .box {
                                    /*display: inline-block;*/
                                    margin: 0px;
                                    /*min-height: 100vh;*/
                                }

                                thead {
                                    background-color: #F8F8FF;
                                }

                                tbody > tr {
                                    border-bottom: 4px solid black;
                                    border-top: 4px solid black;
                                }

                                th {
                                    min-width: 300px;
                                    vertical-align: top;

                                }

                                td {
                                    min-width: 300px;
                                    height: 140px;
                                    vertical-align: top;
                                    background: #fff;
                                }

                                .forprojects {
                                    text-align: center;
                                    vertical-align: middle;
                                    min-width: 100px;
                                    background-color: #F8F8FF;
                                }

                                #topleft {
                                    padding-top: 5px;
                                    vertical-align: top;
                                }

                            </style>


                            {{--<div class="container testimonial-group">--}}
                            {{--<div class="row canvas" id="board-canvas">--}}
                            {{-- Here go the columns! --}}

                            {{--@include('boards.column')--}}

                            {{--</div>--}}
                            {{--</div>--}}


                            <div id="board-holder" class="container testimonial-group">
                                <div class="row canvas" id="board-canvas">


                                    <table border="1px">
                                        <thead id="thead">

                                        {{--<tr>--}}
                                        {{--@foreach($board->structuredColumnsCards as $rootColumn)--}}

                                        {{--<td id="{{ $rootColumn->board_id }}_thead_td">--}}
                                        {{--{{ $rootColumn->column_name }}--}}

                                        {{--</td>--}}

                                        {{--@endforeach--}}
                                        {{--</tr>--}}


                                        </thead>

                                        <tbody id="tbody">


                                        </tbody>
                                    </table>


                                </div>
                            </div>


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
        var containers = [];

        var drake = dragula({
            containers: containers
        });

        var board = {!! $board !!};
        var projects = {!! $board->projects !!};


        var rootColumns = board.structured_columns_cards;

        var allLeaves = [];
        var allCards = [];

        var maxDepth = 0;

        var numAllLeaves = 0;


        window.onload = function () {
//            makeExisting();

            maxDepth = getMaxDepth();
            numAllLeaves = getNumAllLeaves();

            allLeaves = getAllLeaves();


            makeHader();
            makeBody();


        };

        /*
         * NEW design
         *
         * */

        function makeHader() {

            numOfTrs = getMaxDepth();

            for (var i = 0; i < numOfTrs; i++) {
                $("#thead").append("<tr id='thead_tr_" + i + "'></tr>");
            }

            $("#thead_tr_0").append("<th id='topleft' class='forprojects' rowspan='" + numOfTrs + "'>" +
                "<button class='btn btn-primary' onclick='makeFull()'>Full Screen</button></th>");

            makeHeaderTr(rootColumns, 0);
        }


        function makeHeaderTr(row, level) {
            row.sort(compare);

            $.each(row, function (i, current) {

                var rowspan = 1;
                if (current.all_children_cards.length == 0) {
                    rowspan = maxDepth - level;
                }

                $("#thead_tr_" + level).append(
                    "<th id='thead_td_" + current.id + "' colspan='" + getNumOfLeaves(current) + "' rowspan='" + rowspan + "'></th>"
                );

                addColHeader(current, "thead_td_" + current.id);


                makeHeaderTr(current.all_children_cards, level + 1);
            });
        }


        function addColHeader(columnData, place) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@columnHeader') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'column_data': columnData
                },
                success: function (data) {
                    $("#" + place).append(data);

                }
            });
        }


        function makeBody() {

            var numOfProjects = projects.length;

            var maxNumOfTds = getNumAllLeaves();

            for (var j = 0; j < numOfProjects; j++) {
                $("#tbody").append("<tr id='tbody_tr_" + projects[j].id + "'>" +
                    "<td class='forprojects'>" +
                    projects[j].board_name +
                    "</td></tr>");

                for (var i = 0; i < maxNumOfTds; i++) {
                    $("#tbody_tr_" + projects[j].id).append(
                        "<td class='dragdrop' id='tbody_td_" + projects[j].id + "_" + allLeaves[i].id + "'></td>"
                    );

                    var container = $("#tbody_td_" + projects[j].id + "_" + allLeaves[i].id)[0];
                    drake.containers.push(container);

                    addColBody(allLeaves[i], projects[j].id, "tbody_td_" + projects[j].id + "_" + allLeaves[i].id);

                }

            }
        }


        function addColBody(columnData, project_id, place) {
            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@columnBody') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'column_data': columnData,
                    'project_id': project_id
                },
                success: function (data) {
                    $("#" + place).append(data);

                }
            });
        }


        function getMaxDepth() {

            var maxX = 0;

            if (rootColumns.length > 0) {

                for (var col in rootColumns) {
                    if (rootColumns.hasOwnProperty(col)) {

                        var depthX = getDepth(rootColumns[col]);
                        if (maxX < depthX) {
                            maxX = depthX;
                        }

                    }
                }
            }

            maxX += 1;
            // console.log("max globina " + maxX);
            return maxX;
        }

        function getDepth(column) {
            var max = 0;

            if (column.all_children_cards == 0) {
                return 0;
            }
            else {
                for (var key in column.all_children_cards) {
                    if (column.all_children_cards.hasOwnProperty(key)) {

                        var depth = getDepth(column.all_children_cards[key]);

                        if (depth > max) {
                            max = depth;
                        }
                    }
                }
                return max + 1;
            }
        }


        function getNumAllLeaves() {

            var sumX = 0;

            if (rootColumns.length > 0) {
                for (var col in rootColumns) {
                    if (rootColumns.hasOwnProperty(col)) {
                        sumX += getNumOfLeaves(rootColumns[col]);
                    }
                }
            }

            // console.log("st listov " + sumX);
            return sumX;
        }


        function getNumOfLeaves(column) {
            var sum = 0;

            if (column.all_children_cards == 0) {
                return 1;
            }
            else {
                for (var key in column.all_children_cards) {
                    if (column.all_children_cards.hasOwnProperty(key)) {
                        sum += getNumOfLeaves(column.all_children_cards[key]);
                    }
                }
                return sum;
            }
        }


        function getAllLeaves() {
            var leavesX = [];


            if (rootColumns.length > 0) {
                for (var col in rootColumns) {
                    if (rootColumns.hasOwnProperty(col)) {
                        leavesX = leavesX.concat(getLeaves(rootColumns[col]));
                    }
                }
            }

            // console.log("leaves");
            // console.log(leavesX);

            return leavesX;

        }

        function getLeaves(column) {
            var leaves = [];

            if (column.all_children_cards == 0) {
                return [column];
            }
            else {
                for (var key in column.all_children_cards) {
                    if (column.all_children_cards.hasOwnProperty(key)) {
                        leaves = leaves.concat(getLeaves(column.all_children_cards[key]));
                    }
                }
                return leaves;
            }
        }


        function compare(a, b) {
            if (a.order < b.order)
                return -1;
            if (a.order > b.order)
                return 1;
            return 0;
        }


        function makeFull(){
            console.log("makefull");
            $('#board-holder').toggleClass('fullscreen');
        }


        // OLD
        /*
         * Create and Show already existing columns (if editing saved board)
         *
         * */

        //        function makeExisting() {
        //
        //            // structuredColumnsCards
        //
        //            if (rootColumns.length > 0) {
        //
        //                // sort by order (currently on each level starts from beginning)
        //                rootColumns.sort(compare);
        //
        //                // array, location, parent-name, level
        //                forColumns(rootColumns, 'board-canvas', '', 0);
        //            }
        //        }





        {{--function forColumns(columns, place, parent_name, level) {--}}
        {{--// just append to the canvas--}}

        {{--columns.sort(compare);--}}

        {{--for (var key in columns) {--}}
        {{--if (columns.hasOwnProperty(key)) {--}}

        {{--var lvl = Number(level);--}}
        {{--columns[key]['level'] = lvl;--}}

        {{--var pn = parent_name.slice(0);--}}
        {{--columns[key]['parent_name'] = pn;--}}

        {{--columns[key]['projects'] = {!! $board->projects !!};--}}

        {{--addExistingColumn(columns[key], place);--}}

        {{--addExistingCards(columns[key].cards, columns[key].id + "_subcanvas");--}}


        {{--lvl += 1;--}}
        {{--pn += '[' + columns[key].id + '][childs]';--}}
        {{--forColumns(columns[key].all_children_cards, columns[key].id + "_subcanvas", pn, lvl);--}}
        {{--// allChildrenCards--}}
        {{--}--}}
        {{--}--}}
        {{--}--}}


        {{--function addExistingColumn(columnData, place) {--}}
        {{--$.ajax({--}}
        {{--type: 'POST',--}}
        {{--url: "{{ action('BoardController@columnShow') }}",--}}
        {{--data: {--}}
        {{--"_token": "{{ csrf_token() }}",--}}
        {{--'column_data': columnData--}}
        {{--},--}}
        {{--success: function (data) {--}}
        {{--$("#" + place).append(data);--}}

        {{--// allChildrenCards--}}
        {{--if (columnData.all_children_cards.length == 0) {--}}
        {{--var container = $("#" + columnData.id + "_subcanvas")[0];--}}
        {{--drake.containers.push(container);--}}
        {{--}--}}

        {{--}--}}
        {{--});--}}
        {{--}--}}


    </script>


    @include('modals.modal')
@endsection