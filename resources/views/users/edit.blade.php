@extends('default.layout')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Uporabniški račun
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <div class="col-md-3">
                    @include('users.detail')

                    {{--here my be included some other part --}}
                </div>
                <!-- /.col -->

                {{-- right wide column --}}
                <div class="col-md-9">

                    {{-- div for user data form --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Urejanje podatkov</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" method="POST"
                                  action="{{ action('UserController@update', $users->id) }}">

                                @csrf

                                <div class="form-group">
                                    <label for="first_name" class="col-sm-2 control-label">Ime</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                               value="{{ $users->first_name }}" required>
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="last_name" class="col-sm-2 control-label">Priimek</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               value="{{ $users->last_name }}" required>
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{ $users->email }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                @include('users.roles')

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <button type="submit" class="btn btn-primary">Posodobi podatke</button>
                                    </div>
                                    <div class="col-sm-offset-4 col-sm-2">
                                        <a href="{{ action('UserController@show', $users->id) }}"
                                           class="btn btn-danger btn-block"><b>Prekliči</b></a>
                                    </div>
                                </div>
                            </form>


                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    {{-- div for password form --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Spreminjanje gesla</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal" method="POST"
                                  action="{{ action('UserController@passwordUpdate', $users->id) }}">

                                @csrf
                                @if(!Auth::user()->isAdmin())
                                <div class="form-group">
                                    <label for="old_password" class="col-sm-2 control-label">Trenutno geslo</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="old_password"
                                               name="old_password" placeholder="Geslo" pattern=".{8,255}" required
                                               title="Geslo naj bo dolgo med 8 in 255 znakov">
                                        @if ($errors->has('old_password'))
                                            <span class="help-block">{{ $errors->first('old_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Novo geslo</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="Geslo" pattern=".{8,255}" required
                                               title="Geslo naj bo dolgo med 8 in 255 znakov">
                                        @if ($errors->has('password'))
                                            <span class="help-block">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="col-sm-2 control-label">Ponovite novo
                                        geslo </label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation" placeholder="Geslo" pattern=".{8,255}"
                                               required title="Geslo naj bo dolgo med 8 in 255 znakov">
                                        @if ($errors->has('password'))
                                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <button type="submit" class="btn btn-primary">Posodobi geslo</button>

                                    </div>
                                    <div class="col-sm-offset-4 col-sm-2">
                                        <a href="{{ action('UserController@show', $users->id) }}"
                                           class="btn btn-danger btn-block"><b>Prekliči</b></a>
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