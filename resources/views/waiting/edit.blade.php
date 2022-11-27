@extends('layouts.app')
@section('title','たきや漁予約システム |Edit Waiting')
@section('content')
<h1 class="text-center">Edit Waiting</h1>
<div class="container justify-content-center">
<form action="{{route('waiting.update',$waiting)}}" class="mt-5" method="POST">
    @csrf
    @method('PATCH')

    <div class="row mb-3">
        <label for="place" class="col-md-4 col-form-label text-md-end">{{ __('place') }}</label>

        <div class="col-md-6">
            <select id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="{{$waiting->place}}" required autocomplete="place" autofocus>
                <option value="" selected hidden>{{$waiting->place}}</option>
                @foreach ($all_places as $place)
                    <option value="{{$place->place}}">{{$place->place}}</option>
                @endforeach

            </select>


            @error('place')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('price') }}</label>

        <div class="col-md-6">
            <select id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{$waiting->price }}" required autocomplete="price" autofocus>
                <option value="" selected hidden>{{$waiting->price }}</option>
                @foreach ($all_prices as $price)
                    <option value="{{$price->price}}">{{$price->price}}</option>
                @endforeach

            </select>


            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="memo" class="col-md-4 col-form-label text-md-end">{{ __('memo') }}</label>

        <div class="col-md-6">
            <textarea id="memo" type="text" class="form-control @error('memo') is-invalid @enderror" name="memo" value="{{$waiting->memo}}" autocomplete="memo" autofocus></textarea>
           @error('memo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <a href="{{route('user.reserve',$waiting->user_id)}}" class="btn btn-danger">{{__('Back')}}</a>
            <button type="submit" class="btn btn-primary">
                {{ __('Edit') }}
            </button>
        </div>
    </div>
</form>
</div>
@endsection
