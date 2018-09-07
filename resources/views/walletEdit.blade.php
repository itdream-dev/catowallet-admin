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
			<h2>
				Wallet management
			</h2>
		</header>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						<div class="row">
						<div class="col-sm-6 col-lg-6">
						@if($wallet['id'])
							<h2 class="panel-title">Edit wallet</h2>
						@else
							<h2 class="panel-title">Add new wallet</h2>
						@endif
						</div>
						<div class="col-sm-6 col-lg-6" style="text-align:right">
							<button class="btn btn-primary" onclick="test()">Test Connection</button>
						</div>
						</div>
					</header>
					<div class="panel-body">
						@include('common.errors')
						<form id="form" role="form" class="form-horizontal form-bordered" action="{{ Config::get('RELATIVE_URL') }}/wallet" method="post">
							@if($wallet['id'])
								<input type="hidden" name="id" value="{{$wallet->id}}">
							@endif

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="title">Title</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="title" name="title" value="{{$wallet['title']}}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="ip">IP</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="ip" name="ip" value="{{$wallet['ip']}}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="rpcuser">RPC UserName</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="rpcuser" name="rpcuser" value="{{$wallet['rpcuser']}}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="rpcpassword">RPC Password</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="rpcpassword" name="rpcpassword" value="{{$wallet['rpcpassword']}}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="rpcport">RPC Port</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="rpcport" name="rpcport" value="{{$wallet['rpcport']}}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label label-left" for="is_masternode">Is Masternode?</label>
								<div class="col-md-6">
									<div class="switch switch-primary">
										<input type="checkbox" id="is_masternode" name="is_masternode" onchange="ResetMasternode()" value='0' data-plugin-ios-switch required @if ($wallet['is_masternode']) checked @endif/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-9" style="text-align:right">
									<button type="button" class="btn btn-primary" style="width:120px" onclick="Save()">Save</button>
								</div>
							</div>
						</form>
					</div>
				</section>
			</div>
		</div>
	</section>
	<script type="text/javascript">
		// $(function(){
		// 	$("#form").validate({
		// 		rules: {
		// 			password: "required",
		// 			passwordConfirm: {
		// 				equalTo: "#password"
		// 			}
		// 		},
		// 		highlight: function( label ) {
		// 			$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
		// 		},
		// 		success: function( label ) {
		// 			$(label).closest('.form-group').removeClass('has-error');
		// 			label.remove();
		// 		},
		// 		errorPlacement: function( error, element ) {
		// 			var placement = element.closest('.input-group');
		// 			if (!placement.get(0)) {
		// 				placement = element;
		// 			}
		// 			if (error.text() !== '') {
		// 				placement.after(error);
		// 			}
		// 		}
		// 	});
		// });

		function Save(){
			// var isReset = document.getElementById('isResetPassword');
			//
			// if (isReset && isReset.checked)
			// {
			// 	resetpassword = document.getElementById('reset_password').value;
			// 	reset_password_confirm = document.getElementById('reset_password_confirm').value;
			//
			// 	bvalidation = false;
			// 	if (resetpassword.length > 5 && reset_password_confirm.length > 5)
			// 	{
			// 		if (resetpassword == reset_password_confirm)
			// 		{
			// 			bvalidation = true;
			// 		}
			// 	}
			// 	if (!bvalidation)
			// 	{
			// 		new PNotify({
			// 			text: 'please check reset password fields again. (len > 5, equal)',
			// 			type: 'error',
			// 			icon: false,
			// 			addclass: 'ui-pnotify-no-icon',
			// 		});
			// 		return;
			// 	}
			// }
			$('#form').submit();
		}

		function ResetMasternode(){
			value = document.getElementById('is_masternode').checked;
			if (value){
				document.getElementById('is_masternode').value = 1;
			} else {
				document.getElementById('is_masternode').value = 0;
			}

		}

		function test(){
			ip = $('#ip').val();
			rpcuser = $('#rpcuser').val();
			rpcpassword = $('#rpcpassword').val();
			rpcport = $('#rpcport').val();
			if (rpcuser == '') {
				alert('please input rpcuser field!');
				return;
			} else if (rpcpassword == ''){
				alert('please input rpcpassword field!');
				return;
			} else if (rpcport == ''){
				alert('please input rpcport field!');
				return;
			} else if (ip == ''){
				alert('please input ip field!');
				return;
			}
			var data = {
				ip: ip,
				rpcpassword: rpcpassword,
				rpcport: rpcport,
				rpcuser: rpcuser
			};
			$.post('/testconnection', data, function(res, status){
				console.log('status', status);
				console.log('result', res);
				if (res.walletversion > 1){
					alert('Connecting is successed!');
				} else {
					alert('Connecting is failed!\n' + res);
				}
			})
		}
	</script>
@endsection
