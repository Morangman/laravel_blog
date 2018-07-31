<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    a{
        text-decoration:none !important;
    }
    
    .sidenav {
        display: none;
        height: 100%;
        width: 250px;
        position: fixed;
        z-index: 1;
        top: 55px;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0px;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }
    
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width: 100%;
        height: auto;
    }
    
    .post_text{
        margin-top: 30px;
        margin-bottom: 30px;
    }

    @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
    }
    
    @media screen and (min-width: 450px) {
      #go-top {right: 45%; bottom: 5px;}
    }
    
    @media screen and (max-width: 550px) {
      h1 {text-align: left; font-size: 16px!important;}
    }

    #go-top {
        position: fixed; 
        bottom: 25px; 
        right: 35px;
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
    
    .nav-link {
        font-size: 11px;
        font-weight: bold;
        color: rgb(68,68,68);

        user-select: none;
        padding: .2em 1.2em;
        outline: none;
        border: 1px solid rgba(0,0,0,.1);
        border-radius: 2px;
        background: rgb(245,245,245) linear-gradient(#f4f4f4, #f1f1f1);
        transition: all .218s ease 0s;
    }
    
    .nav-link:hover {
      color: rgb(24,24,24);
      border: 1px solid rgb(198,198,198);
      background: #f7f7f7 linear-gradient(#f7f7f7, #f1f1f1);
      box-shadow: 0 1px 2px rgba(0,0,0,.1);
    }
    
    .nav-link:active {
      color: rgb(51,51,51);
      border: 1px solid rgb(204,204,204);
      background: rgb(238,238,238) linear-gradient(rgb(238,238,238), rgb(224,224,224));
      box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
    }
    
    #btn_add_comment{
        width:100px; 
        margin: -20px -50px; 
        margin-bottom: 35px;
        position:relative;
        top:50%; 
        left:50%;
    }
    
    #btn_edit_comment{
        margin-left: 10px;
    }

    .author-image{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        float: left;
        margin-right: 10px;
    }
    
    .comment{
        margin-bottom: 35px;
    }
    
    .created_at{
        font-size: 12px;
        font-style: italic;
        color: #aaa;
    }

    .comment-text{
        clear: both;
        margin-left: 60px;
        font-size: 16px;
        line-height: 1.3em;

    }

    .glyphicon-comment{
        margin-right: 15px;
    }
  

</style>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Future</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false" >
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    @if (Auth::user()->is_admin)
                    <span class="navbar-brand" style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776; ADMIN MENU</span>
                    @else
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Future
                    </a>
                    @endif
                </div> 

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        @if (Auth::user()->is_admin)
                                          <a href="{{ url('/dashboard') }}">Dashboard</a>
                                        @endif
                                        <a href="{{ url('/home') }}">Домой</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="/dashboard">Пользователи</a>
      <a href="/post">Посты</a>
      <a href="/add_post">Добавить пост</a>
      <a href="/add_tags">Добавить тег</a>
      <a href="/add_categories">Добавить категорию</a>
      <a href="/rate">Курсы валют</a>
      <a href="/home">Домой</a>
    </div>
    
@yield('content')
    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        $('div.alert').delay(3000).slideUp(300)
    </script>
    
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.display = "block";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.display = "none";
        }
    </script>

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
    
</body>
</html>