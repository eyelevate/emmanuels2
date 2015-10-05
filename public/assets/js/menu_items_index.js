$(document).ready(function(){
	menu_item.page_load();
	menu_item.events();
});

menu_item = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			$(document).find(".modal-body").html('Are you sure you want to delete this?');
			var id = $(this).attr('menu-item-id');
			$(document).find("#myModal").attr('menu-item',id);
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('menu-item');
			$("#form-"+id).submit();
		});
		$( ".reload-pages" ).click(function() {
		location.reload();
		});

	}
};

request = {

};
