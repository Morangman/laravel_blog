<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('/add_categories');
    }
    
    public function show()
    {
        $categories = Category::all();
        return view('add_categories', compact('categories'));
    }
    
    public function show_add_post()
    {
        $categories = Category::all();
        return view('add_post', compact('categories'));
    }
    
    public function show_category_by_id(int $id){
        $categories = Category::where('id',$id)->first();
        return view('show_to_category', compact('categories'));
    }
    
    
    //добавление нового тега
    public function add_category(Request $request){
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        \Session::flash('new_category', 'Категория успешно добавлена!');
        return redirect ('add_categories');
    }
    
   public function destroy($id)
   {
        $category = Category::find($id);
        $category->delete();
        return redirect ('/add_categories');
   }
}
