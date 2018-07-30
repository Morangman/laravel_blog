<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\EditCommentRequest;
use App\Http\Requests\ReplyRequest;
use App\Comment;
use App\Post;
use Carbon\Carbon;

class CommentController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth', ['execept' => 'store']); //только зарег. пользователи могут комментировать
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $comment = Comment::where('id', $id)->first();
        return view('edit_comment', compact('comment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    //добавление нового комментария
    public function store(AddCommentRequest $request, int $id) 
    {
        $post = Post::find($id);
        
        $comment = new Comment();
        $comment->name = \Auth::user()->name;
        $comment->email = \Auth::user()->email;
        $comment->comment = $request->input('comment');
        $comment->approved = true;
        $comment->post()->associate($post);
        
        $comment->save();
        return redirect ('/show_post/'.$post->id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::where('id', $id)->first();
        return view('reply_to_comment', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    //редактирование выбранного коммент
    public function edit(EditCommentRequest $request, $id)
    {
        $comment = Comment::where('id',$id)->first();
        $post_id = $comment->post->id;
        $comment->comment = $request->input('comment');
        $comment->updated_at = Carbon::now();
        $comment->save();
        
        return redirect ('/show_post/'.$post_id);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyRequest $request, $id)
    {
        $parent_comment = Comment::find($id);
        $comment_id = $parent_comment->id;
        
        $id_post = $parent_comment->post->id;
        $post = Post::find($id_post);
        
        $comment = new Comment();
        $comment->name = \Auth::user()->name;
        $comment->email = \Auth::user()->email;
        $comment->comment = $request->input('comment');
        $comment->approved = true;
        $comment->parent_id = $comment_id;
        $comment->parent()->associate($parent_comment);
        $comment->post()->associate($post);
        
        $comment->save();
        return redirect ('/show_post/'.$id_post);
    }

    private function destroy_cascade($children){
        foreach($children as $c){
            if (count($c->children()->get())>0){
                $this->destroy_cascade($c->children()->get());
            }
            $c->delete();
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    //уничтожение выбранного коммента
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $post_id = $comment->post->id;
        $this->destroy_cascade($comment->children()->get());
        $comment->delete();
        return redirect ('/show_post/'.$post_id);
    }
}
