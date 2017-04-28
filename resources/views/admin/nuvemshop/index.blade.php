@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-xs-12 col-md-offset-0">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Nuvem Shop</h3>
					</div>
					<div class="box-body table-responsive">
						@if(Session::has('alert'))
			            	<p class="alert {{ Session::get('alert_class') }}">{{ Session::get('alert') }}</p>            
			            @endif
		            	<p class="modal-footer btn"><a href="{{ url('nuvemshop/add') }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Add</a></p>
		            	@if (count($shops))
			                <table class="table table-hover table-bordered">
			                    <thead>
				                    <th>ID</th>
				                    <th>Client ID</th>
				                    <th>Client Secret</th>
				                    <th>Tienda ID</th>
				                    <th></th>
				                    <th></th>
				                    <th></th>
				                    <th></th>
				                    <th></th>
			                    </thead>
			                    <tbody>
			                    @foreach ($shops as $shop)
			                        <tr>
			                            <td class="table-text">
			                                {{ $shop->id }}
			                            </td>
			                            <td class="table-text">
			                                <a href="nuvemshop/edit/{{ $shop->id }}">{{ $shop->client_id }}</a>
			                            </td>
			                            <td>
			                                {{ $shop->client_secret }}
			                            </td>
			                            <td>
			                                {{ $shop->tiendanube_id }}
			                            </td>
			                            <td>
			                            	<a href="nuvemshop/delete/{{ $shop->id }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</a>
			                            </td>
			                            <td>
			                            	<a href="intergrate/token/{{ $shop->id }}" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> Auth</a>
			                            </td>
			                            <td>
			                            	<a href="intergrate/syncprod/{{ $shop->id }}" data-url="intergrate/syncprod/{{ $shop->id }}" class="btn btn-success btn-sync"><span class="glyphicon glyphicon-refresh"></span> Sync</a>
			                            </td>
			                            <td>
			                            	<a href="{{ url(route('webhooks.index', array('nuvemShopId' => $shop->id))) }}" class="btn btn-primary"><span class="glyphicon glyphicon-link"></span> Webhooks</a>
			                            </td>
			                            <td>
			                            	<a href="{{ url(route('emailtemplates.index', array('nuvemShopId' => $shop->id))) }}" class="btn btn-warning"><span class="glyphicon glyphicon-envelope"></span> EmailTemplate</a>
			                            </td>
			                        </tr>
			                    @endforeach
			                    </tbody>
			                </table>
		                @endif
		                <p class="col-xs-9">{{$shops->links()}}</p>
					</div>					
				</div>				
			</div>
			<div id="overlay" class="hide">
				<div id="process"></div>
            	<div id="loading"></div>            	
            </div>			
		</div>
	</div>
@endsection
