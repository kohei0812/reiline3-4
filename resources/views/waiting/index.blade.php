@extends('layouts.main')
@section('title','たきや漁予約システム | Reserves')
@section('content')
    <div class="card">
        <div class="card-header">{{ __('キャンセル待ち予約一覧') }}</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>{{ __('日程') }}</th>
                        <th>{{ __('プラン') }}</th>
                        <th>{{ __('パターン') }}</th>
                        <th>{{ __('乗船場所') }}</th>
                        <th>{{ __('価格') }}</th>
                        <th>{{ __('特記事項') }}</th>
                        <th>{{ __('名前') }}</th>
                        <th>{{ __('船数') }}</th>
                        <th>{{ __('予約ステータス') }}</th>
                        <th>{{ __('予約登録日時') }}</th>
                        <th colspan="2">{{ __('設定') }}</th>
                    </tr>
                    @forelse ( $all_reserves as $reserve)
                    <tr>
                        <td>{{$reserve->date}}</td>
                        <td>{{$reserve->plan}}</td>
                        <td>{{$reserve->pattern}}</td>
                        <td>{{$reserve->place}}</td>
                        <td>{{$reserve->price}}</td>
                        <td>{{$reserve->memo}}</td>
                        <td>{{$reserve->user->name}}</td>
                        <td>{{$reserve->boat_num}}</td>
                        <td>
                            @if($reserve->status == 1)
                            {{ __('予約') }}
                            @elseif($reserve->status == 2)
                            {{ __('キャンセル待ち') }}
                            @else
                            {{ __('削除') }}
                            @endif
                        </td>
                        <td>{{$reserve->created_at}}</td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('reserve.edit',$reserve)}}">{{ __('編集') }}</a>
                        </td>
                        <td>
                            <form  action="{{route('reserve.destroy',$reserve)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger px5">{{ __('削除') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    {{ __('予約はありません') }}
                    @endforelse
                </table>
                {{  $all_reserves->links() }}
            </div>

        </div>
    </div>
@endsection
