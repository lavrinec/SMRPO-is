@extends('default.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Skupine
                <small>Seznam skupin</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje nove skupine</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <a href="{{ action('GroupController@create') }}" class="btn btn-primary btn-block">
                                <b>Ustvari novo skupino</b>
                            </a>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam skupin</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Status</th>
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($groups as $group)
                                    <tr>
                                        <td>
                                            <a href="{{ action('GroupController@show', [$group->id]) }}">{{ $group->group_name }}</a>
                                        </td>
                                        <td>{{ $group->description }}</td>

                                        <td>
                                            @if($group->deleted_at != null )
                                                Izbrisan
                                            @else
                                                Aktiven
                                            @endif
                                        </td>
                                        <td>
                                            @if($group->deleted_at == null )
                                                <a href="{{ action('GroupController@edit', [$group->id]) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($group->deleted_at == null )
                                                <a href="javascript:reallyDelete()"><i class="fa fa-remove"></i></a>

                                                <script>
                                                    function reallyDelete() {
                                                        var r = confirm("Ali ste prepričani, da želite izbrisati uporabnika?");
                                                        if (r == true) {
                                                            window.location.href = "{{ action('GroupController@destroy', $group->id) }}";
                                                        }
                                                    }
                                                </script>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Status</th>
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
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
@endsection