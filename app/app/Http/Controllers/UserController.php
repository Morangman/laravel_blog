<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    //вывод всех пользователей
    public function show_users(){
        $users = User::all();
        return view('dashboard', compact('users'));
    }
    
    //вывод информации о пользователе при изменении данных
    public function show_info(int $id){
        $user = User::where('id',$id)->first();
        return view('update', compact('user'));
    }
    
    //обновление данных о пользователе
    public function update_info(int $id, UpdateUserRequest $request){
        $user = User::where('id',$id)->first();
        $user->name = $request->input('name');
        $user->is_admin = $request->input('role');
        $user->updated_at = Carbon::now();
        $user->save();
        \Session::flash('save_message', 'Пользователь был успешно изменен!');
        return redirect ('dashboard');
    }
    
    //удаление пользователя
   public function destroy($id)
   {
        $user = User::find($id);
        $name = $user->name;
        $user->delete();
        \Session::flash('delete_message', 'Пользователь '.$name.' был успешно удален!');
        return redirect ('dashboard');
   }
}
