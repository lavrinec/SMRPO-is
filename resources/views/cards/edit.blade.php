@php
    $authUser = Auth::user();
    $canEdit = true;
    //dd($card);
    if(isset($card)){
        //dd($card);
        $card->move_reason_id = null;
        $canEdit = $authUser->canEditCard($card);
    }

@endphp
<form @if($canEdit) id="updateCard" method="POST" action="{{ action('CardController@update', isset($card) ? $card->id : 0) }}" @endif>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kartica
            @if(isset($card))
                <small class="pull-right" style="margin-top: 2px;">ID: <b>{{ $card->id }}</b>, Stolpec: <b>{{ $column->column_name }}</b>, Zaporedna št.: <b>{{ $card->order }}</b> &nbsp;&nbsp;</small>
            @endif
        </h4>
    </div>
    <div class="modal-body">
        @if(isset($card))
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#editing">Urejanje</a></li>
                <li><a data-toggle="tab" href="#tasks">Naloge</a></li>
                <li><a data-toggle="tab" href="#moves">Premiki</a></li>
                <li><a data-toggle="tab" href="#wip">Kršitve WIP</a></li>
                <li {!! $authUser->canDeleteCard($card) ? '' : 'style="display:none;"' !!}
                ><a data-toggle="tab" href="#delete">Izbris</a></li>
            </ul>
            <br>
        @endif
        <div class="tab-content">
            <div id="editing" class="tab-pane fade in active">
                <input type="hidden" class="form-control" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="form-control" id="column_id" name="column_id" value="{{ $column->id }}">
                <!--<input type="hidden" class="form-control" id="id" value="{{ isset($card) ? $card->id : '0' }}">-->
                <div class="form-group">
                    <label for="card_name" class="col-form-label">Ime kartice:</label>
                    <input type="text" class="form-control" id="card_name" name="card_name" value="{{ isset($card) ? $card->card_name : '' }}" required>
                </div>
                <div class="form-group">
                    <label for="description" class="col-form-label">Opis:</label>
                    <textarea class="form-control" id="description" name="description">{{ isset($card) ? $card->description : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="user_id" class="col-form-label">Projekt:</label>
                    <select class="form-control select2" id="project_id" name="project_id" required>
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
                <div class="checkbox hidden">
                    <label><input type="checkbox" name="is_critical" {{ ((isset($highPriotiry) && $highPriotiry) || (isset($card) && $card->is_critical)) ? 'checked' : '' }}>Kritičen</label>
                </div>
                <div class="checkbox hidden">
                    <label><input type="checkbox" name="is_rejected" {{ isset($card) && $card->is_rejected ? 'checked' : '' }}>Zavrnjen</label>
                </div>
                <!--<input type="submit" style="display: none;">-->
            </div>
            @if(isset($card))
                <div id="tasks" class="tab-pane fade">
                    <div class="collapse" id="collapseEditingTask">
                        <div class="card card-body">
                            <div class="row" data-id="0">
                                <div class="col-sm-5">
                                    <p><input class="form-control" type="text" placeholder="Ime naloge"></p>
                                    <p><input class="form-control" type="number" placeholder="Ocena časa"></p>
                                    <p>
                                        <select class="form-control select2">
                                            <option value="0">Nosilec</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}" {{ isset($card) && $user->id == $card->user_id ? 'selected' : ''}} {{ $user->deactivated ? 'disabled' : ''}}>{{$user->first_name}} {{$user->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                </div>
                                <div class="col-sm-7">
                                    <textarea class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>
                        <button class="btn btn-primary" type="button" id="collapser"> + </button>
                    </p>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Potrditev</th>
                            <th scope="col">Ime naloge</th>
                            <th scope="col">Opis naloge</th>
                            <th scope="col">Nosilec</th>
                            <th scope="col">Ocena časa</th>
                            <th scope="col">Uredi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($card->tasks as $task)
                            @include('tasks.td')
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
                                        <td  style="min-width: 75px;">{{ $move->id }}</th>
                                        <td>
                                            @if(isset($move->old_column))
                                                {{ $move->old_column->column_name }} (#{{ $move->old_column->id }})
                                            @endif
                                        </td>
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
                        <table class="table table-bordered" id="tasks">
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
                                    <td style="min-width: 75px;">{{ $violation->id }}</th>
                                    <td>{{ $violation->reason }}</td>
                                    <td style="min-width: 150px;">{{ $violation->old_column->column_name }} (#{{ $violation->old_column->id }})</td>
                                    <td style="min-width: 150px;">{{ $violation->new_column->column_name }} (#{{ $violation->new_column->id }})</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        Ni WIP kršitev!
                    @endif
                </div>
                <div id="delete" class="tab-pane fade">
                    <div class="form-group">
                        <label for="description" class="col-form-label">Razlog izbrisa:</label>
                        <textarea class="form-control" id="deletingReason" name="deletingReason"></textarea>
                    </div>
                    <div class="fa fa-spinner fa-spin" id="spinner"></div>
                    <a href="#" class="btn btn-warning" id="deleteCard">Izbriši</a>
                </div>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Zapri</button>
        @if($canEdit)
            <button type="submit" class="btn btn-success" id="saveCard">Shrani</button>
        @endif
    </div>
</form>
<script>
    var $disabledResults = $(".select2");
    var tasks = 0;
    var collapsed = true;
    $disabledResults.select2({ width: "100%" });
    @if(isset($card))
    @include('tasks.update')

    function openEditing(name, estimation, descrition) {
        var elem = $('#collapseEditingTask');
        $('#collapser').text("Shrani");
        elem.show("slow");
        collapsed = false;
        var input = elem.find('input');
        input.first().val(name);
        input.eq(1).val(estimation);
        elem.find('textarea').val(descrition);
    }
    $( document ).ready(function() {
        function editFunction(e) {
            var target = $( e.target );
            var parent = target.closest('tr');
            var td = parent.find('td');
            tasks = parent.data('taskId');
            openEditing(td.eq(1).text(),td.eq(3).text(),td.eq(2).text());
            //console.log(tasks, parent);
        }
        $(".editTask").click(editFunction);

        $("#collapser").click(function (e) {
            var elem = $('#collapseEditingTask');
            if(collapsed){
                openEditing("","","");
                tasks = 0;
            } else {
                var target = $( e.target );
                var input = elem.find('input'),
                    name = input.first().val(),
                    estimation = input.eq(1).val(),
                    user = elem.find('select').val(),
                    description = elem.find('textarea').val();
                if(name.length < 1){
                    alert("Ime ne sme biti prazno!");
                    return;
                }
                $.post("/tasks/edit",
                    {
                        "_token": "{{ csrf_token() }}",
                        id: tasks,
                        task_name: name,
                        user_id: user,
                        card_id: {{ $card->id }},
                        estimation: estimation,
                        description: description
                    },
                    function(data, status){
                        elem.hide("slow");
                        collapsed = true;
                        target.text("+");
                        var table = $("#tasks");
                        if(tasks === 0){
                            table.find("tbody").append(data.taskHtml);
                            tasks = data.task.id;
                        } else {
                            table.find('[data-task-id="' + tasks + '"]').replaceWith( data.taskHtml );
                        }
                        table.find('[data-task-id="' + tasks + '"] .editTask').click(editFunction);
                        tasks = 0;
                    });
            }
        });

        $("#spinner").hide();
        $("#deleteCard").click(function(e){
            console.log("delete clicked");
            e.preventDefault();
            var text = $('textarea#deletingReason').val();
            if(text.length < 2){
                alert("Za izbris morate navesti razlog!");
            } else {
                $("#spinner").show();
                $("#deleteCard").hide();
                $.ajax({
                    type: 'POST',
                    url: "{{ action('CardController@destroy', $card->id) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "deletingReason": text
                    },
                    success: function () {
                        console.log("uspesno izbrisana");
                        $('#cardModal').modal('hide');
                        $( document ).find("[data-card-id='{{ $card->id }}']").remove();

                    }

                });
            }
        });
    });
    @endif
</script>