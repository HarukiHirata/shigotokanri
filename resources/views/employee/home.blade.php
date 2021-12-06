@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<h1>従業員ホーム画面</h1>
<p>{{ session('name') }}</p>
<p>{{ session('company_code') }}</p>
<a href="/employee/logout">ログアウト</a>
@endsection