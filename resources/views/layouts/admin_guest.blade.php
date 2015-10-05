<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Booth</title>

    <!-- Bootstrap -->
	  {{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/admin_layout.css')}}
    {{ HTML::style('packages/totop/css/ui.totop.css') }}
    {{ HTML::style('packages/datepicker/css/datepicker3.css') }}
    @yield('stylesheets')
  </head>
  <body >
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
      
          <button id="menuButton" type="button" class="pull-left navbar-toggle" data-toggle="offcanvas" style="display:block">
            <span class="glyphicon glyphicon-tasks white"></span>
          </button>
          <a class="navbar-brand pull-left" href="{{ action('AdminsController@getLogin') }}">Orderbooth</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <!-- Add a login button -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if(!Auth::check())
                <li>{{ HTML::link('admins/login', 'Login') }}</li>   
                @endif
              </ul>
            </li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container" style="padding-top:75px;">

      <div class="row row-offcanvas row-offcanvas-left side-toggle">
        <div class="col-xs-8 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          @yield('sidebar')
        </div>

        <!--/span-->
        <div class="col-xs-12 col-sm-9 col-main">        
          @if(Session::has('message'))
              <div class="alert {{ Session::get('alert_type') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('message') }}
              </div>
              {{ Session::forget('message') }}
          @endif

          @yield('content')

        </div><!--/row-->

      <hr>

    </div><!--/.container-->
    <footer class="row-fluid">
      <p>&copy; Eyelevate LLC {{ date('Y') }}</p>
    </footer>
    @yield('templates')
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
    {{ HTML::script('packages/typeahead/js/bootstrap3-typeahead.min.js') }}
    {{ HTML::script('js/admin_layout.js') }}
    {{ HTML::script('js/global_setup.js') }}
    {{ HTML::script('packages/totop/js/easing.js') }}
    {{ HTML::script('packages/totop/js/jquery.ui.totop.min.js') }}
    {{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js') }}
    @yield('scripts')

    <script type="text/javascript">
    $(document).ready(function() {      
      $().UItoTop({ easingType: 'easeOutQuart' });
      
    });
  </script>
  </body>
</html>