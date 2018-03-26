@extends('default.layout')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Uporabniški račun
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">User profile</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Ustvarjanje novega uporabnika</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            {{--{{ action('UserController@store') }}--}}

                            <form class="form-horizontal" method="POST" action="{{ action('UserController@store') }}">

                                @csrf

                                <div class="form-group">
                                    <label for="first_name" class="col-sm-2 control-label">Ime</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Ime">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="last_name" class="col-sm-2 control-label">Priimek</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Priimek">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Geslo</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Geslo">
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