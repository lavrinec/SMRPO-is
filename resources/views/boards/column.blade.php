<div class="column" id="{{ $column['id'] }}">
    {{--level{{ $column['level'] }}--}}
    <div class="box">
        <pre style="width: 100%; text-align: center; line-height: 0.2em;">id: {{ substr($column['id'], 0, 6) }}
        </pre>

        <input type="hidden" id="{{ $column['id'] }}_parent_id"
               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][parent_id]"
               value="{{ $column['parent_id'] }}">

        <input type="text" id="{{ $column['id'] }}_parent_name"
               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][parent_name]"
               value="{{ $column['parent_name'] }}[{{ $column['id'] }}]">


        <input type="hidden" id="{{ $column['id'] }}_left_id"
               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][left_id]"
               value="{{ $column['left_id'] }}">

        {{--<input type="hidden" id="{{ $column['id'] }}_column_id" name="{{ $column['id'] }}_column_id" value="{{ $column['id'] }}">--}}
        <input type="hidden" id="{{ $column['id'] }}_column_id"
               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][id]"
               value="{{ $column['id'] }}">

        {{--<input type="hidden" id="{{ $column['id'] }}_level"--}}
               {{--name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][level]"--}}
               {{--value="{{ $column['level'] }}">--}}

        <div class="box-header">
            <h5 class="box-title">

                <div class="form-group">
                    <label for="{{ $column['id'] }}_column_name" class="col-sm-2 control-label">Ime</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="{{ $column['id'] }}_column_name"
                               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][column_name]"
                               placeholder="Ime"
                               pattern=".{1,255}" required
                               title="Ime naj bo dolgo med 8 in 255 znakov"
                               value="{{ isset($column['column_name']) ? $column['column_name'] : '' }}">
                    </div>
                </div>

            </h5>
        </div>

        <div class="box-body" style="border-top: solid black 1px;">
            <div class="content">

                <div class="form-group">
                    <label for="{{ $column['id'] }}_description" class="col-sm-3 control-label">Opis</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="{{ $column['id'] }}_description"
                               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][description]"
                               placeholder="Opis"
                               value="{{ isset($column['description']) ? $column['description'] : '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="{{ $column['id'] }}_wip" class="col-sm-3 control-label">WIP</label>

                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="{{ $column['id'] }}_wip"
                               name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][wip]"
                               required title="Vpišite omejitev WIP"
                               value="{{ isset($column['WIP']) ? $column['WIP'] : '' }}" min="0">
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Vloge</label>
                    <div class="col-sm-9">

                        <label for="{{ $column['id'] }}_start_border" class="control-sidebar-subheading">
                            <input id="{{ $column['id'] }}_start_border"
                                   name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][types][start_border]"
                                   value="start_border" type="checkbox" class="pull-left"
                                   onclick="checkChecked({{ $column['id'] }},'start_border')"
                                    {{ isset($start_border)&&$start_border==1 ? 'checked' : ''}}>
                            Začetni robni
                        </label>

                        <label for="{{ $column['id'] }}_end_border" class="control-sidebar-subheading">
                            <input id="{{ $column['id'] }}_end_border"
                                   name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][types][end_border]"
                                   value="end_border" type="checkbox" class="pull-left"
                                   onclick="checkChecked({{ $column['id'] }},'end_border')"
                                    {{ isset($end_border)&&$end_border==1 ? 'checked' : ''}}>
                            Končni robni
                        </label>

                        <label for="{{ $column['id'] }}_high_priority" class="control-sidebar-subheading">
                            <input id="{{ $column['id'] }}_high_priority"
                                   name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][types][high_priority]"
                                   value="high_priority" type="checkbox" class="pull-left"
                                   onclick="checkChecked({{ $column['id'] }},'high_priority')"
                                    {{ isset($high_priority)&&$high_priority==1 ? 'checked' : ''}}>
                            Za nujne kartice
                        </label>

                        <label for="{{ $column['id'] }}_acceptance_testing" class="control-sidebar-subheading">
                            <input id="{{ $column['id'] }}_acceptance_testing"
                                   name="column{{ $column['parent_name'] }}[{{ $column['id'] }}][types][acceptance_testing]"
                                   value="acceptance_testing" type="checkbox" class="pull-left"
                                   onclick="checkChecked({{ $column['id'] }},'acceptance_testing')"
                                    {{ isset($acceptance_testing)&&$acceptance_testing==1 ? 'checked' : ''}}>
                            Sprejemno testiranje
                        </label>

                    </div>
                </div>


                <div class="row">
                    <button type="button" class="btn btn-default col-sm-3"
                            onclick="addColumnBefore({{ $column['id'] }})">
                        <i class="fa fa-plus"></i>
                        <br>
                        <i class="fa fa-arrow-left"></i>
                    </button>


                    <button type="button" class="btn btn-danger col-sm-3"
                            onclick="deleteColumn({{ $column['id'] }})" {{ count($column['cards']) > 0 ? 'disabled' : '' }}>
                        <i class="fa fa-trash"></i>
                    </button>

                    <button id="{{ $column['id'] }}_addFirstSubcolumn" type="button" class="btn btn-default col-sm-3"
                            onclick="addFirstSubColumnTo({{ $column['id'] }})">
                        <i class="fa fa-arrow-down"></i>
                    </button>

                    <button type="button" class="btn btn-default col-sm-3"
                            onclick="addColumnAfter({{ $column['id'] }})">
                        <i class="fa fa-plus"></i>
                        <br>
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="canvas subcanvas row" id="{{ $column['id'] }}_subcanvas"
                 style="margin-left: 0px; margin-right: 0px">

                    @foreach($column['allChildrenCards'] as $child)

                        @include('boards.column', ['column' => $child])

                    @endforeach

            </div>
        </div>
    </div>
</div>