@extends('layouts.main')
@section('title','たきや漁予約システム | top')
@section('content')
<div class="loading-wrapper active">
    <div class="loading-inner">
        <p>ロードしています</p>
        <div class="loader">ロードしています。</div>
        <img src="{{asset('img/undraw_fishing_hoxa.svg')}}" alt="">
    </div>
</div>
<h1>日程を選んでクリック</h1>
<div id="calendar"></div>

@endsection
@section('modal')
<div class="reserve-modal">

    @guest
    <span class="modal-close">✕</span>
        @if (Route::has('register'))
        <div class="card d-flex justify-content-center" id="register">
            <a class="btn btn-success" href="{{ route('register') }}">{{ __('会員登録') }}</a>
        </div>
        @endif
    @else
    <div class="container reserve-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reserve') }}<span class="modal-close">✕</span></div>
                            <div class="card-body reserves">
                                <form method="POST" action="{{ route('reserve.determine') }}">
                                    @csrf
                                <div class="reserve-wrapper">
                                    <div class="reserve1 addship_0 active">
                                        <div class="row mb-3">
                                            <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('日程') }}</label>

                                            <div class="col-md-6">
                                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>

                                                @error('date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="plan" class="col-md-4 col-form-label text-md-end">{{ __('プラン') }}</label>

                                            <div class="col-md-6">
                                                <select id="plan" type="text" class="form-control @error('plan') is-invalid @enderror" name="plan" value="{{ old('plan') }}" required autocomplete="plan" autofocus>
                                                    <option value="" selected hidden>{{ __('選択してください') }}</option>
                                                    @foreach ($all_plans as $plan)
                                                        <option value="{{$plan->plan}}">{{$plan->plan}}</option>
                                                    @endforeach

                                                </select>
                                                @error('plan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="boat_num" class="col-md-4 col-form-label text-md-end">{{ __('船数') }}</label>

                                            <div class="col-md-6">
                                                <input id="boat_num" type="number" class="form-control @error('date') is-invalid @enderror" name="boat_num" value="{{ old('boat_num') }}" required autocomplete="boat_num" autofocus>

                                                @error('boat_num')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="place" class="col-md-4 col-form-label text-md-end">{{ __('乗船場所') }}</label>

                                            <div class="col-md-6">
                                                <select id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="{{ old('place') }}" required autocomplete="place" autofocus>
                                                    <option value="" selected hidden>選択してください</option>
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
                                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('価格') }}</label>

                                            <div class="col-md-6">
                                                <select id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>
                                                    <option value="" selected hidden>{{ __('選択してください') }}</option>
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
                                            <label for="memo" class="col-md-4 col-form-label text-md-end">{{ __('特記事項') }}</label>

                                            <div class="col-md-6">
                                                <textarea id="memo" type="text" class="form-control @error('memo') is-invalid @enderror" name="memo" value="{{ old('memo') }}" autocomplete="memo" autofocus></textarea>
                                               @error('memo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center">
                                            <div class="col-md-6 justify-content-center">
                                                <span id="reserve-next" class="btn btn-success px-5">{{ __('次へ') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reserve2">
                                        <div class="row mb-3 driver_form">
                                            <label class="col-md-2 col-form-label text-md-end">{{ __('船頭') }}</label>

                                            <div class="col-md-10 driver-wrapper">
                                                <ul class="d-flex flex-wrap driver-list">
                                                    @foreach ($all_drivers as $driver)
                                                        @if($driver->enable == 0)
                                                        <li class="driver-list__item m-3 plan_0 not-ava">
                                                        @elseif($driver->enable == 1)
                                                            @if ($driver->plan == 1)
                                                                <li class="driver-list__item plan_1 m-3">
                                                            @elseif($driver->plan == 0)
                                                                <li class="driver-list__item plan_2 m-3">
                                                            @endif
                                                        @endif
                                                            <input type="radio"  class="driver @error('driver') is-invalid @enderror" name="driver" value="{{ $driver->name }}" autocomplete="driver" autofocus>
                                                            <span>{{ $driver->name }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @error('driver')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3 pattern_form">
                                            <label for="pattern" class="col-md-2 col-form-label text-md-end">{{ __('パターン') }}</label>

                                            <div class="col-md-10">
                                                <select type="text" class="pattern form-control @error('pattern') is-invalid @enderror" name="pattern" value="{{ old('pattern') }}" autocomplete="pattern" autofocus>
                                                    <option value="" selected hidden>{{ __('選択してください') }}</option>
                                                    @foreach ($all_patterns as $pattern)
                                                        <option value="{{$pattern->pattern}}">{{$pattern->pattern}}</option>
                                                    @endforeach

                                                </select>

                                                @error('pattern')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {{-- <label for="user_id" class="col-md-4 col-form-label text-md-end">{{ __('user_id') }}</label> --}}

                                            <div class="col-md-10">
                                                <input id="user_id" type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{  Auth::user()->id }}"  autocomplete="user_id" autofocus>

                                                @error('user_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-2 col-form-label text-md-end"></label>

                                            <div class="col-md-10 d-flex">
                                                <span id="reserve-previous" class="btn btn-success px-5">{{ __('戻る') }}</span>
                                                <span id="reserve-confirm" class="btn btn-primary mx-2">
                                                    {{ __('確認') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reserve-confirm">
                                        <div class="row mb-3">
                                            <div class="col-md-10 justify-content-center">
                                                <table class="table">
                                                    <tr id="confirm-date">
                                                        <th>{{ __('日程') }}</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="confirm-plan">
                                                        <th>{{ __('プラン') }}</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="confirm-boat_num">
                                                        <th>{{ __('船数') }}</th>
                                                        <td></td>
                                                    </tr>

                                                    <tr id="confirm-place">
                                                        <th>{{ __('乗船場所') }}</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="confirm-price">
                                                        <th>{{ __('価格') }}</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="confirm-ships">
                                                        <th>{{ __('船頭') }}</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="confirm-memo">
                                                        <th>{{ __('特記事項') }}</th>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-10 d-flex">
                                                <span id="reserve-previous2" class="btn btn-success px-5">{{ __('戻る') }}</span>
                                                <span id="pre-reserve" class="btn btn-primary mx-2">
                                                    {{ __('予約') }}
                                                </span>
                                                <span id="wait-reserve" class="btn btn-primary mx-2">
                                                    {{ __('キャンセル待ち予約') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="reserve" name="reserve" class="d-none">

                                </button>
                                </form>
                            </div>
                </div>
            </div>
        </div>
    </div>
    @endguest
</div>
@endsection
