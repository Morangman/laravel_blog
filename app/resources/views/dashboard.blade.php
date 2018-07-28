@extends('layouts.header')

@section('content')

    <div class="container">
        @if (Session::has('delete_message'))
                <div class="alert alert-success" >{{Session::get('delete_message')}}</div>
        @endif
        @if (Session::has('save_message'))
                <div class="alert alert-success" >{{Session::get('save_message')}}</div>
        @endif
        <div class="panel panel-primary">
          <div class="panel-heading">Пользователи</div>
          <div class="panel-body">
              <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Создан</th>
                        <th>Обновлен</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)

                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>@if($user->is_admin) <p class="badge badge-pill badge-secondary">Администратор</p> @else Пользователь @endif</td>
                                <td>{{ $user->created_at->format('d.m.Y | H:i:s') }}</td>
                                <td>{{ $user->updated_at->format('d.m.Y | H:i:s') }}</td>

                                <td>
                                <form method="post" action="/update/{{ $user->id }}">
                                    {{ csrf_field() }}
                                    {{ method_field('GET') }}
                                    <button type="submit" class="btn btn-primary">Изменить</button>
                                </form>
                                </td>
                                
                                @if($user->id != 1)
                                  <td>
                                    <form method="post" action="/dashboard/{{ $user->id }}">
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}

                                      <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Удалить
                                      </button>
                                    </form>
                                  </td>
                                  @endif
                            </tr>

                        @endforeach
                    </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>

@endsection
    