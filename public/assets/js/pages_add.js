$(document).ready(function(){
	page.page_load();
	page.events();
	page.stepy();
});
page = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		tinymce.init({
			fontsize_formats: "8pt 10pt 12pt 14pt",
			selector: ".content-body",
			toolbar: "undo redo pastetext | styleselect |  bold italic | fontsizeselect"
		});

	},
	stepy: function() {
		$("#deliveryStepy li a").click(function(e){
			previous_step = $("#deliveryStepy .active");
			e.preventDefault();
			var href = $(this).attr('href');
			$("#deliveryStepy li").removeClass('active');
			$(this).parents('li:first').addClass('active');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
			// if ((href == "#billingInfo")) {
			// 	if (previous_step.hasClass('customerInfo') || previous_step.hasClass('menuSelection')) {
			// 	}
			// }
		});

		$(".next").click(function(){

			$("#deliveryStepy .active").next('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
	// if($(this).attr('step') == 4) {//this step is billing info
	// 	setDeliveryAddress();
	// }

});
		$(".previous").click(function(){
			$("#deliveryStepy .active").prev('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
	// if($(this).attr('step') == 5) {//coming from deliverySetup
	// 	updateBillingInfo();
	// }
});
	},
	events: function(){
		$('#title').friendurl({id : 'url'});
		$("#title").on("change", function () {
			$('#url').val("/"+urlfriendly($("#title").val()));
		});

		$(document).on('click','#content .panel',function(){
			$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
			$(this).removeClass('panel-default').addClass('panel-success');
		});
		$("#add-content").click(function(){
			var content_set_count = $(document).find('#content .panel-collapse').length;
			$(document).find('#content .panel-collapse').removeClass('in');
			$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
			request.add_content(content_set_count);
		});
		$("#preview-btn").click(function(){
			// var serialized_data = $("#add-form").serialize();
			// request.load_preview(serialized_data);
		});
		$("#title").keyup(function(){
			var have_error = false; 
			var name_array = $(window.controller_names);
			var dup_val = "";
			var enterd_title = $(this).val();
			jQuery.each( name_array, function( i, val ) {
				if (val == enterd_title && val != "") {
					dup_val = val;
					have_error = true;
				};
			});
			if (have_error == true) {
				$(this).parents('.form-group:first').addClass('has-error');
				$(this).parents('.form-group:first').find('#title-duplicate').removeClass('hide');
				$('#accordion-pro').collapse('show');
				$(document).find('#labels-div .'+dup_val).removeClass('label-default').addClass('label-danger');
				$('.submit-btn').addClass('disabled');
			} else {
				$(this).parents('.form-group:first').removeClass('has-error');
				$(this).parents('.form-group:first').find('#title-duplicate').addClass('hide');
				$(document).find('#labels-div .label').removeClass('label-danger').addClass('label-default');
				$('.submit-btn').removeClass('disabled');
			}
		});
		$(document).on('click','.remove-collapse',function(){

			// console.log($(document).find('.content-area .content-set').length);
			var count = 1;
			$( ".content-area .content-set" ).each(function( index ) {
				$(this).find('.panel-title a .this-title').html('Content '+count);
				count++;
			});
			var this_set = $(this).parents('.content-set').attr('this_set');

			tinymce.remove('#content-body-'+this_set);
			$(this).parents('.content-set:first').remove();
			var count = $('#content_count').val();
			re_count = (count == 0) ? null : count--;

			$('#content_count').val(re_count);
		});
	}
};
request = {
	add_content: function(content_set_count) {
		
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/admins/pages/content-add',
			{
				"_token": token,
				"content_set_count": content_set_count
			},
			function(results){
				var status = results.status;
				var html = results.html;
				switch(status) {
					case 200: // Approved

					$('#content_count').val((content_set_count--));
					$('.content-area').append(html);
					tinymce.init({
						fontsize_formats: "8pt 10pt 12pt 14pt",
						selector: ".content-body",
						toolbar: "undo redo pastetext | styleselect |  bold italic | fontsizeselect"
					});

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