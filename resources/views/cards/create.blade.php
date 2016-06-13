@inject('layout', 'App\Layout')
@extends('layouts.'.$layout->app(), ['page_header'=>'title', 'page_description'=>'description'])

@section('content')
	<div class="container">
		<div class="box box-primary pad">
			{!! Form::open(['route'=>['admin.cards.store'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form']) !!}		
				<div class="form-group">
					<legend>New Card ID</legend>
				</div>
			
				@include('cards._form')

				<div class="col-sm-10 col-sm-offset-2">
					<button type="submit" class="btn btn-primary form-control">Create</button>
					<hr>	
					<a href="{{ route('admin.cards.index') }}"><< Cancel and return to Cards List</a>
				</div>
			
			{!! Form::close() !!}

			{{-- // errors --}}
		</div>
		
	</div>
@stop

@section('scripts')
	
@stop