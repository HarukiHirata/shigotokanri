@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">従業員情報編集画面</h1>
            <div class="card">
                <div class="card-header">{{ __('従業員情報を入力してください。') }}</div>

                <div class="card-body">
                    <form method="POST" action="/admin/employeeupdate">
                        @csrf

                        <div class="form-group row">
                            <label for="employee_code" class="col-md-4 col-form-label text-md-right">{{ __('従業員コード') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code') ?? $employee->employee_code }}">

                            </div>
                        </div>
                        @error('employee_code')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('氏名') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" value="{{ old('name') ?? $employee->name }}">
                            </div>
                        </div>
                        @error('name')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="email" class="form-control" value="{{ old('email') ?? $employee->email }}">
                            </div>
                        </div>
                        @error('email')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                        <input type="hidden" name="password" value="{{ $employee->password }}">

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
