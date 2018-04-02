@extends('default.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Račun skupine
            </h1>
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
                                        <input type="text" class="form-control" id="group_name" name="group_name"
                                               placeholder="Ime" required value="{{old('group_name')}}">
                                        @if ($errors->has('group_name'))
                                            <span class="help-block">{{ $errors->first('group_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Opis skupine</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                               placeholder="Opis" value="{{old('description')}}">
                                        <input type="text" hidden name="usersgroups" id="usersgroups-input" value="{{old('usersgroups')}}" />
                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                @include('groups.usersgroup')
                                <hr/>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger" onclick="createGroup()">Ustvari
                                        </button>
                                    </div>
                                    @if($errors->has('noUsersSelected'))
                                        <span class="col-sm-offset-2 col-sm-10 help-block">
                                            {{$errors->first('noUsersSelected')}}
                                        </span>
                                    @endif
                                    @if($errors->has('invalidGroup'))
                                        <span class="col-sm-offset-2 col-sm-10 help-block">
                                            {{$errors->first('invalidGroup')}}
                                        </span>
                                    @endif
                                    @if($errors->has('noRolesSelected'))
                                        <span class="col-sm-offset-2 col-sm-10 help-block">
                                            {{$errors->first('noRolesSelected')}}
                                        </span>
                                    @endif
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
    <script type="text/javascript">

        /*
        * Each value in users array is object. this object has following structure:
        * {
        *   userId: ___id_of_selected_user___,
        *   roles: ___array_of_selected_roles_for_selected_user___
        * }
        * */
        // var dataToSend = {
        //     users: {}
        // };
        var dataToSend = {};


        {{--function createGroup() {--}}
            {{--$.ajax({--}}
                {{--type:'POST',--}}
                {{--url:"{{action('GroupController@store')}}",--}}
                {{--data:{--}}
                    {{--"_token": "{{ csrf_token() }}",--}}
                    {{--data:dataToSend--}}
                {{--},--}}
                {{--done: function (response){--}}
                    {{--alert('you are in done');--}}
                {{--},--}}
                {{--fail : function (response) {--}}
                    {{--alert('you are in fail');--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}

    </script>
    <!-- /.content-wrapper -->
@endsection