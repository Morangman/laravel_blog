@extends('layouts.header')

@section('content')

<div class="row">
     <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Добавление категорий</div></br>
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
      <th>#</th>
      <th>Name</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($categories as $category)
    <tr>
      <td>{{$category->id}}</td>
      <td>{{$category->name}}</td>
      <td>
            <form method="post" action="/add_categories/{{ $category->id }}">
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