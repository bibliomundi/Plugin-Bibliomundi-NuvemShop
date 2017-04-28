@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-xs-12 col-md-offset-0">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Webhooks</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						@if(Session::has('alert'))
							<p class="alert {{ Session::get('alert_class') }}">{{ Session::get('alert') }}</p>            
						@endif
						<p class="modal-footer btn">
							<a href="{{ url(route('webhooks.create', array('nuvemShopId' => $nuvemShop->id))) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Add</a>
							<!-- <a href="{{ url(route('webhooks.apiListing', array('nuvemShopId' => $nuvemShop->id))) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> List</a> -->
							<!-- <a href="{{ url(route('nuvemshops.edit', array('id' => $nuvemShop->id))) }}" class="btn btn-info"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Back</a> -->
						</p>
						@if (count($webhooks))
							<table class="table table-hover table-bordered">
								<thead>
									<th>ID</th>
									<th>Tienda ID</th>
									<th>Status</th>
									<th>Event</th>
									<th>URL</th>
									<th></th>
								</thead>
								<tbody>
								@foreach ($webhooks as $webhook)
									<tr>
										<td class="table-text">
											<a href="webhooks/{{ $webhook->id }}/edit">{{ $webhook->id }}</a>
										</td>
										<td class="table-text">
											{{ $webhook->tienda_id }}
										</td>
										<td class="table-text">
											{{ $webhook->status }}
										</td>
										<td class="table-text">
											{{ $webhook->event }}
										</td>
										<td class="table-text">
											{{ $webhook->url }}
										</td>
										<td class="table-action">
											<!-- <a href="webhooks/{{ $webhook->id }}/edit" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>	 -->		                           
											<a href="#" class="btn btn-danger btn-delete-webhook" data-url="{{ url(route('webhooks.destroy', array('nuvemShopId' => $nuvemShop->id, 'webhooks' => $webhook->id))) }}" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span> Delete</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
			</div>
			
			<div id="overlay" class="hide">
				<div id="loading"></div>
			</div>
		</div>
	</div>
@endsection
