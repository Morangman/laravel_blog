@extends('layouts.header')

@section('content')

<div class="container">
    <div class="row">
    <p><a href="/home">Домой</a></p>
    <h1>{{$post->title}}</h1>
    <img  src="{{$post->src}}">
    <p>{!! $post->text !!}</p></br>
            <div>
            @foreach ($post->tag as $tags)
                <form method="post" action="/show_to_tag/{{ $tags->id }}">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    <ul style="float: left; margin-left: 0;  padding-left: 5px;">
                        <li style="float: right; list-style-type: none; "><button type="submit" class="btn btn-secondary btn-xs">#{{$tags->name}}</button></li>
                    </ul>
                </form>
            @endforeach
            </div></br></br>
        <p>Создано: {{$post->created_at->format('d.m.Y | H:i:s')}}</p>
        <p class="card-text">Категория: <a href="/show_to_category/{{$post->category->id}}">{{$post->category->name}}</a></p>
        <p>Автор: {{$post->user->name}}</p></br>
        
        
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Комментарии {{$post->comment->count()}}</div>
                    <div class="panel-body">
                        @foreach($post->comment as $comment)
                        <div class="comment">
                            <div class="author-info">
                            <span class="glyphicon glyphicon-user"></span>
                                <div class="author-name">
                                    <h4>{{$comment->name}}</h4>
                                    <p class="created_at">{{$comment->created_at->format('d.m.Y в H:i:s')}}</p>
                                </div>
                            </div>
                            <div class="comment-text">
                                <p>{{$comment->comment}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>
        
        
        <div class="row">
            <div id="comment-form" class="col-md-8 col-md-offset-2">
                <div class="row">
                    <form method="post" action="/show_post/{{$post->id}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="col-md-6">
                            <label for="comment">Имя:</label>
                            <input type="text" name="name" class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <label for="comment">Почта:</label>
                            <input type="text" name="email" class="form-control" ></br>
                        </div>
                        <div class="col-md-12">
                        <label for="comment">Комментарий:</label>
                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea></br>
                        <button style="margin-top: 7px; margin-bottom: 25px;" type="submit" class="btn btn-secondary pull-right">Отправить</button></br>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div> 
</div>

@endsection

