@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success')}}
                    </div>
                @endif

                @if (session('fail'))
                    <div class="alert alert-danger">
                        {{ session('fail')}}
                    </div>
                @endif
                <div class="card-header">{{ __('管理者ログイン') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('adminlogin') }}">
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
                            <label for="admin_code" class="col-md-4 col-form-label text-md-right">{{ __('管理者コード') }}</label>

                            <div class="col-md-6">
                                <input id="admin_code" type="text" name="admin_code" value="{{ old('admin_code') }}" required autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

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
