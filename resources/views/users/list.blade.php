@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title:"Uporabniki",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Trenutni pogled/stran vam omogoča:" +
                "<ul>" +
                "<li>Ustvarjanje novih uporabnikov,</li>" +
                "<li>Pregled vseh uporabnikov,</li>" +
                "<li>Urejanje uporabnikov,</li>" +
                "<li>Brisanje uporabnikov.</li>" +
                "</ul>" +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 7
            },
            {
                title:"Ustvarjanje uporabnikov",
                body: "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/users/createUsers.png' style='height:60px;' " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb s katerim se lahko navigiramo na stran, kjer vnesemo podatke za novega uporabnika. Ob kliku na gumb <b>Ustvari novega uporabnika</b> " +
                "se boste navigirali na novo stran/novi pogled na katerem boste imeli nadaljno pomoč." +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 7
            },
            {
                title:"Seznam uporabnikov",
                body:"<div class='col-sm-12'>" +
                "<p>" +
                "Seznam uporabnikov prikazuje je tabela vseh uporabnikov. Na tem seznamu lahko (v kolikor imate pravice <b>Administratorja</b>) " +
                "ustvarjate, brišete in urejate uporabnike znotraj aplikacije <b>SCRUMBAN</b>." +
                "</p>" +
                "<p>" +
                "Na spodnji sliki vidite primer seznama uporabnikov kot ga vidi administrator. Vsi ostali uporabniki aplikacije ne bodo uspeli videti:" +
                "<ul>" +
                "<li>Gumba <b>Ustvari novega uporabnika</b>,</li>" +
                "<li>Stolpca <b>Uredi</b>,</li>" +
                "<li>Stolpca <b>Zbriši</b>,</li>" +
                "</ul>" +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/users/listUsers.png' style='height:300px;' " +
                "</div>",
                currentStep:3,
                allSteps:7
            },
            {
                title:"Iskalnik uporabnikov",
                body: "<div class='col-sm-12' style='text-align:center;'>" +
                "<img class='' src='img/documentation/users/searchInput.png' style='width:150px;height:50px'" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da bi se lažje znašli med iskanjem specifičnega uporabnika smo vam pripravili polje s katerim " +
                "lahko filtrirate uporabnike po njihovem <b>imenu</b>, <b>priimku</b>, <b>e-pošti</b>. Polje s katerim lahko " +
                "filtriramo uporabike je viden na sliki zgoraj." +
                "" +
                "</p>" +
                "<div>",
                currentStep : 4,
                allSteps: 7
            },
            {
                title:"Podatki uporabnika",
                body: "<div class='col-sm-12'>"+
                "<p>Do podatkov uporabnika lahko pridemo na dva načina. Pregled podatkov uporabnika (dostopen vsem) " +
                "in urejanje podatkov uporabnika (dostopen le <b>adminstratorju</b>)." +
                "</p>" +
                "</div>" +
                "<div class='col-lg-6 col-sm-12 align-text-center' >" +
                "<h4>Pregled podatkov uporabnika</h4>" +
                "<img style='height:70px;width:170px' src='/img/documentation/users/userEmail.png' />" +
                "<p>Na zgornji sliki je prikazan primer emaila uporabnika v seznamu uporabnikov. Ob kliku na email " +
                "vas bo navigiralo na stran na kateri boste lahko videli podatke " +
                "uporabnika.</p>" +
                "</div>"+
                "<div class='col-lg-6 col-sm-12 align-text-center'>" +
                "<h4>Urejanje podatkov uporabnika</h4>" +
                "<img style='height:70px;width:100px' src='/img/documentation/users/editUserIcon.png' />" +
                "<p>Na zgornji sliki je prikazan gumb na katerega lahko kliknete, da vas preusmeri na urejanje podatkov " +
                "uporabnika.</p>" +
                "</div>",
                currentStep : 5,
                allSteps:7
            },
            {
                title:"Brisanje uporabnika",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:70px;width:100px' src='/img/documentation/users/deleteUserIcon.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Brisanje uporabnika je omogočena le za uporabnika s pravicami <b>administratorja</b>. Ob kliku na gumb, ki ga lahko " +
                "vidite v zgornji vrstici, se bo uporabnik izbrisal. Uporabnik ne bo fizično izbrisan iz podatkovne baze, ampak bo " +
                "dobil status <b>neaktiven</b>, kar pa pri končnemu uporabniku pomeni isto kot, da je uporabnik izbrisan.</p>" +
                "</div>",
                currentStep : 6,
                allSteps:7
            },
            {
                title:"Paginacija seznama uporabnikov",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:50px;width:120px' src='/img/documentation/users/listPagination.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da ne bi bil seznam uporabnikov predolg, se seznam razdeli na več strani po 10 zapisov na stran. Za iskanje različne uporabnike lahko uporabite " +
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
                        Uporabniki
                        <small>Seznam uporabnikov</small>
                    </h3>
                </div>

                <div class="col-sm-1">
                    <h1><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h1>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje novega uporabnika</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <a href="{{ action('UserController@create') }}" class="btn btn-primary btn-block">
                                <b>Ustvari novega uporabnika</b>
                            </a>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam uporabnikov</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>št.</th>
                                    <th>Email</th>
                                    <th>Ime</th>
                                    <th>Priimek</th>
                                    <th>A.</th>
                                    <th>P.O.</th>
                                    <th>K.M.</th>
                                    <th>R.</th>
                                    <th>Status</th>
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $index => $user)
                                    <tr>
                                        <th width="40px">{{ $index+1 }}</th>
                                        <td>
                                            <a href="{{ action('UserController@show', [$user->id]) }}">{{ $user->email }}</a>
                                        </td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>

                                        <td>
                                            @if($user->isAdmin())
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->isPO())
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->isKM())
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->isDev())
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </td>

                                        <td>
                                            @if($user->deleted_at != null )
                                                Izbrisan
                                            @else
                                                Aktiven
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->deleted_at == null )
                                                <a href="{{ action('UserController@edit', [$user->id]) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->deleted_at == null )
                                                <a href="javascript:reallyDelete({{ $user->id }})"><i class="fa fa-remove"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>št.</th>
                                    <th>Email</th>
                                    <th>Ime</th>
                                    <th>Priimek</th>
                                    <th>A.</th>
                                    <th>P.O.</th>
                                    <th>K.M.</th>
                                    <th>R.</th>
                                    <th>Status</th>
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
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
            var r = confirm("Ali ste prepričani, da želite izbrisati uporabnika?");
            if (r == true) {
                window.location.href = "/users/" + id + "/delete";
            }
        }
    </script>
@endsection