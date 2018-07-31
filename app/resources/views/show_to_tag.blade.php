@extends('layouts.header')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    ../ <a href="/home">Домой</a> / {{$tags->name}}
                </div>

                <div class="panel-body">
                    <div class="content_posts">
                        @foreach ($tags->posts as $posts)
                        <p><a href="/show_post/{{$posts->id}}"><h1>{{$posts->title}}</h1></a></p>
                        <p>{!! str_limit($posts->text, 64) !!}</p><hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection