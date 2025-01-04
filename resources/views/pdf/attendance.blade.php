<h1>Employees Attendance Record</h1>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Time Clock-In</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendanceRecords as $attendance)
            <tr>
                <td>{{ $attendance->employee->name }}</td>
                <td>{{ $attendance->created_at->format('h:i A') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
