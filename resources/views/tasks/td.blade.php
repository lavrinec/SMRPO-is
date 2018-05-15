<tr data-task-id="{{ $task->id }}">
    <td  style="min-width: 75px;">{{ $task->id }}</th>
    <td>{{ $task->task_name }}</td>
    <td>{{ $task->description }}</td>
    <td style="min-width: 75px;">{{ $task->estimation }}</td>
    <td style="min-width: 75px;" class="editTask"><i class="fa fa-edit"></i></td>
</tr>