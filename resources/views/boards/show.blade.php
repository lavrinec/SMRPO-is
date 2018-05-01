@extends('default.layout')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tabla
            </h1>
        </section>
        @include('layout.error')
        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <div class="col-md-3">
                    @include('boards.detail')

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

                            <table class="table table-bordered table-striped table-hover">


                                <tr>
                                    <td>Ime</td>
                                    <td>{{ $board->board_name }}</td>
                                </tr>

                                <tr>
                                    <td>Opis</td>
                                    <td>{{ $board->description }}</td>
                                </tr>

                                <tr>
                                    <td>Dni pred obvestilom</td>
                                    <td>{{ isset($board->meta->notification) ? $board->meta->notification : '-' }}</td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>@if($board->deleted_at != null )
                                            Izbrisana
                                        @else
                                            Aktivna
                                        @endif
                                    </td>
                                </tr>

                            </table>

                            @if(Auth::user()->isKM() && $board->deleted_at==null)
                            <div class="row">
                                <div class="col-sm-4">
                                    {{-- @if() check if there are cards in columns --}}
                                        <a href="{{ action('BoardController@edit', $board->id) }}"
                                           class="btn btn-primary btn-block">
                                            <b>Uredi</b>
                                        </a>
                                    {{--@endif--}}
                                </div>

                                <div class="col-sm-offset-6 col-sm-2">
                                    @if($board->deleted_at == null )
                                        <a href="javascript:reallyDelete({{$board->id}})"
                                           class="btn btn-danger btn-block">
                                            <b>Izbriši</b>
                                        </a>

                                        <script>
                                            function reallyDelete(boardid) {
                                                console.log(boardid);
                                                var r = confirm("Ali ste prepričani, da želite izbrisati tablo?");
                                                        
                                                if (r == true) {
                                                        window.location.href = "/boards/" + boardid +"/delete";
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