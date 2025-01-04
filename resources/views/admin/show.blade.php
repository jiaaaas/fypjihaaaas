<x-app-layout>

    @section('content')
    <br>
    <div class="row match-height">
        <div class="col-12">
            <div class="card" style="padding: 20px; margin: 10px;">
                <div class="title-container">
                    <h1 class="page-title">User's Details</h1>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('Name') }}</label>
                                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="email">{{ __('Email') }}</label>
                                        <input type="email" id="email" class="form-control" value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions d-flex justify-content-end mt-3">
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary">{{ __('Back to List') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    </x-app-layout>
    