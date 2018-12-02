{{--  @if(Session::has('alert'))
    <flash-message 
        type="{{ $class }}"
        heading="{{ $title }}"
        message="{{ $message }}"
    ></flash-message>
@endif  --}}
    <!-- Global Messages to be Printed -->
	<?php
        $class = null;
        $message = null;
        $title = null;
        $icon = null;

        if (Session::has('global')) {
            $class = 'global';
            $title = 'Attention';
            $message = Session::get('global');
            $icon = 'info';
        } elseif (Session::has('info')) {
            $class = 'info';
            $title = 'Attention';
            $message = Session::get('info');
            $icon = 'info';
        } elseif (Session::has('success')) {
            $class = 'success';
            $title = 'Nice';
            $message = Session::get('success');
            $icon = 'check-circle';
        } elseif (Session::has('danger')) {
            $class = 'error';
            // $class = 'danger';
            $title = 'Oops';
            $message = Session::get('danger');
            $icon = 'exclamation-triangle';
        } elseif (Session::has('warning')) {
            $class = 'warning';
            $title = 'Warning';
            $message = Session::get('warning');
            $icon = 'exclamation-circle';
        }elseif (Session::has('question')) {
            $class = 'question';
            $title = '??';
            $message = Session::get('question');
            $icon = 'exclamation-circle';
        }
    ?>	

	@if($class)

        <flash-message type="{{ $class }}" title="{{ $title }}" text="{{ $message }}"></flash-message>
		{{--  <div style="position: fixed; z-index: 100000; bottom: 25px; right: 25px;" class="container-fluid {{ session('important', 'dismiss') }}">
			<div class="alert alert-{{ $class }}">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>{{ $title }} <i class="fa fa-{{ $icon }}"></i> !</strong> {!! $message !!} 
			</div>
		</div>  --}}
	@endif
	<!-- /. Warning Messages -->