<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Assignee</th>
            <th>Due Date</th>
            <th>Time Tracked</th>
            <th>Status</th>
            <th>Priority</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($todos as $todo)
            <tr>
                <td>{{ $todo->title }}</td>
                <td>{{ $todo->assignee }}</td>
                <td>{{ $todo->due_date }}</td>
                <td>{{ $todo->time_tracked }}</td>
                <td>{{ $todo->status }}</td>
                <td>{{ $todo->priority }}</td>
            </tr>
        @endforeach

        <!-- Ringkasan -->
        <tr>
            <td colspan="3"><strong>Total Tugas</strong></td>
            <td colspan="3"><strong>{{ $totalTasks }}</strong></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Total Waktu</strong></td>
            <td colspan="3"><strong>{{ $totalTime }} menit</strong></td>
        </tr>
    </tbody>
</table>
