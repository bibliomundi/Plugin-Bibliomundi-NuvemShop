@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-xs-12 col-md-offset-0">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">List of webhooks on TiendaNube</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						@if(Session::has('alert'))
							<p class="alert {{ Session::get('alert_class') }}">{{ Session::get('alert') }}</p>            
						@endif
						<p class="modal-footer btn">
							<a href="{{ url(route('webhooks.index', array('nuvemShopId' => $nuvemShop->id))) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> Return to webhooks</a>
						</p>
						<p>
							<span>Response Code: </span> {{ $code }}
						</p>
						@if (count($body))
							@foreach ($body as $item)
							    <p><pre> {{ print_r($item) }} </pre></p>
							@endforeach
						@endif
					</div>
				</div>				
			</div>
		</div>
	</div>
@endsection
