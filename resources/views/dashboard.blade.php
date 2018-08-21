@extends('layouts.back')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Dashboard</h2>
        </header>
        <div class="row" id="pageDocument" style="padding-left:10px; padding-top:10px;background-color:#ecedf0;">
        <div class="row" style="">
				<div class="col-md-8 col-lg-5 col-xl-3 ">
					<section class="panel panel-featured-left panel-featured-secondary">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-secondary" style="background:url('/images/logo.png') no-repeat center/cover">

									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Sales this month</h4>
										<div class="info" style="padding-top:5px">
											<strong id="netsales-str" class="amount">0 CATO</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-md-8 col-lg-5 col-xl-3">
					<section class="panel panel-featured-left panel-featured-quartenary">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-quartenary">
										<i class="fa fa-user"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Total registered members</h4>
										<div class="info" style="padding-top:5px">
											<strong class="amount">{{count($users)}}</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="row" style="padding-top:50px; padding-bottom:50px;">
				<div class="col-md-8 col-lg-5 col-xl-3">
					<section class="panel">
						<header class="panel-heading">
							<h2 class="panel-title">
								<span class="va-middle">New members</span>
							</h2>
						</header>
						<div class="panel-body">
							<div class="content">
								<ul class="simple-user-list">
                  <?php $i = 0; ?>
                  @foreach ($users as $user)
                  <?php $i++ ?>
                  @if ($i < 11)
                  <li>
										<figure class="image rounded">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior" class="img-circle">
										</figure>
										<span class="title">{{$user->email}}</span>
										<span class="message truncate">{{$user->created_at}}</span>
									</li>
                  @endif
                  @endforeach
								</ul>
							</div>
						</div>
					</section>
				</div>
        <div class="col-md-8 col-lg-5 col-xl-3">
							<section class="panel">
                <header class="panel-heading">
    							<h2 class="panel-title">
    								<span class="va-middle">Lastest buyers</span>
    							</h2>
    						</header>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped mb-none">
											<thead>
												<tr>
													<th>User</th>
													<th>Purchased Time</th>
                          <th>Paid Price</th>
													<th>Purchased Amount</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr>
													<td>skyclean</td>
													<td>2018-04-05 12:00</td>
                          <td>0.1 BTC</td>
                          <td>1000 CATO</td>
												</tr>
                        <tr>
                          <td>pillow</td>
                          <td>2018-04-05 12:00</td>
                          <td>0.1 BTC</td>
                          <td>1000 CATO</td>
                        </tr>
                        <tr>
                          <td>john</td>
                          <td>2018-04-05 12:00</td>
                          <td>0.1 BTC</td>
                          <td>1000 CATO</td>
                        </tr> -->
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
			</div>
    </div>
    </section>
	<script>

	</script>
@endsection
