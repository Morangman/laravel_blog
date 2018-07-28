<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    
    public function index()
    {
        return view('/add_tags');
    }
    
    public function show()
    {
        $tags = Tag::all();
        return view('add_tags', compact('tags'));
    }
    
    public function show_tag_by_id(int $id){
        $tags = Tag::where('id',$id)->first();
        return view('show_to_tag', compact('tags'));
    }
    
    //добавление нового тега
    public function add_tag(Request $request){
        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->save();
        \Session::flash('new_tag', 'Тег был успешно добавлен!');
        return redirect ('add_tags');
    }
    
   public function destroy($id)
   {
        $tag = Tag::find($id);
        $tag->delete();
        return redirect ('/add_tags');
   }
}
