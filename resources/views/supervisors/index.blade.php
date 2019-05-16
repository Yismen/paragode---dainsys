@inject('layout', 'App\Layout')
@extends('layouts.'.$layout->app(), ['page_header'=>'Supervisors', 'page_description'=>'Supervisors list!'])

@section('content')
	<div class="container-fluid">
    	<form action="/admin/supervisors/employees" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            Supervisors List
                            <a href="/admin/supervisors/create" class="pull-right"><i class="fa fa-plus"></i> Create</a>
                        </div>
                    </div>

                    @include('supervisors._free_employees')
                </div>

                <div class="col-sm-10 col-sm-offset-1">
                    @foreach ($supervisors as $supervisor)
                        @include('supervisors._list_with_employees')
                    @endforeach
                </div>
            </div>
            <div style="position: fixed; bottom: 35%; right: 30px; padding: 15px ; width: 30%; background-color: whitesmoke; border: darkgray; border-style: solid; border-width: thin;">
                <div class="input-group">
                    {{ Form::select('supervisor', $supervisors->pluck('name', 'id'), null, ['class' => 'form-control']) }}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning">Re-Assign</button>
                    </span>
                </div>

                @include('layouts.partials.errors')
            </div>
        </form>
	</div>
@stop

@section('scripts')
@stop
