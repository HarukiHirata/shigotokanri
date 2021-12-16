@extends('layouts.app')

@section('content')
<h1>従業員ホーム画面</h1>
<p>{{ session('name') }}</p>
<p>{{ session('company_code') }}</p>
<a href="/employee/attendance/create">勤怠登録画面</a>
<a href="/employee/attendance/index">勤怠一覧画面</a>
<a href="/employee/logout">ログアウト</a>
@endsection