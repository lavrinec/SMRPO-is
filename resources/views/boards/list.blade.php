@extends('default.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Table
                <small>Seznam tabel</small>
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
                            <h3 class="box-title">Ustvarjanje nove table</h3>
                        </div>
                        <!-- /.box-header -->
                            <div class="box-body">

                                <a href="{{ action('BoardController@create') }}" class="btn btn-primary btn-block">
                                    <b>Ustvari novo tablo</b>
                                </a>

                            </div>
                            <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    @endif

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Seznam tabel</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if ($errors->has('NoBoard'))
                                <span class="help-block">{{ $errors->first('NoBoard') }}</span>
                            @endif
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Status</th>
                                    @if(Auth::user()->isKM())
                                    <th>Uredi</th>
                                    <th>Izbriši</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($boards as $board)
                                    <tr>
                                        <td>
                                            {{--<a href="{{ action('BoardController@show', [$board->id]) }}">{{ $board->board_name }}</a>--}}
                                            <a href="{{ action('BoardController@focus', $board->id) }}">{{$board->board_name}}</a>
                                        </td>
                                        <td>{{ $board->description }}</td>

                                        <td>
                                            @if($board->deleted_at != null )
                                                Izbrisana
                                            @else
                                                Aktivna
                                            @endif
                                        </td>
                                        @if(Auth::user()->isKM())
                                        <td>
                                            {{-- check if board has cards in columns --}}
                                            {{-- if no, board can still be edited --}}
                                            {{-- if yes, board can not be edited  --}}
                                            @if($board->deleted_at == null )
                                                <a href="{{ action('BoardController@edit', [$board->id]) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                        @if($board->deleted_at == null )
                                                <a href="javascript:reallyDelete({{$board->id}})"><i class="fa fa-remove"></i></a>

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
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Ime</th>
                                    <th>Opis</th>
                                    <th>Status</th>
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
@endsection