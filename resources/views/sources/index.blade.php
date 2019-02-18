@inject('layout', 'App\Layout')
@extends('layouts.'.$layout->app(), ['page_header'=>'Sources', 'page_description'=>'List of sources of production.'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="box box-primary">
                   {{ $sources }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@stop