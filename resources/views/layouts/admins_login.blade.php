<!DOCTYPE Html>
<Html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emmanuels - Admin</title>

<!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    {!! Html::style('/assets/css/admin_login.css')!!}
    {!! Html::style('/assets/css/home_layout.css')!!}
    @yield('stylesheets')
  </head>
  <body>

    <div class="container">
    	<div class="row-fluid">
			@yield('content')
	    </div><!--/row-->
    </div>

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</Html>