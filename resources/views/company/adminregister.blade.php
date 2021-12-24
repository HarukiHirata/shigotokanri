@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">管理者登録画面</h1>
            <div class="card">
                <div class="card-header">{{ __('管理者情報を入力してください。') }}</div>

                <div class="card-body">
                    <form method="POST" action="/company/adminstore">
                        @csrf

                        <div class="form-group row">
                            <label for="admin_code" class="col-md-4 col-form-label text-md-right">{{ __('管理者コード') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="admin_code" class="form-control" value="{{ old('admin_code') }}">
                            </div>
                        </div>
                        @error('admin_code')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('氏名') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        @error('name')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        @error('email')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('権限') }}</label>

                            <div class="col-md-6">
                                <input type="radio" name="role" value="0">勤怠閲覧・編集可能
                                <input type="radio" name="role" value="1">勤怠閲覧可能
                            </div>
                        </div>
                        @error('role')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('初期パスワード') }}</label>

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
