@extends('layouts.app')

@section('content')
<h1>管理者ホーム画面</h1>
<p>{{ session('name') }}</p>
<p>{{ session('company_code') }}</p>
<a href="/admin/attendance/index">勤怠一覧画面</a>
<a href="/admin/logout">ログアウト</a>
@endsection