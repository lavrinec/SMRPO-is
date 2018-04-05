<form id="updateCard" method="POST" action="{{ action('CardController@update', isset($card) ? $card->id : 0) }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kartica
            @if(isset($card))
                <small class="pull-right" style="margin-top: 2px;">ID: {{ $card->id }}, Št. v stolpcu: {{ $card->order }}&nbsp;&nbsp;&nbsp;</small>
            @endif
        </h4>
    </div>
    <div class="modal-body">
        @if(isset($card))
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#editing">Urejanje</a></li>
                <li><a data-toggle="tab" href="#moves">Premiki</a></li>
                <li><a data-toggle="tab" href="#wip">Kršitve WIP</a></li>
            </ul>
            <br>
        @endif
        <div class="tab-content">
            <div id="editing" class="tab-pane fade in active">
                <input type="hidden" class="form-control" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="form-control" id="column_id" name="column_id" value="{{ $column->id }}">
                <!--<input type="hidden" class="form-control" id="id" value="{{ isset($card) ? $card->id : '0' }}">-->
                <div class="form-group">
                    <label for="card_name" class="col-form-label">Ime naloge:</label>
                    <input type="text" class="form-control" id="card_name" name="card_name" value="{{ isset($card) ? $card->card_name : '' }}" required>
                </div>
                <div class="form-group">
                    <label for="description" class="col-form-label">Opis:</label>
                    <textarea class="form-control" id="description" name="description">{{ isset($card) ? $card->description : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="user_id" class="col-form-label">Projekt:</label>
                    <select class="form-control select2" id="project_id" name="project_id">
                        @foreach($projects as $project)
                            <option value="{{$project->id}}" {{ isset($card) && $project->id == $card->project_id ? 'selected' : ''}} {{ $project->deactivated ? 'disabled' : ''}}>{{$project->board_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id" class="col-form-label">Lastnik:</label>
                    <select class="form-control select2" id="user_id" name="user_id">
                        <option value="0"></option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{ isset($card) && $user->id == $card->user_id ? 'selected' : ''}} {{ $user->deactivated ? 'disabled' : ''}}>{{$user->first_name}} {{$user->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline" class="col-form-label">Rok:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline"  value="{{ isset($card) ? $card->deadline : '' }}">
                </div>
                <div class="form-group">
                    <label for="color" class="col-form-label">Barva:</label>
                    <input type="color" class="form-control" id="color" name="color"  value="{{ isset($card) ? $card->color : '#6fdede' }}">
                </div>
                <div class="form-group">
                    <label for="estimation" class="col-form-label">Ocena časa:</label>
                    <input type="number" class="form-control" id="estimation" name="estimation"  value="{{ isset($card) ? $card->estimation : '' }}">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="is_critical" {{ isset($card) && $card->is_critical ? 'checked' : '' }} {{ Auth::user()->isPo() ? '' : 'disabled' }}>Kritičen</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="is_rejected" {{ isset($card) && $card->is_rejected ? 'checked' : '' }}>Zavrnjen</label>
                </div>
                <!--<input type="submit" style="display: none;">-->
            </div>
            @if(isset($card))
                <div id="moves" class="tab-pane fade">
                    @if(count($moves) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Iz stolpca</th>
                                    <th scope="col">V stolpec</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moves as $move)
                                    <tr>
                                        <td>{{ $move->id }}</th>
                                        <td>{{ $move->old_column->column_name }} (#{{ $move->old_column->id }})</td>
                                        <td>{{ $move->new_column->column_name }} (#{{ $move->new_column->id }})</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        Ni premikov!
                    @endif
                </div>
                <div id="wip" class="tab-pane fade">
                    @if(count($WipViolations) > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Razlog</th>
                                <th scope="col">Iz stolpca</th>
                                <th scope="col">V stolpec</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($WipViolations as $violation)
                                <tr>
                                    <td>{{ $violation->id }}</th>
                                    <td>{{ $violation->reason }}</td>
                                    <td>{{ $violation->old_column->column_name }} (#{{ $violation->old_column->id }})</td>
                                    <td>{{ $violation->new_column->column_name }} (#{{ $violation->new_column->id }})</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        Ni WIP kršitev!
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Zapri</button>
        <button type="submit" class="btn btn-success" id="saveCard">Shrani</button>
    </div>
</form>
<script>
    var $disabledResults = $(".select2");
    $disabledResults.select2();
</script>