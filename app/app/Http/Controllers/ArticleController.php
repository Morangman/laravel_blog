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
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        return view('/welcome', compact('posts'));
    }
    
        //отображение постов на домашней странице
    public function show_posts_home() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        $tags = Tag::all();
        $categories = Category::all();
        return view('/home', compact('posts', 'tags', 'categories')); 
    }

    //вывод информации о посте при изменении данных
    public function show_info(int $id){
        $post = Post::where('id',$id)->first();
        $categories = Category::all();
        $tags = Tag::all();
        return view('update_post', compact('post', 'categories', 'tags'));
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
    public function update_info(int $id, UpdateArticleRequest $request){
        $post = Post::where('id',$id)->first();
        $post->title = $request->input('title');
        $post->text = $request->input('text');
        if($request->hasFile('image')){
            $oldFile = $post->src;
            unlink(public_path().$oldFile);
            $file = $request->file('image');
            $file_name = md5_file($file).'.'.$file->getClientOriginalExtension();
            $file->move(public_path() . '/img', $file_name);
            $post->src = str_replace("\\", "/", '\img'.'\\'. $file_name);
        }
        $post->category_id = $request->input('category');
        $tags = $request->input('tags', []);
        if (isset ($request->tags)){
            $post->tag()->sync($tags, true);
        }else{
            $post->tag()->sync(array());
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
        $image = $post->src;
        $result = public_path().$image;
        $file = fopen($result, "w");
        fclose($file);
        unlink(public_path().$image);
        $post->delete();
        \Session::flash('delete_post_message', 'Пост был успешно удален!');
        return redirect ('/post');
   }
   
    private function postLikeDislikePost(Request $request, bool $is_like)
    {
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        if (!$post) {
                return json_encode([
                    'status' => 'error',
                    'msg' => 'Post not found'
                ]);
        }
        $user = \Auth::user();
        $like_record = $user->likes()
                ->where('post_id', $post_id)
                ->where('like', (($is_like)? 1:0))
                ->first();
        if ($like_record) {
            if(!$like_record->delete()){
                return json_encode([
                    'status' => 'error',
                    'msg' => 'Fail to delete'
                ]);
            } else {
                return json_encode([
                    'status' => 'ok',
                    'msg' => (($is_like)? "Лайк":"Дизлайк").' удален',
                    'likes' => $post->likes->sum('like'),
                    'dislikes' => $post->likes->where('like',0)->count()
                ]);
            }
        } else {
            $not_like = $user->likes()
                    ->where('post_id', $post_id)
                    ->where('like', (($is_like)? 0:1))
                    ->first();
            if ($not_like){
                $not_like->like = (($is_like)? 1:0);
                $not_like->update();
            } else {
                $new_like = new Like();
                $new_like->like = (($is_like)? 1:0);
                $new_like->user_id = $user->id;
                $new_like->post_id = $post->id;
                $new_like->save();
            }

            return json_encode([
                'status' => 'ok',
                'msg' => (($is_like)? "Лайк":"Дизлайк").' учтен',
                'likes' => $post->likes->sum('like'),
                'dislikes' => $post->likes->where('like',0)->count()
            ]);
        } 

    }
    
    public function postLikePost(Request $request)
    {
        return $this->postLikeDislikePost($request, true);
    }

    public function postDislikePost(Request $request)
    {
        return $this->postLikeDislikePost($request, false);
    }
}
