@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">企業登録画面</h1>
            <div class="card">
                <div class="card-header">{{ __('企業情報を入力してください。') }}</div>

                <div class="card-body">
                    <form method="POST" action="/company/store">
                        @csrf

                        <div class="form-group row">
                            <label for="company_code" class="col-md-4 col-form-label text-md-right">{{ __('企業コード') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="company_code" class="form-control" value="{{ old('company_code') }}">
                            </div>
                        </div>
                        @error('company_code')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('企業名') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        @error('name')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('企業用メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        @error('email')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="8文字以上で入力してください">
                            </div>
                        </div>
                        @error('password')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('登録') }}
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
