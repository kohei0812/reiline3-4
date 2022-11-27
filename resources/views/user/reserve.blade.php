@php
use Carbon\Carbon;
$dt1 = Carbon::now();
$reserve_num = 0;
@endphp
@extends('layouts.main')
@section('title','たきや漁予約システム | Reserves')
@section('content')
    <div class="card">
        <div class="card-header">{{ __('予約情報') }}</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>{{ __('日程') }}</th>
                        <th>{{ __('プラン') }}</th>
                        <th>{{ __('船数') }}</th>
                        <th>{{ __('パターン') }}</th>
                        <th>{{ __('船頭') }}</th>
                        <th>{{ __('乗船場所') }}</th>
                        <th>{{ __('価格') }}</th>
                        <th>{{ __('特記事項') }}</th>
                        <th>{{ __('予約登録日時') }}</th>
                        <th colspan="3">{{ __('設定') }}</th>
                    </tr>
                    @forelse ( $user->reserveLists as $reserveList)
                        @php
                        $dt2 = new Carbon($reserveList->date);
                        $reserve_num = 0;
                        @endphp
                        @if($dt2->gte($dt1) ==  true)
                    <tr>
                        <td>{{$reserveList->date}}</td>
                        <td>{{$reserveList->plan}}</td>
                        <td>{{$reserveList->boat_num}}</td>
                        <td>
                            @foreach ( $reserveList->reserves as $lists)
                           <p class="d-block">{{$lists->pattern}}</p>
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $reserveList->reserves as $lists)
                            <p class="d-block">{{$lists->driver}}</p>
                            @endforeach
                        </td>

                        <td>{{$reserveList->place}}</td>
                        <td>{{$reserveList->price}}</td>
                        <td>{{$reserveList->memo}}</td>
                        <td>{{$reserveList->created_at}}</td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('reserve.edit',$reserveList)}}">{{ __('編集') }}</a>
                        </td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('reserve.shipEdit',$reserveList)}}">{{ __('船数編集') }}</a>
                        </td>
                        <td>
                            <form  action="{{route('reserve.destroy',$reserveList)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger px5">{{ __('削除') }}</button>
                            </form>
                        </td>
                    </tr>
                        @php
                         $reserve_num ++;
                        @endphp
                        @endif
                        @empty
                        <tr>{{ __('予約はありません') }}</tr>
                    @endforelse
                    @if( $reserve_num == 0)
                    <tr>{{ __('予約はありません') }}</tr>
                    @endif
                </table>
                {{-- {{  $user->reserves->links() }} --}}
            </div>

        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">{{ __('キャンセル待ち') }}</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>{{ __('日程') }}</th>
                        <th>{{ __('プラン') }}</th>
                        <th>{{ __('船数') }}</th>
                        <th>{{ __('パターン') }}</th>
                        <th>{{ __('船頭') }}</th>
                        <th>{{ __('乗船場所') }}</th>
                        <th>{{ __('価格') }}</th>
                        <th>{{ __('特記事項') }}</th>
                        <th>{{ __('予約登録日時') }}</th>
                        <th colspan="3">{{ __('設定') }}</th>
                    </tr>
                    @forelse ( $user->waitings as $waiting)
                        @php
                        $dt2 = new Carbon($waiting->date);
                        $reserve_num = 0;
                        @endphp
                        @if($dt2->gte($dt1) ==  true)
                    <tr>
                        <td>{{$waiting->date}}</td>
                        <td>{{$waiting->plan}}</td>
                        <td>{{$waiting->boat_num}}</td>
                        <td>
                            @foreach ( $waiting->reserves as $lists)
                           <p class="d-block">{{$lists->pattern}}</p>
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $waiting->reserves as $lists)
                            <p class="d-block">{{$lists->driver}}</p>
                            @endforeach
                        </td>

                        <td>{{$waiting->place}}</td>
                        <td>{{$waiting->price}}</td>
                        <td>{{$waiting->memo}}</td>
                        <td>{{$waiting->created_at}}</td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('waiting.edit',$waiting)}}">{{ __('編集') }}</a>
                        </td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('waiting.shipEdit',$waiting)}}">{{ __('船数編集') }}</a>
                        </td>
                        <td>
                            <form  action="{{route('waiting.destroy',$waiting)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger px5">{{ __('削除') }}</button>
                            </form>
                        </td>
                    </tr>
                        @php
                         $reserve_num ++;
                        @endphp
                        @endif
                        @empty
                        <tr>{{ __('予約はありません') }}</tr>
                    @endforelse
                    @if( $reserve_num == 0)
                    <tr>{{ __('予約はありません') }}</tr>
                    @endif
                </table>
                {{-- {{  $user->reserves->links() }} --}}
            </div>

        </div>
    </div>
@endsection
