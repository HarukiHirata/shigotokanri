@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('企業設定画面へログイン') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('companylogin') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="company_code" class="col-md-4 col-form-label text-md-right">{{ __('企業コード') }}</label>

                            <div class="col-md-6">
                                <input id="company_code" type="text" name="company_code" value="{{ old('company_code') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('ログイン') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center">
                <a href="/company/register">企業登録はこちら</a>
            </p>
        </div>
    </div>
</div>
@endsection
