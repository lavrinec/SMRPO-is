@extends('default.layout')

@section('content')
    <script>
        documentationContent = [
            {
                title:"Table",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Trenutni pogled/stran vam omogoča:" +
                "<ul>" +
                "<li>Ustvarjanje novih tabel,</li>" +
                "<li>Pregled vseh tabel,</li>" +
                "<li>Urejanje tabel,</li>" +
                "<li>Brisanje tabel.</li>" +
                "</ul>" +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 7
            },
            {
                title:"Ustvarjanje tabele",
                body: "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/boards/createBoardButton.png' style='height:45px;' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb s katerim se lahko navigiramo na stran, kjer vnesemo podatke za novo tablo. Ob kliku na gumb <b>Ustvari novo tablo</b> " +
                "se boste navigirali na novo stran/novi pogled na katerem boste imeli nadaljno pomoč." +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 7
            },
            {
                title:"Seznam tabel",
                body:"<div class='col-sm-12'>" +
                "<p>" +
                "Seznam tabel je tabela vseh tabel. Na tem seznamu lahko (v kolikor imate pravice <b>Kanban masterja</b>) " +
                "ustvarjate, brišete in urejate table znotraj aplikacije <b>SCRUMBAN</b>." +
                "</p>" +
                "<p>" +
                "Na spodnji sliki vidite primer seznama tabel kot ga vidi <b>Kanban master</b>. Vsi ostali uporabniki aplikacije ne bodo uspeli videti:" +
                "<ul>" +
                "<li>Gumba <b>Ustvari novo tablo</b>,</li>" +
                "<li>Stolpca <b>Uredi</b>,</li>" +
                "<li>Stolpca <b>Zbriši</b>,</li>" +
                "</ul>" +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/boards/listBoards.png' style='height:300px;/>' " +
                "</div>",
                currentStep:3,
                allSteps:7
            },
            {
                title:"Iskalnik tabel",
                body: "<div class='col-sm-12' style='text-align:center;'>" +
                "<img class='' src='img/documentation/users/searchInput.png' style='width:150px;height:50px'/>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da bi se lažje znašli med iskanjem specifične table smo vam pripravili polje s katerim " +
                "lahko filtrirate table po njihovem <b>imenu</b>. Polje s katerim lahko " +
                "filtriramo table je viden na sliki zgoraj." +
                "" +
                "</p>" +
                "<div>",
                currentStep : 4,
                allSteps: 7
            },
            {
                title:"Podatki table",
                body: "<div class='col-sm-12'>"+
                "<p>Do podatkov table lahko pridemo na dva načina. Pregled podatkov table (dostopen vsem) " +
                "in urejanje podatkov table (dostopen le <b>Kanban masterju</b>)." +
                "</p>" +
                "</div>" +
                "<div class='col-lg-6 col-sm-12 align-text-center' >" +
                "<h4>Pregled podatkov table</h4>" +
                "<img style='height:55px;width:65px' src='/img/documentation/boards/boardName.png' /><br/>" +
                "<p>Na zgornji sliki je prikazan primer imena table v seznamu tabel. Ob kliku na ime " +
                "vas bo navigiralo na stran na kateri boste lahko videli podatke " +
                "table.</p>" +
                "</div>"+
                "<div class='col-lg-6 col-sm-12 align-text-center'>" +
                "<h4>Urejanje podatkov table</h4>" +
                "<img style='height:70px;width:100px' src='/img/documentation/users/editUserIcon.png' />" +
                "<p>Na zgornji sliki je prikazan gumb na katerega lahko kliknete, da vas preusmeri na urejanje podatkov " +
                "table.</p>" +
                "</div>",
                currentStep : 5,
                allSteps:7
            },
            {
                title:"Brisanje table",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:70px;width:100px' src='/img/documentation/users/deleteUserIcon.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Brisanje table je omogočena le za uporabnika s pravicami <b>Kanban masterja</b>. Ob kliku na gumb, ki ga lahko " +
                "vidite v zgornji vrstici, se bo tabla izbrisala. Tabla ne bo fizično izbrisana iz podatkovne baze, ampak bo " +
                "dobila status <b>neaktivna</b>, kar pa pri končnemu uporabniku pomeni isto kot, da je tabla izbrisana.</p>" +
                "</div>",
                currentStep : 6,
                allSteps:7
            },
            {
                title:"Paginacija seznama tabel",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:50px;width:120px' src='/img/documentation/users/listPagination.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da ne bi bil seznam tabel predolg, se seznam razdeli na več strani po 10 zapisov na stran. Za iskanje table lahko uporabite " +
                "filter polje <b>Išči</b> ali pa listate po preistalih straneh s klikom na gumba <b>Pred.</b>, <b>Nasl.</b>, ali s klikom na eno izmed številk med " +
                "omenjenima gumboma. Zgled omenjenih gumbov je viden na zgornji sliki." +
                "</p>" +
                "</div>",
                currentStep : 7,
                allSteps:7
            }

        ];
    </script>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-11">
                    <h3>
                        Table
                        <small>Seznam tabel</small>
                    </h3>
                </div>
                <div class="col-sm-1">
                    <h2><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
                </div>
            </div>
        </section>
        @include('layout.error')
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    @if(Auth::user()->isKM())
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje nove table</h3>
                        </div>
                        <!-- /.box-header -->
                            <div class="box-body">

                                <a href="{{ action('BoardController@create') }}" class="btn btn-primary btn-block">
                                    <b>Ustvari novo tablo</b>
                                </a>

                            </div>
                            <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    @endif

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam tabel</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if ($errors->has('NoBoard'))
                                <span class="help-block">{{ $errors->first('NoBoard') }}</span>
                            @endif
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>št.</th>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Status</th>
                                    @if(Auth::user()->isKM())
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($boards as $index => $board)
                                    <tr>
                                        <td width="40px">{{ $index+1 }}</td>
                                        <td>
                                            {{--<a href="{{ action('BoardController@show', [$board->id]) }}">{{ $board->board_name }}</a>--}}
                                            <a href="{{ action('BoardController@focus', $board->id) }}">{{$board->board_name}}</a>
                                        </td>
                                        <td>{{ $board->description }}</td>

                                        <td>
                                            @if($board->deleted_at != null )
                                                Izbrisana
                                            @else
                                                Aktivna
                                            @endif
                                        </td>
                                        @if(Auth::user()->isKM())
                                        <td>
                                            {{-- check if board has cards in columns --}}
                                            {{-- if no, board can still be edited --}}
                                            {{-- if yes, board can not be edited  --}}
                                            @if($board->deleted_at == null )
                                                <a href="{{ action('BoardController@edit', [$board->id]) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                        @if($board->deleted_at == null )
                                                <a href="javascript:reallyDelete({{$board->id}})"><i class="fa fa-remove"></i></a>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>št.</th>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Status</th>
                                    @if(Auth::user()->isKM())
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
                                    @endif
                                </tr>
                                </tfoot>
                            </table>
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
    <script>
        function reallyDelete(boardid) {
            console.log(boardid);
            var r = confirm("Ali ste prepričani, da želite izbrisati tablo?");

            if (r == true) {
                window.location.href = "/boards/" + boardid +"/delete";
            }
        }
    </script>
@endsection