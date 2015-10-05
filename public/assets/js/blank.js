$(document).ready(function(){
	blank.pageLoad();
	blank.events();

});
blank = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function() {
        $(document).on('click','.blank',function(){
         
        });
	}
}
request = {

};

