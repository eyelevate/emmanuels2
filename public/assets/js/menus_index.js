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

		$(document).on('click','.remove',function(){
			var count = $(this).attr('count');
			var id = $(this).attr('menu-id');
			request.count_menu_items(id);
			
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('menu-id');
			$("#form-"+id).submit();
		});
		$( ".reload-pages" ).click(function() {
			location.reload();
		});

	}
};

request = {
	count_menu_items: function(id) {
		
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/admins/menus/count-items',
			{
				"_token": token,
				"id": id
			},
			function(results){
				var status = results.status;
				var count = results.count;
				$('#myModal').modal('show');
				switch(status) {
					case 200: // Approved
					$(document).find("#myModal").attr('menu-id',id);
					if (count == 1) {
						$(document).find(".modal-body").html('This menu group has '+count+' item. Deleting this menu group will result in the loss of all menu items that are belong to this group. Click remove to confirm?');
					} else if (count == 0){
						$(document).find(".modal-body").html('Are you sure you want to delete this?');
					}
					else {
						$(document).find(".modal-body").html('This menu group has '+count+' items.  Deleting this menu group will result in the loss of all menu items that are belong to this group. Click remove to confirm?');
					}
					break;

					default:
					break;
				}
			}
			);
	}
};
