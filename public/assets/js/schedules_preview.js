$(document).ready(function() {
    page.page_load();
    page.events();

});
page = {
    page_load: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
   
    },
    events: function() {

    }
}