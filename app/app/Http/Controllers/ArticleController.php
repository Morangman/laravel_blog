<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Tag;
use App\Like;
use App\Dislike;
use App\Category;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    private $aComments;
    
    //отображение формы добавления нового поста
    public function index(){
        $tags = Tag::all();
        $categories = Category::all();
        return view('add_post', compact('tags','categories'));
    }
    

    //вывод всех постов
    public function show_posts(){
        $posts = Post::all();
        $users = User::all();
        return view('post', compact('posts','users'));
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
    
    private function collectComments($comments,$depth){
        if($depth === 0){
            $this->aComments = [];
        }
        foreach($comments as $c){
            array_push($this->aComments,[$c,$depth]);
            $this->collectComments($c->children()->get(),$depth+1);
        }
        
    }
    
    public function show_post_by_id(int $id){
        $post = Post::where('id',$id)->first();
        $this->collectComments($post->comment()->where('parent_id',null)->get(),0);
        $all_comments = $this->aComments;
        return view('show_post', compact('post','all_comments'));
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
   
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = \Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        $dislike = $user->dislikes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $already_dis_like = $dislike->dislike;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
            if ($already_dis_like == true) {
                $dislike->delete();
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }
    
    public function postDisLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_dis_like = $request['isDisLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = \Auth::user();
        $dislike = $user->dislikes()->where('post_id', $post_id)->first();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($dislike) {
            $already_dis_like = $dislike->dislike;
            $already_like = $like->like;
            $update = true;
            if ($already_dis_like == $is_dis_like) {
                $dislike->delete();
                return null;
            }
            if ($already_like == true) {
                $like->delete();
            }
        } else {
            $dislike = new Dislike();
        }
        $dislike->dislike = $is_dis_like;
        $dislike->user_id = $user->id;
        $dislike->post_id = $post->id;
        
        if ($update) {
            $dislike->update();
        } else {
            $dislike->save();
        }
        return null;
    }
}
