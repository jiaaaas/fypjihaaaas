<x-app-layout>
    @section('content')
    <div class="container-fluid">
        <div class="row-md-8">
            <div class="col-md-20 mx-auto">
                <br>
                @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <br>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Late Attendance Record</h5>
                            </div>
                            
                            <form action="{{ route('attendance.index') }}" method="GET" class="row g-3">
                                <div class="col">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ request()->input('name') }}">
                                </div>
                                <div class="col">
                                    <input type="text" name="department" class="form-control" placeholder="Department" value="{{ request()->input('department') }}">
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="material-icons me-1">search</i>
                                    </button>
                                    <a href="{{ route('attendance.index') }}" class="btn btn-warning btn-sm ms-2" title="{{ __('Reset') }}">
                                        <i class="material-icons">refresh</i>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <form action="{{ route('attendance.update') }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Evidence</th>
                                            <th>Scanned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employeesNotScanned as $employee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->department->name ?? 'N/A' }}</td>
                                            <td></td>
                                            <td>
                                                <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                        @if ($employeesNotScanned->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">All employees have scanned attendance today.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="d-flex justify-content-center mt-3">
                                {{ $attendances->links() }}
                            </div> --}}

                            @if ($employeesNotScanned->count())
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Update Attendance</button>
                            </div>
                            @endif
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageElement = document.getElementById('successMessage');
            if (messageElement) {
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 5000);
            }
        });
    </script>
    @endpush
</x-app-layout>
