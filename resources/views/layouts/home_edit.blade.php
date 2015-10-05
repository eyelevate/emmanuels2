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

  <!-- Bootstrap -->
  {!! Html::style('http://fonts.googleapis.com/css?family=Lobster|Oswald:400,300,700') !!}
<!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  {!! Html::style('/assets/css/image_lightbox.css') !!}
  {!! Html::style('/packages/totop/css/ui.totop.css') !!}
  {!! Html::style('/assets/css/home_edit_layout.css')!!}
  @yield('stylesheets')

<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body id="top" class="clearfix homepoint" data-spy="scroll" data-target="#nav">

  <header class="site-header">
    <div id="headerNav" class="container col-md-8 col-md-offset-2">
      <a href="/" class="my-svg-container">
        <img src="/assets/img/emmanuels_logo.png" onerror="this.onerror=null; this.src='/assets/img/emmanuels_logo.jpg'" alt="..." >
      </a>
      <nav class="top-nav text-center ">
        {!!$menu_html!!}
        <button type="button" class="navbar-menu-toggle clearfix" data-toggle="collapse" data-target=".navbar-collapse-menu">
          <span class="glyphicon glyphicon-chevron-down pull-right"></span>
          <span class="home-tag pull-left">Home</span>
          <span class="icon-bar"></span>
        </button>

      </nav>
      <div class="menu-nav-toggle-div">
        <nav class="navbar navbar-default menu-nav-toggle hide" role="navigation" status="0">
          <div class="container">
            <div class="navbar-header">
            </div>
            <div class="collapse navbar-collapse-menu">
              {!!$nav_html!!}
            </div>
          </div>
        </nav> 
      </div>
    </div>

  </header> 
  <!-- stickyNav -->
  
  <nav id="nav" class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">

      <div class="navbar-header">

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/" style="position:absolute; top:-10px; left:10px;">          
          <img src="/assets/img/emmanuels_compact_logo.png" onerror="this.onerror=null; this.src='/assets/img/emmanuels_compact_logo.jpg'" alt="..." style="height:40px; width:136px;"/>
        </a>
      </div>
      <div class="collapse navbar-collapse">
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li>{!! Html::link('users/index', 'View Users') !!}</li>
            <li>{!! Html::link('users/edit/2', 'Edit Users') !!}</li>
            <li>{!! Html::link('users/add', 'Add Users') !!}</li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-camera"></span> Resources <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li>{!! Html::link('/resources/edit', 'Manage Resources') !!}</li>
            
          </ul>
        </li>            
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt"></span> Company <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li>{!! Html::link('/companies/view', 'View Company') !!}</li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span> Setup <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li>{!! Html::link('/taxes', 'View Taxes') !!}</li>
            <li>{!! Html::link('/taxes/add', 'Add Tax') !!}</li>
            <li>{!! Html::link('/pages/index', 'View Pages') !!}</li>
            <li>{!! Html::link('/menus/index', 'View Menus') !!}</li>
            <li>{!! Html::link('/menu-items/index', 'View Menu Items') !!}</li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {!!Auth::user()->username!!} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            @if(!Auth::check())
            <li>{!! Html::link('users/register', 'Register') !!}</li>   
            <li>{!! Html::link('admins/login', 'Login') !!}</li>   
            @else
            @if(Auth::user()->roles == 3) 
            <li><a href="/owners/edit/{!! Auth::user()->id !!}">Edit User</a></li>
            @endif
            @if(Auth::user()->roles == 4)
            <li><a href="/employees/edit/{!! Auth::user()->id !!}">Edit User</a></li>
            @endif

            <li>{!! Html::link('admins/logout', 'Logout') !!}</li>
            @endif
          </ul>
        </div>
      </div>
    </nav>    
    <section id="start-offset" class="section" style="padding:0px; margin:0px;" data-url="/"></section> <!-- Home Waypoint Trigger -->
    <!-- Use a container to wrap the slider, the purpose is to enable slider to always fit width of the wrapper while window resize -->
    <div class="contaidner">
      <!-- Jssor Slider Begin -->
      <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
      <!-- ================================================== -->
      <div id="slider1_container" style="display: none; position: relative; margin: 0 auto; width: 1140px; height: 442px; overflow: hidden;">
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
          <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
          background-color: #000; top: 0px; left: 0px;width: 100%; height:100%;">
        </div>
        <div style="position: absolute; display: block; background: url(/packages/jssor/img/loading.gif) no-repeat center center;
        top: 0px; left: 0px;width: 100%;height:100%;">
      </div>
    </div>
    <!-- Slides Container -->
    <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1140px; height: 442px;
    overflow: hidden;">
    @if((isset($session_slider_images)) && ($session_slider_images != "empty"))
    @foreach ($session_slider_images as $images)
    <div>
      <img u="image" src2="/assets/img/{!!$images[1]!!}/{!!$images[0]!!}" />
    </div>
    @endforeach
    @endif

  </div>

  <!--#region Bullet Navigator Skin Begin -->
  <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
  <style>
  /* jssor slider bullet navigator skin 05 css */
/*
.jssorb05 div           (normal)
.jssorb05 div:hover     (normal mouseover)
.jssorb05 .av           (active)
.jssorb05 .av:hover     (active mouseover)
.jssorb05 .dn           (mousedown)
*/
.jssorb05 {
  position: absolute;
}
.jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
  position: absolute;
  /* size of bullet elment */
  width: 16px;
  height: 16px;
  background: url(/packages/jssor.carousel.slider.for.bootstrap.example/img/b05.png) no-repeat;
  overflow: hidden;
  cursor: pointer;
}
.jssorb05 div { background-position: -7px -7px; }
.jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
.jssorb05 .av { background-position: -67px -7px; }
.jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }
</style>
<!-- bullet navigator container -->
<div u="navigator" class="jssorb05" style="bottom: 16px; right: 6px;">
  <!-- bullet navigator item prototype -->
  <div u="prototype"></div>
</div>
<!--#endregion Bullet Navigator Skin End -->

<!--#region Arrow Navigator Skin Begin -->
<!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
<style>
/* jssor slider arrow navigator skin 11 css */
/*
.jssora11l                  (normal)
.jssora11r                  (normal)
.jssora11l:hover            (normal mouseover)
.jssora11r:hover            (normal mouseover)
.jssora11l.jssora11ldn      (mousedown)
.jssora11r.jssora11rdn      (mousedown)
*/
.jssora11l, .jssora11r {
  display: block;
  position: absolute;
  /* size of arrow element */
  width: 37px;
  height: 37px;
  cursor: pointer;
  background: url(/packages/jssor.carousel.slider.for.bootstrap.example/img/a11.png) no-repeat;
  overflow: hidden;
}
.jssora11l { background-position: -11px -41px; }
.jssora11r { background-position: -71px -41px; }
.jssora11l:hover { background-position: -131px -41px; }
.jssora11r:hover { background-position: -191px -41px; }
.jssora11l.jssora11ldn { background-position: -251px -41px; }
.jssora11r.jssora11rdn { background-position: -311px -41px; }
</style>
<!-- Arrow Left -->
<span u="arrowleft" class="jssora11l" style="top: 123px; left: 8px;">
</span>
<!-- Arrow Right -->
<span u="arrowright" class="jssora11r" style="top: 123px; right: 8px;">
</span>
<!--#endregion Arrow Navigator Skin End -->
<a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
</div>
<!-- Jssor Slider End -->
</div>
<div class="container-fluid">
  <div id="startContent" class="row" data-parallax="scroll" data-image-src="/assets/img/parallax_rug2.jpg">
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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
{!! Html::script('/packages/jssor.carousel.slider.for.bootstrap.example/examples-bootstrap/docs.min.js') !!}
{!! Html::script('/packages/jssor.carousel.slider.for.bootstrap.example/examples-bootstrap/ie10-viewport-bug-workaround.js') !!}
{!! Html::script('/packages/jssor.carousel.slider.for.bootstrap.example/js/jssor.slider.mini.js') !!}
{!! Html::script('/packages/modernizr/modernizr.custom.20702.js') !!}
{!! Html::script('/packages/waypoints/waypoints.min.js') !!}
{!! Html::script('/packages/history/scripts/compressed/history.js') !!}
{!! Html::script('/packages/lazyload/jquery.lazyload.min.js')!!}
{!! Html::script('/packages/parallax/parallax.min.js') !!}
{!! Html::script('/packages/lightbox/lightbox.min.js') !!}
{!! Html::script('/packages/totop/js/easing.js') !!}
{!! Html::script('/packages/totop/js/jquery.ui.totop.min.js') !!}

{!! Html::script('/assets/js/home_layout.js') !!}
@yield('scripts')

<script type="text/javascript">
$(document).ready(function() {      
  $().UItoTop({ easingType: 'easeOutQuart' });
});
</script>
</body>
</html>