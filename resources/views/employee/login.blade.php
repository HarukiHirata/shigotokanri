@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('loginfail1'))
        <div class="alert alert-danger">
            {{ session('loginfail1') }}
        </div>
    @endif
    @if (session('loginfail2'))
        <div class="alert alert-danger">
            {{ session('loginfail2') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('従業員ログイン') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('emplogin') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="company_code" class="col-md-4 col-form-label text-md-right">{{ __('企業コード') }}</label>

                            <div class="col-md-6">
                                <input id="company_code" type="text" name="company_code" value="{{ old('company_code') }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="employee_code" class="col-md-4 col-form-label text-md-right">{{ __('従業員コード') }}</label>

                            <div class="col-md-6">
                                <input id="employee_code" type="text" name="employee_code" value="{{ old('employee_code') }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                <!-- @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('ログイン') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
