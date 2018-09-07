<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use App\Http\Controllers\Rpc\jsonRPCClient;
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

    public function my_simple_crypt( $string, $action = 'e' ) {
      // you may change these values to your own
      $secret_key = 'my_simple_secret_key';
      $secret_iv = 'my_simple_secret_iv';

      $output = false;
      $encrypt_method = "AES-256-CBC";
      $key = hash( 'sha256', $secret_key );
      $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

      if( $action == 'e' ) {
          $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
      }
      else if( $action == 'd' ){
          $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
      }

      return $output;
    }

    public function wallets(Request $request)
    {
        $query = $request->input('query');
        if($query == null)
          $query = '';
        $wallets = Wallet::where('title', 'like', '%'.$query.'%')->paginate(50);
        foreach ($wallets as $wallet){
          $user = User::where('id', $wallet->user_id)->first();
          $wallet->user_name = "No Owner";
          $wallet->rpcpassword = $this->my_simple_crypt($wallet->rpcpassword, 'd');
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
        $wallet = Wallet::findOrNew($id);
        $wallet->rpcpassword = $this->my_simple_crypt($wallet->rpcpassword, 'd');
        return view('walletEdit', [
            'wallet' => $wallet
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
            $wallet->rpcpassword = $this->my_simple_crypt($request->input('rpcpassword'));
            $wallet->rpcport = $request->input('rpcport');
            $wallet->is_masternode = $request->input('is_masternode');
            $wallet->save();
          } else {
            $exists = Wallet::where('title', $request->input('title'))->get();
            if(sizeof($exists) > 0) {
              return Redirect::back()->withErrors("This title already used.");
            }
            $rpcpassword = $this->my_simple_crypt($request->input('rpcpassword'));
            $wallet = Wallet::create([
              'title' => $request->input('title'),
              'ip' => $request->input('ip'),
              'rpcuser' => $request->input('rpcuser'),
              'rpcpassword' => $rpcpassword,
              'rpcport' => $request->input('rpcport'),
              'is_masternode' => $request->input('is_masternode'),
            ]);
          }
          return redirect()->to('wallets');
    }

    public function testconnection(Request $request){
      $rpcuser = $request->input('rpcuser');
      $ip = $request->input('ip');
      $password = $request->input('rpcpassword');
      $rpcport = $request->input('rpcport');
      $client = new jsonRPCClient('http://'.$rpcuser.':'.$password.'@'.$ip.':'.$rpcport.'/');
      return $client->getwalletinfo();
    }

    public function destroy($id)
    {
      $u = Wallet::findOrNew($id);
      $u->delete();
      $ret = array("result"=>"ok");
      return json_encode($ret);
    }
}
