<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Future</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
  
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 10vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }
            
            .content{
                margin: 12px;
            }
            
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                max-width: 100%;
                height: auto;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            
            #go-top {
              position: fixed; 
              bottom: 25px; 
              right: 70px;
              text-align: center;
              cursor:pointer; 
              display:none;
              width: 50px;
              height: 30px;
              background: #c0c0c0 url(http://alaev.info/wp-content/plugins/goupbutt/b-j-top.png) no-repeat 50% 11px;
              line-height: 30px;
              border-radius: 5px;
            }

            #go-top:hover {
              background-color: #3d6791;
            }
            
            @media screen and (max-width: 550px) {
              h1 {text-align: left; font-size: 16px!important;}
            }
            
            .post-info{
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-default">
                    <div class="content">
                        @foreach($posts as $post)

                            <div class="card bg-dark text-white">
                              <img  src="{{$post->src}}" alt="Card image">
                              <div class="post-info">
                                <h1>{{$post->title}}</h1>
                                @if (Auth::guest())
                                <p class="card-text">{!! str_limit($post->text, 221) !!}<a href="/login" >  Читать далее...</a></p>
                                @endif
                                @if (Auth::check())
                                <p class="card-text">{!! str_limit($post->text, 221) !!}<a href="/show_post/{{ $post->id }}" >  Читать далее...</a></p>
                                @endif
                                <p class="card-text">Создано: {{$post->created_at->format('d.m.Y | H:i:s')}}</p>
                                <p class="card-text">Категория: {{$post->category->name}}</p>
                                <p class="card-text">Автор: {{$post->user->name}}</p>
                              </div>
                            </div></br>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
        <script>
            $(document).ready(function(){
              $('body').append('<a href="#" id="go-top" title="Вверх"></a>');
            });

            $(function() {
             $.fn.scrollToTop = function() {
              $(this).hide().removeAttr("href");
              if ($(window).scrollTop() >= "250") $(this).fadeIn("slow")
              var scrollDiv = $(this);
              $(window).scroll(function() {
               if ($(window).scrollTop() <= "250") $(scrollDiv).fadeOut("slow")
               else $(scrollDiv).fadeIn("slow")
              });
              $(this).click(function() {
               $("html, body").animate({scrollTop: 0}, "slow")
              })
             }
            });

            $(function() {
             $("#go-top").scrollToTop();
            });
        </script>
</html>
