<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'title', 'ip', 'username', 'password', 'rpcuser', 'rpcpassword', 'rpcport', 'is_masternode', 'balance'
    ];

}
