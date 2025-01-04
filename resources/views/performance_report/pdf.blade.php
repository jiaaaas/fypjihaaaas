<!DOCTYPE html>
<html>
<head>
    <title>Performance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Performance Report</h2>
    <h3>{{ $employeeId ? 'Employee: ' . $attendances->first()->employee->name : 'All Employees' }}</h3>
    <h4>{{ ucfirst($reportType) }} Report for {{ $reportType === 'monthly' ? \Carbon\Carbon::create($year, $month)->format('F Y') : $year }}</h4>
    <p>Report ID: {{ $report->id }}</p>

    <p>Total Days: {{ $attendances->count() }}</p>
    <p>On Time Days: {{ $attendances->where('status', 'present')->count() }}</p>
    <p>Performance: {{ number_format($performance, 2) }}%</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->created_at->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($attendance->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>