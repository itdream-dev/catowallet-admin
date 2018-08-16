<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $query = $request->input('query');
        if($query == null)
          $query = '';
        $users = User::where('email', 'like', '%'.$query.'%')->paginate(50);
        return view('users', [
          'users' => $users,
          'search' => $query
        ]);
    }

    public function newUser()
    {
        return view('userEdit', [
            'user' => array('id'=>null, 'name'=>'', 'email'=>'', 'permission'=>0, 'course'=>null)
        ]);
    }

    public function editUser(Request $request, $id)
    {
        return view('userEdit', [
            'user' => User::findOrNew($id)
        ]);
    }

    public function postEdit(Request $request)
    {
        $user=[];
        if($request->input('id') != '') {
            $user = User::findOrNew($request->input('id'));
            if(!$request->input('name')) {
                $pos = stripos($request->input('email'),"@");
                $userName =  substr($request->input('email'), 0, $pos);
            } else {
                $userName = $request->input('name');
            }

            $user->name = $userName;

            if ($request->input('isResetPassword'))
            {
              Log::info($request->input('reset_password'));
              $user->password = bcrypt($request->input('reset_password'));
            }
            $user->save();

          } else {
            $exists = User::where('email', $request->input('email'))->get();
            if(sizeof($exists) > 0) {
              return Redirect::back()->withErrors("This email already used.");
            }
            $userName = "";

            if(!$request->input('name')) {
              $pos = stripos($request->input('email'),"@");
              $userName =  substr($request->input('email'), 0, $pos);
            } else {
              $userName = $request->input('name');
            }

            $user = User::create([
              'email' => $request->input('email'),
              'password' => bcrypt($request->input('password')),
              'name' => $userName,
            ]);
          }
          return redirect()->to('users');
    }

    public function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public function loginuser(Request $request, $id){
      $user = User::where('id', $id)->first();
      $generate_token = $this->quickRandom();
      $user->admin_token = $generate_token;
      $user->save();
      return $generate_token;
    }

    public function destroy($id)
    {
      $u = User::findOrNew($id);
      $u->delete();
      $ret = array("result"=>"ok");
      return json_encode($ret);
    }
}
