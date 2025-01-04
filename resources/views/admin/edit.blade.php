<x-app-layout>

    @section('content')
    <br>
    <div class="row match-height">
        <div class="col-12">
            <div class="card" style="padding: 20px; margin: 10px;">
                <div class="title-container">
                    <h1 class="page-title">Edit User</h1>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form id="form-user" class="form" action="{{ route('admin.update', $user->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('Name') }}</label>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="{{ __('Name') }}" name="name">
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
                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="{{ __('Email') }}" name="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="password">{{ __('Password') }}</label>
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        <input type="password" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary ms-2">{{ __('Back') }}</a>
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
