$(document).ready(function(){
	user.page_load();
	user.events();
});

user = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			$(document).find(".modal-body").html('Are you sure you want to delete this user?');
			var id = $(this).attr('user-id');
			$(document).find("#myModal").attr('user',id);
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('user');
			$("#form-"+id).submit();
		});

	}
};

request = {

};
