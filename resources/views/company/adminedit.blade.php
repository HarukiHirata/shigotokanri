@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">管理者情報編集画面</h1>
            <div class="card">
                <div class="card-header">{{ __('管理者情報を入力してください。') }}</div>

                <div class="card-body">
                    <form method="POST" action="/company/adminupdate">
                        @csrf

                        <div class="form-group row">
                            <label for="admin_code" class="col-md-4 col-form-label text-md-right">{{ __('管理者コード') }}</label>

                            <div class="col-md-6">
                                <input id="admin_code" type="text" name="admin_code" value="{{ old('admin_code') ?? $admin->admin_code }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('氏名') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" name="name" value="{{ old('name') ?? $admin->name }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" name="email" value="{{ old('email') ?? $admin->email }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('権限') }}</label>

                            <div class="col-md-6">
                                @if ($admin->role == 0)
                                    <input id="role" type="radio" name="role" value="0" required checked>勤怠閲覧・編集可能
                                    <input id="role" type="radio" name="role" value="1">勤怠閲覧可能
                                @elseif ($admin->role == 1)
                                    <input id="role" type="radio" name="role" value="0" required>勤怠閲覧・編集可能
                                    <input id="role" type="radio" name="role" value="1" checked>勤怠閲覧可能
                                @endif

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <input id="admin_id" name="admin_id" type="hidden" value="{{ $admin->id }}">
                        <input id="password" name="password" type="hidden" value="{{ $admin->password }}">

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
