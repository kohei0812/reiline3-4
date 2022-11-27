@extends('layouts.app')
@section('title','たきや漁予約システム |Edit Waiging')
@section('content')
<h1 class="text-center">{{ __('船数編集') }}</h1>
@php
$user = $waiting->user_id;
@endphp

<div class="container d-flex flex-column justify-content-center align-items-center">
    @foreach ($waiting->reserves as $reserve)
    <div class="card w-75 mt-3 py-3 each_ship">

        <div class="driver_wrapper row mb-3">
            <label class="col-md-4 col-form-label text-md-end"></label>

            <div class="col-md-2">

            </div>
            <div class="col-md-2">
                {{-- <span class="wait_ship_del btn btn-danger">
                    {{ __('Delete') }}
                </span> --}}
                <form  action="{{route('reserve.shipDel')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$reserve->id}}" required autocomplete="id" autofocus>
                    <input id="date" type="hidden" class="form-control @error('date') is-invalid @enderror" name="date" value="{{$reserve->date}}" required autocomplete="date" autofocus>
                    <input id="plan" type="hidden" class="form-control @error('plan') is-invalid @enderror" name="plan" value="{{ $reserve->plan}}" required autocomplete="plan" autofocus>
                    <input id="user_id" type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ $reserve->user_id}}" required autocomplete="user_id" autofocus>
                    <button type="submit" class="btn btn-danger px5">{{ __('削除') }}</button>
                </form>
            </div>
        </div>

        <div class="pattern_wrapper row mb-3">
            <label class="col-md-4 col-form-label text-md-end">{{ __('パターン') }}</label>
            <div class="col-md-4">
                <select type="text" class="pattern form-control @error('pattern') is-invalid @enderror" name="pattern" value="{{$reserve->pattern}}" required autocomplete="pattern" autofocus>
                    <option value="" selected hidden>{{$reserve->pattern}}</option>
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
            <div class="col-md-4">

                <span class="pattern_edit btn btn-primary">
                    {{ __('編集') }}
                </span>
            </div>
        </div>
        <input class="reserve_id" type="hidden" value="{{$reserve->id}}">
    </div>
    @endforeach
    <div class="my-3 text-center d-flex">
        <a href="{{ route('user.reserve',$user) }}" class="btn btn-warning">{{ __('戻る') }}</a>
        <span id="ship_add" class="btn btn-success mx-3">{{ __('船追加') }}</span>
    </div>
</div>
<div class="reserve-modal">
    <div class="container reserve-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('予約') }}<span class="ship-modal-close">✕</span></div>
                            <div class="card-body reserves">
                                <form method="POST" action="{{ route('reserve.determine') }}">
                                    @csrf
                                <div class="reserve-wrapper">
                                    <div class="reserve1 addship_0 active">
                                        <input id="date" type="hidden" class="form-control @error('date') is-invalid @enderror" name="date" value="{{$waiting->date}}" required autocomplete="date" autofocus>
                                        <input id="plan" type="hidden" class="form-control @error('plan') is-invalid @enderror" name="plan" value="{{ $waiting->plan}}" required autocomplete="plan" autofocus>

                                        <div id ="def_boat-num"class="d-none">{{ $waiting->boat_num }}</div>
                                        <div class="row mb-3">
                                            <label for="boat_num" class="col-md-4 col-form-label text-md-end">{{ __('boat_num') }}</label>

                                            <div class="col-md-6">
                                                <input id="boat_num" type="number" class="form-control @error('date') is-invalid @enderror" name="boat_num" value="{{ $waiting->boat_num }}" required autocomplete="boat_num" autofocus>

                                                @error('boat_num')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <input id="place" type="hidden" class="form-control @error('place') is-invalid @enderror" name="place" value="{{ $waiting->place}}" required autocomplete="place" autofocus>
                                        <input id="price" type="hidden" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $waiting->price}}" required autocomplete="price" autofocus>
                                        <input id="memo" type="hidden" class="form-control @error('memo') is-invalid @enderror" name="memo" value="{{ $waiting->memo}}" autocomplete="memo" autofocus>
                                        <div class="row mb-3 justify-content-center">
                                            <div class="col-md-6 justify-content-center">
                                                <span id="wait-ship_add-next" class="btn btn-success px-5">{{ __('次へ') }}</span>
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
                                        <input id="user_id" type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{  $waiting->user->id }}"  autocomplete="user_id" autofocus>

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
                                                <span id="wait_add_ship" class="btn btn-primary mx-2">
                                                    {{ __('予約') }}
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="editShip">


                                        <div class="row mb-3">
                                            <label class="col-md-2 col-form-label text-md-end"></label>

                                            <div class="col-md-10 d-flex">
                                                <span id="editShip-previous" class="btn btn-success px-5">{{ __('戻る') }}</span>
                                                <span id="editShip-edit" class="btn btn-primary mx-2">
                                                    {{ __('編集') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="reserve" name="wait_ship_add" class="d-none">

                                </button>
                                </form>
                            </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
