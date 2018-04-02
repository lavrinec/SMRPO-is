<div class="column level{{ $level }}" id="{{ $column_id }}">
    <div class="box">
        <pre style="width: 100%; text-align: center; line-height: 0.2em;">začasni id: {{ substr($column_id, 0, 6) }}
        </pre>
        <input type="hidden" id="{{ $column_id }}_parent_id" name="column[{{ $column_id }}][parent_id]" value="{{ $parent_id }}">
        <input type="hidden" id="{{ $column_id }}_left_id" name="column[{{ $column_id }}][left_id]" value="{{ $left_id }}">

        {{--<input type="hidden" id="{{ $column_id }}_column_id" name="{{ $column_id }}_column_id" value="{{ $column_id }}">--}}
        <input type="hidden" id="{{ $column_id }}_column_id" name="column[{{ $column_id }}][id]" value="{{ $column_id }}">

        <input type="hidden" id="{{ $column_id }}_level" name="column[{{ $column_id }}][level]" value="{{ $level }}">

        <div class="box-header">
            <h5 class="box-title">

                <div class="form-group">
                    <label for="{{ $column_id }}_column_name" class="col-sm-2 control-label">Ime</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="{{ $column_id }}_column_name"
                               name="column[{{ $column_id }}][column_name]" placeholder="Ime" pattern=".{1,255}" required
                               title="Ime naj bo dolgo med 8 in 255 znakov">
                    </div>
                </div>

            </h5>
        </div>

        <div class="box-body" style="border-top: solid black 1px;">
            <div class="content">

                <div class="form-group">
                    <label for="{{ $column_id }}_description" class="col-sm-3 control-label">Opis</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="{{ $column_id }}_description"
                               name="column[{{ $column_id }}][description]" placeholder="Opis" pattern=".{1,255}" required
                               title="Opis naj bo dolg med 1 in 255 znakov">
                    </div>
                </div>

                <div class="form-group">
                    <label for="{{ $column_id }}_wip" class="col-sm-3 control-label">WIP</label>

                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="{{ $column_id }}_wip" name="column[{{ $column_id }}][wip]"
                               required title="Vpišite omejitev WIP">
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Vloge</label>
                    <div class="col-sm-9">

                        <label for="{{ $column_id }}_start_border" class="control-sidebar-subheading">
                            <input id="{{ $column_id }}_start_border" name="column[{{ $column_id }}][types][start_border]"
                                   value="start_border" type="checkbox" class="pull-left">
                            Začetni robni
                        </label>

                        <label for="{{ $column_id }}_end_border" class="control-sidebar-subheading">
                            <input id="{{ $column_id }}_end_border" name="column[{{ $column_id }}][types][end_border]"
                                   value="end_border" type="checkbox" class="pull-left">
                            Končni robni
                        </label>

                        <label for="{{ $column_id }}_high_priority" class="control-sidebar-subheading">
                            <input id="{{ $column_id }}_high_priority" name="column[{{ $column_id }}][types][high_priority]"
                                   value="high_priority" type="checkbox" class="pull-left">
                            Za nujne kartice
                        </label>

                        <label for="{{ $column_id }}_acceptance_testing" class="control-sidebar-subheading">
                            <input id="{{ $column_id }}_acceptance_testing" name="column[{{ $column_id }}][types][acceptance_testing]"
                                   value="acceptance_testing" type="checkbox" class="pull-left">
                            Sprejemno testiranje
                        </label>

                    </div>
                </div>


                <div class="row">
                    <button type="button" class="btn btn-default col-sm-3" onclick="addColumnBefore({{ $column_id }})">
                        <i class="fa fa-plus"></i>
                        <br>
                        <i class="fa fa-arrow-left"></i>
                    </button>

                    <button type="button" class="btn btn-danger col-sm-3" onclick="deleteColumn({{ $column_id }})">
                        <i class="fa fa-trash"></i>
                    </button>

                    <button id="{{ $column_id }}_addFirstSubcolumn" type="button" class="btn btn-default col-sm-3"
                            onclick="addFirstSubColumnTo({{ $column_id }})">
                        <i class="fa fa-arrow-down"></i>
                    </button>

                    <button type="button" class="btn btn-default col-sm-3" onclick="addColumnAfter({{ $column_id }})">
                        <i class="fa fa-plus"></i>
                        <br>
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="canvas subcanvas row" id="{{ $column_id }}_subcanvas"
                 style="margin-left: 0px; margin-right: 0px">

            </div>
        </div>
    </div>
</div>