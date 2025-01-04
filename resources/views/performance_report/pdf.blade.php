<!DOCTYPE html>
<html>
<head>
    <title>Performance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .card {
            border: 1px solid #ddd;
            border-left-width: 4px;
            border-radius: 8px;
            padding: 8px; /* Reduced padding */
            margin-bottom: 8px; /* Reduced margin */
            flex: 1;
            min-width: 150px; /* Reduced min-width */
        }
        .border-blue {
            border-left-color: #4299e1;
        }
        .border-green {
            border-left-color: #48bb78;
        }
        .border-red {
            border-left-color: #f56565;
        }
        .border-yellow {
            border-left-color: #ecc94b;
        }
        .border-purple {
            border-left-color: #9f7aea;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px; /* Reduced gap */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
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
    <h3>{{ $employeeId && $attendances->isNotEmpty() ? 'Employee: ' . $attendances->first()->employee->name : 'All Employees' }}</h3>
    <h4>{{ ucfirst($reportType) }} Report for {{ $reportType === 'monthly' ? \Carbon\Carbon::create($year, $month)->format('F Y') : $year }}</h4>
    <p>Report ID: {{ $report->id }}</p>

    <div class="card-container">
        <div class="card border-blue">
            <p><strong>Total Days:</strong> {{ $totalDays }}</p>
        </div>
        <div class="card border-green">
            <p><strong>On Time Days:</strong> {{ $presentCount }}</p>
        </div>
        <div class="card border-red">
            <p><strong>Absent Days:</strong> {{ $absentCount }}</p>
        </div>
        <div class="card border-yellow">
            <p><strong>Late Days:</strong> {{ $lateCount }}</p>
        </div>
        <div class="card border-purple">
            <p><strong>Performance:</strong> {{ number_format($performance, 2) }}%</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                @if(!$employeeId)
                    <th>Employee Name</th>
                @endif
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->created_at->format('d-m-Y') }}</td>
                    @if(!$employeeId)
                        <td>{{ $attendance->employee->name }}</td>
                    @endif
                    <td>{{ ucfirst($attendance->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>