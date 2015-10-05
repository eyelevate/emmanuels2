$(document).ready(function(){
	page.page_load();
	page.events();
});

page = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			var count = $(this).attr('count');
			var id = $(this).attr('page-id');
			$(document).find("#myModal").attr('page-id',id);
			$(document).find(".modal-body").html('By deleting this page all links connecting to this page will be unlinked. '+
				'Are you sure you want to delete this page?');

			
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('page-id');
			$("#form-"+id).submit();
		});
		$( "#page-add" ).click(function() {
			var this_url = $(this).attr('this-url');
			window.open(this_url);
		});
		$( ".reload-pages" ).click(function() {
				location.reload();
		});
		$(document).on('change','.status',function(){
			var id = $(this).parents('tr:first').find('td:first').attr('this-id');
			var selected_status = $("option:selected", this).attr("value");
			var this_name = $("option:selected", this).html();
			$('#status-modal').attr('page_id',id);
			$('#status-modal').attr('selected_status',selected_status);
			if (selected_status == 1) {
				$('#status-modal').find('.modal-body:first').html('Are you sure you would like to change this status to draft?');
			} else {
				$('#status-modal').find('.modal-body:first').html('By changing this status to public all pages will be '+
				 'viewable on the website. Are you sure you would like to change this status to public?');

			}
			$('#status-modal').modal('show');
			
		});
		$(document).on('click','.yes-status-btn',function(){
			var id = $(this).parents('.modal:first').attr('page_id');
			var selected_status = $(this).parents('.modal:first').attr('selected_status');
			request.change_status(id,selected_status);
		});
		$(document).on('click','.no-status-btn',function(){
			var id = $(this).parents('.modal:first').attr('page_id');
			var selected_status = $(this).parents('.modal:first').attr('selected_status');
			var pre_status = 0;
			if (selected_status == 1) {
				pre_status = 2;
			}
			else {
				pre_status = 1;
			}
			$('.status-'+id).val(pre_status);
		});

	}
};

request = {
	change_status: function(id,selected_status) {
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/admins/pages/change-status',
			{
				"_token": token,
				"id": id,
				"selected_status":selected_status
			},
			function(results){
				var status = results.status;
				switch(status) {
					case 200: // Approved
					$('#status-modal').modal('hide');
					break;

					default:
					$('#status-modal').modal('hide');
					break;
				}
			}
			);
	}
};
