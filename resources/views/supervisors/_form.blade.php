<!-- Name -->
<div class="col-sm-12">
	<div class="form-group {{ $errors->has('name') ? 'has-error' : null }}">
		{!! Form::label('name', 'Name:', ['class'=>'col-sm-2 control-label']) !!}
		<div class="col-sm-10">
			{!! Form::input('text', 'name', null, ['class'=>'form-control input-sm', 'placeholder'=>'Name']) !!}
	        {!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
		</div>
	</div>
</div>
<!-- /. Name -->