$(document).ready(function(){
	page.page_load();
	page.events();
});
page = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});

		$('.dd').nestable({
			maxDepth:2
		});
		$('.dd').on('change', function() {
   	 		list_reindex();
		});
		list_reindex();
	},
	events: function(){

	}
};
request = {

};
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

function list_reindex()
{
	$('.dd > ol > li').each(function (e) {
    	$(this).children('.menu-order').val(e);
	});
	$('.dd > ol > li > ol > li').each(function (e) {
		$(this).children('.menu-item-order').val(e);
	});
}
