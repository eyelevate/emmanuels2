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
    events: function(){
        $(document).on('click','.remove',function(){
            var id = $(this).attr('schedule-rules-id');
            $(document).find("#myModal").attr('schedule-rules-id',id);
            $(document).find(".modal-body").html('Are you sure you want to delete this?');
        });
        $(document).on('click','.remove-btn',function(){
            var idd = $(this).parents('.modal:first').attr('schedule-rules-id');
            $("#form-"+idd).submit();
        });
    }
}