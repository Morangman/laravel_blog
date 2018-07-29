<html>
<head>
<title>Ответ на комментарий</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
</head>
<body>
    
<div class="row">
     <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Ответ на комментарий</div></br>
            <form method="post" action="/reply_to_comment/{{ $comment->id }}">
            <label>Автор: </label>
            <input type="text" class="form-control"  value="{{$comment->name}}" disabled>

            <label>Почта: </label>  
            <input type="text" class="form-control"  value="{{$comment->email}}" disabled>
            
            <label>Комментарий: </label>
            <textarea class="form-control" name="comment" rows="10" id="text" disabled>{{$comment->comment}}</textarea>
            
            <div class="row">
                <div id="comment-form" class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <form method="post" action="/show_post/{{$comment->post->id}}" enctype="multipart/form-data">
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
            
            <p class="text-center"><a href="/show_post/{{$comment->post->id}}" >Отмена</a></p>
        </div>
     </div>
</div>


</body>
</html>