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
                @include('users.detail')
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Podatki</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="example1" class="table table-bordered table-striped table-hover">


                                <tr>
                                    <td>Email</td>
                                    <td>{{ $users->email }}</td>
                                </tr>

                                <tr>
                                    <td>Ime</td>
                                    <td>{{ $users->first_name }}</td>
                                </tr>

                                <tr>
                                    <td>Priimek</td>
                                    <td>{{ $users->last_name }}</td>

                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>@if($users->deleted_at != null )
                                            Izbrisan
                                        @else
                                            Aktiven
                                        @endif
                                    </td>
                                </tr>

                            </table>


                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if($users->deleted_at == null )
                                        <a href="{{ action('UserController@edit', $users->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($users->deleted_at == null )
                                        <a href="javascript:reallyDelete()"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete() {
                                                var r = confirm("Ali ste prepričani, da želite izbrisati uporabnika?");
                                                if (r == true) {
                                                    window.location.href = "{{ action('UserController@destroy', $users->id) }}";
                                                }
                                            }
                                        </script>
                                    @endif

                                </div>
                            </div>


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