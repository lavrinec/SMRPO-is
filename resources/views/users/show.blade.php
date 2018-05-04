@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title:"Podatki uporabnika",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Podatki so precej standardni. Prikazujemo vam sledeče podatke uporabnika:" +
                "<ul>" +
                "<li>Ime,</li>" +
                "<li>Priimek,</li>" +
                "<li>Email naslov,</li>" +
                "<li>Status (ali je uporabnik aktiven ali izbrisan).</li>" +
                "</ul>" +
                "</div>",
                currentStep : 1,
                allSteps: 3
            },
            {
                title:"Stransko okno",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/users/editUserSideWindow.png' style='height:140px;width:180px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Stransko okno, ki ga vidite na zgornji sliki vsebuje sledeče podatke:" +
                "<ul>" +
                "<li><b>Ime in priimek</b>,</li>" +
                "<li><b>Email naslov uporabnika</b>,</li>" +
                "<li><b>Vloge uporabnika</b> katere lahko zastopa v posamezni skupini.</li>" +
                "</ul>" +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 3
            },
            {
                title:"Urejanje podatkov uporabnika",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<p>V kolikor imate pravice <b>administratorja</b> potem lahko podatke uporabnika tudi uredite. S klikom " +
                "na gumb <b>Uredi</b> vas bo aplikacija preusmerila na urejanje podatkov uporabnika. V kolikor nimate ustreznih pravic " +
                "potem omenjenega gumba ne boste videli in lahko to informacijo spregledate." +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 3
            }

        ];
    </script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-11">
                    <h3>
                        Uporabniški račun
                    </h3>
                </div>
                <div class="col-sm-1">
                    <h2><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <div class="col-md-3">
                    @include('users.detail')

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

                            <table id="example1" class="table table-bordered table-striped table-hover">


                                <tr>
                                    <td>Email</td>
                                    <td>{{ $users->email }}</td>
                                </tr>

                                <tr>
                                    <td>Ime</td>
                                    <td>{{ $users->first_name }}</td>
                                </tr>

                                <tr>
                                    <td>Priimek</td>
                                    <td>{{ $users->last_name }}</td>

                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>@if($users->deleted_at != null )
                                            Izbrisan
                                        @else
                                            Aktiven
                                        @endif
                                    </td>
                                </tr>

                            </table>


                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if($users->deleted_at == null )
                                        <a href="{{ action('UserController@edit', $users->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($users->deleted_at == null )
                                        <a href="javascript:reallyDelete()"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete() {
                                                var r = confirm("Ali ste prepričani, da želite izbrisati uporabnika?");
                                                if (r == true) {
                                                    window.location.href = "{{ action('UserController@destroy', $users->id) }}";
                                                }
                                            }
                                        </script>
                                    @endif

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
@endsection