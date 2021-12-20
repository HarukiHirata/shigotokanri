@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">{{ session('name') }}さんのホーム画面</h1>
    <div class="row">
        <div class="links col-md-6">
            <button type="button" class="btn btn-info links-btn">
                <a href="/employee/attendance/index" class="a-white">勤怠一覧はこちら</a>
            </button>
            <button type="button" class="btn btn-info links-btn">
                <a href="/employee/attendance/create" class="a-white">勤怠登録はこちら</a>
            </button>
            <button type="button" class="btn btn-info links-btn">
                <a href="/admin/logout" class="a-white">ログアウト</a>
            </button>
        </div>
    </div>
</div>
@endsection