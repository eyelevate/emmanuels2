<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Emmanuels</title>

  <!-- Bootstrap -->
  {{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
  {{ HTML::style('css/admin_layout.css')}}
  {{ HTML::style('packages/totop/css/ui.totop.css') }}
  @yield('stylesheets')
</head>
<body >
 <header>
  <nav id="nav" class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <img src="/img/emmanuels_compact_logo.png" onerror="this.onerror=null; this.src='/img/emmanuels_compact_logo.jpg'" alt="..." style="height:40px; width:136px;"/>
      </a>
    </div>
    <div class="collapse navbar-collapse">
      {{$nav_html}}
    </div>
  </div>
</nav>   
</header>

<div class="container">

  <div class="row row-offcanvas row-offcanvas-left side-toggle">
    <div class="col-xs-8 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

    </div>
    <!--/span-->
    <div class="col-xs-12 col-sm-9 col-main">        
      @if(Session::has('message'))
      <div class="alert {{ Session::get('alert_type') }} alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('message') }}
      </div>
      @endif
      @yield('content')
      @yield('modals')
    </div><!--/row-->

    <hr>

  </div><!--/.row-->
</div><!--/.container-->
<footer class="row-fluid"> 
  <br/>
  <p>&copy; Eyelevate LLC 2014</p>
  <br/>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
{{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('packages/typeahead/js/bootstrap3-typeahead.min.js') }}
{{ HTML::script('js/admin_layout.js') }}
{{ HTML::script('js/global_setup.js') }}
{{ HTML::script('packages/totop/js/easing.js') }}
{{ HTML::script('packages/totop/js/jquery.ui.totop.min.js') }}
@yield('scripts')

<script type="text/javascript">
$(document).ready(function() {      
  $().UItoTop({ easingType: 'easeOutQuart' });
  
});
</script>

</body>
<footer>
  {{ View::make('layouts.partials.javascript_vars'); }}
</footer>
</html>