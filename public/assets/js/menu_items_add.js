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
		$(".menus").on("change", function () {
			var page_option_selected = "";
			var menu_option_selected = "";
			menu_option_selected = $(this).find('option:selected').text();
			page_option_selected = $('.page_id').find('option:selected').text();
			if ((page_option_selected != "Select Page")&&(menu_option_selected != "Select Menu") ) {
				$('#url').val("/"+urlfriendly(menu_option_selected)+"/"+urlfriendly(page_option_selected));
			} else {
				$('#url').val("");
			}
		});
		$( "#page-index" ).click(function() {
			var this_url = $(this).attr('this-url');
			window.open(this_url);
		});
	
		$( ".reload-page" ).click(function() {
			location.reload();
		});

		$( "#reload-pages-select" ).click(function() {
			request.reload_pages();
		});

		$( "#reload-menus-select" ).click(function() {
			request.reload_menus();
		});

		$( "#add-menu-group" ).click(function() {
			var this_url = $(this).attr('this-url');
			window.open(this_url);
		});

		$( "#add-page" ).click(function() {
			var this_url = $(this).attr('this-url');
			window.open(this_url);
		});

		$( "#menu-index" ).click(function() {
			var this_url = $(this).attr('this-url');
			window.open(this_url);
		});


		$(".page_id").on("change", function () {
			var page_option_selected = "";
			var menu_option_selected = "";

			page_option_selected = $(this).find('option:selected').text();
			menu_option_selected = $('.menus').find('option:selected').text();

			if ((page_option_selected != "Select Page")&&(menu_option_selected != "Select Menu") ) {
				$('#url').val("/"+urlfriendly(menu_option_selected)+"/"+urlfriendly(page_option_selected));
			} else {
				$('#url').val("");
			}
		});
	}
};

request = {
			reload_pages: function() {
		
		var token = $('meta[name=_token]').attr('content');
		$('.loading-icon-page').addClass('hide');
		$('#loading-gif-page').removeClass('hide');
		$.post(
			'/admins/pages/reload-pages',
			{
				"_token": token
			},
			function(results){
				$('#loading-gif-page').addClass('hide');
				$('.loading-icon-page').removeClass('hide');
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
	},
		reload_menus: function() {
		
		var token = $('meta[name=_token]').attr('content');
		$('.loading-icon-menu').addClass('hide');
		$('#loading-gif-menu').removeClass('hide');
		$.post(
			'/admins/menus/reload-menus',
			{
				"_token": token
			},
			function(results){
				$('#loading-gif-menu').addClass('hide');
				$('.loading-icon-menu').removeClass('hide');
				var status = results.status;
				var menus_option = results.menus_option;
				switch(status) {
					case 200: // Approved
						$('.menus_select').html(menus_option);
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
