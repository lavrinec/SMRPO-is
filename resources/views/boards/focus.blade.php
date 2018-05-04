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

                                    <a href="{{ route('boards.report', $board->id) }}"
                                       class="btn btn-primary pull-right" style="margin-right:5px">
                                        <b>Poročilo</b>
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

                                #board-holder.fullscreen {
                                    z-index: 9999;
                                    width: 100%;
                                    height: 100%;
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    overflow-x: auto;
                                    white-space: nowrap;
                                    background: #fff;
                                }

                                table, th, td {
                                    border: 1px solid lightgrey;
                                }

                                .canvas {
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }

                                .subcanvas {
                                    min-height: 200px;
                                }


                                /*.canvas > .column {*/
                                    /*display: inline-block;*/
                                    /*!*float: none;*!*/

                                    /*min-width: 320px;*/
                                    /*!*min-height: 434px;*!*/
                                    /*!*min-height: 100vh;*!*/

                                    /*!*padding: 5px;*!*/
                                    /*border: 5px solid #69c;*/
                                    /*vertical-align: top;*/
                                /*}*/

                                .grabbable {
                                    cursor: move; /* fallback if grab cursor is unsupported */
                                    cursor: grab;
                                    cursor: -moz-grab;
                                    cursor: -webkit-grab;

                                    border: none;
                                    width: 240px;
                                    margin: 5px;
                                    margin-bottom: 10px;
                                }

                                /* (Optional) Apply a "closed-hand" cursor during drag operation. */
                                .grabbable :active {
                                    cursor: grabbing;
                                    cursor: -moz-grabbing;
                                    cursor: -webkit-grabbing;
                                }

                                .cardRow {
                                    /*border-bottom: 4px solid black;*/
                                    /*border-top: 4px solid black;*/
                                }

                                .thead_th {
                                    background-color: #F8F8FF;
                                    min-width: 250px;
                                    vertical-align: top;
                                }

                                td {
                                    min-width: 250px;
                                    /*min-height: 140px;*/
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

                                .narrow {
                                    background-color: #f00;
                                }

                                .narrowCol {
                                    display: none;
                                }

                                .fornarrow {
                                    display: none;
                                    min-width: 50px;
                                    background-color: #F8F8FF;
                                    vertical-align: top;
                                    max-height: 100vh;
                                }

                                .verticaltext {
                                    width: 1px;
                                    word-wrap: break-word;
                                    font-family: monospace; /* this is just for good looks */
                                    white-space: pre-wrap; /* this is for displaying whitespaces including Firefox */

                                    margin-left: auto;
                                    margin-right: auto;
                                    margin-top: 5px;
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


                                    <table id="boardTable">
                                        {{--<thead id="thead">--}}

                                        {{--<tr>--}}
                                        {{--@foreach($board->structuredColumnsCards as $rootColumn)--}}

                                        {{--<td id="{{ $rootColumn->board_id }}_thead_td">--}}
                                        {{--{{ $rootColumn->column_name }}--}}

                                        {{--</td>--}}

                                        {{--@endforeach--}}
                                        {{--</tr>--}}

                                        {{--</thead>--}}



                                        {{--<tbody id="tbody">--}}

                                        {{--</tbody>--}}


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
        allColumns = [];

        var maxDepth = 0;

        var numAllLeaves = 0;

        var columnsWide = {};


        window.onload = function () {
//            makeExisting();

            maxDepth = getMaxDepth();
            numAllLeaves = getNumAllLeaves();

            allLeaves = getAllLeaves();
            allColumns = getAllColumns();

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
                $("#boardTable").append("<tr id='thead_tr_" + i + "'></tr>");
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

                // additional cells for narrower view
                $("#thead_tr_" + level).append(
                    "<th class='fornarrow' id='thead_th_fornarrow_" + current.id + "' colspan='" + getNumOfLeaves(current) +
                    "' rowspan='" + parseInt(maxDepth - level + projects.length) + "' onclick='wideColumn(" + current.id + ")'>" +
                    "<div class='verticaltext'>" + current.id + " " + current.column_name + "</div>" +
                    "</th>"
                );


                $("#thead_tr_" + level).append(
                    "<th class='thead_th' id='thead_th_" + current.id + "' colspan='" + getNumOfLeaves(current) +
                    "' rowspan='" + rowspan + "' onclick='narrowColumn(" + current.id + ")'></th>"
                );

                addColHeader(current, "thead_th_" + current.id);


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
                $("#boardTable").append("<tr id='tbody_tr_" + projects[j].id + "' class='cardRow'>" +
                    "<td class='forprojects'>" +
                    projects[j].board_name +
                    "</td></tr>");

                for (var i = 0; i < maxNumOfTds; i++) {

                    // additional cells for narrower view
//                    $("#tbody_tr_" + projects[0].id).append(
//                        "<td class='column fornarrow' id='tbody_td_fornarrow_" + allLeaves[i].id + "' rowspan='" + numOfProjects + "' style='display: none;'></td>"
//                    );

                    $("#tbody_tr_" + projects[j].id).append(
                        "<td class='column dragdrop' id='tbody_td_" + projects[j].id + "_" + allLeaves[i].id + "'></td>"
                    );

                    var container = $("#tbody_td_" + projects[j].id + "_" + allLeaves[i].id)[0];
                    drake.containers.push(container);

                    addColBody(allLeaves[i], projects[j].id, "tbody_td_" + projects[j].id + "_" + allLeaves[i].id);

                }

            }

            updateRowHeight();
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


        function getAllColumns() {
            var columnsX = [];


            if (rootColumns.length > 0) {
                for (var col in rootColumns) {
                    if (rootColumns.hasOwnProperty(col)) {
                        columnsX = columnsX.concat(getColumns(rootColumns[col]));
                    }
                }
            }

            return columnsX;

        }


        function getColumns(column) {
            var columns = [];

            columnsWide[column.id] = true;

            if (column.all_children_cards == 0) {
                return [column];
            }
            else {
                columns = columns.concat([column]);

                for (var key in column.all_children_cards) {
                    if (column.all_children_cards.hasOwnProperty(key)) {
                        columns = columns.concat(getColumns(column.all_children_cards[key]));
                    }
                }
                return columns;
            }
        }


        function compare(a, b) {
            if (a.order < b.order)
                return -1;
            if (a.order > b.order)
                return 1;
            return 0;
        }


        function makeFull() {
            console.log("makefull");
            $('#board-holder').toggleClass('fullscreen');

            updateRowHeight();
        }

        function updateRowHeight() {
            var headerHeight = $("#topleft").height();
            var fullHeight = $(window).height();
            var rowHeight = (fullHeight-headerHeight)/projects.length;


            $(".cardRow").each(function (i, current) {
                console.log($("#" + current.id).height());

                $("#" + current.id).height(rowHeight);

            });
        }


        function narrowColumn(id) {
            console.log("narrow id: " + id);

            columnsWide[id] = false;

            $("#thead_th_" + id).hide();

            $('td[id^=tbody_td_][id$=' + id + ']').each(function (i, current) {
                $("#" + current.id).hide();
            });

            narrowColumnChildren(id);

            $("#thead_th_fornarrow_" + id).show();

            updateRowHeight();
        }


        function narrowColumnChildren(id) {
            // get children
            $.each(allColumns, function (i, currentLeaf) {
                if (currentLeaf.parent_id == id) {

                    $("#thead_th_" + currentLeaf.id).hide(); // hide - parent is narrow

                    $("#thead_th_fornarrow_" + currentLeaf.id).hide(); // hide - parent is narrow

                    $('td[id^=tbody_td_][id$=' + currentLeaf.id + ']').each(function (i, currentChild) {
                        $("#" + currentChild.id).hide(); // hide - parent is narrow
                    });

                    narrowColumnChildren(currentLeaf.id);
                }
            });
        }


        function wideColumn(id) {
            console.log("wide id: " + id);

            columnsWide[id] = true;

            $("#thead_th_" + id).show();

            $('td[id^=tbody_td_][id$=' + id + ']').each(function (i, current) {
                $("#" + current.id).show();
            });

            wideColumnChildren(id);

            $("#thead_th_fornarrow_" + id).hide();

            updateRowHeight();
        }


        function wideColumnChildren(id) {
            // get children
            $.each(allColumns, function (i, currentLeaf) {
                if (currentLeaf.parent_id == id) {

                    console.log("column: " + currentLeaf.id + "|| parent: " + currentLeaf.parent_id);
                    console.log("if parent is wide: " + columnsWide[currentLeaf.parent_id]);

                    if (!columnsWide[currentLeaf.parent_id]) {
                        $("#thead_th_" + currentLeaf.id).hide(); // hide - parent is narrow

                        $("#thead_th_fornarrow_" + currentLeaf.id).hide(); // hide - parent is narrow

                        $('td[id^=tbody_td_][id$=' + currentLeaf.id + ']').each(function (i, currentChild) {
                            $("#" + currentChild.id).hide(); // hide - parent is narrow
                        });
                    }
                    else if (columnsWide[currentLeaf.id]) {
                        $("#thead_th_" + currentLeaf.id).show(); // show if wide
                        $("#thead_th_fornarrow_" + currentLeaf.id).hide(); // hide if wide

                        $('td[id^=tbody_td_][id$=' + currentLeaf.id + ']').each(function (i, currentChild) {
                            $("#" + currentChild.id).show(); // show if wide
                        });
                        wideColumnChildren(currentLeaf.id);
                    }
                    else {
                        $("#thead_th_" + currentLeaf.id).hide(); // hide if narrow
                        $("#thead_th_fornarrow_" + currentLeaf.id).show(); // show if narrow

                        $('td[id^=tbody_td_][id$=' + currentLeaf.id + ']').each(function (i, currentChild) {
                            $("#" + currentChild.id).hide(); // hide if narrow
                        });
                        wideColumnChildren(currentLeaf.id);
                    }

                    // wideColumnChildren(currentLeaf.id);
                }
            });
        }

    </script>


    @include('modals.modal')
@endsection