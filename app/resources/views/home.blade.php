@extends('layouts.header')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Категории 
                @if (Auth::user()->is_admin)
                <a href="/add_categories"><span class="glyphicon glyphicon-plus"></span></a>
                @endif
            </div>
                <div class="panel-body">
                    <nav class="nav">
                      @foreach($categories as $category)
                      <a class="nav-link" href="/show_to_category/{{$category->id}}">{{$category->name}}</a>
                      @endforeach
                    </nav>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="content_posts">
                        @foreach($posts as $post)

                            <div class="card bg-dark text-white">
                                    <p><a href="/show_post/{{ $post->id }}"><h1>{{$post->title}}  @if (Auth::user()->is_admin)<a href="/update_post/{{ $post->id }}"><span class="glyphicon glyphicon-pencil"></span></a>@endif</h1></a></p>
                                <a href="/show_post/{{ $post->id }}"><img  src="{{$post->src}}" alt="Card image"></a>
                              <div class="card-img-overlay">
                                  <p class="card-text">{!! str_limit($post->text, 221) !!}</p></br>
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
                                <p class="card-text">Создано: {{$post->created_at->format('d.m.Y | H:i:s')}}</p>
                                <p class="card-text">Категория: <a href="/show_to_category/{{$post->category->id}}">{{$post->category->name}}</a></p>
                                <p class="card-text">Автор: {{$post->user->name}}</p>
                              </div>
                            </div></br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
