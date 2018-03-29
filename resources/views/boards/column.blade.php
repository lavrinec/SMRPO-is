<div class="col-xs-3 column" id="{{ $column_id }}">
    <div class="box">
        <div class="box-header">
            <h5 class="box-title">

                <div class="form-group">
                    <label for="column_name" class="col-sm-2 control-label">Ime</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="column_name" name="column_name"
                               placeholder="Ime" pattern=".{1,255}" required
                               title="Ime naj bo dolgo med 8 in 255 znakov">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Opis</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="Opis" pattern=".{1,255}" required
                               title="Opis naj bo dolg med 1 in 255 znakov">
                    </div>
                </div>


            </h5>
        </div>

        <div class="box-body" style="border: solid black 1px;">
            <div class="">
                {{ $column_id }}
                
                <div class="form-group">
                    <label for="wip" class="col-sm-2 control-label">WIP</label>

                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="wip" name="wip">
                    </div>
                </div>


                <div class="form-group">
                    <label for="types" class="col-sm-3 control-label">Vloge</label>
                    <div class="col-sm-9">

                        <label for="start_border" class="control-sidebar-subheading">
                            <input id="start_border" name="types[]"
                                   value="start_border" type="checkbox"
                                   class="pull-left">
                            Začetni robni
                        </label>

                        <label for="end_border" class="control-sidebar-subheading">
                            <input id="end_border" name="types[]"
                                   value="end_border" type="checkbox"
                                   class="pull-left">
                            Končni robni
                        </label>

                        <label for="high_priority" class="control-sidebar-subheading">
                            <input id="high_priority" name="types[]"
                                   value="high_priority" type="checkbox"
                                   class="pull-left">
                            Za nujne kartice
                        </label>

                        <label for="acceptance_testing" class="control-sidebar-subheading">
                            <input id="acceptance_testing" name="types[]"
                                   value="acceptance_testing" type="checkbox"
                                   class="pull-left">
                            Sprejemno testiranje
                        </label>


                    </div>
                </div>
            </div>

            <div class="container">



                <button type="button" class="btn btn-default" onclick="addSubColumnTo({{ $column_id }})" style="float: left;">
                    Dodaj podstolpec
                </button>
                <br>
                <br>
                <button type="button" class="btn btn-danger" onclick="deleteColumn({{ $column_id }})" style="float: left;">
                    Izbriši stolpec
                </button>
            </div>

            <div class="row text-center" id="sub_{{ $column_id }}">

            </div>
        </div>
    </div>
</div>