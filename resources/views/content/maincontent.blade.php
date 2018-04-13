@extends('default.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Nadzorna plošča
            </h1>
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