@extends('layouts.main')
@section('title','たきや漁予約システム | Reserves')
@section('content')
    <div class="card">
        <div class="card-header">{{ __('Reserves') }}</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Date</th>
                        <th>Plan</th>
                        <th>Pattern</th>
                        <th>Place</th>
                        <th>Price</th>
                        <th>Memo</th>
                        <th>User</th>
                        <th>Boat_num</th>
                        <th>Status</th>
                        <th>Created_at</th>
                        <th colspan="2">Setting</th>
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
                                    {{"Reserved"}}
                            @elseif($reserve->status == 2)
                                    {{"Waiting"}}
                            @else
                                {{"Delete it"}}
                            @endif
                        </td>
                        <td>{{$reserve->created_at}}</td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('reserve.edit',$reserve)}}">edit</a>
                        </td>
                        <td>
                            <form  action="{{route('reserve.destroy',$reserve)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger px5">delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    No reserves so far
                    @endforelse
                </table>
                {{  $all_reserves->links() }}
            </div>

        </div>
    </div>
@endsection
