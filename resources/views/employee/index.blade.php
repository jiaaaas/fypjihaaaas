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
                                <h5 class="card-title mb-0">List of Employees</h5>
                                <a href="{{ route('employee.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                    <i class="material-icons me-1">add</i> Add Employee
                                </a>
                            </div>
                            
                            <form action="{{ route('employee.index') }}" method="GET" class="row g-3 mb-4">
                                <div class="col">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ request()->input('name') }}">
                                </div>
                                <div class="col">
                                    <input type="text" name="phone_no" class="form-control" placeholder="Phone No." value="{{ request()->input('phone_no') }}">
                                </div>
                                <div class="col">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ request()->input('email') }}">
                                </div>
                                <div class="col">
                                    <input type="text" name="address" class="form-control" placeholder="Address" value="{{ request()->input('address') }}">
                                </div>
                        
                                <div class="col">
                                    <select name="status_work_id" class="form-control">
                                        <option value="" disabled {{ is_null(request()->input('status_work_id')) ? 'selected' : '' }}>Status Work</option>
                                        <option value="Hybrid" {{ request()->input('status_work_id') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        <option value="Non-Hybrid" {{ request()->input('status_work_id') == 'Non-Hybrid' ? 'selected' : '' }}>Non-Hybrid</option>
                                    </select>
                                </div>
                                
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="material-icons me-1">search</i>
                                    </button>
                                    <a href="{{ route('employee.index') }}" class="btn btn-warning ms-2 btn-sm" title="{{ __('Reset') }}">
                                        <i class="material-icons">refresh</i>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Phone No.</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Department</th> <!-- New Column -->
                                    <th>Status Work</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->phone_no }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->address }}</td>
                                    <td>{{ $employee->department->name }}</td>
                                    {{-- <td>{{ $employee->roleid == 'normal_employee' ? 'Employee' : ucwords(str_replace('_', ' ', $employee->roleid)) }}</td> <!-- Change normal_employee to Employee --> --}}
                                    <td>
                                        <span class="badge {{ strtolower($employee->statusWork->name) == 'hybrid' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($employee->statusWork->name) }}
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-primary btn-sm" title="{{ __('Show') }}">
                                            <i class="material-icons">visibility</i>
                                        </a> 
                                        <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning btn-sm me-1" title="{{ __('Edit') }}">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form id="form-delete-{{ $employee->id }}" class="d-inline-block" method="POST" action="{{ route('employee.destroy', $employee->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="{{ __('Delete') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
    
                        <div class="d-flex justify-content-center mt-3">
                            {{ $employees->links() }}
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
