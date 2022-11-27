@extends('layouts.main')
@section('title','たきや漁予約システム | Users')
@section('content')
    <div class="card">
        <div class="card-header">{{ __('Users') }}</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Furigana</th>
                        <th>Email</th>
                        <th>Sex</th>
                        <th>Old</th>
                        <th>code</th>
                        <th>address</th>
                        <th>tel</th>
                        <th>tel2</th>
                        <th colspan="2">Setting</th>
                    </tr>
                    @forelse ( $all_users as $user)
                    <tr>
                        <td><a href="{{route('user.show',$user)}}">{{$user->name}}</a></td>
                        <td>{{$user->furigana}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user->sex == 0)
                                    {{"male"}}
                            @elseif($user->sex == 1)
                                    {{"female"}}
                            @else
                                {{"not chosen"}}
                            @endif
                        </td>
                        <td>{{$user->old}}</td>
                        <td>{{$user->code}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->tel}}</td>
                        <td>{{$user->tel2}}</td>
                        <td>
                            <a class="btn btn-primary px5" href="{{route('user.edit',$user)}}">edit</a>
                        </td>
                        <td>
                            <form  action="{{route('user.destroy',$user)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger px5">delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    No users so far
                    @endforelse
                </table>
                {{  $all_users->links() }}
            </div>

        </div>
    </div>
@endsection
