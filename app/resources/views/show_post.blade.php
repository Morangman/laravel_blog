@extends('layouts.header')

@section('content')

<div class="container">
    <div class="row">
        <div class="container">
            <p><a href="/home">Домой</a></p>
            <div class="row">
                <div class="col-md-12">
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
                </div>
            </div>
        </div>
        
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4><span class="glyphicon glyphicon-comment"></span>Комментарии: {{$post->comment->count()}}</h4></div>
                            <div class="panel-body row">
                                @foreach($all_comments as $comment)
                                @if($comment[1]>0)
                                <div class="col-xs-1">
                                    <span>{{((count($comment[0]->parent()->get())>0)? '-&gt; #'.$comment[0]->parent()->get()->first()->id:'')}}</span>
                                    <span>[Level {{$comment[1]}}]</span>
                                </div>
                                @endif
                                @if($comment[1]===0)
                                <div class="col-xs-12 comment">
                                @else
                                <div class="col-xs-{{(($comment[1]<6)? 12-$comment[1]: 6)}} col-xs-offset-{{(($comment[1]<6)? $comment[1]-1: 5)}} comment">
                                @endif
                                    <div class="author-info">
                                        <img src="{{"https://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment[0]->email ))) . "?s=50&d=identicon" }}" class="author-image">
                                        <div class="author-name">
                                            <h4>{{$comment[0]->name}} @if(Auth::user()->is_admin)<a href="/edit_comment/{{$comment[0]->id}}"><span class="glyphicon glyphicon-edit"></span></a>@endif <a href="/reply_to_comment/{{$comment[0]->id}}">Ответить</a></h4>
                                            <p class="created_at">{{$comment[0]->created_at->format('d.m.Y в H:i:s')}} </p>
                                        </div>
                                    </div>
                                    <div class="comment-text">
                                        <p>{{$comment[0]->comment}}</p>
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
                        
                        <label for="comment">Комментарий:</label>
                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                        <p class="text-danger">{{ $errors->first('comment') }}</p></br>
                        <button type="submit" id="btn_add_comment" class="btn btn-secondary col-md-12">Отправить</button></br>
                    </form>
                </div>
            </div>
        </div>

    </div> 
</div>

@endsection

