@extends('default.layout')

@section('content')
    <script>
        documentationContent = [
            {
                title:"Skupine",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Trenutni pogled/stran vam omogoča:" +
                "<ul>" +
                "<li>Ustvarjanje novih skupin,</li>" +
                "<li>Pregled vseh skupin,</li>" +
                "<li>Urejanje skupin,</li>" +
                "<li>Brisanje skupin.</li>" +
                "</ul>" +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 7
            },
            {
                title:"Ustvarjanje skupin",
                body: "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/groups/createNewGroup.png' style='height:60px;' " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Zgornja slika prikazuje gumb s katerim se lahko navigiramo na stran, kjer vnesemo podatke za novo skupino. Ob kliku na gumb <b>Ustvari novo skupino</b> " +
                "se boste navigirali na novo stran/novi pogled na katerem boste imeli nadaljno pomoč." +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 7
            },
            {
                title:"Seznam skupin",
                body:"<div class='col-sm-12'>" +
                "<p>" +
                "Seznam skupin je tabela vseh skupin. Na tem seznamu lahko (v kolikor imate pravice <b>Kanban masterja</b>) " +
                "ustvarjate, brišete in urejate skupine znotraj aplikacije <b>SCRUMBAN</b>." +
                "</p>" +
                "<p>" +
                "Na spodnji sliki vidite primer seznama skupin kot ga vidi <b>Kanban master</b>. Vsi ostali uporabniki aplikacije ne bodo uspeli videti:" +
                "<ul>" +
                "<li>Gumba <b>Ustvari novo skupino</b>,</li>" +
                "<li>Stolpca <b>Uredi</b>,</li>" +
                "<li>Stolpca <b>Zbriši</b>,</li>" +
                "</ul>" +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<img class='full-row' src='/img/documentation/groups/listGroups.png' style='height:300px;' " +
                "</div>",
                currentStep:3,
                allSteps:7
            },
            {
                title:"Iskalnik skupin",
                body: "<div class='col-sm-12' style='text-align:center;'>" +
                "<img class='' src='img/documentation/users/searchInput.png' style='width:150px;height:50px'" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da bi se lažje znašli med iskanjem specifične skupine smo vam pripravili polje s katerim " +
                "lahko filtrirate skupine po njihovem <b>imenu</b>. Polje s katerim lahko " +
                "filtriramo uporabike je viden na sliki zgoraj." +
                "" +
                "</p>" +
                "<div>",
                currentStep : 4,
                allSteps: 7
            },
            {
                title:"Podatki skupine",
                body: "<div class='col-sm-12'>"+
                "<p>Do podatkov skupine lahko pridemo na dva načina. Pregled podatkov skupine (dostopen vsem) " +
                "in urejanje podatkov skupine (dostopen le <b>Kanban masterju</b>)." +
                "</p>" +
                "</div>" +
                "<div class='col-lg-6 col-sm-12 align-text-center' >" +
                "<h4>Pregled podatkov skupine</h4>" +
                "<img style='height:65px;width:110px' src='/img/documentation/groups/groupName.png' />" +
                "<p>Na zgornji sliki je prikazan primer imena skupine v seznamu skupin. Ob kliku na ime " +
                "vas bo navigiralo na stran na kateri boste lahko videli podatke " +
                "skupine.</p>" +
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
                title:"Brisanje skupine",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:70px;width:100px' src='/img/documentation/users/deleteUserIcon.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Brisanje skupine je omogočena le za uporabnika s pravicami <b>Kanban masterja</b>. Ob kliku na gumb, ki ga lahko " +
                "vidite v zgornji vrstici, se bo skupina izbrisala. Skupina ne bo fizično izbrisana iz podatkovne baze, ampak bo " +
                "dobila status <b>neaktivna</b>, kar pa pri končnemu uporabniku pomeni isto kot, da je skupina izbrisana.</p>" +
                "</div>",
                currentStep : 6,
                allSteps:7
            },
            {
                title:"Paginacija seznama skupin",
                body: "<div class='col-sm-12 align-text-center'>"+
                "<img style='height:50px;width:120px' src='/img/documentation/users/listPagination.png' />" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Da ne bi bil seznam skupin predolg, se seznam razdeli na več strani po 10 zapisov na stran. Za iskanje skupin lahko uporabite " +
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
                        Skupine
                        <small>Seznam skupin</small>
                    </h3>
                </div>
                <div class="col-sm-1">
                    {{--color:rgb(67,120,45)--}}
                    <h2><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    @if(Auth::user()->isKM())
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Ustvarjanje nove skupine</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <a href="{{ action('GroupController@create') }}" class="btn btn-primary btn-block">
                                    <b>Ustvari novo skupino</b>
                                </a>

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    @endif


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam skupin</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>št.</th>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    {{--<th>Status</th>--}}
                                    @if(Auth::user()->isKM())
                                        <th>Uredi</th>
                                        <th>Izbriši</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($groups as $index => $group)
                                    <tr>
                                        <td width="40px">{{ $index+1 }}</td>
                                        <td>
                                            <a href="{{ action('GroupController@show', [$group->id]) }}">{{ $group->group_name }}</a>
                                        </td>
                                        <td>{{ $group->description }}</td>

                                        {{--<td>--}}
                                            {{--@if($group->deleted_at != null )--}}
                                                {{--Izbrisana--}}
                                            {{--@else--}}
                                                {{--Aktivna--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
                                        @if(Auth::user()->isKM())
                                            <td>
                                                @if($group->deleted_at == null )
                                                    <a href="{{ action('GroupController@edit', [$group->id]) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($group->deleted_at == null )
                                                    <a href="javascript:reallyDelete({{$group->id}})"><i class="fa fa-remove"></i></a>


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
                                    {{--<th>Status</th>--}}
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
        <script type="text/javascript">
            function reallyDelete(groupid) {
                var r = confirm("Ali ste prepričani, da želite izbrisati skupino?");
                if (r == true) {
                    window.location.href = "/groups/" + groupid +"/delete";
                    // {{--//"{{ action('GroupController@destroy', $group->id) }}";--}}
                }
            }
        </script>
    </div>
@endsection