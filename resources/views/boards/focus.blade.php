@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title: "Prikaz table",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Na trenutni maski lahko vidite grafično stanje izbrane table. V kolikor je tabla že precej obsežna vam priporočamo klik na gumb " +
                "<b>Full screen</b> s katerim boste vidno polje table razširili čez celoten ekran (celozaslonski način). Ko pa hočete izstopiti iz celozaslonskega načina " +
                "ponovno kliknite na gumb <b>Full screen</b>." +
                "</p>" +
                "V kolikor bi hoteli dodajati nove kartice na tablo lahko kliknete na gumb <b>Dodaj kartico</b>." +
                "</div>",
                currentStep: 1,
                allSteps: 3
            },
            {
                title: "Dodajanje nove kartice - prvi del",
                body: "<div class='col-sm-12'>" +
                "<p>Pri dodajanju nove kartice morate vnesti <b>ime naloge</b>, <b>opis naloge</b>, izbrati morate projekt kateremu spada na novo " +
                "ustvarjena kartica. V kolikor hočete ustvariti kartico morate obvezno izbrati <b>projekt</b>. Vnesete lahko tudi lastnika kartice. Lastnika kartice boste lahko " +
                "izbrali le v primeru, ko boste imeli izbran nek projekt, kajti izbirni seznam uporabnikov je odvisen od izbranega projekta." +
                "</p>" +
                "<p>Omenjene podatke prikazuje spodnja slika.</p>" +
                "</div>" +
                "<div class='col-sm-12 align-text-center' style='margin-bottom:20px;'>" +
                "<img class='' src='/img/documentation/boards/createNewCardPart1.png' style='height:240px;width:75%;' />" +
                "</div>",
                currentStep: 2,
                allSteps: 3
            },
            {
                title: "Dodajanje nove kartice - drugi del",
                body: "<div class='col-sm-12'>" +
                "<p>Naslednji pomemben podatek za ga vnesti je <b>datum</b> do kdaj naj bo naloga opravljena. Pri barvi, si lahko " +
                "nastavljate poljubno barvo, v kolikor želite lažje prepoznati med različnimi karticami (še posebej uporabno za razločevanje med različnimi karticami različnih uporabnikov)." +
                "</p>" +
                "<p>Pri vnosnem polju <b>Ocena časa</b> morate vnesti neko število, ki predstavlja število ur kolikor ste predvidevali, da boste potrebovali za omenjeno kartico." +
                "Na koncu lahko še obkljukate, ali je kartica <b>kritična</b>, ali <b>zavrnjena</b>. Kritična kartica bo prioritetno obravnavana pred ostalimi karticami v sprint backlogu. " +
                "Ko vnesete vse podatke lahko kliknete gumb <b>Shrani</b> in kartica bo shranjena in prikazana na tabli." +
                "</p>" +
                "<p>Omenjene podatke prikazuje spodnja slika.</p>" +
                "</div>" +
                "<div class='col-sm-12 align-text-center' style='margin-bottom:20px;'>" +
                "<img class='' src='/img/documentation/boards/createNewCardPart2.png' style='height:240px;width:75%;' />" +
                "</div>",
                currentStep: 2,
                allSteps: 3
            }

        ];
    </script>
    <!-- Content Wrapper. Contains page content -->
    <input type="hidden" name="cardToUpdate" value="" id="board-focus-card-to-update" />
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
                <div class="col-sm-11">

                </div>
                <div class="col-sm-1">
                    {{--color:rgb(67,120,45)--}}
                    <h3 style="padding:0;margin:0;"><span onclick="openDocumentationModal()"
                                                          style="color:#3c8dbc;cursor: pointer;"
                                                          class="glyphicon glyphicon-question-sign"></span></h3>
                </div>
            </div>
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

                            <div class="pull-right" style="margin: 8px;">
                                <label for="saveNarrowColumnsCheckbox" class="">
                                    <input id="saveNarrowColumnsCheckbox"
                                           name="saveNarrowColumnsCheckbox"
                                           value="saveNarrowColumns" type="checkbox" class="pull-left"
                                           onclick="saveNarrowColumns()">
                                    Ohrani trenutni pogled v prihodnje
                                </label>
                            </div>

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
                                    z-index: 1040;
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
            containers: containers,
            revertOnSpill:true
        });



        var board = {!! $board !!};
        console.log("show board");
        console.log({!! $board !!});
        var projects = {!! $board->projects !!};
        var groups = {!! $board->groups !!};
        var user = {!! Auth::user() !!};
        console.log(user);

        var rootColumns = board.structured_columns_cards;

        console.log("check this out!");
        console.log(rootColumns);

        console.log("check user");
        console.log(groups);

        var allLeaves = [];
        var allCards = [];
        allColumns = [];

        var maxDepth = 0;

        var numAllLeaves = 0;

        var columnsWide = {};


        window.onload = function () {
//            makeExisting();

            columnsWide = checkIfSavedNarrowColumns();

            maxDepth = getMaxDepth();
            numAllLeaves = getNumAllLeaves();

            allLeaves = getAllLeaves();
            allColumns = getAllColumns();


            makeHader();
            makeBody();

            $.each(allColumns, function (i, current) {
                if(!columnsWide[current.id]){
//                    console.log("make it narrow " + current.id);
//                    console.log("current state: " + columnsWide[current.id]);
                    narrowColumn(current.id);
//                    console.log("after state: " + columnsWide[current.id]);
                }

            });


        };




        drake.on("drop", function(el, target, source, sibling){

            console.log(allColumns);
            console.log(allLeaves);

            console.log("kartica");
            var cardId = el.dataset.cardId;

            var previousElement = source.id;
            var previousSplit = previousElement.split("_");
            var projectId = previousSplit[2];
            var nextElement = target.id;
            var nextSplit = nextElement.split("_");
            var foundIndex =-1;
            var foundPrevious = allLeaves.find(function (element,i){
                if(element.id == parseInt(previousSplit[3])){
                    foundIndex=i;
                    return element;
                }
            });

            var foundNext = allLeaves.find(function (element,i){
                console.log("show money" + element.id);
                if(element.id == parseInt(nextSplit[3])){
                    return element;
                }
            });

            var nextIndex = foundIndex+1;
            var previousIndex = foundIndex-1;
            var shouldAllow = false;
            if(nextIndex < allLeaves.length){
                if(allLeaves[nextIndex].id == foundNext.id){
                    shouldAllow = true;
                }
            }
            if(previousIndex >= 0){
                if(allLeaves[previousIndex].id == foundNext.id){
                    shouldAllow = true;
                }
            }
            if(foundPrevious.acceptance_testing){
                shouldAllow = true;
            }

            if(shouldAllow){
                //
                console.log('jap');
                console.log('before');
                console.log(allLeaves);
                var foundCard = findCard(foundPrevious.id, cardId, allLeaves, foundNext.id)
                console.log(foundCard);
                console.log('after');
                console.log(allLeaves);
                $('#board-focus-card-to-update').val(cardId);
                //var url = ;
                //url = url.replace(":id", cardId);
                var blabla= {
                    "request":{}
                };
                console.log("tototksldfjalsfjfajfa:  " + cardId);
                $.ajax({
                    url: "{{action('CardController@what')}}",
                    type: 'post',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'new_column_id': parseInt(foundNext.id),
                        'old_column_id': parseInt(foundPrevious.id),
                        'card_id':parseInt(cardId),
                        'user_id': parseInt(user.id)
                    },
                    success: function (result) {
                        console.log('johhny go|!');
                    }
                });

            }else{
                resetDocumentationModel();
                $('#documentationModel h4.modal-title').html("Slipping away");
                $('#documentationModel .modal-body').html("Each other!");
                showDocumentationModel();
                drake.cancel();
            }


            //var targetElement =
        });

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
                    "' rowspan='" + parseInt(maxDepth - level + projects.length) + "' onclick='wideColumn(" + current.id + ")'" +
                    "title='Klikni, da me razširiš.'>" +
                    "<div class='verticaltext'><small>" + current.id + "</small> <span><i class='fa fa-expand'></i></span> " +
                    current.column_name + " " + current.cards.length + "/" + current.WIP + "</div>" +
                    "</th>"
                );

                // headers of columns
                $("#thead_tr_" + level).append(
                    "<th class='thead_th' id='thead_th_" + current.id + "' colspan='" + getNumOfLeaves(current) +
                    "' rowspan='" + rowspan + "' onclick='narrowColumn(" + current.id + ")' title='Klikni, da me skrčiš.'></th>"
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

            console.log("columns wide column " + column.id + ": " + columnsWide[column.id]);

            if(columnsWide[column.id] == undefined) {
                console.log("change to true");
                columnsWide[column.id] = true;
            }

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
            var rowHeight = (fullHeight - headerHeight) / projects.length;


            $(".cardRow").each(function (i, current) {
                //console.log($("#" + current.id).height());

                $("#" + current.id).height(rowHeight);

            });
        }


        function narrowColumn(id) {
            console.log("narrow id: " + id);

            columnsWide[id] = false;
            saveNarrowColumns();

            $("#thead_th_" + id).hide();

            $('td[id^=tbody_td_][id$=' + id + ']').each(function (i, current) {
                $("#" + current.id).hide();
            });

            narrowColumnChildren(id);
            


            var columnFromAllColumns = allColumns.find(function (element) {
                return element.id == id;
            });

            var columnFromRootColumns = rootColumns.find(function (element) {
                return element.id == id;
            });

            var parents = getAllParents(columnFromAllColumns.parent_id);
            var allParentWide = checkParentsWide(parents);

            if(columnFromRootColumns != undefined){ // if ROOT column, show narrowed column
                $("#thead_th_fornarrow_" + id).show();
            }
            else if (allParentWide) { // if parent is widen, show show narrowed column
                $("#thead_th_fornarrow_" + id).show();
            }
            else{ // else hide
                $("#thead_th_fornarrow_" + id).hide();
            }

            updateRowHeight();
        }


        function getAllParents(id) {
            var currentParent = allColumns.find(function (element) {
                return element.id == id;
            });

            if(currentParent != undefined){
                var parents = getAllParents(currentParent.parent_id);

                parents.push(currentParent);
                return parents;
            }
            else{
                return [];
            }
        }

        function checkParentsWide(arrayOfParents){
            var allWide = true;

            $.each(arrayOfParents, function (i, curr) {
                if(!columnsWide[curr.id]){
                    allWide = false;
                }
            });

            return allWide;
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
            saveNarrowColumns();

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

                    console.log("column: " + currentLeaf.id + " | parent: " + currentLeaf.parent_id);
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


        function saveNarrowColumns() {
            var chckbox = $("#saveNarrowColumnsCheckbox")[0];
//            console.log("checkbox saved: " + chckbox.checked);

            if (chckbox.checked) {
                localStorage.setItem("user_" + user.id + "_board_" + board.id, JSON.stringify(columnsWide));
            }
            else {
                localStorage.removeItem("user_" + user.id + "_board_" + board.id);
            }
        }


        function checkIfSavedNarrowColumns() {
            var savedCols = {};

            if (localStorage.getItem("user_" + user.id + "_board_" + board.id) != null) {
//                console.log("columns saved");
                savedCols = localStorage.getItem("user_" + user.id + "_board_" + board.id);
                $("#saveNarrowColumnsCheckbox").prop('checked', true);

                savedCols = JSON.parse(savedCols);
            }

            return savedCols;
        }

        /*custom functions*/
        function findCard(columnId, cardId, arrayOfColumns, nextColumn){
            var foundColumn = arrayOfColumns.find(function(element,i){
                if(element.id == columnId){
                    return element;
                }
            });
            if(foundColumn != undefined && foundColumn != null){
                console.log(foundColumn);
                var foundCard=foundColumn.cards.find(function(element,i){
                    if(element.id == cardId){
                        return element;
                    }
                });
                if(foundCard != null && foundCard != undefined){
                    console.log('here you go');
                    console.log(foundCard);
                    //foundCard.updated_at = new Date();
                    arrayOfColumns.find(function(element,i){
                        if(element.id == nextColumn){
                            element.cards.push(foundCard);
                        }
                    });
                }else{
                    console.log('here you dont go');
                }
            }else{
                console.log('no luck');
            }
        }


    </script>


    @include('modals.modal')
@endsection