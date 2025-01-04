<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Employees Card -->
                <div class="bg-white rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">{{ __('Total Employees') }}</h3>
                    <div class="d-flex align-items-center mt-2">
                        <p class="text-4xl font-semibold text-indigo-600">{{ $totalEmployees }}</p>
                    </div>
                </div>

                <!-- Total Absent Today Card -->
                <div class="bg-white rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">{{ __('Total Absent Today') }}</h3>
                    <div class="d-flex align-items-center mt-2">
                        <p class="text-4xl font-semibold text-red-500">{{ $totalAbsentToday ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Total Late Today Card -->
                <div class="bg-white rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">{{ __('Total Late Today') }}</h3>
                    <div class="d-flex align-items-center mt-2">
                        <p class="text-4xl font-semibold text-yellow-500">{{ $totalLateToday ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Employee Performance Card -->
                <div class="bg-white rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">{{ __('Average Employees Performance') }}</h3>
                    <div class="d-flex align-items-center mt-2">
                        <p class="text-4xl font-semibold text-green-600">{{ number_format($averagePerformance, 2) ?? 'N/A' }}%</p>
                    </div>
                </div>

                <!-- Employee Scanned QR Code Card -->
                <div class="bg-white rounded-lg p-6 md:col-span-3">
                    <!-- Header with download buttons aligned to the right -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('Employees Attendance Record') }}</h3>
                        
                        <!-- Download Buttons -->
                        <div>
                            <a href="{{ route('attendance.download.excel') }}" class="btn btn-success btn-sm me-2">
                                <i class="bi bi-file-earmark-spreadsheet"></i> {{ __('Download Excel') }}
                            </a>
                            <a href="{{ route('attendance.download.pdf') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> {{ __('Download PDF') }}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('Name') }}</th>
                                    <th class="text-center">{{ __('Time Clock-In') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employeesScanned as $attendance)
                                    <tr>
                                        <td class="text-gray-900 font-semibold text-center">{{ $attendance->employee->name }}</td>
                                        <td class="text-gray-900 text-center">{{ $attendance->created_at->format('h:i A') }}</td>
                                        <td class="text-gray-900 text-center">
                                            @if ($attendance->created_at > $startTime)
                                                <span class="text-danger">{{ __('Late') }}</span>
                                            @else
                                                <span class="text-success">{{ __('On Time') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-gray-500">{{ __('No employees have scanned the QR code today.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Attendance Statistics Chart -->
                <div class="bg-white rounded-lg p-6 md:col-span-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('Attendance Statistics') }}</h3>
                    </div>
                
                    <canvas id="attendanceChart" class="mt-4"></canvas>
                </div>

            </div>
        </div>
    </div>


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('attendanceChart').getContext('2d');
            var attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($attendanceLabels),
                    datasets: [{
                        label: 'Attendance',
                        data: @json($attendanceData),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endpush
    
    
</x-app-layout>
