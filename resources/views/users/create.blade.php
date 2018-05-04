@extends('default.layout')

@section('content')


    <script>
        documentationContent = [
            {
                title:"Podatki uporabnika",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Vnos podatkov je precej standarden. Podati morate <b>ime</b> uporabnika, <b>priimek</b> uporabnika, " +
                "<b>email naslov</b> uporabnika (ki služi kot uporabniško ime za dostop v sistem), geslo s katerim se " +
                "poleg uporabniškega imena(email naslova) uporabnik lahko prijavi v sistem in izbrati morate vlogo za posameznega uporabnika.</p>" +
                "<p>Geslo mora vsebovati vsaj 6 znakov,črk ali števil. Email naslov pa mora biti prave strukture: <b>_nekoime_@_domena_._zakljucek_</b>. V kolikor " +
                "boste vnesli email naslov, ki že pripada nekemu uporabniku, vam sistem ne bo pustil ustvariti uporabnika z navedenim email naslovom. Vsak uporabnik " +
                "mora imeti unikaten email naslov.</p>" +
                "<p>Ko vnesete vse podatke lahko uporabnika ustvarite s klikom na gumb <b>Ustvari</b>." +
                "</div>",
                currentStep : 1,
                allSteps: 2
            },
            {
                title:"Vloge uporabnika",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/users/editUserIntro.png' style='height:90px;width:180px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Na tem mestu lahko določite vloge, za katere naj bi bil uporabnik kompetenten po <b>Scrumban</b> metodologiji. Te vloge niso ekvivalentne vlogam, ki jih " +
                "boste morali posebej izbirati pri ustvarjanju skupin. Te vloge morate izbrati skladno s kvalifikacijami posameznega uporabnika za posamezno vlogo. V kolikor " +
                "je uporabnik usposobljen za vse vloge potem mu lahko določite vse vloge. Če pa uporabniku ne izberete nobene vloge potem ne boste uspeli dodati " +
                "uporabnika k nobeni skupini." +
                "</p>" +
                "<p>Vloge, ki jih je mogoče izbrati ponazarja zgornja slika.</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 2
            }

        ];
    </script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-11">
                    <h3>
                        Uporabniški račun
                    </h3>
                </div>
                <div class="col-sm-1">
                    <h2><span onclick="openModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
                </div>
            </div>
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
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                               placeholder="Ime" pattern=".{1,255}" required
                                               title="Ime naj bo dolgo med 8 in 255 znakov">
                                        @if ($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="last_name" class="col-sm-2 control-label">Priimek</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               placeholder="Priimek" pattern=".{1,255}" required
                                               title="Priimek naj bo dolg med 1 in 255 znakov">
                                        @if ($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="Email" required title="Vnesi email v pravilni obliki">
                                        @if ($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Geslo</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="Geslo" pattern=".{8,255}" required
                                               title="Geslo naj bo dolgo med 8 in 255 znakov">
                                        @if ($errors->has('password'))
                                            <span class="help-block">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Password Confirmation --}}
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Ponovite geslo</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation" placeholder="Geslo" pattern=".{8,255}"
                                               required title="Geslo naj bo dolgo med 8 in 255 znakov">
                                        @if ($errors->has('password'))
                                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>

                                @include('users.roles')


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-4">
                                        <button type="submit" class="btn btn-primary">Ustvari</button>
                                    </div>
                                    <div class="col-sm-offset-4 col-sm-2">
                                        <a href="{{ action('UserController@index') }}" class="btn btn-danger btn-block"><b>Prekliči</b></a>
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