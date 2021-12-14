@extends('layouts.app')

@section('content')
<h1 class="text-center">勤怠一覧画面</h1>
<div class="search-wrapper">
    <div class="attendance-search-form">
        <div class="card-body">
            <form>
                @csrf

                <div class="form-group row">
                    <label for="search_year" class="col-md-4 col-form-label text-md-right">{{ __('検索する年・月') }}</label>

                    <div class="col-md-6">
                        <input id="search_month" type="month" name="search_month" value="{{ old('search_month') }}">

                        <!-- @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary search-btn">
                            {{ __('ログイン') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection