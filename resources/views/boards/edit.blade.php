@extends('default.layout')

@section('content')
    <script>
        documentationContent = [
            {
                title:"Urejanje table",
                body: "<div class='col-sm-12'>" +
                "<p>Vnašamo lahko vse podatke kot na maski za novo tablo:" +
                "<ul>" +
                "<li>Izbira projekta,</li>" +
                "<li>Ime table,</li>" +
                "<li>Opis table,</li>" +
                "<li>Število dni pred zaključkom (za obveščanje),</li>" +
                "</ul>" +
                "Izberete lahko le tiste projekte, ki imajo povezan podatek o tabli na trenutno tablo. Ko zaključite z urejanjem table kliknite na gumb <b>Shrani</b> " +
                "da se spremembe shranijo." +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 1
            },
            {
                title:"Dodajanje stolpcev",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/boards/newColumn.png' style='height:240px;width:45%;' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Na zgornji sliki lahko vidite primer grafičnega vmesnika za kreiranje novih stolpcev. Vnesete lahko <b>ime stolpca</b>, <b>opis stolpca</b>," +
                "<b>WIP omejitev</b> (koliko kartico je lahko naenkrat v stolpcu in <b>vlogo</b> stolpca." +
                "Izberete lahko le tiste projekte, ki imajo povezan podatek o tabli na trenutno tablo. Ko zaključite z urejanjem table kliknite na gumb <b>Shrani</b> " +
                "da se spremembe shranijo." +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 1
            },
            {
                title:"Funkcije",
                body: "<div class='col-sm-12 '>" +
                "<img class='' src='/img/documentation/boards/deleteColumn.png' style='height:50px;width:110px;' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb za odstranitev stolpca." +
                "</p>" +
                "</div>"+
                "<div class='col-sm-12 '>" +
                "<img class='' src='/img/documentation/boards/createLeftColumn.png' style='height:50px;width:110px;' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb dodajanje stolpca na levo stran." +
                "</p>" +
                "</div>"+
                "<div class='col-sm-12 '>" +
                "<img class='' src='/img/documentation/boards/createRightColumn.png' style='height:50px;width:110px;' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb dodajanje stolpca na desno stran." +
                "</p>" +
                "</div>"+
                "<div class='col-sm-12 '>" +
                "<img class='' src='/img/documentation/boards/createSubColumn.png' style='height:50px;width:110px;' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb s katerim ustvarite nov podstolpec.." +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 1
            }

        ];
    </script>
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
                <div class="col-sm-11">

                </div>
                <div class="col-sm-1">
                    {{--color:rgb(67,120,45)--}}
                    <h3 style="padding:0;margin:0;"><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h3>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">

                    {{-- div for data form --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Urejanje table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" method="POST" onsubmit="return checkBeforeSubmit();"
                                  action="{{ action('BoardController@update', $board->id) }}">

                                @csrf

                                <div class="form-group">

                                    <div class="col-sm-6">
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
                                        <label for="board_name" class="col-sm-8 control-label">Dni pred
                                            obvestilom</label>

                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="meta[notification]"
                                                   value="{{ isset($board->meta->notification) ? $board->meta->notification : '0' }}"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-7">
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
                                <br>


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
                                    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
                                        color: black;
                                    }

                                </style>


                                <div class="container testimonial-group">
                                    <div class="row canvas" id="board-canvas">
                                        {{-- Here go the columns! --}}

                                        {{--@include('boards.column')--}}


                                        @foreach($board->structuredColumnsCards as $rootColumn)

                                            @include('boards.column', ['column' => $rootColumn])


                                        @endforeach


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

        var board = {!! $board !!};

        var rootColumns = board.structured_columns_cards;

        var allColumns = [];

        window.onload = function () {
//            makeExisting();

            redoLeftIds();
            redoParentNames();

            checkIfEmpty($("#board-canvas")[0]);


            $("#usersgroupsselect").select2({
                placeholder: "Izberi projekte"
            });

            allColumns = getAllColumns();

        };


        function compare(a, b) {
            if (a.order < b.order)
                return -1;
            if (a.order > b.order)
                return 1;
            return 0;
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
                    redoLeftIds();
                    redoParentNames();
                }
            });
        }

        function addColumnBefore(column) {
            column = $("#" + column)[0];

            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': $("#" + column.id + "_parent_id")[0].value,
                    'parent_name': $("#" + column.id + "_parent_name")[0].value.replace('[' + column.id + ']', ''),
//                    'level': parseInt($("#" + column.id + "_level")[0].value)
                },
                success: function (data) {
                    $(data).insertBefore($("#" + column.id));
                    redoLeftIds();
                    redoParentNames();

                }
            });
        }

        function addColumnAfter(column) {
            column = $("#" + column)[0];

            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': $("#" + column.id + "_parent_id")[0].value,
                    'parent_name': $("#" + column.id + "_parent_name")[0].value.replace('[' + column.id + ']', ''),
//                    'level': parseInt($("#" + column.id + "_level")[0].value)
                },
                success: function (data) {
                    $(data).insertAfter($("#" + column.id));
                    redoLeftIds();
                    redoParentNames();
                }
            });
        }


        function addFirstSubColumnTo(column) {
            column = $("#" + column)[0];

            $.ajax({
                type: 'POST',
                url: "{{ action('BoardController@addColumn') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'parent_id': column.id,
                    'parent_name': $("#" + column.id + "_parent_name")[0].value + '[childs]',
//                    'level': parseInt($("#" + column.id + "_level")[0].value) + 1
                },
                success: function (data) {
                    // disable [add first subcolumn] button
                    $("#" + column.id + "_addFirstSubcolumn")[0].setAttribute('disabled', 'disabled');
                    $("#" + column.id + "_subcanvas").append(data);
                    redoLeftIds();
                    redoParentNames();
                }
            });
        }


        function deleteColumn(column) {
            column = $("#" + column)[0];

            var parent = column.parentNode;
            column.parentNode.removeChild(column);
            checkIfEmpty(parent);
            redoLeftIds();
            redoParentNames();
            return false;
        }

        function checkIfEmpty(parent) {
//            console.log("#" + parent.id);

            if (parent.id == 'board-canvas') {

                if ($("#" + parent.id)[0].childElementCount == 0) {
                    $("#buttonFirstColumn")[0].removeAttribute("disabled");
                    return true;
                }
                else {
                    $("#buttonFirstColumn")[0].setAttribute('disabled', 'disabled');
                    return false;
                }
            }


            else {

                var splitedID = parent.id.split("_");
//                console.log("splited ");
//                console.log(splitedID);

                if (splitedID[1] == "subcanvas") {
                    if ($("#" + parent.id)[0].childElementCount == 0) {
                        $("#" + splitedID[0] + "_addFirstSubcolumn")[0].removeAttribute('disabled');
                    }
                    else {
                        $("#" + splitedID[0] + "_addFirstSubcolumn")[0].setAttribute('disabled', 'disabled');
                    }

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

        function redoParentNames() {
            $(".column").each(function (i, current) {

                checkIfEmpty(current);

                var parent = $("#" + current.id).parent()[0];

                var inputs = $("#" + current.id + " :input");


                if (parent.id == "board-canvas") {
                    var nameX = "[" + current.id + "]";
                    $("#" + current.id + "_parent_name")[0].value = "[" + current.id + "]";

                    renameX(inputs, "[" + current.id + "]");
                }
                else {
                    var parent_id = parent.id.replace("_subcanvas", "");
                    var parents_parent_name = $("#" + parent_id + "_parent_name")[0];
//                    var nameX = parents_parent_name.value + "[childs][" + current.id + "]";

                    $("#" + current.id + "_parent_name")[0].value = parents_parent_name.value + "[childs][" + current.id + "]";

                    renameX(inputs, parents_parent_name.value + "[childs][" + current.id + "]");
                }


            });
        }


        function renameX(inputs, name) {
//            console.log("renameX " + name);

            $.each(inputs, function (i, currentInput) {

                if (currentInput.id.includes("parent_id")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[parent_id]");
                }
                else if (currentInput.id.includes("parent_name")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[parent_name]");
                }
                else if (currentInput.id.includes("left_id")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[left_id]");
                }
                else if (currentInput.id.includes("id")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[id]");
                }
                else if (currentInput.id.includes("column_name")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[column_name]");
                }
                else if (currentInput.id.includes("description")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[description]");
                }
                else if (currentInput.id.includes("wip")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[wip]");
                }
                else if (currentInput.id.includes("start_border")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[types][start_border]");
                }
                else if (currentInput.id.includes("end_border")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[types][end_border]");
                }
                else if (currentInput.id.includes("high_priority")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[types][high_priority]");
                }
                else if (currentInput.id.includes("acceptance_testing")) {
                    $("#" + currentInput.id).attr('name', "column" + name + "[types][acceptance_testing]");
                }


            });
        }


        function checkChecked(clickedItem, group) {
            clickedItem = $("#" + clickedItem)[0];

            var groupItems = $("input[name*=" + group + "]");

            if (clickedItem.checked) {
                groupItems.each(function (i, current) {
                    if (current != clickedItem) {
//                        console.log(current.checked);

                        if (current.checked) {
                            if (confirm("Kot " + group + "je že označen drug stolpec." +
                                    "\n Ali želite spremeniti?")) {
                                $("#" + current.id).prop('checked', false);
                            } else {
                                $("#" + clickedItem.id).prop('checked', false);
                            }
                        }

                    }
                });
            }
        }


        function checkBeforeSubmit() {
            var allSpecial = false, rightOrder = false, empty = true;

            empty = checkIfEmpty($("#board-canvas")[0]);
            if (empty) {
                alert("Prazna tabla!")
            }

            allSpecial = checkIfAllSpecialColumns();
            if (allSpecial) {
                rightOrder = checkIfRightOrder();
            }


            return (allSpecial && rightOrder && !empty);
        }


        function checkIfAllSpecialColumns() {

            var typeNames = {
                "high_priority": "Stolpec za nujne kartice",
                "start_border": "Začetni mejni",
                "end_border": "Končni mejni",
                "acceptance_testing": "Stolpec za sprejemno testiranje"
            };

            var allTypes = ["high_priority", "start_border", "end_border", "acceptance_testing"];
            var typeList = [];

            $("input:checkbox:checked").each(function (i, current) {
                typeList.push(current.value);
            });

            console.log(typeList);

            var missing = allTypes.filter(function (item) {
                return typeList.indexOf(item) === -1;
            });

            var stolpci = "";
            for (var x in missing) {
                stolpci += typeNames[missing[x]] + ", ";
            }

            stolpci = stolpci.substr(0, stolpci.length - 2);

            if (typeList.length != 4) {
                alert("Manjkajo stolpci: " + stolpci);
                return false;
            }
            else {
                return true;
            }

        }

        function checkIfRightOrder() {
            var ok = ["high_priority", "start_border", "end_border", "acceptance_testing"];
            var reality = [];

            $("input:checkbox:checked").each(function (i, current) {
                reality.push(current.value);
            });

            console.log(reality);

            if (!(ok[0] == reality[0] && ok[1] == reality[1] && ok[2] == reality[2] && ok[3] == reality[3])) {
                alert("Stolpci niso v priporočenem vrstnem redu " +
                    "(Stolpec za nujne kartice, Začetni mejni, Končni mejni, Stolpec za sprejemno testiranje)");
                return false;
            }
            else {
                return true;
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

        // naredi se rekurzivno =>
        // upostevaj se parent WIPe
        // in children WIPe
        function checkWIPandCards(columnid) {
            console.log("checkWIPandCards " + columnid);

            var column = allColumns.find(function (element) {
                return element.id == columnid;
            });
            console.log("column from existing columns");
            console.log(column);


            if (column != undefined) {

                console.log("input field");
                console.log($("#" + columnid + "_wip"));

                var newWIP = $("#" + columnid + "_wip")[0].value;


                console.log("old wip: " + column.WIP);
//                console.log("num of cards: " + column.cards.length);
                console.log("new wip: " + newWIP);

                var allChildCards = sumAllChildrenCards(columnid); // ALSO CARDS FROM THIS COLUMN! (NOT JUST CHILDREN)
                console.log("allchildcards: " + allChildCards);


                // consider putting this in separate function so that it can be called when changing
                // type of column
                // (because changing to high_priority causes high priority cards to move to that column)
                if (newWIP < allChildCards && newWIP != 0) {
                    var r = confirm("V stolpcu je več kartic kot znaša nova omejitev WIP.\n" +
                        "Ali ste prepričani, da želite uveljaviti spremembo \n" +
                        "(kršitev WIP se bo ob shranjevanju avtomatsko zabeležila)?");
                    if (r == true) {
                        // in BoardController, first save new WIP,
                        // then run checkWipViolation for every card in that column
                    } else {
                        $("#" + columnid + "_wip")[0].value = column.WIP;
                    }
                }

            }


        }


        function sumAllChildrenCards(columnid) {
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

@endsection