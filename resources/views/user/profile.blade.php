@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h4><a href="{{ route('home') }}" style="color:gray">Volver</a></h4>
        <div class="col-md-8">
            <div class='data-user'>               
                @if($user->image)
                <div class="profile-avatar">
                    <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" class="avatar"/>                
                </div>
                @endif
                
                <div class="user-info">
                    <h2>{{'@'.$user->nick}}</h2>
                    <h3>{{$user->name.' '.$user->surname}}</h3>
                    <p>{{'Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                </div>
                <hr>
            @foreach($user->images as $image)
                @include('includes.image', ['image' => $image])
            @endforeach
        </div>         
    </div>   
</div>
@endsection
