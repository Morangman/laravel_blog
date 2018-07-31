@extends('layouts.header')

@section('content')

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Добавление тега</div></br>
            <form method="post">
            <label>Название: </label>
            <input type="text" name="name" class="form-control" ></br>
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <button type="submit" class="btn btn-primary form-control">Добавить</button></br>
            </form></br>
            <p class="text-center"><a href="/dashboard" >Назад</a></p>
        </div>
    </div>
</div>
<table class="table table-hover">
    <thead>
      <tr>
        <th>id</th>
        <th>Name</th>
        <th>Posts</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tags as $tag)
      <tr>
        <td>{{$tag->id}}</td>
        <td>{{$tag->name}}</td>
        <td>
        @foreach ($tag->posts as $posts)
        <p><a href="/show_post/{{ $posts->id }}">{{$posts->title}}</a></p>
        @endforeach
        </td>
        <td>
            <form method="post" action="/add_tags/{{ $tag->id }}">
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
    
@endsection