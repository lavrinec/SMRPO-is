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

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-md-12">

                    {{-- div for data form --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Urejanje table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" method="POST"
                                  action="{{ action('BoardController@update', $board->id) }}">

                                @csrf

                                <div class="form-group">
                                    <label for="board_name" class="col-sm-1 control-label">Ime</label>

                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="board_name" name="board_name"
                                               value="{{ $board->board_name }}" required>
                                        @if ($errors->has('board_name'))
                                            <span class="help-block">{{ $errors->first('board_name') }}</span>
                                        @endif
                                    </div>

                                    <label for="board_name" class="col-sm-1 control-label">Opis</label>

                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="description" name="description"
                                               value="{{ $board->description }}" required>
                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-offset-3 col-sm-3">
                                        <button type="submit" class="btn btn-primary">Shrani tablo</button>

                                        <a href="{{ action('BoardController@show', $board->id) }}"
                                           class="btn btn-danger">Prekliči</a>
                                    </div>
                                </div>
                            </form>

                            <style>
                                /* The heart of the matter */
                                .testimonial-group > .row {
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }

                                .testimonial-group > .row > .col-xs-4 {
                                    display: inline-block;
                                    float: none;
                                }

                                /* Decorations */
                                .col-xs-4 {
                                    color: #fff;
                                    font-size: 48px;
                                    padding-bottom: 20px;
                                    padding-top: 18px;
                                }

                                .col-xs-4:nth-child(3n+1) {
                                    background: #c69;
                                }

                                .col-xs-4:nth-child(3n+2) {
                                    background: #9c6;
                                }

                                .col-xs-4:nth-child(3n+3) {
                                    background: #69c;
                                }


                            </style>


                            <div class="box container testimonial-group">
                                <div class="row text-center">
                                    <div class="col-xs-4">1</div>
                                    <div class="col-xs-4">2</div>
                                    <div class="col-xs-4">3</div>
                                    <div class="col-xs-4">4</div>
                                    <div class="col-xs-4">5</div>
                                    <div class="col-xs-4">6</div>
                                    <div class="col-xs-4">7</div>
                                    <div class="col-xs-4">8</div>
                                    <div class="col-xs-4">9</div>
                                </div>
                            </div>


                            <!-- Dragula JS for boards -->
                            <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.js'></script>

                            <div class="box container">

                                <div class="row" style="float:left;">
                                    <div class="col-sm-12">stolpec 1</div>

                                    <div id="column1" class="container col-sm-12"
                                         style="border: solid black 1px; width: 150px; height: 200px; float: left;">
                                        <div style="background: lightblue;">test1</div>
                                        <div style="background: lightgreen;">test2</div>
                                        <div style="background: lightgrey;">test3</div>

                                    </div>
                                </div>


                                <div class="row" style="float:left;">
                                    <div class="col-sm-12">stolpec 2</div>
                                    <div id="column2" class="container col-sm-12"
                                         style="border: solid black 1px; width: 150px; height: 200px; float: left;">


                                        <div class="row" style="float:left; width: 80px;">
                                            <div class="col-sm-12">st 2_1</div>
                                            <div id="column21" class="container col-sm-12"
                                                 style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                            </div>
                                        </div>

                                        <div class="row" style="float:left; width: 70px;">
                                            <div class="col-sm-12">st 2_2</div>
                                            <div id="column22" class="container col-sm-12"
                                                 style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row" style="float:left;">
                                    <div class="col-sm-12">stolpec 3</div>

                                    <div id="column3" class="container col-sm-12"
                                         style="border: solid black 1px; width: 150px; height: 200px; float: left;">

                                    </div>
                                </div>


                                <div class="row" style="float:left;">
                                    <div class="col-sm-12">stolpec 4</div>
                                    <div id="column4" class="container col-sm-12"
                                         style="border: solid black 1px; width: 150px; height: 200px; float: left;">


                                        <div class="row" style="float:left; width: 80px;">
                                            <div class="col-sm-12">st 4_1</div>
                                            <div id="column41" class="container col-sm-12"
                                                 style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                            </div>
                                        </div>

                                        <div class="row" style="float:left; width: 70px;">
                                            <div class="col-sm-12">st 4_2</div>
                                            <div id="column42" class="container col-sm-12"
                                                 style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row" style="float:left;">
                                    <div class="col-sm-12">stolpec 5</div>

                                    <div id="column5" class="container col-sm-12"
                                         style="border: solid black 1px; width: 150px; height: 200px; float: left;">

                                    </div>
                                </div>


                                <div class="row" style="float:left;">
                                    <div class="col-sm-12">stolpec 6</div>
                                    <div id="column6" class="container col-sm-12"
                                         style="border: solid black 1px; width: 150px; height: 200px; float: left;">


                                        <div class="row" style="float:left; width: 80px;">
                                            <div class="col-sm-12">st 6_1</div>
                                            <div id="column61" class="container col-sm-12"
                                                 style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                            </div>
                                        </div>

                                        <div class="row" style="float:left; width: 70px;">
                                            <div class="col-sm-12">st 6_2</div>
                                            <div id="column62" class="container col-sm-12"
                                                 style="border: solid deeppink 1px; width: 50px; height: 180px; float: left;">

                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>


                            <script>
                                dragula([
                                    document.querySelector('#column1'),
//                                    document.querySelector('#column2'),
                                    document.querySelector('#column21'),
                                    document.querySelector('#column22'),

                                    document.querySelector('#column3'),
//                                    document.querySelector('#column4'),
                                    document.querySelector('#column41'),
                                    document.querySelector('#column42'),

                                    document.querySelector('#column5'),
//                                    document.querySelector('#column6'),
                                    document.querySelector('#column61'),
                                    document.querySelector('#column62'),

                                ]);
                            </script>


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