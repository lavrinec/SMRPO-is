@extends('default.layout')

@section('content')
    <script>
        documentationContent = [
            {
                title:"Podatki projekta",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Vnos podatkov je precej standarden. Podati morate <b>ime</b> projekta, <b>opis</b> projekta, " +
                "<b>ime naročnika</b> projekta, določiti <b>Datum začetka</b> kdaj bo projekt postal aktiven in <b>Datum zaključka</b> " +
                "kdaj bo projekt postal neaktiven oz. kdaj se predvideva, da bo zaključen." +
                "Na koncu morate še izbrati skupino iz izbirnega seznama. Vsak projekt mora biti vezan na eno skupino, drugače se projekta " +
                "ne more uporabiti na nobeni tabli.</p>" +
                "<p>Ko vnesete vse podatke boste projekt ustvarili tako, da kliknete na gumb <b>Ustvari</b>.</p>"+
                "</div>",
                currentStep : 1,
                allSteps: 1
            }

        ];
    </script>
    <link rel="stylesheet" href="/dependencies/select2/dist/css/select2.min.css">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-11">
                    <h3>
                        Račun projekta
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
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje novega projekta</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            {{--{{ action('ProjectController@store') }}--}}

                            <form class="form-horizontal" method="POST" action="{{ action('ProjectController@store') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="board_name" class="col-sm-2 control-label">Ime projekta</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="board_name" name="board_name"
                                               placeholder="Ime" value="{{old('board_name')}}" required>
                                        @if ($errors->has('board_name'))
                                            <span class="help-block">{{ $errors->first('board_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Opis projekta</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                               placeholder="Opis" value="{{old('description')}}" required>
                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="buyer_name" class="col-sm-2 control-label">Naročnik projekta</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="buyer_name" name="buyer_name"
                                               placeholder="Naročnik" value="{{old('buyer_name')}}" required>
                                        @if ($errors->has('buyer_name'))
                                            <span class="help-block">{{ $errors->first('buyer_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="start_date" class="col-sm-2 control-label">Datum začetka</label>

                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                               placeholder="Začetek" value="{{old('start_date')}}" required>
                                        @if ($errors->has('start_date'))
                                            <span class="help-block">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="end_date" class="col-sm-2 control-label">Datum zaključka</label>

                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                               placeholder="Zaključek" value="{{old('end_date')}}" required>
                                        @if ($errors->has('end_date'))
                                            <span class="help-block">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="group_id" class="col-sm-2 control-label">Skupina</label>

                                    <div class="col-sm-10">                    
                                        <select class="form-control" name="group_id" id="group_id">
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->group_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('group'))
                                            <span class="help-block">{{ $errors->first('group') }}</span>
                                        @endif
                                    </div>
                                </div>

                           


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Ustvari</button>
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