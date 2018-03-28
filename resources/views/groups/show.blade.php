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

                {{-- left narrow column --}}
                <div class="col-md-3">
                    @include('groups.detail')

                    {{--here my be included some other part --}}
                </div>
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
                                    <td>Ime</td>
                                    <td>{{ $groups->group_name }}</td>
                                </tr>


                                <tr>
                                    <td>Status</td>
                                    <td>@if($groups->deleted_at != null )
                                            Izbrisana
                                        @else
                                            Aktivna
                                        @endif
                                    </td>
                                </tr>

                            </table>


                            <div class="row">
                                <div class="col-sm-offset-0 col-sm-4">
                                    @if($groups->deleted_at == null )
                                        <a href="{{ action('GroupController@edit', $groups->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($groups->deleted_at == null )
                                        <a href="javascript:reallyDelete()"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete() {
                                                var r = confirm("Ali ste prepričani, da želite izbrisati skupino?");
                                                if (r == true) {
                                                    window.location.href = "{{ action('GroupController@destroy', $groups->id) }}";
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