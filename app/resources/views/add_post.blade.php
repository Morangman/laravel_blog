<html>
<head>
	<title>Добавление нового поста</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">
  
</head>
<body>
<div class="row">
     <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Добавление поста</div></br>
            <form method="post" action="/add_post" enctype="multipart/form-data">
            <label>Заголовок: </label>
            <input type="text" name="title" class="form-control" >
            <p class="text-danger">{{ $errors->first('title') }}</p></br>
            
            <label>Текст поста: </label>
            <textarea class="form-control" name="text" id="text"></textarea>
            <p class="text-danger">{{ $errors->first('text') }}</p></br>
            
            <label>Фото: </label>
            <input type="file" name="image">
            <p class="text-danger">{{ $errors->first('image') }}</p></br>
            
            <div>
            <label>Теги: </label>
            <select name="tags[]" class="selectpicker form-control form-control-lg" multiple>
                @foreach ($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>
            <p class="text-danger">{{ $errors->first('tags') }}</p></br>
            </div></br>
            
            <div>
            <label>Категории: </label>
            <select name="category" class="form-control form-control-lg">
                <option value="">--выберете категорию--</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            <p class="text-danger">{{ $errors->first('category') }}</p></br>
            </div></br>
            
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <button type="submit" class="btn btn-primary form-control">Добавить</button></br>
            </form></br>

            <p class="text-center"><a href="post" >Отмена</a></p>
        </div>
     </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>

<script>
    $(document).ready(function() {
        $('#text').summernote({
            height: 300
        });

    });
</script>
</body>
</html>