@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
            {
                title:"Podatki projekta",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Na maski lahko vidite <b>ime projekta</b>, <b>opis projekta</b>, <b>datum začetka</b>, <b>datum zaključka</b>, <b> ime naročnika</b>, <b>ime skupine</b> in <b>ime table</b> " +
                "kateri pripada projekt. Ime table se nastavlja avtomatsko, ko boste na maski za ustvarjanje table določili kateri projekt spada na ustvarjeno tablo."+
                "</p>" +
                "<p>S klikom na gumb <b>Uredi</b> vas bo aplikacija preusmerila na masko za urejanje podatkov projekta.</p>" +
                "<p>S klikom na gumb <b>Izbriši</b> bo aplikacija trenutni projekt postavila v status <b>neaktiven</b>.</p>" +
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
            <div class="row">
                <div class="col-sm-11">
                    <h3>
                        Projekt
                    </h3>
                </div>
                <div class="col-sm-1">
                    {{--color:rgb(67,120,45)--}}
                    <h2><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
                </div>
            </div>
        </section>

        @include('layout.error')

        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <!-- <div class="col-md-3">
                   

                    {{--here my be included some other part --}}
                </div> -->

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
                                    <td>Ime projekta</td>
                                    <td>{{ $projects->board_name }}</td>
                                </tr>

                                <tr>
                                    <td>Opis projekta</td>
                                    <td>{{ $projects->description }}</td>
                                </tr>

                                <tr>
                                    <td>Naročnik projekta</td>
                                    <td>{{ $projects->buyer_name }}</td>

                                </tr>

                                <tr>
                                    <td>Datum začetka</td>
                                    
                                    <td>{{ date("d.m.Y", strtotime($projects->start_date)) }}</td>

                                </tr>

                                <tr>
                                    <td>Datum zaključka</td>
                                    <td>{{ date("d.m.Y", strtotime($projects->end_date)) }}</td>

                                </tr>

                                <tr>
                                    <td>Skupina</td>
                                    <td>@if(isset($group->group_name))
                                            <a href="/groups/{{$group->id}}/show">
                                                {{ $group->group_name}}
                                            </a>
                                        @endif</td>

                                </tr>

                                <tr>
                                    <td>Tabla</td>
                                    <td>
                                        @if($projects->board_id)
                                            <a href="/boards/{{$projects->board->id}}/focus">
                                                {{ $projects->board->board_name }}
                                            </a>
                                            @else
                                            Projekt še ni dodeljen na tablo
                                        @endif

                                    </td>

                                </tr>
                                

                            </table>

                         @if(Auth::user()->isKM()&&!$projects->deactivated)
                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if($projects->deleted_at == null )
                                        <a href="{{ action('ProjectController@edit', $projects->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($projects->deleted_at == null )
                                        <a href="javascript:reallyDelete()"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete() {
                                                var r = confirm("Ali ste prepričani, da želite izbrisati projekt?");
                                                if (r == true) {
                                                    window.location.href = "{{ action('ProjectController@destroy', $projects->id) }}";
                                                }
                                            }
                                        </script>
                                    @endif

                                </div>
                            </div>
                        @endif
                        @if(Auth::user()->isKM()&&$projects->deactivated)
                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if($projects->deleted_at == null )
                                    <!-- TO DO: klici aktivacijsko funkcijo iz projectControllerja -->
                                    <button id="actovate" type="button" class="btn btn-success"
                                                onclick="activate({{$projects->id}})">
                                            Aktiviraj
                                        </button>
                        
                                        
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
<script>
     function activate(id) {
        $.ajax({
                type: 'POST',
                url: "{{ action('ProjectController@activate',$projects->id) }}",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    console.log("uspesno potegnien id" + id);
                    document.location.href = "/projects";
                }

            });
        //console.log(id);
        }
        </script>
    <!-- /.content-wrapper -->
@endsection