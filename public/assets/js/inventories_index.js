$(document).ready(function(){
	inventory.page_load();
	inventory.events();
});

inventory = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			var count = $(this).attr('count');
			var id = $(this).attr('inventory-id');
			$(document).find("#myModal").attr('inventory-id',id);
			if (count == 1) {
				$(document).find(".modal-body").html('This inventory group has '+count+' item. Deleting this inventory group will result in the loss of all inventory items that are belong to this group. Press remove to confirm?');
			} else if (count == 0){
				$(document).find(".modal-body").html('Are you sure you want to delete this?');
			}
			else {
				$(document).find(".modal-body").html('This inventory group has '+count+' items.  Deleting this inventory group will result in the loss of all inventory items that are belong to this group. Press remove to confirm?');
			}
			
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('inventory-id');
			$("#form-"+id).submit();
			
		});

	}
};

request = {

};
