@extends('default.layout')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Projekt
            </h1>
        </section>

        @include('layout.error')

        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <!-- <div class="col-md-3">
                   

                    {{--here my be included some other part --}}
                </div> -->

                <!-- /.col -->

                {{-- right wide column --}}
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Podatki</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="example1" class="table table-bordered table-striped table-hover">


                                <tr>
                                    <td>Ime projekta</td>
                                    <td>{{ $projects->board_name }}</td>
                                </tr>

                                <tr>
                                    <td>Opis projekta</td>
                                    <td>{{ $projects->description }}</td>
                                </tr>

                                <tr>
                                    <td>Naročnik projekta</td>
                                    <td>{{ $projects->buyer_name }}</td>

                                </tr>

                                <tr>
                                    <td>Datum začetka</td>
                                    
                                    <td>{{ date("d-m-Y", strtotime($projects->start_date)) }}</td>

                                </tr>

                                <tr>
                                    <td>Datum zaključka</td>
                                    <td>{{ date("d-m-Y", strtotime($projects->end_date)) }}</td>

                                </tr>

                                <tr>
                                    <td>Skupina</td>
                                    <td>{{ $group->group_name }}</td>

                                </tr>
                                

                            </table>

                         @if(Auth::user()->isKM())
                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if($projects->deleted_at == null )
                                        <a href="{{ action('ProjectController@edit', $projects->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($projects->deleted_at == null )
                                        <a href="javascript:reallyDelete()"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete() {
                                                var r = confirm("Ali ste prepričani, da želite izbrisati projekt?");
                                                if (r == true) {
                                                    window.location.href = "{{ action('ProjectController@destroy', $projects->id) }}";
                                                }
                                            }
                                        </script>
                                    @endif

                                </div>
                            </div>
                        @endif


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