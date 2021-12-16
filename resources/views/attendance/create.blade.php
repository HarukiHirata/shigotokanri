@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">勤怠登録画面</h1>
            <div class="card">
                <div class="card-header">{{ __('勤怠を入力してください。') }}</div>

                <div class="card-body">
                    <form method="POST" action="/employee/attendance/store">
                        @csrf

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('勤務日') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="date" name="date" value="{{ old('date') }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_time" class="col-md-4 col-form-label text-md-right">{{ __('始業時間') }}</label>

                            <div class="col-md-6">
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_time" class="col-md-4 col-form-label text-md-right">{{ __('終業時間') }}</label>

                            <div class="col-md-6">
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}" required autofocus>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="break_time" class="col-md-4 col-form-label text-md-right">{{ __('休憩時間') }}</label>

                            <div class="col-md-6">
                                <input id="break_time" type="number" name="break_time" value="{{ old('break_time') }}" required autofocus>分

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
