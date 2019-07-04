@inject('layout', 'App\Layout')
@extends('layouts.'.$layout->app(), ['page_header'=>'Supervisors', 'page_description'=>'Supervisors list!'])

@section('content')
	<div class="container-fluid">
    	<form action="/admin/supervisors/employees" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h3>
                        Supervisors List
                        <a href="/admin/supervisors/create" class="pull-right"><i class="fa fa-plus"></i> Add</a>
                    </h3>

                    @include('supervisors._free_employees')
                </div>

                <div class="col-sm-12">
                    @foreach ($supervisors as $supervisor)
                        @include('supervisors._list_with_employees')
                    @endforeach
                </div>

            </div>
                @if ($inactive_supervisors->count() > 0)
                    <div class="row">
                        <div class="box box-danger">
                            <div class="box-header">
                                <h4>List of Supervisors Inactives</h4>
                            </div>
                            <div class="box-body">
                                @foreach ($inactive_supervisors as $supervisor)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <a href="{{ route('admin.supervisors.edit', $supervisor->id) }}" class="text-warning">
                                            {{ $supervisor->name }}
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            <div class="col-sm-3 col-xs-7" style="position: fixed; bottom: 35%; right: 30px; padding: 15px ;  background-color: whitesmoke; border: darkgray; border-style: solid; border-width: thin;">
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
