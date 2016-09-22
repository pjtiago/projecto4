<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Session;

class UsersController extends Controller
{
     /**
     * Display a listing of the users.
     *
     * @return void
     */
    public function index($id_user)
    {
        $user = User::findOrFail($id_user);
        
        if(Auth::id()==$id_user && $user->level == 1){
            $user = User::paginate(15);
            return view('listagem', compact('user'));
           
        }else{
            Auth::logout();
            return view('home');
        }
    }
    
    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        echo ($request->level);
        
        if ($request->level == '1'){
            $user->level = 1;
        
            echo ('sim');
        }else {
            $user->level = 0;
            echo ('nao');
        }
        
        $user->save();

        Session::flash('flash_message', 'User updated!');

        return redirect(Auth::id() . '/administration/');

    }
    
     /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id,Request $request)
    {
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('listagem');
    }
}
