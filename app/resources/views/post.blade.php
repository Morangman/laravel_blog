@extends('layouts.header')

@section('content')

    <div class="container">
        @if (Session::has('delete_post_message'))
                <div class="alert alert-success" >{{Session::get('delete_post_message')}}</div>
        @endif
        
        @if (Session::has('save_post'))
                <div class="alert alert-success" >{{Session::get('save_post')}}</div>
        @endif
        
        @if (Session::has('save_message'))
                <div class="alert alert-success" >{{Session::get('save_message')}}</div>
        @endif
        
        <div class="panel panel-primary">
          <div class="panel-heading">Посты</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Автор</th>
                        <th>Заголовок</th>
                        <th>Пост</th>
                        <th>Фото</th>
                        <th>Категория</th>
                        <th>Теги</th>
                        <th>Создан</th>
                        <th>Обновлен</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->user->name}}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ str_limit($post->text, 20)}}</td>
                                <td><a href="{{ $post->src }}" target="_blank">{{ str_limit($post->src, 12) }}</a></td>
                                <td>{{$post->category->name}}</td>
                                <td>
                                @foreach($post->tag as $tags)
                                    {{$str = $tags->name.';'}}
                                @endforeach
                                </td>
                                <td>{{ $post->created_at->format('d.m.Y | H:i:s') }}</td>
                                <td>{{ $post->updated_at->format('d.m.Y | H:i:s') }}</td>

                                <td>
                                <form method="post" action="/update_post/{{ $post->id }}">
                                    {{ csrf_field() }}
                                    {{ method_field('GET') }}
                                    <button type="submit" class="btn btn-primary">Изменить</button>
                                </form>
                                </td>
                                
                                <td>
                                    <form method="post" action="/post/{{ $post->id }}">
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}

                                      <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Удалить
                                      </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>

@endsection
    