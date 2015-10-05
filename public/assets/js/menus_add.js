$(document).ready(function(){
	menu.page_load();
	menu.events();
});
menu = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){
		$('#name').friendurl({id : 'url'});
		$("#name").on("change", function () {
			$('#url').val("/"+urlfriendly($("#name").val()));
		});
		$(".kind").on("change", function () {
			var option_selected = $(this).find('option:selected').val();
			switch(parseInt(option_selected)){
				case 1:
				$('.hide-link').addClass('show').removeClass('hide');
				$('#url').attr('id','url_link');
				var option_selected = $('.page_id').find('option:selected').text();
				$('#url_link').val("/");
				if (option_selected != "Select Page") {
					$('#url_link').val("/"+urlfriendly(option_selected));
				};
				break
				case 2:
				$('.hide-link').addClass('hide').removeClass('show');

				$('#url_link').attr('id','url');

				var _name = urlfriendly($('#name').val());
				$('#url').val("/"+_name);
				break;
			}
		});
		$(".page_id").on("change", function () {
			var option_selected = $(this).find('option:selected').text();
			if (option_selected != "Select Page") {
				$('#url_link').val("/"+urlfriendly(option_selected));
			}
		});
			$( "#page-index" ).click(function() {
				var this_url = $(this).attr('this-url');
				 window.open(this_url);
			});
			$( "#page-add" ).click(function() {
				var this_url = $(this).attr('this-url');
				 window.open(this_url);
			});
			$( ".reload-pages" ).click(function() {
				location.reload();

			});
			$( "#reload-pages-select" ).click(function() {
				request.reload_pages();
				$('#url_link').val("");
			});
	}
};

request = {
		reload_pages: function() {
		$('.loading-icon').addClass('hide');
		$('#loading-gif').removeClass('hide');
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/admins/pages/reload-pages',
			{
				"_token": token
			},
			function(results){
				$('#loading-gif').addClass('hide');
				$('.loading-icon').removeClass('hide');
				var status = results.status;
				var pages_option = results.pages_option;
				switch(status) {
					case 200: // Approved
						$('.page_id').html(pages_option);
					break;

					default:
					break;
				}
			}
			);
	}
};
function urlfriendly(url)
{
	url = url
	.toLowerCase() // change everything to lowercase
	.replace(/^\s+|\s+$/g, "") // trim leading and trailing spaces		
	.replace(/[_|\s]+/g, "-") // change all spaces and underscores to a hyphen
	.replace(/[^a-z\u0400-\u04FF0-9-]+/g, "") // remove all non-cyrillic, non-numeric characters except the hyphen
	.replace(/[-]+/g, "-") // replace multiple instances of the hyphen with a single instance
	.replace(/^-+|-+$/g, ""); // trim leading and trailing hyphens
	return url;
}
function url_redirect(url)
{

}
