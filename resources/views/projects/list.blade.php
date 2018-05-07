@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title:"Projekti",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Trenutni pogled/stran vam omogoča:" +
                "<ul>" +
                "<li>Ustvarjanje novih projektov,</li>" +
                "<li>Pregled vseh projektov,</li>" +
                "<li>Urejanje projektov,</li>" +
                "<li>Brisanje projektov.</li>" +
                "</ul>" +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 7
            },
            {
                title:"Ustvarjanje projekta",
                body: "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/projects/createNewProjectButton.png' style='height:45px;' " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb s katerim se lahko navigiramo na stran, kjer vnesemo podatke za nov projekt. Ob kliku na gumb <b>Ustvari nov projekt</b> " +
                "se boste navigirali na novo stran/novi pogled na katerem boste imeli nadaljno pomoč." +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 7
            },
            {
                title:"Seznam projektov",
                body:"<div class='col-sm-12'>" +
                "<p>" +
                "Seznam projektov je tabela vseh projektov. Na tem seznamu lahko (v kolikor imate pravice <b>Kanban masterja</b>) " +
                "ustvarjate, brišete in urejate projekte znotraj aplikacije <b>SCRUMBAN</b>." +
                "</p>" +
                "<p>" +
                "Na spodnji sliki vidite primer seznama projektov kot ga vidi <b>Kanban master</b>. Vsi ostali uporabniki aplikacije ne bodo uspeli videti:" +
                "<ul>" +
                "<li>Gumba <b>Ustvari nov projekt</b>,</li>" +
                "<li>Stolpca <b>Uredi</b>,</li>" +
                "<li>Stolpca <b>Zbriši</b>,</li>" +
                "</ul>" +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/projects/listOfProjects.png' style='height:300px;' " +
                "</div>",
                currentStep:3,
                allSteps:7
            },
            {
                title:"Seznam projektov",
                body:"<div class='col-sm-12'>" +
                "<p>" +
                "Seznam projektov ima od vseh seznamov v aplikaciji največ podatkov. Tako lahko vidite <b>ime naročnika</b>, dva datuma <b>Datum začetka</b> in <b>Datum zaljučka</b>, ki " +
                "predstavljata interval v katerem bo nek projekt aktiven in dostopen za vnos podatkov. Prav tako lahko vidite znotraj tabele ime <b>Skupine</b> in ime <b>Table</b>. " +
                "Projekti, skupine in table so med seboj povezani. Nek projekt mora pripadati neki skupini in prav tako neki tabli." +
                "</p>" +
                "<p>" +
                "Ob kliku na <b>ime skupine</b> ali <b>ime table</b> vas bo aplikacija navigirala bodisi na podatke o izbrani skupini ali na podatke o izbrani tabli. " +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/projects/listOfProjects.png' style='height:300px;' " +
                "</div>",
                currentStep:4,
                allSteps:7
            },
            {
                title:"Iskalnik projektov",
                body: "<div class='col-sm-12' style='text-align:center;'>" +
                "<img class='' src='img/documentation/users/searchInput.png' style='width:150px;height:50px'/>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da bi se lažje znašli med iskanjem specifične table smo vam pripravili polje s katerim " +
                "lahko filtrirate table po sledečih podatkih: " +
                "<ul>" +
                "<li><b>Imenu projekta</b>,</li>" +
                "<li><b>Opisu projekta</b>,</li>" +
                "<li><b>Imenu table</b>,</li>" +
                "<li><b>Imenu skupine</b>,</li>" +
                "<li><b>Datumu začetka</b>,</li>" +
                "<li><b>Datumu zaključka</b>,</li>" +
                "<li><b>Imenu naročnika</b>.</li>" +
                "</ul>" +
                "</p>" +
                "</div>",
                currentStep : 5,
                allSteps: 7
            },
            {
                title:"Podatki projektov",
                body: "<div class='col-sm-12'>"+
                "<p>Do podatkov projekta lahko pridemo na dva načina. Pregled podatkov projekta (dostopen vsem) " +
                "in urejanje podatkov projekta (dostopen le <b>Kanban masterju</b>)." +
                "</p>" +
                "</div>" +
                "<div class='col-lg-6 col-sm-12 align-text-center' >" +
                "<h4>Pregled podatkov projekta</h4>" +
                "<img style='height:55px;width:65px' src='/img/documentation/projects/projectName.png' /><br/>" +
                "<p>Na zgornji sliki je prikazan primer imena projekta v seznamu projektov. Ob kliku na ime " +
                "vas bo navigiralo na stran na kateri boste lahko videli podatke " +
                "projekta.</p>" +
                "</div>"+
                "<div class='col-lg-6 col-sm-12 align-text-center'>" +
                "<h4>Urejanje podatkov projekta</h4>" +
                "<img style='height:70px;width:100px' src='/img/documentation/users/editUserIcon.png' />" +
                "<p>Na zgornji sliki je prikazan gumb na katerega lahko kliknete, da vas preusmeri na urejanje podatkov " +
                "projekta.</p>" +
                "</div>",
                currentStep : 6,
                allSteps:7
            },
            {
                title:"Brisanje projekta",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:70px;width:100px' src='/img/documentation/users/deleteUserIcon.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Brisanje projekta je omogočena le za uporabnika s pravicami <b>Kanban masterja</b>. Ob kliku na gumb, ki ga lahko " +
                "vidite v zgornji vrstici, se bo projekt izbrisal. Projekt ne bo fizično izbrisan iz podatkovne baze, ampak bo " +
                "dobil status <b>neaktiven</b>, kar pa pri končnemu uporabniku pomeni isto kot, da je projekt izbrisan.</p>" +
                "</div>",
                currentStep : 7,
                allSteps:7
            },
            {
                title:"Paginacija seznama projektov",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:50px;width:120px' src='/img/documentation/users/listPagination.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da ne bi bil seznam projektov predolg, se seznam razdeli na več strani po 10 zapisov na stran. Za iskanje projekta lahko uporabite " +
                "filter polje <b>Išči</b> ali pa listate po preistalih straneh s klikom na gumba <b>Pred.</b>, <b>Nasl.</b>, ali s klikom na eno izmed številk med " +
                "omenjenima gumboma. Zgled omenjenih gumbov je viden na zgornji sliki." +
                "</p>" +
                "</div>",
                currentStep : 8,
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
                        Projekti
                        <small>Seznam projektov</small>
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
                                <h3 class="box-title">Ustvarjanje novega projekta</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <a href="{{ action('ProjectController@create') }}" class="btn btn-primary btn-block">
                                    <b>Ustvari nov projekt</b>
                                </a>

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    @endif


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam projektov</h3>
                        </div>

                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>št.</th>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Naročnik</th>
                                    <th>Datum začetka</th>
                                    <th>Datum zaključka</th>
                                    <th>Skupina</th>
                                    <th>Status</th>
                                    <th>Tabla</th>

                                    @if(Auth::user()->isKM())
                                        <th>Uredi</th>
                                        <th>Izbriši</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $index => $project)
                                    <tr>
                                        <td width="40px">{{ $index+1 }}</td>
                                        <td>
                                            <a href="{{ action('ProjectController@show', [$project->id]) }}">{{ $project->board_name }}</a>
                                        </td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->buyer_name }}</td>
                                        <td>{{ date("d.m.Y", strtotime($project->start_date)) }}</td>
                                        <td>{{ date("d.m.Y", strtotime($project->end_date)) }}</td>
                                        <td>
                                            @if(isset($project->group->group_name))
                                                <a href="/groups/{{$project->group->id}}/show">
                                                    {{ $project->group->group_name}}
                                                </a>
                                            @endif
                                        </td>
                                        <td>@if($project->deactivated || $project->deactivated!=null)
                                                Neaktiven
                                            @else
                                                Aktiven
                                            @endif
                                        </td>
                                        <td>
                                            {{--@if($project->board_id)--}}
                                                {{--<a href="/boards/{{$project->board->id}}/focus">--}}
                                                    {{--{{ $project->board->board_name }}--}}
                                                {{--</a>--}}
                                            {{--@endif--}}
                                        </td>

                                        @if(Auth::user()->isKM())
                                            <td>
                                                @if($project->deleted_at == null && !$project->deactivated)
                                                    <a href="{{ action('ProjectController@edit', [$project->id]) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($project->deleted_at == null && !$project->deactivated )
                                                    <a href="javascript:reallyDelete({{$project->id}})"><i
                                                                class="fa fa-remove"></i></a>


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
                                    <th>Naročnik</th>
                                    <th>Datum začetka</th>
                                    <th>Datum zaključka</th>
                                    <th>Skupina</th>
                                    <th>Status</th>
                                    <th>Tabla</th>
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
        function reallyDelete(id) {
            var r = confirm("Ali ste prepričani, da želite izbrisati projekt?");
            if (r == true) {
                window.location.href = "/projects/" + id + "/delete";
            }
        }
    </script>
@endsection