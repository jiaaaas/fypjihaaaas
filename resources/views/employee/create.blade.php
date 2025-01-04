<x-app-layout>

    @section('content')
    <style>
        .dz-progress {
            display: none !important;
        }
    </style>
    <br>
    
    <div class="row match-height">
        <div class="col-12">
            <div class="card" style="padding: 20px; margin: 10px;">
                <div class="title-container" >
                    <h1 class="page-title">Add New Employee</h1>
                </div>
                <div class="card-content">
                    <div class="card-body"> 
                        <form id="form-room" class="form" action="{{ route('employee.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
    
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('Name') }}</label>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('Name') }}" name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="email">{{ __('Email') }}</label>
                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('Email') }}" name="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="phone_no">{{ __('Phone No.') }}</label>
                                        <input type="text" id="phone_no" class="form-control @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}" placeholder="{{ __('Phone No.') }}" name="phone_no">
                                        @error('phone_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="address">{{ __('Address') }}</label>
                                        <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="{{ __('Address') }}" name="address">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="department_id">{{ __('Department') }}</label>
                                        <select name="department_id" id="department_id"  class="form-control @error('department_id') is-invalid @enderror">>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

    
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label" for="status_work_id">{{ __('Status Work') }}</label>
                                        </div>
                                        <div class="col-md-12">
                                            @foreach($statusWorks as $status)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('status_work_id') is-invalid @enderror" type="radio" name="status_work_id" id="status_work_{{ $status->id }}" value="{{ $status->id }}" {{ old('status_work_id') == $status->id ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_work_{{ $status->id }}">{{ $status->name }}</label>
                                                </div>
                                            @endforeach
                                            @error('status_work_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
    
                            </div>
     
                            <div class="form-actions d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                <a href="{{ URL::previous() == URL::current() ? route('employee.index') : URL::previous() }}" class="btn btn-secondary ms-2">{{ __('Back') }}</a>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @endsection
    
    @section('script')
    <script src="{{ asset('tabler/dist/libs/dropzone/dist/dropzone-min.js?1684106062') }}" defer></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // You can add additional JavaScript if necessary
    });
    </script>
    @endsection
    </x-app-layout>