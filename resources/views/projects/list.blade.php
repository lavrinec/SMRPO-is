@extends('default.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Projekti
                <small>Seznam projektov</small>
            </h1>
        </section>

        @include('layout.error')

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    @if(Auth::user()->isKM())
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Ustvarjanje novega projekta</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <a href="{{ action('ProjectController@create') }}" class="btn btn-primary btn-block">
                                    <b>Ustvari nov projekt</b>
                                </a>

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    @endif


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam projektov</h3>
                        </div>
                       
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Naročnik</th>
                                    <th>Datum začetka</th>
                                    <th>Datum zaključka</th>
                                    <th>Skupina</th>
                                    <th>Status</th>
                                    <th>Tabla</th>
            
                                    @if(Auth::user()->isKM())
                                        <th>Uredi</th>
                                        <th>Izbriši</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>
                                            <a href="{{ action('ProjectController@show', [$project->id]) }}">{{ $project->board_name }}</a>
                                        </td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->buyer_name }}</td>
                                        <td>{{ date("d.m.Y", strtotime($project->start_date)) }}</td>
                                        <td>{{ date("d.m.Y", strtotime($project->end_date)) }}</td>
                                        <td>{{ isset($project->group->group_name) ? $project->group->group_name : '' }}</td>
                                        <td>@if($project->deactivated || $project->deactivated!=null)
                                                Neaktiven
                                            @else
                                                Aktiven
                                            @endif                                        
                                        </td>
                                        <td>{{ !($project->board_id) ? "" : $project->board->board_name }}</td>

                                        @if(Auth::user()->isKM())
                                            <td>
                                                @if($project->deleted_at == null && !$project->deactivated)
                                                    <a href="{{ action('ProjectController@edit', [$project->id]) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($project->deleted_at == null && !$project->deactivated )
                                                    <a href="javascript:reallyDelete({{$project->id}})"><i class="fa fa-remove"></i></a>

                                                    
                                                @endif
                                            </td>
                                            @endif
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Naročnik</th>
                                    <th>Datum začetka</th>
                                    <th>Datum zaključka</th>
                                    <th>Skupina</th>
                                    <th>Status</th>
                                    <th>Tabla</th>
                                    @if(Auth::user()->isKM())
                                        <th>Uredi</th>
                                        <th>Izbriši</th>
                                    @endif
                                </tr>
                                </tfoot>
                            </table>
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
        function reallyDelete(id) {
        var r = confirm("Ali ste prepričani, da želite izbrisati projekt?");
        if (r == true) {
            window.location.href ="/projects/"+id+"/delete";
        }
    }
                                                    </script>
@endsection