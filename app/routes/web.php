<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ArticleController@show_posts_welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@session');
Route::get('/home', 'ArticleController@show_posts_home');
Route::get('/show_to_tag/{tags}', 'TagController@show_tag_by_id')->name('show_tag_by_id');
Route::get('/show_to_category/{posts}', 'CategoryController@show_category_by_id')->name('show_category_by_id');

Route::get('/show_post/{post}', 'ArticleController@show_post_by_id')->name('show_post');
Route::post('/show_post/{post}', 'CommentController@store');

Route::get('/reply_to_comment/{id}', 'CommentController@show')->name('reply_to_comment');
Route::post('/reply_to_comment/{id}', 'CommentController@update');

Route::get('/example', 'HomeController@getUserAgentLanguage');



Route::group(['middleware' => 'auth', 'middleware' => 'access:admin'], function () {

  Route::get('/dashboard', 'AdminController@admin')->name('dashboard');
  Route::get('/dashboard', 'UserController@show_users')->name('dashboard');
  Route::get('/update/{user}', 'UserController@show_info')->name('update');
  Route::delete('/dashboard/{user}', 'UserController@destroy');
  Route::post('/update/{user}', 'UserController@update_info');
  
  Route::get('/post', 'AdminController@admin_post')->name('post');
  Route::get('/add_post', 'ArticleController@index')->name('add_post');

  Route::get('/post', 'ArticleController@show_posts')->name('post');
  Route::delete('/post/{post}', 'ArticleController@destroy');
  Route::post('/add_post', 'ArticleController@add_post');
  Route::get('/update_post/{post}', 'ArticleController@show_info')->name('update_post');
  Route::post('/update_post/{post}', 'ArticleController@update_info');
  
  Route::get('/rate', 'RateController@rate');
  
  Route::get('/add_tags', 'TagController@index')->name('add_tags');
  Route::post('/add_tags', 'TagController@add_tag');
  Route::get('/add_tags', 'TagController@show')->name('add_tags');
  Route::delete('/add_tags/{add_tags}', 'TagController@destroy');
  
  
  Route::get('/add_categories', 'CategoryController@index')->name('add_categories');
  Route::post('/add_categories', 'CategoryController@add_category');
  Route::get('/add_categories', 'CategoryController@show')->name('add_categories');
  Route::delete('/add_categories/{add_categories}', 'CategoryController@destroy');
  
  Route::post('/edit_comment/{id}', 'CommentController@edit');
  Route::get('/edit_comment/{id}', 'CommentController@create')->name('edit_comment');
  Route::delete('/edit_comment/{id}', 'CommentController@destroy');
  

});

//Route::get('/abc',  function () {
//    $a = $_GET['x'];
//    $b = $_GET['y'];     
//    $c = $a + $b;
//    echo ($c);
//});


