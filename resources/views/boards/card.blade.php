<div class="box grabbable" style="border: 2px solid {{ $card->color }};" ondblclick="openCard({{ $card->id }})"
     data-card-id="{{ $card->id }}" title="Dvokliknite za urejanje kartice">
    <div class="box-header" style="background-color: {{ $card->color }};">
        <div class="row">

            <div class="col-sm-10">

                <h5 class="box-title" style="white-space: normal;">
                    <small><small>{{ $card->order }}</small></small>
                    {{ $card->card_name }}

                </h5>
                <br>
                <small>pooblaščeni:
                    @if($card->user)
                        {{ $card->user["first_name"] }} {{ $card->user["last_name"] }}
                    @else
                        -
                    @endif
                </small>
                <br>
                <small>Projekt: {{ $card->project["board_name"] }}</small>

            </div>

            <div class="col-sm-2">
                @if(isset($card->is_silver_bullet) && ($card->is_silver_bullet == 1 || $card->is_silver_bullet == "true"))
                    <i class="fa fa-asterisk" title="nujna kartica"></i>
                    <br>
                @endif

                @if(isset($card->is_critical) && ($card->is_critical == 1 || $card->is_critical == "true"))
                    <i class="fa fa-bell" title="kritična kartica"></i>
                    <br>
                @endif

                @if(isset($card->is_rejected) && ($card->is_rejected == 1 || $card->is_rejected == "true"))
                    <i class="fa fa-minus-circle" title="zavrnjena kartica"></i>
                @endif
            </div>
        </div>
    </div>

    <div class="box-body" style="background-color: #F6F6F6;"> 
    @if (isset($card->tasks) && count($card->tasks)>0 )
                  
              
            @foreach ($card->tasks as $task)       
            <div class='row {{ (isset($task["is_finished"]) && ($task["is_finished"] == 1 || $task["is_finished"] == "true")) ? "text-muted": ""}}'>
            
                <div class="dd col-sm-9" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        
                    {{-- show checkbox for completing --}}
                    <input type="checkbox" onchange="updateTaskCheck({{ $task['id'] }}, this, {{ $card->id }})"
                           @if(isset($task["is_finished"]) && ($task["is_finished"] == 1 || $task["is_finished"] == "true"))
                                checked
                            @endif
                           data-checkbox-task-id="{{ $task['id'] }}"
                    >
                    {{ $task["task_name"] }}
                </div>

                <div class="dd col-sm-2">
                    {{ $task["estimation"] }}
                </div>
                    
            </div>
            @endforeach
            
    @else
    <i class="fa fa-plus"></i> Dodaj nalogo
        
    @endif
    </div>
</div>