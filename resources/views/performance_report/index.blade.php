<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('performance_report.generate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Employees</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-wrap justify-between mb-4">
                        <div class="w-full sm:w-1/3 mb-4">
                            <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                            <select name="report_type" id="report_type" class="form-control w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/3 mb-4">
                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                            <input type="number" name="year" id="year" class="form-control w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ date('Y') }}">
                        </div>
                        <div class="w-full sm:w-1/3 mb-4" id="month-field">
                            <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                            <select name="month" id="month" class="form-control w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    

                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary w-full md:w-auto bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('report_type').addEventListener('change', function() {
            if (this.value === 'yearly') {
                document.getElementById('month').disabled = true;
            } else {
                document.getElementById('month').disabled = false;
            }
        });
    </script>
    @endpush
</x-app-layout>
