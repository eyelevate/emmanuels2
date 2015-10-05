$(document).ready(function(){
	pages_js.pageLoad();
});

pages_js = {
	pageLoad: function(){
        function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(47.5734982, -122.33009440000001),
          zoom: 19,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
	}
};

