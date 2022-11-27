@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員登録') }}</div>


                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="card-body registers">
                            <div class="register-wrapper d-flex">
                                <div class="register1">
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('お名前') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="furigana" class="col-md-4 col-form-label text-md-end">{{ __('フリガナ') }}</label>

                                        <div class="col-md-6">
                                            <input id="furigana" type="text" class="form-control @error('furigana') is-invalid @enderror" name="furigana" value="{{ old('furigana') }}" required autocomplete="furigana" autofocus>

                                            @error('furigana')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('・パスワード') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('パスワード確認') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <span class="btn btn-primary" id="next">
                                                {{ __('Next') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="register2">
                                    <div class="row mb-3">
                                        <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('性別') }}</label>

                                        <div class="col-md-6">

                                            <select id="sex" type="text" class="form-control @error('sex') is-invalid @enderror" name="sex" value="{{ old('sex') }}"  autocomplete="sex" autofocus>
                                                <option value="">choose</option>
                                                <option value="0">male</option>
                                                <option value="1">female</option>
                                                </select>
                                            @error('sex')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="old" class="col-md-4 col-form-label text-md-end">{{ __('年齢') }}</label>

                                        <div class="col-md-6">
                                            <input id="old" type="number" class="form-control @error('old') is-invalid @enderror" name="old" value="{{ old('old') }}"  autocomplete="old" autofocus>

                                            @error('old')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('郵便番号') }}</label>

                                        <div class="col-md-6">
                                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}"  autocomplete="code" autofocus>

                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('住所') }}</label>

                                        <div class="col-md-6">
                                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"  autocomplete="address" autofocus>

                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tel" class="col-md-4 col-form-label text-md-end">{{ __('電話番号') }}</label>

                                        <div class="col-md-6">
                                            <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel') }}"  autocomplete="tel" autofocus>

                                            @error('tel')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tel2" class="col-md-4 col-form-label text-md-end">{{ __('電話番号２') }}</label>

                                        <div class="col-md-6">
                                            <input id="tel2" type="text" class="form-control @error('tel2') is-invalid @enderror" name="tel2" value="{{ old('tel2') }}"  autocomplete="tel2" autofocus>

                                            @error('tel2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4 d-flex">
                                            <span class="btn btn-success" id="previous">
                                                {{ __('戻る') }}
                                            </span>
                                            <button type="submit" class="btn btn-primary mx-2">
                                                {{ __('登録') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>
@endsection
