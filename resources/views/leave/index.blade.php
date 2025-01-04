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
                                <h5 class="card-title mb-0">Leave Record</h5>
                            </div>

                            <form action="" method="GET" class="row g-3">
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

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($leaves as $leave)
                                    <tr>
                                        <td>{{ $loop->iteration + ($leaves->currentPage() - 1) * $leaves->perPage() }}</td>
                                        <td>{{ $leave->employee->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}</td>
                                        {{-- <td>{{ ucfirst($leave->status) }}</td> --}}
                                        <td>
                                            @if ($leave->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($leave->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif ($leave->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('leave.updateStatus', $leave->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select" onchange="this.form.submit()">
                                                    <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No leave records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>{{ $leaves->links() }}</div>
                        </div>
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