@inject('layout', 'App\Layout')
@extends('layouts.'.$layout->app(), ['page_header'=>'title', 'page_description'=>'description'])

@section('content')
	<div class="container">
		<div class="box box-primary pad">
			{!! Form::model($permission, ['route'=>['admin.permissions.update', $permission->name], 'method'=>'PUT', 'class'=>'form-horizontal', 'role'=>'form']) !!}		
				<div class="form-group">
					<legend>Edit Permission {{ $permission->display_name }}</legend>
				</div>
			
				@include('permissions._form')

				<div class="col-sm-10 col-sm-offset-2">
					<button type="submit" class="btn btn-primary form-control">Update</button>
					<br><br>
					<a href="{{ route('admin.permissions.index') }}"><< Return to Permissions List</a>
				</div>
			
			{!! Form::close() !!}
		</div>
	</div>
@stop

@section('scripts')
	
@stop