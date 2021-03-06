<tr data-task-id="{{ $task->id }}">
    <td  style="min-width: 75px;">
        <input type="checkbox"
               onchange="updateTaskCheck({{ $task->id }}, this, {{ $task->card_id }})"
               data-checkbox-task-id="{{ $task->id }}"
        @if($task->is_finished)
            checked
         @endif
        ></th>
    <td>{{ $task->task_name }}</td>
    <td>{{ $task->description }}</td>
    <td data-id="{{ isset($task->user_id) ? $task->user_id : '0' }}">{{ isset($task->user) ? $task->user->first_name . " " . $task->user->last_name : '' }}</td>
    <td style="min-width: 75px;">{{ $task->estimation }}</td>
    <td style="min-width: 75px;" class="editTask"><i class="fa fa-edit"></i></td>
</tr>