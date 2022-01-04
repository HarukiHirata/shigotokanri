@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">{{ session('company_name') }}の管理者一覧</h1>
    <p class="text-center">
        <a href="/company/adminregister">管理者登録はこちら</a>
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>管理者コード</th>
                <th>管理者名</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($admins) && count($admins) != 0)
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->admin_code }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>
                        <button type="button" class="btn btn-info">
                            <a href="/company/adminedit/{{ $admin->id }}" class="a-white">編集</a>
                        </button>
                    </td>
                    <td>
                        <form method="post" action="/company/admindestroy/{{ $admin->id }}">
                            @csrf
                            <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('削除してよろしいですか')">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td>管理者が登録されていません。</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection