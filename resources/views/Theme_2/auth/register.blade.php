
@extends('Theme_2.layouts.master_auth')

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body" style="text-align:center">
                    <img src="{{ asset('logo.png') }}" style="width: 80px;margin: auto;margin-bottom:20px"/>
                    <br/>
                    <h5>ضبط كلمة المرور</h5>
                    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('save-password') }}">
                        @csrf
                        <input type="hidden" name="email" value="admin@admin.com" />
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{ __('كلمة المرور') }}</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                {{ __('ضبط كلمة المرور') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>
@endsection
