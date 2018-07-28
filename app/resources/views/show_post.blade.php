@extends('layouts.header')

@section('content')

<div class="container">
    <div class="row">
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
        <p>Автор: {{$post->user->name}}</p>
        <p><a href="/home">Домой</a></p>
    </div> 
</div>

@endsection

