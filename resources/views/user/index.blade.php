@extends('layouts.main')
@section('title','たきや漁予約システム | Users')
@section('content')
    <div class="card">
        <div class="card-header">{{ __('会員情報') }}</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>{{ __('名前') }}</th>
                        <th>{{ __('フリガナ') }}</th>
                        <th>{{ __('メールアドレス') }}</th>
                        <th>{{ __('性別') }}</th>
                        <th>{{ __('年齢') }}</th>
                        <th>{{ __('郵便番号') }}</th>
                        <th>{{ __('住所') }}</th>
                        <th>{{ __('電話番号') }}</th>
                        <th>{{ __('電話番号２') }}</th>
                        <th colspan="2">{{ __('設定') }}</th>
                    </tr>
                    @forelse ( $all_users as $user)
                    <tr>
                        <td><a href="{{route('user.show',$user)}}">{{$user->name}}</a></td>
                        <td>{{$user->furigana}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user->sex == 0)
                            {{ __('男性') }}
                            @elseif($user->sex == 1)
                            {{ __('女性') }}
                            @else
                            {{ __('非選択') }}
                            @endif
                        </td>
                        <td>{{$user->old}}</td>
                        <td>{{$user->code}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->tel}}</td>
                        <td>{{$user->tel2}}</td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('user.edit',$user)}}">{{ __('編集') }}</a>
                        </td>
                        <td>
                            <form  action="{{route('user.destroy',$user)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger px5">{{ __('削除') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    {{ __('会員はいません') }}
                    @endforelse
                </table>
                {{  $all_users->links() }}
            </div>

        </div>
    </div>
@endsection
