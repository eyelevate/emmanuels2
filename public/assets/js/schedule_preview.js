$(document).ready(function() {
    page.page_load();
    page.events();
 alert();
});
page = {asdas
	    page_load: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });asd

    },
     events: function() {

    }
}