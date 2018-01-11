@extends('escalations_admin.home')

@section('views')
    <div class="row">        
        <router-view name="escalations_admin"></router-view> 
        <router-view></router-view>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('js/dainsys/app.js') }}"></script>
@stop