@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-5 col-md-offset-0">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Nuvem Shop</h3>
					</div>
					<div class="box-body">
						@if(isset($webhook))
							{{ Form::model($webhook, ['url' => url(route('webhooks.update', array('nuvemShopId' => $nuvemShop->id, 'webhooks' => $webhook->id))), 'method' => 'put']) }}

							<div class="form-group">
								{{ Form::label('tienda_id', 'Tienda ID', ['class' => 'form-label']) }}
								{{ Form::text('tienda_id', old('tienda_id'), ['class' => 'form-control', 'disabled' => 'disabled']) }}
							</div>
						@else
							{{ Form::open(['url' => url(route('webhooks.store', array('nuvemShopId' => $nuvemShop->id))), 'method' => 'post']) }}
						@endif
						
						<div class="form-group required">
							{{ Form::label('event', 'Event', ['class' => 'form-label']) }}
							{{ Form::text('event', old('event'), ['class' => 'form-control', 'required' => 'required']) }}
						</div>
						<div class="form-group required">
							{{ Form::label('url', 'URL', ['class' => 'form-label']) }}
							{{ Form::text('url', old('url'), ['class' => 'form-control', 'required' => 'required']) }}
						</div>
						<div class="form-group">
							@if(isset($webhook))
								{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Save', ['class' => 'btn btn-primary', 'type'=>'submit']) }}
							@else
								{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Create', ['class' => 'btn btn-primary', 'type'=>'submit']) }}
							@endif
							<a href="{{ url(route('webhooks.index', array('nuvemShopId' => $nuvemShop->id))) }}" class="btn btn-info"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
						</div>

						{{ Form::close() }}
					</div>
				</div>				
			</div>
		</div>
	</div>
@endsection
