<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
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
        $wallets = Wallet::all();
        $wallet_empty = [];
        foreach ($wallets as $wallet){
          $user = User::where('wallet_id', $wallet->id)->first();
          if (!isset($user->id)) {
            array_push($wallet_empty, $wallet);
          }
        }
        return view('userEdit', [
            'wallets' => $wallet_empty,
            'user' => array('id'=>null, 'name'=>'', 'email'=>'', 'permission'=>0, 'course'=>null, 'wallet_id'=>null)
        ]);
    }

    public function editUser(Request $request, $id)
    {
      $wallets = Wallet::all();
      $wallet_empty = [];
      foreach ($wallets as $wallet){
        $user = User::where('wallet_id', $wallet->id)->first();
        if (!isset($user->id) || $user->id == $id) {
          array_push($wallet_empty, $wallet);
        }
      }
        return view('userEdit', [
            'wallets' => $wallet_empty,
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
            $user->wallet_id = $request->input('wallet_id');

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
              'wallet_id' => $request->input('wallet_id')
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
