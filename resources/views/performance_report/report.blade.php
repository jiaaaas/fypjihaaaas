<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex justify-between items-center w-full">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $employeeId && $attendances->isNotEmpty() ? 'Employee: ' . $attendances->first()->employee->name : 'All Employees' }}
                        </h3>
                        <div class="mt-4 flex justify-end items-center space-x-2">
                            <a href="{{ route('performance_report.index') }}" class="btn btn-secondary">Back</a>
                            <form action="{{ route('performance_report.download_pdf') }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                                <input type="hidden" name="report_type" value="{{ $reportType }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                <input type="hidden" name="month" value="{{ $month }}">
                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                <button type="submit" class="btn btn-danger">Download PDF</button>
                            </form>
                        </div>
                    </div>
                </div>

                <h4 class="text-md font-medium text-gray-700 mb-4">
                    {{ ucfirst($reportType) }} Report for {{ $reportType === 'monthly' ? \Carbon\Carbon::create($year, $month)->format('F Y') : $year }}
                </h4>
                <p>Report ID: {{ $report->id }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4 mt-4">
                    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-500">
                        <p class="text-gray-700"><strong>Total Days:</strong> {{ $totalDays }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-green-500">
                        <p class="text-gray-700"><strong>On Time Days:</strong> {{ $presentCount }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-red-500">
                        <p class="text-gray-700"><strong>Absent Days:</strong> {{ $absentCount }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-yellow-500">
                        <p class="text-gray-700"><strong>Late Days:</strong> {{ $lateCount }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-purple-500">
                        <p class="text-gray-700"><strong>Performance:</strong> {{ number_format($performance, 2) }}%</p>
                    </div>
                </div>

                {{-- <!-- Performance Chart -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold mb-4">Performance Overview</h4>
                    <canvas id="performanceChart" width="200" height="100"></canvas> <!-- Minimized size -->
                </div> --}}

                <!-- Attendance Status Tabs -->
                <div class="mt-4 mb-4">
                    <ul class="flex border-b">
                        <li class="-mb-px mr-1">
                            <a href="#present" class="bg-blue-500 text-white inline-block py-2 px-4 rounded-t-lg">Present</a>
                        </li>
                        <li class="-mb-px mr-1">
                            <a href="#absent" class="bg-red-500 text-white inline-block py-2 px-4 rounded-t-lg">Absent</a>
                        </li>
                        <li class="-mb-px mr-1">
                            <a href="#late" class="bg-yellow-500 text-white inline-block py-2 px-4 rounded-t-lg">Late</a>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content mt-4">
                        <!-- Present Tab -->
                        <div id="present" class="tab-pane">
                            <h4 class="text-lg font-semibold">Present Employees</h4>
                            <table class="table table-striped table-bordered">
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
                                    @foreach($attendances->where('status', 'present') as $attendance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
                                            @if(!$employeeId)
                                                <td>{{ $attendance->employee->name }}</td>
                                            @endif
                                            <td>{{ ucfirst($attendance->status) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Absent Tab -->
                        <div id="absent" class="tab-pane">
                            <h4 class="text-lg font-semibold">Absent Employees</h4>
                            <table class="table table-striped table-bordered">
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
                                    @foreach($attendances->where('status', 'absent') as $attendance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
                                            @if(!$employeeId)
                                                <td>{{ $attendance->employee->name }}</td>
                                            @endif
                                            <td>{{ ucfirst($attendance->status) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Late Tab -->
                        <div id="late" class="tab-pane">
                            <h4 class="text-lg font-semibold">Late Employees</h4>
                            <table class="table table-striped table-bordered">
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
                                    @foreach($attendances->where('status', 'late') as $attendance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
                                            @if(!$employeeId)
                                                <td>{{ $attendance->employee->name }}</td>
                                            @endif
                                            <td>{{ ucfirst($attendance->status) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        // Performance Chart Data
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'line', // Changed to line chart
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'], // Day labels (you can replace them with actual dates)
                datasets: [{
                    label: 'On Time',
                    data: [{{ $presentCount }}, {{ $presentCount }}, {{ $presentCount }}, {{ $presentCount }}, {{ $presentCount }}, {{ $presentCount }}, {{ $presentCount }}], // Replace with actual values per day
                    fill: false,
                    borderColor: '#4CAF50',
                    tension: 0.1
                }, {
                    label: 'Absent',
                    data: [{{ $absentCount }}, {{ $absentCount }}, {{ $absentCount }}, {{ $absentCount }}, {{ $absentCount }}, {{ $absentCount }}, {{ $absentCount }}], // Replace with actual values per day
                    fill: false,
                    borderColor: '#F44336',
                    tension: 0.1
                }, {
                    label: 'Late',
                    data: [{{ $lateCount }}, {{ $lateCount }}, {{ $lateCount }}, {{ $lateCount }}, {{ $lateCount }}, {{ $lateCount }}, {{ $lateCount }}], // Replace with actual values per day
                    fill: false,
                    borderColor: '#FFEB3B',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' days';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script> --}}
    <script>
        // You can use a simple JavaScript function or AlpineJS to switch between tabs
        document.querySelectorAll('.tab-pane').forEach(tab => tab.style.display = 'none');
        document.getElementById('present').style.display = 'block';

        document.querySelectorAll('.flex a').forEach(tab => {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                document.querySelectorAll('.tab-pane').forEach(tab => tab.style.display = 'none');
                const tabId = tab.getAttribute('href').replace('#', '');
                document.getElementById(tabId).style.display = 'block';
            });
        });
    </script>
    @endpush
</x-app-layout>
