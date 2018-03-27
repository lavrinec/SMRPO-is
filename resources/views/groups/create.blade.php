@extends('default.layout')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Račun skupine
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
                            <h3 class="box-title">Ustvarjanje nove skupine</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            {{--{{ action('GroupController@store') }}--}}

                            <form class="form-horizontal" method="POST" action="{{ action('GroupController@store') }}">

                                @csrf

                                <div class="form-group">
                                    <label for="first_name" class="col-sm-2 control-label">Ime skupine</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Ime">
                                        @if ($errors->has('group_name'))
                                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Opis skupine</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Opis">
                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
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