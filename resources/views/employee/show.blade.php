<x-app-layout>

    @section('content')
    <br>
    
    <div class="row match-height">
        <div class="col-12">
            <div class="card" style="padding: 20px; margin: 10px;">
                <div class="title-container" >
                    <h1 class="page-title">Employee's Details</h1>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" autocomplete="off">
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('Name') }}</label>
                                        <input type="text" id="name" class="form-control" value="{{ $employees->name }}" disabled>
                                    </div>
                                </div>
    
                                <!-- Email -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="email">{{ __('Email') }}</label>
                                        <input type="email" id="email" class="form-control" value="{{ $employees->email }}" disabled>
                                    </div>
                                </div>
    
                                <!-- Phone No. -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="phone_no">{{ __('Phone No.') }}</label>
                                        <input type="text" id="phone_no" class="form-control" value="{{ $employees->phone_no }}" disabled>
                                    </div>
                                </div>
    
                                <!-- Address -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="address">{{ __('Address') }}</label>
                                        <input type="text" id="address" class="form-control" value="{{ $employees->address }}" disabled>
                                    </div>
                                </div>
    
                                <!-- Department -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="department">{{ __('Department') }}</label>
                                        <input type="text" id="department" class="form-control" value="{{ $employees->department->name }}" disabled>
                                    </div>
                                </div>
    
                                <!-- Status Work -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Status Work') }}</label>
                                        <div>
                                            @if (isset($employees->statusWork->name))
                                                <span class="badge {{ strtolower($employees->statusWork->name) == 'hybrid' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($employees->statusWork->name) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('Not specified') }}</span>
                                            @endif
                                        </div>           
                                    </div>
                                </div>

                            </div>
    
                            <!-- Back Button -->
                            <div class="form-actions d-flex justify-content-end mt-3">
                                <a href="{{ route('employee.index') }}" class="btn btn-secondary">{{ __('Back to List') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @endsection
    </x-app-layout>
    