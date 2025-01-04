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

                <div class="mt-4 mb-4" style="max-width: 400px; margin: auto; border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
                    <canvas id="attendanceChart"></canvas>
                </div>

                <div class="table-responsive">
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
                            @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendance->created_at->format('d-m-Y') }}</td>
                                @if(!$employeeId)
                                    <td>{{ $attendance->employee->name }}</td>
                                @endif
                                <td>{{ ucfirst($attendance->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $employeeId ? '3' : '4' }}" class="text-center">No data available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4" style="max-width: 400px; margin: auto;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceData = @json($attendances->map(function($attendance) {
            return [
                'date' => $attendance->created_at->format('d-m-Y'),
                'status' => $attendance->status
            ];
        }));

        const presentCount = attendanceData.filter(data => data.status === 'present').length;
        const absentCount = attendanceData.filter(data => data.status === 'absent').length;
        const lateCount = attendanceData.filter(data => data.status === 'late').length;

        const data = {
            labels: ['Present', 'Absent', 'Late'],
            datasets: [{
                label: 'Attendance Status',
                data: [presentCount, absentCount, lateCount],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            let percentage = (value * 100 / sum).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#000000',
                    }
                }
            }
        };

        Chart.register(ChartDataLabels);
        const attendanceChart = new Chart(ctx, config);
    </script>
    @endpush
</x-app-layout>