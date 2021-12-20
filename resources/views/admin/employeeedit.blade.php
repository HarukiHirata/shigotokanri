@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">従業員情報編集画面</h1>
            <div class="card">
                <div class="card-header">{{ __('従業員情報を入力してください。') }}</div>

                <div class="card-body">
                    <form method="POST" action="/admin/employeeregister">
                        @csrf

                        <div class="form-group row">
                            <label for="employee_code" class="col-md-4 col-form-label text-md-right">{{ __('従業員コード') }}</label>

                            <div class="col-md-6">
                                <input id="employee_code" type="text" name="employee_code" value="{{ old('employee_code') ?? $employee->employee_code }}" required autofocus>

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
                                <input id="name" type="text" name="name" value="{{ old('name') ?? $employee->name }}" required autofocus>

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
                                <input id="email" type="text" name="email" value="{{ old('email') ?? $employee->email }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

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
