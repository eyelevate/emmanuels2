$(document).ready(function(){
	pages.pageLoad();
	pages.slider();
	pages.setupLightbox();
});

pages = {
	pageLoad: function(){

        $('.parallax-window').parallax({imageSrc: ''});
        /* Navigation Scripts */

        // twitter navigation scripts

        $(".navbar-menu-toggle").click(function(){
            var status = $('.menu-nav-toggle').attr('status');

            switch(parseInt(status)){
                case 0:
                    $(this).css('border-bottom-left-radius','0');
                    $(this).css('border-bottom-right-radius','0');
                    $('.menu-nav-toggle-div').css('border-top','solid 2px #025502');
                    $('.menu-nav-toggle').attr('status',1);
                    $('.menu-nav-toggle').addClass('show').removeClass('hide');
                break;
                case 1:
                    $('.menu-nav-toggle-div').css('border-top','none');
                    $(this).css('border-radius','4px');
                    $('.menu-nav-toggle').attr('status',0);
                    $('.menu-nav-toggle').addClass('hide').removeClass('show');
                break;
            }
        });
        

        $('#nav').affix({
           offset: { top: $('#start-offset').offset().top }
       });

        $('#nav-wrapper').height($("#nav").height());

        $('#nav').affix({
           offset: { top: $('#start-offset').offset().top }
       });

        /* Content Display Scripts*/
		$(".lazy").lazyload({ // Lazy image loader
			effect : "fadeIn"
		});

        /* Waypoints & history */
        $('.section').waypoint(function(direction) {
            // var dataUrl = $(this).attr('data-url');
            // var dataTitle = $(this).attr('data-title');
            // window.history.pushState(null,dataTitle,dataUrl);
        });

        $("#mainMenuSelect").change(function(){
           var href = $(this).find('option:selected').val();
           window.location = href;
       });
        /* Google maps display */
        // var latitude = parseFloat(47.6756731);
        // var longitude = parseFloat(-122.3194878);
        // google.maps.event.addDomListener(window, 'load', layout.googleMapsInitialize(latitude, longitude));


    },
    slider: function() {

                   var _CaptionTransitions = [];
            _CaptionTransitions["L"] = { $Duration: 900, x: 0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["R"] = { $Duration: 900, x: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["T"] = { $Duration: 900, y: 0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["B"] = { $Duration: 900, y: -0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["ZMF|10"] = { $Duration: 900, $Zoom: 11, $Easing: { $Zoom: $JssorEasing$.$EaseOutQuad, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 };
            _CaptionTransitions["RTT|10"] = { $Duration: 900, $Zoom: 11, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseOutQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} };
            _CaptionTransitions["RTT|2"] = { $Duration: 900, $Zoom: 3, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Round: { $Rotate: 0.5} };
            _CaptionTransitions["RTTL|BR"] = { $Duration: 900, x: -0.6, y: -0.6, $Zoom: 11, $Rotate: 1, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.8} };
            _CaptionTransitions["CLIP|LR"] = { $Duration: 900, $Clip: 15, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic }, $Opacity: 2 };
            _CaptionTransitions["MCLIP|L"] = { $Duration: 900, $Clip: 1, $Move: true, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic} };
            _CaptionTransitions["MCLIP|R"] = { $Duration: 900, $Clip: 2, $Move: true, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic} };

            var options = {
                $FillMode: 2,                                      //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actuall size, 5 contain for large image and actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 2500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,                          //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0,                                   //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                }
            };

            //Make the element 'slider1_container' visible before initialize jssor slider.
            $("#slider1_container").css("display", "block");
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

       //responsive code begin
        //you can remove responsive code if you don't want the slider scales
        //while window resizes
        function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code endeSlider);
        // responsive code end

    },

    setupLightbox: function() {

        // ACTIVITY INDICATOR

        var activityIndicatorOn = function() {
            $('<div id="imagelightbox-loading"><div></div></div>').appendTo('body');
        },
        
        activityIndicatorOff = function() {
            $( '#imagelightbox-loading' ).remove();
        },


        // OVERLAY

        overlayOn = function() {
            $('<div id="imagelightbox-overlay"></div>').appendTo('body');
        },
        overlayOff = function() {
            $('#imagelightbox-overlay').remove();
        },


        // CLOSE BUTTON

        closeButtonOn = function( instance ) {
            $('<button type="button" id="imagelightbox-close" title="Close"></button>').appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
        },
        closeButtonOff = function() {
            $('#imagelightbox-close').remove();
        },


        // CAPTION

        captionOn = function() {
            var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
            if( description.length > 0 )
                $( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
        },
        captionOff = function() {
            $( '#imagelightbox-caption' ).remove();
        },


        // NAVIGATION

        navigationOn = function( instance, selector ) {
            var images = $( selector );
            if( images.length ) {
                var nav = $( '<div id="imagelightbox-nav"></div>' );
                for( var i = 0; i < images.length; i++ )
                    nav.append( '<button type="button"></button>' );

                nav.appendTo( 'body' );
                nav.on( 'click touchend', function(){ return false; });

                var navItems = nav.find( 'button' );
                navItems.on( 'click touchend', function()
                {
                    var $this = $( this );
                    if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
                        instance.switchImageLightbox( $this.index() );

                    navItems.removeClass( 'active' );
                    navItems.eq( $this.index() ).addClass( 'active' );

                    return false;
                })
                .on( 'touchend', function(){ return false; });
            }
        },
        navigationUpdate = function( selector ) {
            var items = $( '#imagelightbox-nav button' );
            items.removeClass( 'active' );
            items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
        },
        navigationOff = function() {
            $( '#imagelightbox-nav' ).remove();
        },


        // ARROWS

        arrowsOn = function( instance, selector )
        {
            var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

            $arrows.appendTo( 'body' );

            $arrows.on( 'click touchend', function( e )
            {
                e.preventDefault();

                var $this   = $( this ),
                $target = $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
                index   = $target.index( selector );

                if( $this.hasClass( 'imagelightbox-arrow-left' ) )
                {
                    index = index - 1;
                    if( !$( selector ).eq( index ).length )
                        index = $( selector ).length;
                }
                else
                {
                    index = index + 1;
                    if( !$( selector ).eq( index ).length )
                        index = 0;
                }

                instance.switchImageLightbox( index );
                return false;
            });
        },
        arrowsOff = function() {
            $( '.imagelightbox-arrow' ).remove();
        };


        //  WITH ACTIVITY INDICATION

        $( 'a[data-imagelightbox="a"]' ).imageLightbox({
            onLoadStart:    function() { activityIndicatorOn(); },
            onLoadEnd:      function() { activityIndicatorOff(); },
            onEnd:          function() { activityIndicatorOff(); }
        });


        //  WITH OVERLAY & ACTIVITY INDICATION

        $( 'a[data-imagelightbox="b"]' ).imageLightbox({
            onStart:     function() { overlayOn(); },
            onEnd:       function() { overlayOff(); activityIndicatorOff(); },
            onLoadStart: function() { activityIndicatorOn(); },
            onLoadEnd:   function() { activityIndicatorOff(); }
        });


        //  WITH "CLOSE" BUTTON & ACTIVITY INDICATION

        var instanceC = $( 'a[data-imagelightbox="c"]' ).imageLightbox({
            quitOnDocClick: false,
            onStart:        function() { closeButtonOn( instanceC ); },
            onEnd:          function() { closeButtonOff(); activityIndicatorOff(); },
            onLoadStart:    function() { activityIndicatorOn(); },
            onLoadEnd:      function() { activityIndicatorOff(); }
        });


        //  WITH CAPTION & ACTIVITY INDICATION

        $( 'a[data-imagelightbox="d"]' ).imageLightbox({
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd:   function() { captionOn(); activityIndicatorOff(); },
            onEnd:       function() { captionOff(); activityIndicatorOff(); }
        });


        //  WITH ARROWS & ACTIVITY INDICATION

        var selectorG = 'a[data-imagelightbox="g"]';
        var instanceG = $( selectorG ).imageLightbox({
            onStart:        function(){ arrowsOn( instanceG, selectorG ); },
            onEnd:          function(){ arrowsOff(); activityIndicatorOff(); },
            onLoadStart:    function(){ activityIndicatorOn(); },
            onLoadEnd:      function(){ $( '.imagelightbox-arrow' ).css( 'display', 'block' ); activityIndicatorOff(); }
        });


        //  WITH NAVIGATION & ACTIVITY INDICATION

        var selectorE = 'a[data-imagelightbox="e"]';
        var instanceE = $( selectorE ).imageLightbox({
            onStart:     function() { navigationOn( instanceE, selectorE ); },
            onEnd:       function() { navigationOff(); activityIndicatorOff(); },
            onLoadStart: function() { activityIndicatorOn(); },
            onLoadEnd:   function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
        });


        //  ALL COMBINED

        var selectorF = 'a[data-imagelightbox="f"]';
        var instanceF = $( selectorF ).imageLightbox({
            onStart:        function() { overlayOn(); closeButtonOn( instanceF ); },
            onEnd:          function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
            onLoadStart:    function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd:      function() { captionOn(); activityIndicatorOff(); }
        });
    },
    backgroundResize: function(){
      var windowH = $(window).height();
      $(".background").each(function(i){
       var path = $(this);
			// variables
			var contW = path.width();
			var contH = path.height();
			var imgW = path.attr("data-img-width");
			var imgH = path.attr("data-img-height");
			var ratio = imgW / imgH;
			// overflowing difference
			var diff = parseFloat(path.attr("data-diff"));
			diff = diff ? diff : 0;
			// remaining height to have fullscreen image only on parallax
			var remainingH = 0;
			if(path.hasClass("parallax")){
               var maxH = contH > windowH ? contH : windowH;
               remainingH = windowH - contH;
           }
			// set img values depending on cont
			imgH = contH + remainingH + diff;
			imgW = imgH * ratio;
			// fix when too large
			if(contW > imgW){
               imgW = contW;
               imgH = imgW / ratio;
           }
			//
			path.data("resized-imgW", imgW);
			path.data("resized-imgH", imgH);
			path.css("background-size", imgW + "px " + imgH + "px");
		});
  },
  fullscreenFix: function(){
      var h = $('body').height();
	    // set .fullscreen height
	    $(".content-b").each(function(i){
         if($(this).innerHeight() <= h){
             $(this).closest(".fullscreen").addClass("not-overflow");
         }
     });
    }
};

