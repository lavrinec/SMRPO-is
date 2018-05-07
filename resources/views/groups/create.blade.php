@extends('default.layout')

@section('content')
    <script>
        documentationContent = [
            {
                title:"Podatki skupine",
                body: "<div class='col-sm-12'>" +
                "<p>" +
                "Vnos podatkov je precej standarden. Podati morate <b>ime</b> skupine, <b>opis</b> skupine, " +
                "izbrati <b>uporabnika</b> (kako ga izbrati boste izvedeli več v naslednjih korakih) " +
                "in izbrati vloge za posameznega uporabnika.poleg uporabniškega imena(email naslova) uporabnik lahko prijavi v sistem in izbrati morate vlogo za posameznega uporabnika.</p>" +
                "<p>Ko vnesete vse podatke boste skupino ustvarili tako, da kliknete na gumb <b>Ustvari</b>.</p>"+
                "</div>",
                currentStep : 1,
                allSteps: 3
            },
            {
                title:"Izbira uporabnika",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='full-row' src='/img/documentation/groups/selectUserSuggestions.png' style='height:100px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>Za izbiro uporabnika uporabite polje <b>Uporabnik:</b>. V tem polju lahko iščete uporabnika preko njegove imena ali priimka. " +
                "Med pisanjem se vam bo prikazalo okno s predlogi. To okno s predlogi prikazuje zgornja slika.</p>" +
                "<p>Ko dobite v oknu s predlogi ustreznega uporabnika, lahko kliknete na vrstico z njegovim imenom in priimkom. Nato se vam mora " +
                "polje <b>Uporabnik:</b> zapolniti z imenom in priimkom izbranega uporabnika kot to prikazuje spodnja slika." +
                "</p>" +
                "</div>" +
                "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/groups/selectUser.png' style='width:250px;height:40px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>"+
                "<p>Ob kliku na predlaganega uporabnika se vam bo uporabnik (ime in priimek) dodal v polje <b>Uporabnik:</b> a hkati se bo ustvarila nov kartica z vlogami. Več o tem " +
                "boste lahko izvedeli na naslednjem koraku.</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 3
            },
            {
                title:"Izbira vlog",
                body: "<div class='col-sm-12 align-text-center'>" +
                "<img class='' src='/img/documentation/groups/rolesToSelect.png' style='height:140px;width:180px;' /> " +
                "</div>" +
                "<div class='col-sm-12'>" +
                "<p>V kolikor hočete izbrati vloge za uporabnika ga morate prvo izbrati v polju <b>Uporabnik:</b>, kot smo to " +
                "opisali v prejšnjem koraku. Ko izbere uporabnika iz okna s predlogi se bo pojavila nova kartica, ki jo lahko " +
                "vidite na zgornji sliki. Katere vloge se vam bodo prikazale je odvisno od tega katere vloge ima dodeljen uporabnik v svojih " +
                "nastavitvah." +
                "</p>" +
                "<p><b>OPOZORILO:</b>Pri izbiri uporabnikov in vlog morate paziti, da imate določenega le enega <b>Product owner-ja</b> in enega <b>Kanban master-ja</b> v skupini. " +
                "Prav tako morate paziti, da ne določite enemu uporabniku tako vloge <b>Kanban master-ja</b> kot vlogo <b>Product owner-ja</b>. Če to storite vam aplikacija ne bo " +
                "dovolila ustvariti skupine, kajti taka izbira krši pravila Scrumban-a!</p>" +
                "</div>",
                currentStep : 2,
                allSteps: 3
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
                        Račun skupine
                    </h3>
                </div>
                <div class="col-sm-1">
                    {{--color:rgb(67,120,45)--}}
                    <h2><span onclick="openDocumentationModal()" style="color:#3c8dbc;cursor: pointer;" class="glyphicon glyphicon-question-sign"></span></h2>
                </div>
            </div>
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