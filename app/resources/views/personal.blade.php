@extends('layouts.header')

@section('content') 

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Личный кабинет</div>
                <div class="user-info">
                    <img src="{{"https://www.gravatar.com/avatar/" 
                                . md5( strtolower( trim( Auth::user()->email ))) 
                                . "?s=50&d=identicon" }}" class="user-photo">
                    <div class="add_photo">
                        <label>Фото: </label>
                        <input type="file" name="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
