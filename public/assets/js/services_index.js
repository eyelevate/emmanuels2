$(document).ready(function(){
	service.page_load();
	service.events();
});

service = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			var id = $(this).attr('service-id');
			$(document).find("#myModal").attr('service-id',id);
			$(document).find(".modal-body").html('Are you sure you want to delete this?');
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('service-id');
			$("#form-"+id).submit();
			
		});

	}
};

request = {

};
