@extends('default.layout')

@section('content')

    <script>
        documentationContent = [
        {
        title:"Podatki table",
        body: "<div class='col-sm-12'>" +
            "<p>" +
                "Vnos podatkov je precej standarden. Podati morate <b>ime</b> table, <b>opis</b> table, " +
                "število dni preden preden bo tabla postala neaktivna. Toliko dni kot boste vnesli v omenjeno polje, toliko dni prej"+
                "boste dobili obvestilo, da bo tabla kmalu prešla v rok neaktivnosti." +
                "</p>" +
            "<p>Ko vnesete vse podatke boste tablo ustvarili tako, da kliknete na gumb <b>Ustvari</b>.</p>"+
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
                        Tabla
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
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje nove table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            {{--{{ action('UserController@store') }}--}}

                            <form class="form-horizontal" method="POST" action="{{ action('BoardController@store') }}">

                                @csrf

                                <div class="form-group">
                                    <label for="board_name" class="col-sm-2 control-label">Ime table</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="board_name" name="board_name"
                                               placeholder="Ime" pattern=".{1,255}" required
                                               title="Ime naj bo dolgo med 8 in 255 znakov">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Opis</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                               placeholder="Opis" pattern=".{1,255}" required
                                               title="Opis naj bo dolg med 1 in 255 znakov">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Število dni preden se pošlje mail</label>

                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="meta[notification]"
                                               placeholder="Dni" required min="0">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <button type="submit" class="btn btn-primary">Ustvari tablo</button>
                                    </div>
                                    <div class="col-sm-offset-4 col-sm-2">
                                        <a href="{{ action('BoardController@index') }}" class="btn btn-danger btn-block"><b>Prekliči</b></a>
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
@endsection