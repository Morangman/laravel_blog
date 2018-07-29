<html>
<head>
<title>Редактирование комментария</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
</head>
<body>
    
<div class="row">
     <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Редактирование комментария</div></br>
            <form method="post" action="/edit_comment/{{ $comment->id }}">
            <label>Автор: </label>
            <input type="text" class="form-control"  value="{{$comment->name}}" disabled>

            <label>Почта: </label>  
            <input type="text" class="form-control"  value="{{$comment->email}}" disabled>
            
            <label>Комментарий: </label>
            <textarea class="form-control" name="comment" rows="10" id="text">{{$comment->comment}}</textarea>
            <p class="text-danger">{{ $errors->first('comment') }}</p></br>
            
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <button type="submit" class="btn btn-primary form-control">Сохранить изменения</button></br>
            </form>
            
            <form method="post" action="/edit_comment/{{ $comment->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

            <button type="submit" class="btn btn-danger form-control">
                <i class="fa fa-btn fa-trash"></i>Удалить
            </button>
            </form>
            
            <p class="text-center"><a href="/show_post/{{$comment->post->id}}" >Отмена</a></p>
        </div>
     </div>
</div>


</body>
</html>