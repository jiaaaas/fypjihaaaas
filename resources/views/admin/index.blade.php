<x-app-layout>
    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-20 col-md-12 mx-auto">
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
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-3 mb-md-0">List of Admin</h5>
                                <a href="{{ route('admin.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                    <i class="material-icons me-1">add</i> Add Admin
                                </a>
                            </div>

                            <form action="{{ route('admin.index') }}" method="GET" class="row g-3 mb-4">
                                <div class="col-12 col-md">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ request()->input('name') }}">
                                </div>
                                <div class="col-12 col-md">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ request()->input('email') }}">
                                </div>
                                <div class="col-12 col-md-auto">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="material-icons me-1">search</i>
                                    </button>
                                    <a href="{{ route('admin.index') }}" class="btn btn-warning ms-2 btn-sm" title="{{ __('Reset') }}">
                                        <i class="material-icons">refresh</i>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <a href="{{ route('admin.show', $user->id) }}" class="btn btn-primary btn-sm me-1 mb-1 mb-md-0" title="{{ __('Show') }}">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-warning btn-sm me-1 mb-1 mb-md-0" title="{{ __('Edit') }}">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <form id="form-delete-{{ $user->id }}" class="d-inline-block" method="POST" action="{{ route('admin.destroy', $user->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __('Delete') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->links() }}
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
