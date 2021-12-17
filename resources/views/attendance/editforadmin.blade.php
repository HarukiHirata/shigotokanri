@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">勤怠編集画面</h1>
            <div class="card">
                <div class="card-header">{{ __('勤怠を入力してください。') }}</div>
                <div class="card-body">
                    <form method="POST" action="/attendance/update">
                        @csrf

                        <div class="form-group row">
                            <label for="employee_name" class="col-md-4 col-form-label text-md-right">{{ __('従業員名') }}</label>

                            <div class="col-md-6">
                                <input id="employee_name" type="text" name="employee_name" value="{{ $attendance->employee->name }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('勤務日') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="date" name="date" value="{{ old('date') ?? $attendance->date }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_time" class="col-md-4 col-form-label text-md-right">{{ __('始業時間') }}</label>

                            <div class="col-md-6">
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time') ?? $attendance->start_time }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_time" class="col-md-4 col-form-label text-md-right">{{ __('終業時間') }}</label>

                            <div class="col-md-6">
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time') ?? $attendance->end_time }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="break_time" class="col-md-4 col-form-label text-md-right">{{ __('休憩時間') }}</label>

                            <div class="col-md-6">
                                <input id="break_time" type="number" name="break_time" value="{{ old('break_time') ?? $attendance->break_time }}" required autofocus>分
                            </div>
                        </div>

                        <input type="hidden" type="number" name="attendance_id" value="{{ $attendance->id }}">

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
