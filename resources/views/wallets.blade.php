<?php
/******************************************************
 * IM - Vocabulary Builder
 * Version : 1.0.2
 * Copyright© 2016 Imprevo Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:http://imprevo.net
 ******************************************************/
?>
@extends('layouts.back')

@section('content')
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Wallet management</h2>
            </header>
            <div class="panel-body" id="pageDocument">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="mb-md">
                            <a href="/wallets/new" id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <form id="search-form" method="GET" action="">
      								<div class="input-group input-search">
      									<input type="text" class="form-control" name="query" id="query" placeholder="Search..." value="{{$search}}">
      									<span class="input-group-btn">
      										<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
      									</span>
      								</div>
                     </form>
      							</div>
                </div>
                <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Owner</th>
                        <th>Ip</th>
                        <th>Rpc User</th>
                        <th>Rpc Password</th>
                        <th>Rpc Port</th>
                        <th>Is Masternode?</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($wallets as $wallet)
                        <tr id="{{$wallet->id}}">
                            <td>{{$wallet->id}}</td>
                            <td>{{$wallet->title}}</td>
                            <td>{{$wallet->user_name}}</td>
                            <td>{{$wallet->ip}}</td>
                            <td>{{$wallet->rpcuser}}</td>
                            <td>{{$wallet->rpcpassword}}</td>
                            <td>{{$wallet->rpcport}}</td>
                            <td>@if ($wallet->is_masternode) Yes @else No @endif</td>
                            <td class="actions">
                                <a href="/wallets/{{$wallet->id}}" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="on-default remove-row" onclick="removeWallet({{$wallet->id}})"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $wallets->links() }}
            </div>
        </section>
        <script>
        function removeWallet(id) {
          res = confirm("Do you really want to delete this item?");
          if (res){
            $.ajax({
              url:'/wallets/' + id,
              type:'delete'
            }).then(function(ret){
                console.log(ret);
                location.href = "{{$wallets->url($wallets->currentPage())}}"
            }, function(err){
                console.log(err);
            })
          }
        }
    </script>

@endsection
