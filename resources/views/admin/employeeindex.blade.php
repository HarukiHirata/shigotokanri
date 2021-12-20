@extends('layouts.app')

@section('content')
<h1 class="text-center">従業員一覧</h1>
<p class="text-center">
    <a href="/admin/employeeregister">従業員登録はこちら</a>
</p>
<table class="table">
    <thead>
        <tr>
            <th>従業員コード</th>
            <th>従業員氏名</th>
            <th>メールアドレス</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($employees))
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->employee_code }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>
                    <button type="button" class="btn btn-info">
                        <a href="/admin/employeeedit/{{ $employee->id }}" class="a-white">編集</a>
                    </button>
                </td>
                <td>削除</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>登録されている従業員が存在していません。</td>
            </tr>
        @endif
    </tbody>
</table>
@endsection