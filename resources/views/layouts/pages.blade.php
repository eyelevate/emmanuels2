<?php
/**
* Declare or set any page wide variables here
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/assets/img/yongs_red.svg" type="image/icon">
    <title>Emmanuel's</title>
    {!! Html::style('http://fonts.googleapis.com/css?family=Lobster|Oswald:400,300,700') !!}
    <!-- Bootstrap -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    {!! Html::style('/assets/css/image_lightbox.css') !!}
    {!! Html::style('/packages/totop/css/ui.totop.css') !!}
    {!! Html::style('/assets/css/pages_layout.css')!!}
    {!! Html::style('/assets/css/general_styling/gs_1.css')!!}
    @yield('stylesheets')

<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
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
        <a class="navbar-brand" href="/" style="position:absolute; top:-10px; left:10px;">          
          <img src="/assets//img/emmanuels_compact_logo.png" onerror="this.onerror=null; this.src='/assets//img/emmanuels_compact_logo.jpg'" alt="..." style="height:40px; width:136px;"/>
        </a>
      </div>
      <div class="collapse navbar-collapse">
        {!!$nav_html!!}
      </div>
    </div>
  </nav>   
</header> 

<!-- stickyNav -->  
<section id="start-offset" class="section" style="padding:0px; margin:0px;" data-url="/"></section> <!-- Home Waypoint Trigger -->
@yield('slider')
<div class="container-fluid">
    <div id="startContent" class="row" data-parallax="scroll" data-image-src="/assets//img/parallax_rug2.jpg">
        <div id="contentDiv" class="col-md-8 col-md-offset-2" >
            @if(Session::has('message'))
            <div class="alert {!! Session::get('alert_type') !!} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! Session::get('message') !!}
            </div>
            @endif
            
            @yield('content')
        </div><!--/row-->
    </div>
</div>
<footer class="row-fluid clearfix">
    <p>&copy; emmanuel's {!! date('Y') !!}</p>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
{!! HTML::script('/packages/modernizr/modernizr.custom.20702.js') !!}
{!! HTML::script('/packages/waypoints/waypoints.min.js') !!}
{!! HTML::script('/packages/history/scripts/compressed/history.js') !!}
{!! HTML::script('/packages/lazyload/jquery.lazyload.min.js')!!}
{!! HTML::script('/packages/parallax/parallax.min.js') !!}
{!! HTML::script('/packages/lightbox/lightbox.min.js') !!}
{!! HTML::script('/packages/totop/js/easing.js') !!}
{!! HTML::script('/packages/totop/js/jquery.ui.totop.min.js') !!}
{!! HTML::script('/assets/js/pages_layout.js') !!}
@yield('scripts')
<script type="text/javascript">
$(document).ready(function() {      
    $().UItoTop({ easingType: 'easeOutQuart' });
});
</script>

</body>
</html>