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
                                <input type="text" name="employee_name" class="form-control" value="{{ $attendance->employee->name }}" disabled>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <label class="col-form-label text-md-right">勤務日</label>
                            <div class="form-group col-md-3">
                                <input type="number" name="year" class="form-control small-form" value="{{ old('year') ?? $year }}">年
                            </div>

                            <div class="form-group col-md-3">
                                <input type="number" name="month" class="form-control small-form" value="{{ old('month') ?? $month }}">月
                            </div>

                            <div class="form-group col-md-3">
                                <input type="number" name="day" class="form-control small-form" value="{{ old('day') ?? $day }}">日
                            </div>
                        </div>
                        @error('year')
                            <p class="text-center">{{ $message }}</p>
                        @enderror
                        @error('month')
                            <p class="text-center">{{ $message }}</p>
                        @enderror
                        @error('day')
                            <p class="text-center">{{ $message }}</p>
                        @enderror
                        @if (session('date_error'))
                            <p class="text-center">{{ session('date_error') }}</p>
                        @endif

                        <div class="form-row justify-content-center">
                            <label class="col-form-label text-md-right">始業時間</label>

                            <div class="form-group col-md-5">
                                <input type="number" name="start_time_h" class="form-control small-form" value="{{ old('start_time_h') ?? $start_time_h }}">時
                            </div>
                            <div class="form-group col-md-5">
                                <input type="number" name="start_time_m" class="form-control small-form" value="{{ old('start_time_m') ?? $start_time_m }}">分
                            </div>
                        </div>
                        @error('start_time_h')
                            <p class="text-center">{{ $message }}</p>
                        @enderror
                        @error('start_time_m')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="form-row justify-content-center">
                            <label class="col-form-label text-md-right">終業時間</label>

                            <div class="form-group col-md-5">
                                <input type="number" name="end_time_h" class="form-control small-form" value="{{ old('end_time_h') ?? $end_time_h }}">時
                            </div>
                            <div class="form-group col-md-5">
                                <input type="number" name="end_time_m" class="form-control small-form" value="{{ old('end_time_m') ?? $end_time_m }}">分
                            </div>
                        </div>
                        @error('end_time_h')
                            <p class="text-center">{{ $message }}</p>
                        @enderror
                        @error('end_time_m')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <div class="justify-content-center">
                            <div class="form-group row">
                                <label for="break_time" class="col-md-4 col-form-label text-md-right">{{ __('休憩時間') }}</label>

                                <div class="col-md-4 form-inline">
                                    <input type="number" name="break_time" class="form-control" value="{{ old('break_time') ?? $attendance->break_time }}">分
                                </div>
                            </div>
                        </div>
                        @error('break_time')
                            <p class="text-center">{{ $message }}</p>
                        @enderror

                        <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                        <input type="hidden" name="transition" value="admin">

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
