<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
class WalletController extends Controller
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
    public function wallets(Request $request)
    {
        $query = $request->input('query');
        if($query == null)
          $query = '';
        $wallets = Wallet::where('title', 'like', '%'.$query.'%')->paginate(50);
        foreach ($wallets as $wallet){
          $user = User::where('wallet_id', $wallet->id)->first();
          $wallet->user_name = "No Owner";
          if (isset($user->name)) $wallet->user_name = $user->name;
        }
        return view('wallets', [
          'wallets' => $wallets,
          'search' => $query
        ]);
    }

    public function newWallet()
    {
        return view('walletEdit', [
            'wallet' => array('id'=>null, 'title'=>'', 'user_id'=>'', 'ip'=>'', 'rpcuser'=>'', 'rpcpassword'=>'', 'rpcport'=>'', 'is_masternode'=>0, 'balance'=>0)
        ]);
    }

    public function editWallet(Request $request, $id)
    {
        return view('walletEdit', [
            'wallet' => Wallet::findOrNew($id)
        ]);
    }

    public function postEdit(Request $request)
    {
        $wallet=[];
        if($request->input('id') != '') {
            $wallet = Wallet::findOrNew($request->input('id'));
            $wallet->title = $request->input('title');
            $wallet->rpcuser = $request->input('rpcuser');
            $wallet->ip = $request->input('ip');
            $wallet->rpcpassword = $request->input('rpcpassword');
            $wallet->rpcport = $request->input('rpcport');
            $wallet->is_masternode = $request->input('is_masternode');
            $wallet->save();
          } else {
            $exists = Wallet::where('title', $request->input('title'))->get();
            if(sizeof($exists) > 0) {
              return Redirect::back()->withErrors("This title already used.");
            }
            $wallet = Wallet::create([
              'title' => $request->input('title'),
              'ip' => $request->input('ip'),
              'rpcuser' => $request->input('rpcuser'),
              'rpcpassword' => $request->input('rpcpassword'),
              'rpcport' => $request->input('rpcport'),
              'is_masternode' => $request->input('is_masternode'),
            ]);
          }
          return redirect()->to('wallets');
    }



    public function destroy($id)
    {
      $u = Wallet::findOrNew($id);
      $u->delete();
      $ret = array("result"=>"ok");
      return json_encode($ret);
    }
}
