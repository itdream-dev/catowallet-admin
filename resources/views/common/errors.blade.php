<?php
 /******************************************************
  * IM - Vocabulary Builder
  * Version : 1.0.2
  * Copyright© 2016 Imprevo Ltd. All Rights Reversed.
  * This file may not be redistributed.
  * Author URL:http://imprevo.net
  ******************************************************/
?>
@if (count($errors) > 0)
	<!-- Form Error List -->
	<div class="alert alert-danger">
		<strong>Whoops! Something went wrong!</strong>

		<br><br>

		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
