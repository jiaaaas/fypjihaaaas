<!DOCTYPE html>
<html>
<head>
    <title>Performance Report</title>
    <meta name="generated_at" content="{{ now()->toDayDateTimeString() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }
        .header img {
            height: 50px;
        }
        .header .date {
            font-size: 14px;
            color: #666;
        }
        .container {
            padding: 20px;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .title h3 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-left-width: 4px;
            border-radius: 8px;
            padding: 16px;
            flex: 1;
            min-width: 150px;
            background-color: #fff;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logoamtis.jpg') }}" alt="AMTIS Solution">
    </div>
    <div class="container">
        <div class="title">
            <h2>Performance Report</h2>
            <h3>{{ $employeeId && $attendances->isNotEmpty() ? 'Employee: ' . $attendances->first()->employee->name : 'All Employees' }}</h3>
            <h4>{{ ucfirst($reportType) }} Report for {{ $reportType === 'monthly' ? \Carbon\Carbon::create($year, $month)->format('F Y') : $year }}</h4>
            <div class="date">Generated at: {{ now()->toDayDateTimeString() }}</div>
            <p>Report ID: {{ $report->id }}</p>
        </div>

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

        <!-- Present Table -->
        <h4>Present Employees</h4>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    @if(!$employeeId)
                        <th>Employee Name</th>
                    @endif
                    {{-- <th>Status</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($attendances->where('status', 'present') as $attendance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
                        @if(!$employeeId)
                            <td>{{ $attendance->employee->name }}</td>
                        @endif
                        {{-- <td>{{ ucfirst($attendance->status) }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Absent Table -->
        <h4>Absent Employees</h4>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    @if(!$employeeId)
                        <th>Employee Name</th>
                    @endif
                    {{-- <th>Status</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($attendances->where('status', 'absent') as $attendance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
                        @if(!$employeeId)
                            <td>{{ $attendance->employee->name }}</td>
                        @endif
                        {{-- <td>{{ ucfirst($attendance->status) }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Late Table -->
        <h4>Late Employees</h4>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    @if(!$employeeId)
                        <th>Employee Name</th>
                    @endif
                    {{-- <th>Status</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($attendances->where('status', 'late') as $attendance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
                        @if(!$employeeId)
                            <td>{{ $attendance->employee->name }}</td>
                        @endif
                        {{-- <td>{{ ucfirst($attendance->status) }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} AMTIS Solution Sdn. Bhd. All rights reserved.
    </div>
</body>
</html>
