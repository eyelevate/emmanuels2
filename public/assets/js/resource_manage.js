$(document).ready(function(){
	resource.pageLoad();
	resource.events();
});

resource = {
	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		$("img.lazy").lazyload({
			effect : "fadeIn"
		});
		// $('#fileupload').fileupload({
		// 	// Uncomment the following to send cross-domain cookies:
		// 	//xhrFields: {withCredentials: true},
		// 	url: '/resources/fileupload'
		// });

    },

	events: function() {
		$("#addSlide").click(function(){
			var countLi = $("#step2_panel .slideshowDiv").length;
			var newCount = countLi +1;
			var newSlide = slide_show(newCount);
			$("#step2_panel").append(newSlide);

		});
		$(document).on('click','.deleteImage',function(){
			if(confirm('Are you sure you wish to delete this file?')) {
				var src = $(this).attr('data-src');
				element = $(this);
				var delete_status = resource.request_delete(src, element);
				console.log(delete_status);
			}
			
		});

		$('.popup-link').magnificPopup({
			type: 'image'
			// other options
		});


	},
	request_delete: function(src, element) {
		var token = $('meta[name=_token]').attr('content');

		$.post(
			'/admins/resources/delete',
			{
				"_token": token,
                src: src
			},
			function(obj){
                var result = $.parseJSON(obj);
                if(result.status == true) {
                	element.parents('.row-fluid:first').remove();
                } 
            }
        );

	},

};
