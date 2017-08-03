@inject('layout', 'App\Layout')
@extends('layouts.'.$layout->app(), ['page_header'=>config("dainsys.app_name"), 'page_description'=>'Escalations Hours List'])

@section('content')
	<div class="container-fluid">
    	<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="box box-primary">
					<div class="box-header "><h2>Escalations Hours</h2></div>

					    
					<div class="box-body no-padding">
					    {!! Form::open(['route'=>['admin.escalations_hours.search'], 'method'=>'POST', 'class'=>'', 'role'=>'form', 'autocomplete'=>"off",  'enctype'=>"multipart/form-data"]) !!}       
					
					    	@include('escalations_hours._form')
					
					        <div class="box-footer">
					            <button type="submit" class="btn btn-primary">SUBMIT</button>
					        </div>
					
					    {!! Form::close() !!}
					</div>  
					
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')

@stop