@extends('default.layout')

@section('content')

 <!-- bootstrap datepicker -->
 <link rel="stylesheet" href="/dependencies/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Projekt
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">

              
                <div class="col-md-9">

                    {{-- div for user data form --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Urejanje podatkov</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" method="POST"
                                  action="{{ action('ProjectController@update', $projects->id) }}">

                                @csrf

                                <div class="form-group">
                                    <label for="board_name" class="col-sm-2 control-label">Ime projekta</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="board_name" name="board_name"
                                               value="{{ $projects->board_name }}" required>
                                        @if ($errors->has('board_name'))
                                            <span class="help-block">{{ $errors->first('board_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Opis projekta</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                        value="{{ $projects->description }}" required>
                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="buyer_name" class="col-sm-2 control-label">Naročnik projekta</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="buyer_name" name="buyer_name"
                                        value="{{ $projects->buyer_name }}" required>
                                        @if ($errors->has('owner'))
                                            <span class="help-block">{{ $errors->first('owner') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="startDate" class="col-sm-2 control-label">Datum začetka</label>

                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $projects->start_date }}" {{ $hasCards ? 'readonly' : 'required' }}>
                                        @if ($errors->has('startDate'))
                                            <span class="help-block">{{ $errors->first('startDate') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="endDate" class="col-sm-2 control-label">Datum zaključka</label>

                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $projects->end_date }}" required>
                                        @if ($errors->has('endDate'))
                                            <span class="help-block">{{ $errors->first('endDate') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="group_id" class="col-sm-2 control-label">Skupina</label>

                                    <div class="col-sm-10">                    
                                        <select class="form-control" name="group_id" id="group_id">
                                            @foreach($groups as $group)
                                                @if ($group->id == $projects->group_id)
                                                <option value="{{$group->id}}" selected>{{$group->group_name}}</option>
                                                @else
                                                <option value="{{$group->id}}">{{$group->group_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('group'))
                                            <span class="help-block">{{ $errors->first('group') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <button type="submit" class="btn btn-primary">Posodobi podatke</button>
                                    </div>
                                    <div class="col-sm-offset-4 col-sm-2">
                                        <a href="{{ action('ProjectController@show', $projects->id) }}"
                                           class="btn btn-danger btn-block"><b>Prekliči</b></a>
                                    </div>
                                </div>
                            </form>


                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

             
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