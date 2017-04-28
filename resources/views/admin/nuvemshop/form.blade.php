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
						@if(isset($nuvemshop))
		                	{{ Form::model($nuvemshop, ['url' => ['nuvemshop/edit', $nuvemshop->id], 'method' => 'post']) }}
			            @else
			                {{ Form::open(['url' => 'nuvemshop/add', 'method' => 'post']) }}
			            @endif
			            <div class="form-group">
			            	{{ Form::label('client_id', 'Client ID')}}
			            	{{ Form::text('client_id', Illuminate\Support\Facades\Input::old('client_id'), ['class' => 'form-control'])}}
			            </div>
			            <div class="form-group">
			            	{{ Form::label('client_secret', 'Client Secret')}}
			            	{{ Form::text('client_secret', Illuminate\Support\Facades\Input::old('client_secret'), ['class' => 'form-control'])}}
			            </div>
			            <div class="form-group">
			            	{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Save', ['class' => 'btn btn-primary', 'type'=>'submit']) }}
			            	<a href="{{ url(route('nuvemshops.index')) }}" class="btn btn-info"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
		            	</div>
			            {{ Form::close() }}
					</div>
				</div>				
			</div>
		</div>
	</div>
@endsection
