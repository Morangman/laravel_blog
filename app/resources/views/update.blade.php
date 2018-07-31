<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Пользователи</div></br>
            <form method="post" action="/update/{{ $user->id }}">
                <label>Имя пользователя: </label>
                <input type="text" name="name" class="form-control"  value="{{$user->name}}">
                <p class="text-danger">{{ $errors->first('name') }}</p></br>

                <label>Роль: </label>
                <select name="role" class="form-control form-control-lg">
                  <option value="{{$user->is_admin}}">--выберете роль--</option>
                  <option value="1">Администратор</option>
                  <option value="0">Пользователь</option>
                </select></br>
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <button type="submit" class="btn btn-primary form-control">Сохранить</button>
            </form></br>
            
            <p class="text-center"><a href="/dashboard" >Отмена</a></p>
        </div>
    </div>
</div>