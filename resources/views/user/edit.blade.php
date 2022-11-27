@extends('layouts.app')
@section('title','たきや漁予約システム |Edit')
@section('content')
<h1 class="text-center">Edit</h1>
<div class="container justify-content-center">
<form action="{{route('user.update',$user)}}" class="mt-5" method="POST">
    @csrf
    @method('PATCH')
    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="furigana" class="col-md-4 col-form-label text-md-end">{{ __('furigana') }}</label>

        <div class="col-md-6">
            <input id="furigana" type="text" class="form-control @error('furigana') is-invalid @enderror" name="furigana" value="{{ $user->furigana }}" required autocomplete="furigana" autofocus>

            @error('furigana')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('Upload Image') }}</label>

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
        <label for="old" class="col-md-4 col-form-label text-md-end">{{ __('old') }}</label>

        <div class="col-md-6">
            <input id="old" type="number" class="form-control @error('old') is-invalid @enderror" value="{{ $user->old }}" name="old" required autocomplete="new-old">

            @error('old')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('code') }}</label>

        <div class="col-md-6">
            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{  $user->code }}" required autocomplete="code" autofocus>

            @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('address') }}</label>

        <div class="col-md-6">
            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{  $user->address }}" required autocomplete="address" autofocus>

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
     <div class="row mb-3">
        <label for="tel" class="col-md-4 col-form-label text-md-end">{{ __('tel') }}</label>

        <div class="col-md-6">
            <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{  $user->tel }}" required autocomplete="tel" autofocus>

            @error('tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
     <div class="row mb-3">
        <label for="tel2" class="col-md-4 col-form-label text-md-end">{{ __('tel2') }}</label>

        <div class="col-md-6">
            <input id="tel2" type="text" class="form-control @error('tel2') is-invalid @enderror" name="tel2" value="{{  $user->tel2 }}" required autocomplete="tel2" autofocus>

            @error('tel2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Edit') }}
            </button>
        </div>
    </div>
</form>
</div>
@endsection
