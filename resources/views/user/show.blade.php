@extends('layouts.main')
@section('title','たきや漁予約システム | User')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('会員情報') }}</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>{{ __('名前') }}</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('フリガナ') }}</th>
                            <td>{{$user->furigana}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('メールアドレス') }}</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('性別') }}</th>
                            <td>
                                @if($user->sex == 0)
                                        {{"男性"}}
                                @elseif($user->sex == 1)
                                        {{"女性"}}
                                @else
                                    {{"非選択"}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('年齢') }}</th>
                            <td>{{$user->old}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('郵便番号') }}</th>
                            <td>{{$user->code}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('住所') }}</th>
                            <td>{{$user->address}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('電話番号') }}</th>
                            <td>{{$user->tel}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('電話番号２') }}</th>
                            <td>{{$user->tel2}}</td>
                        </tr>
                        <tr>
                            <th>{{ __('設定') }}</th>
                            <td class="d-flex">
                                <a class="btn btn-primary px5" href="{{route('user.edit',$user)}}">{{ __('編集') }}</a>
                                <form  action="{{route('user.destroy',$user)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="btn btn-danger px-5 mx-5">{{ __('削除') }}</button>
                                </form>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
