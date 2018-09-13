<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use Log;
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
        foreach ($users as $user){
          $wallet = Wallet::where('user_id', $user->id)->first();
          $user->has_connection = 'NO';
          if (isset($wallet->user_id)){
            $user->has_connection = 'YES';
          }
        }
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
          if ($wallet->user_id == NULL) {
            array_push($wallet_empty, $wallet);
          }
        }

        return view('userEdit', [
            'wallets' => $wallet_empty,
            'owned_wallets' => [],
            'user' => array('id'=>null, 'name'=>'', 'email'=>'', 'permission'=>0, 'password'=>'')
        ]);
    }

    public function editUser(Request $request, $id)
    {
      $wallets = Wallet::all();
      $wallet_empty = [];
      $owned_wallets = [];
      $user = User::findOrNew($id);
      foreach ($wallets as $wallet){
        if ($wallet->user_id == NULL) {
          array_push($wallet_empty, $wallet);
        } else if ($wallet->user_id == $user->id) {
          array_push($wallet_empty, $wallet);
          array_push($owned_wallets, $wallet);
        }
      }
        return view('userEdit', [
            'wallets' => $wallet_empty,
            'owned_wallets' => $owned_wallets,
            'user' => $user
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
            $wallets = $request->input('wallets');

            $wallet_all = Wallet::where('user_id', $user->id)->get();
            foreach ($wallet_all as $item){
              $item->user_id = null;
              $item->save();
            }

            Log::info($wallets);
            if ($wallets){
            foreach ($wallets as $item){
              $wallet = Wallet::where('id', $item)->first();
              $wallet->user_id = $user->id;
              $wallet->save();
            }
            }
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

            $wallet_all = Wallet::where('user_id', $user->id)->get();
            foreach ($wallet_all as $item){
              $item->user_id = null;
              $item->save();
            }
            $wallets = $request->input('wallets');
            foreach ($wallets as $item){
              $wallet = Wallet::where('id', $item)->first();
              $wallet->user_id = $user->id;
              $wallet->save();
            }
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
