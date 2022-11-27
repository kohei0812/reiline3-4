@extends('layouts.main')
@section('title','たきや漁予約システム | User')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('User Information') }}</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>Furigana</th>
                            <td>{{$user->furigana}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th>Sex</th>
                            <td>
                                @if($user->sex == 0)
                                        {{"male"}}
                                @elseif($user->sex == 1)
                                        {{"female"}}
                                @else
                                    {{"not chosen"}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Old</th>
                            <td>{{$user->old}}</td>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <td>{{$user->code}}</td>
                        </tr>
                        <tr>
                            <th>Adress</th>
                            <td>{{$user->address}}</td>
                        </tr>
                        <tr>
                            <th>Tel</th>
                            <td>{{$user->tel}}</td>
                        </tr>
                        <tr>
                            <th>Tel2</th>
                            <td>{{$user->tel2}}</td>
                        </tr>
                        <tr>
                            <th>Setting</th>
                            <td class="d-flex">
                                <a class="btn btn-primary px5" href="{{route('user.edit',$user)}}">edit</a>
                                <form  action="{{route('user.destroy',$user)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="btn btn-danger px-5 mx-5">delete</button>
                                </form>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
