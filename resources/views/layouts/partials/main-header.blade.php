
<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini" style="margin-top: 3px;">
            <img src="{{ asset('images/logo.png') }}" class="img-responsive" alt="Image">
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ $client_name_mini }}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @include('layouts.partials.user-menu')

            </ul>
        </div>
    </nav>

</header>
