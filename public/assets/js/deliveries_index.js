$(document).ready(function(){
	delivery.page_load();
	delivery.events();
});

delivery = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			var id = $(this).attr('delivery-id');
			$(document).find("#myModal").attr('delivery-id',id);
			$(document).find(".modal-body").html('Are you sure you want to delete this delivery?');

		});

		$(document).on('click','.remove-btn',function(){
			
			var id = $(this).parents('.modal:first').attr('delivery-id');
			$("#form-"+id).submit();
		});

	}
};

request = {

};
