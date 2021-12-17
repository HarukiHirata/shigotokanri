@extends('layouts.app')

@section('content')
<h1 class="text-center">勤怠一覧画面</h1>
<div class="attendance-search-form">
    <div class="card-body">
        <form method="post" action="/admin/attendance/index">
            @csrf

            <div class="form-group row">
                <label for="search_month" class="col-md-4 col-form-label text-md-right">{{ __('検索する年・月') }}</label>

                <div class="col-md-6">
                    <input id="search_month" type="month" name="search_month" value="{{ old('search_month') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="employee_id" class="col-md-4 col-form-label text-md-right">{{ __('従業員') }}</label>

                <div class="col-md-6">
                    <select name="employee_id">
                        <option value="">選択してください</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary search-btn">
                        {{ __('検索') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>従業員名</th>
            <th>勤務日</th>
            <th>始業時間</th>
            <th>終業時間</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($attendances) && count($attendances) != 0)
            @foreach ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->employee->name }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->start_time }}</td>
                <td>{{ $attendance->end_time }}</td>
                <td>{{ $attendance->break_time }}分</td>
                <td>{{ $attendance->working_hours }}時間</td>
                <td>
                    <button type="button" class="btn btn-info">
                        <a href="/admin/attendance/edit/{{ $attendance->id }}" class="a-white">編集</a>
                    </button>
                </td>
                <td>
                    <form method="post" action="/attendance/destroy/{{ $attendance->id }}">
                        @csrf
                        <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('削除してよろしいですか')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @elseif (!empty($nullmessage))
            <tr>
                <td>{{ $nullmessage }}</td>
            </tr>
        @endif
    </tbody>
</table>
<a href="/admin/home">ホーム画面へ</a>
@endsection