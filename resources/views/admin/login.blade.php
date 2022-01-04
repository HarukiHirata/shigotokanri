@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('管理者ログイン') }}</div>

                <div class="card-body">
                    <form method="POST" action="/admin/login">
                        @csrf

                        <div class="form-group row">
                            <label for="company_code" class="col-md-4 col-form-label text-md-right">{{ __('企業コード') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="company_code" class="form-control" value="{{ old('company_code') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="admin_code" class="col-md-4 col-form-label text-md-right">{{ __('管理者コード') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="admin_code" class="form-control" value="{{ old('admin_code') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                            </div>
                        </div>
                        @if (session('login_error'))
                            <p class="text-center">{{ session('login_error') }}
                        @endif

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
