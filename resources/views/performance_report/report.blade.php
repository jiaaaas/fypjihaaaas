<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                {{-- <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ $employeeId ? 'Employee: ' . $attendances->first()->employee->name : 'All Employees' }}
                </h3> --}}
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ $employeeId && $attendances->isNotEmpty() ? 'Employee: ' . $attendances->first()->employee->name : 'All Employees' }}
                </h3>
                <h4 class="text-md font-medium text-gray-700 mb-4">
                    {{ ucfirst($reportType) }} Report for {{ $reportType === 'monthly' ? \Carbon\Carbon::create($year, $month)->format('F Y') : $year }}
                </h4>
                <p>Report ID: {{ $report->id }}</p>

                <div class="mb-4">
                    <p>Total Days: {{ $attendances->count() }}</p>
                    <p>On Time Days: {{ $attendances->where('status', 'present')->count() }}</p>
                    <p>Performance: {{ number_format($performance, 2) }}%</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
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
                </div>

                <div class="mt-4">
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
    </div>
</x-app-layout>