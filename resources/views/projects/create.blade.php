@extends('default.layout')

@section('content')

    <link rel="stylesheet" href="/dependencies/select2/dist/css/select2.min.css">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Račun projekta
            </h1>
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