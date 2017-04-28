@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen email-template">
		<div class="row">
			<div class="col-md-12 col-md-offset-0">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Email Template</h3>
						@if(Session::has('alert'))
							<p class="alert {{ Session::get('alert_class') }}">{{ Session::get('alert') }}</p>            
						@endif
					</div>
					<div class="box-body">
						@if(isset($template))
							{{ Form::model($template, ['url' => url(route('emailtemplates.update', array('nuvemShopId' => $nuvemShop->id, 'emailtemplates' => $template->id))), 'method' => 'put']) }}
						@else
							{{ Form::open(['url' => url(route('emailtemplates.store', array('nuvemShopId' => $nuvemShop->id))), 'method' => 'post']) }}
						@endif
						
						<div class="form-group required">
							{{ Form::label('from_name', 'From Name', ['class' => 'form-label']) }}
							{{ Form::text('from_name', old('from_name'), ['class' => 'form-control', 'required' => 'required']) }}
						</div>
						
						<div class="form-group required">
							{{ Form::label('from_address', 'From Email Address', ['class' => 'form-label']) }}
							{{ Form::email('from_address', old('from_address'), ['class' => 'form-control', 'required' => 'required']) }}
						</div>
						
						<div class="form-group required">
							{{ Form::label('subject', 'Email Subject', ['class' => 'form-label']) }}
							{{ Form::text('subject', old('subject'), ['class' => 'form-control', 'required' => 'required']) }}
						</div>

						<div class="form-group">
							{{ Form::label('header', 'Email Header', ['class' => 'form-label']) }}
							{{ Form::textarea('header', old('header'), ['class' => 'form-control ckeditor']) }}
						</div>

						<div class="form-group">
							{{ Form::label('content', 'Email Content', ['class' => 'form-label']) }}
							<p class="email-content-note">
								<span>* Note: Enter <strong>[RecipientName]</strong> and <strong>[DownloadLinks]</strong> to the position you want they appear.</span>
							</p>
							{{ Form::textarea('content', old('content'), ['class' => 'form-control ckeditor']) }}
						</div>

						<div class="form-group">
							{{ Form::label('footer', 'Email Footer', ['class' => 'form-label']) }}
							{{ Form::textarea('footer', old('footer'), ['class' => 'form-control ckeditor']) }}
						</div>

						<div class="form-group">
							@if(isset($template))
								{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Save', ['class' => 'btn btn-primary', 'type'=>'submit']) }}
							@else
								{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Create', ['class' => 'btn btn-primary', 'type'=>'submit']) }}
							@endif
							<a href="{{ url(route('nuvemshops.index')) }}" class="btn btn-info"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
						</div>

						{{ Form::close() }}
					</div>
				</div>				
			</div>
		</div>
	</div>
@endsection
