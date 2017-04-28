@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-6 col-md-offset-0">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Global Setting</h3>
					</div>
					<div class="box-body">
						{{ Form::model($setting, ['route' => 'setting.save']) }}
							<div class="form-group">
								{{ Form::label('bbm_client_id', 'Bibliomundi Client ID') }}
								{{ Form::text('bbm_client_id', Illuminate\Support\Facades\Input::old('bbm_client_id'), array('class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('bbm_client_secret', 'Bibliomundi Client Secret') }}
								{{ Form::text('bbm_client_secret', Illuminate\Support\Facades\Input::old('bbm_client_secret'), array('class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('bbm_operation', 'Operation') }}
								<div class="radio">
									<label>
										{{ Form::radio('bbm_operation', 'complete', true) }} Complete									
									</label>
								</div>
								<div class="radio">
									<label>
										{{ Form::radio('bbm_operation', 'updates', true) }} Update									
									</label>
								</div>							
							</div>
							<div class="form-group">
								{{ Form::label('bbm_environment', 'Environment') }}
								<div class="radio">
									<label>
										{{ Form::radio('bbm_environment', 'sandbox', true) }} Test									
									</label>
								</div>
								<div class="radio">
									<label>
										{{ Form::radio('bbm_environment', 'production', true) }} Production									
									</label>
								</div>
							</div>
							<div class="form-group">
								{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Save', ['class'=>'btn btn-primary', 'type'=>'submit']) }}
							</div>                                                    
						{{ Form::close() }}
					</div>
				</div>				
			</div>
		</div>
	</div>
@endsection
