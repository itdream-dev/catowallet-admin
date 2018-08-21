<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$frontPath = env('FRONT_URL', 'https://catowallet.com');
Config::Set('FRONT_URL', $frontPath);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get ( '/', ['as' => 'admin.courses', 'uses' => 'HomeController@index']);
Route::get ( '/home', ['as' => 'admin.home', 'uses' => 'HomeController@index']);
Route::get ( '/dashboard', ['as' => 'admin.dashboard', 'uses' => 'HomeController@index']);
Route::get ( '/users', ['as' => 'admin.users', 'uses' => 'UserController@users']);
Route::get('/users/new', ['as' => 'admin.user.new', 'uses' => 'UserController@newUser']);
Route::get('/users/{id}', ['as' => 'admin.userEdit', 'uses' => 'UserController@editUser']);
Route::delete('/users/{id}', ['uses' => 'UserController@destroy']);
Route::post('/user', ['as' => 'admin.users', 'uses' => 'UserController@postEdit']);
Route::get ( '/site_settings', ['as' => 'admin.site_settings', 'uses' => 'SettingController@site_settings']);

Route::get ( '/wallets', ['as' => 'admin.wallets', 'uses' => 'WalletController@wallets']);
Route::get('/wallets/new', ['as' => 'admin.wallet.new', 'uses' => 'WalletController@newWallet']);
Route::get('/wallets/{id}', ['as' => 'admin.walletEdit', 'uses' => 'WalletController@editWallet']);
Route::delete('/wallets/{id}', ['uses' => 'WalletController@destroy']);
Route::post('/wallet', ['as' => 'admin.wallet', 'uses' => 'WalletController@postEdit']);
