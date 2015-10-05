$(document).ready(function(){
	tax.page_load();
	tax.events();
});

tax = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			var id = $(this).attr('tax-id');
			$(document).find("#myModal").attr('tax-id',id);
			$(document).find(".modal-body").html('Are you sure you want to delete this tax?');

		});

		$(document).on('click','.remove-btn',function(){
			
			var id = $(this).parents('.modal:first').attr('tax-id');
			$("#form-"+id).submit();
		});

	}
};

request = {

};
