@extends('default.layout')

@section('content')
    <script>

        documentationContent = [
            {
                title:"Pomoč",
                body: "<div class='col-sm-12'>" +
                "<h4 style='text-align:center;'>Dobrodošli v aplikaciji SCRUMBAN!</h4>" +
                "Med uporabo aplikacije vam bo vedno dostopna pomoč do katere lahko dostopate s klikom na " +
                "<span class='glyphicon glyphicon-question-sign'></span>." +
                "</p>"+
                "<p>" +
                "Pomoč bo vedno pristotna v obliki modalnega okna. To okno bo včasih vsebovalo več korakov skozi katere" +
                " vam bomo predstavili uporabo funkcionalnosti določene vsebine. Število korakov je odvisno od števila" +
                " funkcionalnosti, ki jih vsebina vsebuje." +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 5
            },
            {
                title:"Struktura aplikacije",
                body: "<div class='col-sm-12'>" +
                "<p>Naša aplikacija vsebuje določeno strukturo, ki bo ves čas enaka. Vsak del v strukturi ima svoj pomen, " +
                "ki se lahko dinamično spreminja. Ti deli so:" +
                "<ul>" +
                "<li><b>Stranski meni</b>,</li>" +
                "<li><b>Uporabniški profil</b>,</li>" +
                "<li><b>Vsebina</b>.</li>" +
                "</ul>" +
                "</p>" +
                "<p>" +
                ""+
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 5
            },
            {
                title:"Stranski meni",
                body:"<div class='col-sm-12'>" +
                "<p>Stranski meni vam omogoča dostop do vseh funkcionalnosti za izvajanje in pregled dela po SCRUMBAN metodologiji. " +
                "Dostopate lahko do:</p>" +
                "<div id='sidebar-step-left-column' class='col-sm-6'>" +
                "<ul>" +
                "<li><b>Domača stran</b>,</li>" +
                "<li><b>Uporabnikov</b> - upravljanje uporabnikov (pregled, dodajanje, urejanje),</li>" +
                "<li><b>Skupin</b> - upravljanje skupin (pregled, dodajanje, urejanje),</li>" +
                "<li><b>Projektov</b> - upravljanje projektov (pregled, dodajanje, urejanje),</li>" +
                "<li><b>Tabel</b> - upravljanje tabel (pregled, dodajanje, urejanje).</li>" +
                "</ul>" +
                "</div>" +
                "<div class='col-sm-6'><div style='height:25vh;width:65%;'><img style='height:100%;width:100%;' src='img/documentation/home/sidebar.png' />" +
                "</div></div>" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Vsaka funkcionalnost/stran ima tudi dostopno pomoč, ki je prilagojena za specifično funkcionalnost na kateri se nahajate.</p></div>",
                currentStep:3,
                allSteps:5
            },
            {
                title:"Uporabniški profil",
                body: "<div class='col-sm-12' style='text-align:center;'>" +
                "<img src='img/documentation/home/userProfile.png' style='width: 250px;height:200px'" +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Tukaj vam omogočamo odjavo iz sistema in dostop do vaših podatkov, ki jih lahko spremenite in dopolnite." +
                "" +
                "</p>" +
                "<div>",
                currentStep : 4,
                allSteps: 5
            },
            {
                title:"Vsebina",
                body: "<div class='col-sm-12'>"+
                "<p>Kontekst razdelka <b>Vsebina</b> je odvisna od tega katero funkcionalnost smo izbrali. Ob vstopu v aplikacijo " +
                "bomo imeli prikazano <b>Nadzorno ploščo</b>, ki prikazuje nam omogoča prikaz raznih statistič analiz za " +
                "boljši pregled na delom skupin, ali posameznikov. Pri izbiri <b>Uporabnikov</b> bomo imeli prikazan seznam uporabnikov in možnost urejanja, " +
                "dodajanja uporabnikov (to velja le za Administratorja). Enako možnost prikaza bomo imeli ob kliku na <b>Projekte</b>, " +
                "<b>Skupine</b>, <b>Table</b> le da vsaka izbira prikaže podatke povezane z izbrano funkcionalnostjo." +
                "" +
                "</p>" +
                "<div>",
                currentStep : 5,
                allSteps:5
            },
            {
                title:"Nadzorna plošča",
                body: "<div class='col-sm-12'>"+
                "<p> <b>Nadzorna plošča</b> prikazuje seznam nekaterih analitičnih orodij s katerimi lažje opazujemo " +
                "napredek in opravljeno delo skupin in posameznikov. Ta orodja so:" +
                "<ul>" +
                "<li>Povprečen čas,</li>" +
                "<li>Kršitve WIP,</li>" +
                "<li>Itd - dopolni se ob dopolnitvi funkcionalnosti.</li>" +
                "</ul>" +
                "</p>" +
                "<div>" +
                "<div class='col-sm-12'>" +
                "<img src='/img/documentation/home/homeBoard.png' style='width:100%;height:250px;margin-bottom:15px;' />" +
                "</div>",
                currentStep : 6,
                allSteps:6
            }

        ];
    </script>
    <script type="text/javascript">
        (function(){



            // $('#documentationModel h4.modal-title').text("ecnhatement");
            // console.log($('#documentationModel h4.modal-title').text());

            $(document).ready(function(){
                console.log(documentationContent);
                //openModal();
                // resetDocumentationModel();
                // setHtmlInModal();
                // showDocumentationModel();
            });


        })();
    </script>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-11">
                    <h2>
                        Nadzorna plošča
                    </h2>
                </div>
                <div class="col-sm-1">
                    {{--color:rgb(67,120,45)--}}
                    <h1><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h1>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Dodeljenih nalog</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-search"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Opravljenih nalog</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>44</h3>

                            <p>Uporabnikov</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Tabel</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">

                {{--for ADMIN--}}

                @if(isset($users))
                    <div class="col-sm-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Uporabniki</h3>
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
                                        <th>Status</th>
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
                                                @if($user->deleted_at != null )
                                                    Izbrisan
                                                @else
                                                    Aktiven
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
                                        <th>Status</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                @endif


                @if(isset($notifications))
                    <div class="col-sm-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Obvestila</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>št.</th>
                                        <th>Naslov</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>št.</th>
                                        <th>Naslov</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                @endif



                 {{--for ordinary users--}}

                @if(isset($boards))
                    <div class="col-sm-3">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Moje table</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                @if ($errors->has('NoBoard'))
                                    <span class="help-block">{{ $errors->first('NoBoard') }}</span>
                                @endif
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
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
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                @endif


                @if(isset($projects))
                    <div class="col-sm-3">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Moji projekti</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($projects as $index => $project)
                                        <tr>
                                            <td width="40px">{{ $index+1 }}</td>
                                            <td>
                                                {{--<a href="{{ action('BoardController@show', [$board->id]) }}">{{ $board->board_name }}</a>--}}
                                                <a href="{{ action('ProjectController@show', $project->id) }}">{{$project->board_name}}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                @endif


                @if(isset($groups))
                    <div class="col-sm-3">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Moje skupine</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($groups as $index => $group)
                                        <tr>
                                            <td width="40px">{{ $index+1 }}</td>
                                            <td>
                                                {{--<a href="{{ action('BoardController@show', [$board->id]) }}">{{ $board->board_name }}</a>--}}
                                                <a href="{{ action('GroupController@show', $group->id) }}">{{$group->group_name}}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                @endif

                @if(isset($tasks))
                    <div class="col-sm-3">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Moje naloge</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>št.</th>
                                        <th>Ime</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                @endif


            </div>


        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection