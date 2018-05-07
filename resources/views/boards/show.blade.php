@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title:"Podatki table",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Maska prikazuje vse podatke, ki ste jih vnesli na maski za novo tablo: <b>ime table</b>,<b>opis table</b>, <b>število dni za obveščanje</b> pred zaključkom table, " +
                "<b>status table</b>." +
                "</p>" +
                "<p>S klikom na gumb <b>Uredi</b> vas bo aplikacija preusmerila na masko za urejanje podatkov trenutne table. S klikom na gumb <b>Izbriši</b> " +
                "boste trenutno tablo postavili v stanje <b>neaktivna</b>.</p>" +
                "<p>Ko vnesete vse podatke boste tablo ustvarili tako, da kliknete na gumb <b>Ustvari</b>.</p>"+
                "</div>",
                currentStep : 1,
                allSteps: 1
            },
            {
                title:"Stransko okno",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "V stranskem oknu, ki ga nakazuje spodnja slika, lahko kopirate celotno strukturo tabele. To pomeni, da lahko kopirate vse podatke, ki so povezani s strukturo table, " +
                "razen kartic, ki so prisotne na tabli. S klikom na gumb <b>Dodaj kartico</b> lahko dodate kartico na tablo. S klikom na <b>Prva kartica</b> boste ustvarili začetno " +
                "kartico na tabli. S klikom na <b>silver bullet</b> boste ustvarili posebno kartico, ki ima visoko prioriteto v celotni tabli (za izbran projekt)." +
                "S klikom na gumb <b>Prikaži</b> vas bo aplikacija preusmerila na grafični pogled stanja table." +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12 align-text-center'>" +
                "<img src='/img/documentation/boards/sideWindow.png' src='width:100px;height:200;'/>" +
                "</div> ",
                currentStep : 2,
                allSteps: 4
            },
            {
                title:"Dodajanje nove kartice - prvi del",
                body: "<div class='col-sm-12'>" +
                "<p>Pri dodajanju nove kartice morate vnesti <b>ime naloge</b>, <b>opis naloge</b>, izbrati morate projekt kateremu spada na novo " +
                "ustvarjena kartica. V kolikor hočete ustvariti kartico morate obvezno izbrati <b>projekt</b>. Vnesete lahko tudi lastnika kartice. Lastnika kartice boste lahko " +
                "izbrali le v primeru, ko boste imeli izbran nek projekt, kajti izbirni seznam uporabnikov je odvisen od izbranega projekta." +
                "</p>" +
                "<p>Omenjene podatke prikazuje spodnja slika.</p>" +
                "</div>"+
                "<div class='col-sm-12 align-text-center' style='margin-bottom:20px;'>" +
                "<img class='' src='/img/documentation/boards/createNewCardPart1.png' style='height:240px;width:75%;' />" +
                "</div>",
                currentStep : 3,
                allSteps: 3
            },
            {
                title:"Dodajanje nove kartice - drugi del",
                body: "<div class='col-sm-12'>" +
                "<p>Naslednji pomemben podatek za ga vnesti je <b>datum</b> do kdaj naj bo naloga opravljena. Pri barvi, si lahko " +
                "nastavljate poljubno barvo, v kolikor želite lažje prepoznati med različnimi karticami (še posebej uporabno za razločevanje med različnimi karticami različnih uporabnikov)."+
                "</p>" +
                "<p>Pri vnosnem polju <b>Ocena časa</b> morate vnesti neko število, ki predstavlja število ur kolikor ste predvidevali, da boste potrebovali za omenjeno kartico." +
                "Na koncu lahko še obkljukate, ali je kartica <b>kritična</b>, ali <b>zavrnjena</b>. Kritična kartica bo prioritetno obravnavana pred ostalimi karticami v sprint backlogu. " +
                "Ko vnesete vse podatke lahko kliknete gumb <b>Shrani</b> in kartica bo shranjena in prikazana na tabli." +
                "</p>" +
                "<p>Omenjene podatke prikazuje spodnja slika.</p>" +
                "</div>"+
                "<div class='col-sm-12 align-text-center' style='margin-bottom:20px;'>" +
                "<img class='' src='/img/documentation/boards/createNewCardPart2.png' style='height:240px;width:75%;' />" +
                "</div>",
                currentStep : 4,
                allSteps: 3
            }

        ];
    </script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="col-sm-11">
                <h3>
                    Tabla
                </h3>
            </div>
            <div class="col-sm-1">
                {{--color:rgb(67,120,45)--}}
                <h2><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
            </div>
        </section>
        @include('layout.error')
        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <div class="col-md-3">
                    @include('boards.detail')

                    {{--here my be included some other part --}}
                </div>
                <!-- /.col -->

                {{-- right wide column --}}
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Podatki</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table class="table table-bordered table-striped table-hover">


                                <tr>
                                    <td>Ime</td>
                                    <td>{{ $board->board_name }}</td>
                                </tr>

                                <tr>
                                    <td>Opis</td>
                                    <td>{{ $board->description }}</td>
                                </tr>

                                <tr>
                                    <td>Dni pred obvestilom</td>
                                    <td>{{ isset($board->meta->notification) ? $board->meta->notification : '-' }}</td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>@if($board->deleted_at != null )
                                            Izbrisana
                                        @else
                                            Aktivna
                                        @endif
                                    </td>
                                </tr>

                            </table>

                            @if(Auth::user()->isKM() && $board->deleted_at==null)
                            <div class="row">
                                <div class="col-sm-4">
                                    {{-- @if() check if there are cards in columns --}}
                                        <a href="{{ action('BoardController@edit', $board->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    {{--@endif--}}
                                </div>

                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($board->deleted_at == null )
                                        <a href="javascript:reallyDelete({{$board->id}})"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete(boardid) {
                                                console.log(boardid);
                                                var r = confirm("Ali ste prepričani, da želite izbrisati tablo?");
                                                        
                                                if (r == true) {
                                                        window.location.href = "/boards/" + boardid +"/delete";
                                                    }
                                                }
                                        </script>
                                    @endif

                                </div>
                            </div>
                            @endif


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
@endsection