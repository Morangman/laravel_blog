<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Tag;
use App\Category;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    
    //отображение формы добавления нового поста
    public function index(){
        $tags = Tag::all();
        $categories = Category::all();
        return view('add_post', compact('tags'), compact('categories'));
    }
    

    //вывод всех постов
    public function show_posts(){
        $posts = Post::all();
        $users = User::all();
        return view('post', compact('posts'), compact('users'));
    }
    //отображение постов на начальной странице
    public function show_posts_welcome(){
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('/welcome', compact('posts'));
    }
    
        //отображение постов на домашней странице
    public function show_posts_home() {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $tags = Tag::all();
        $categories = Category::all();
        return view('/home', compact('posts', 'tags', 'categories')); 
    }

    //вывод информации о посте при изменении данных
    public function show_info(int $id){
        $post = Post::where('id',$id)->first();
        $categories = Category::all();
        return view('update_post', compact('post'), compact('categories'));
    }
    
    public function show_post_by_id(int $id){
        $post = Post::where('id',$id)->first();
        return view('show_post', compact('post'));
    }
    
    
    //импорт данных в таблицу с новыми параметрами
    public function update_info(int $id, Request $request){
        $post = Post::where('id',$id)->first();
        $post->title = $request->input('title');
        $post->text = $request->input('text');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = md5_file($file).'.'.$file->getClientOriginalExtension();
            $file->move(public_path() . '/img', $file_name);
            $post->src = str_replace("\\", "/", '\img'.'\\'. $file_name);
            $oldImage = $post->src;
            Storage::delete($oldImage);
            $post->save();
        }
        $post->updated_at = Carbon::now();
        $post->save();
        \Session::flash('save_post', 'Пост был успешно изменен!');
        return redirect ('/post');
    }
    
    //добавление нового поста
    public function add_post(AddArticleRequest $request){
        $post = new Post();
        $post->title = $request->input('title');
        $post->user_id = \Auth::user()->id;
        $post->text = $request->input('text');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = md5_file($file).'.'.$file->getClientOriginalExtension();
            $file->move(public_path() . '/img', $file_name);
            $post->src = str_replace("\\", "/", '\img'.'\\'. $file_name);
        }
        $post->category_id = $request->input('category');
        $post->created_at = Carbon::now();
        $post->updated_at = Carbon::now();
        $post->save();
        
        $tags = $request->input('tags', []);
        if (isset ($request->tags)){
            $post->tag()->sync($tags, true);
        }else{
            $post->tag()->sync(array());
        }
        
        \Session::flash('save_message', 'Пост был успешно добавлен!');
        return redirect ('/post');
    }
    
    //удаление поста
   public function destroy($id)
   {
        $post = Post::find($id);
        $post->delete();
        \Session::flash('delete_post_message', 'Пост был успешно удален!');
        return redirect ('/post');
   }
}
