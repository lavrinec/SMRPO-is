@extends('default.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Uporabniki
                <small>Seznam uporabnikov</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje novega uporabnika</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <a href="{{ action('UserController@create') }}" class="btn btn-primary btn-block"><b>Ustvari novega uporabnika</b></a>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->




                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam uporabnikov</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Ime</th>
                                    <th>Priimek</th>
                                    <th>Izbrisan</th>
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ action('UserController@show', [$user->id]) }}">{{ $user->email }}</a>
                                        </td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>@if($user->deleted_at != null ) Izbrisan @endif
                                        </td>
                                        <td><a href="{{ action('UserController@edit', [$user->id]) }}"><i class="fa fa-edit"></i></a></td>
                                        <td><a href=""><i class="fa fa-remove"></i></a></td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Email</th>
                                    <th>Ime</th>
                                    <th>Priimek</th>
                                    <th>Izbrisan</th>
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