@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">勤怠登録アプリ</h1>
    <div class="row">
        <div class="links col-md-6">
            <button type="button" class="btn btn-info links-btn">
                <a href="/admin/login" class="a-white">管理者用ログインはこちら</a>
            </button>
            <button type="button" class="btn btn-info links-btn">
                <a href="/employee/login" class="a-white">従業員用ログインはこちら</a>
            </button>
            <button type="button" class="btn btn-info links-btn">
                <a href="/company/login" class="a-white">企業登録・企業設定はこちら</a>
            </button>
        </div>
    </div>
</div>
@endsection