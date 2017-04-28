@extends('adminlte::layouts.app')

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Users</h3>

						<!--
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
						-->
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						@if(Session::has('alert'))
							<p class="alert {{ Session::get('alert_class') }}">{{ Session::get('alert') }}</p>
						@endif
						@if (count($users))
							<table class="table table-hover table-bordered">
								<thead>
								<th>ID</th>
								<th>Username</th>
								<th>Email</th>
								<th></th>
								</thead>
								<tbody>
								@foreach ($users as $user)
									<tr>
										<td class="table-text">
											{{ $user->id }}
										</td>
										<td class="table-text">
											{{ $user->name }}
										</td>
										<td>
											{{ $user->email }}
										</td>
										<td>
											<a href="user/delete/{{ $user->id }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endif
						<p class="col-xs-9">{{$users->links()}}</p>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
