@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title:"Podatki skupine",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Na maski lahko vidite <b>ime skupine</b>, <b>opis skupine</b>, <b>seznam uporabnikov</b> in njihovih <b>vlog v skupini</b>(prva leva stranska kartica) in " +
                "seznam <b>tabel</b> in <b>projektov</b> na katere je vezana trenutno ogledana skupina." +
                "</p>" +
                "</div>",
                currentStep : 1,
                allSteps: 3
            },
            {
                title:"Uporabniki v skupini",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/groups/listOfUsersInGroup.png' style='height:130px;width:200px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>V stranski kartici <b>Uporabniki v skupini</b>, ki jo prikazuje zgornja slika vam prikazujemo seznam " +
                "uporabnikov in vlog, ki pripadajo tem uporabnikom v trenutno izbrani skupini." +
                "</p>" +
                "<p>Prvo imamo podano v <b>odebeljenem tekstu</b> ime in priimek uporabnika, nato imamo v alinejah pod imenom " +
                "razvrščene vse vloge, ki jih ima uporabnik v skupini." +
                "</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 3
            },
            {
                title:"Table in projekti",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/groups/listProjectsAndBoards.png' style='height:100px;width:200px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>V stranski kartici <b>Table in projekti</b>, ki jo prikazuje zgornja slika vam prikazujemo seznam " +
                "vseh tabel v prvi vrstici z <b>odebeljenim tekstom</b> in nato v alinejah razporejene vse projekte, katerim je trenutna skupina dodeljena." +
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
                        Račun skupine
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

                {{-- left narrow column --}}
                <div class="col-md-3">
                    @include('groups.detail')

                    {{--here my be included some other part --}}
                    @include('groups.data')
                    
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
                                    <td>Ime</td>
                                    <td>{{ $groups->group_name }}</td>
                                </tr>


                                <tr>
                                    <td>Opis</td>
                                    <td>
                                        {{$groups->description}}
                                    </td>
                                </tr>

                            </table>


                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if(Auth::user()->isKM())
                                        @if($groups->deleted_at == null )
                                            <a href="{{ action('GroupController@edit', $groups->id) }}"
                                               class="btn btn-primary btn-block">
                                                <b>Uredi</b>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
                                    @if(Auth::user()->isKM())
                                        @if($groups->deleted_at == null )
                                            <a href="javascript:reallyDelete()"
                                               class="btn btn-danger btn-block">
                                                <b>Izbriši</b>
                                            </a>

                                            <script>
                                                function reallyDelete() {
                                                    var r = confirm("Ali ste prepričani, da želite izbrisati skupino?");
                                                    if (r == true) {
                                                        window.location.href = "{{ action('GroupController@destroy', $groups->id) }}";
                                                    }
                                                }
                                            </script>
                                        @endif
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