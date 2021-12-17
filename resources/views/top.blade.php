@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">勤怠登録アプリ</h1>
    <div class="row">
        <div class="top-links col-md-6">
            <button type="button" class="btn btn-info top-btn">
                <a href="/admin/login" class="a-white">管理者用ログインはこちら</a>
            </button>
            <button type="button" class="btn btn-info top-btn">
                <a href="/employee/login" class="a-white">従業員用ログインはこちら</a>
            </button>
        </div>
    </div>
</div>
@endsection