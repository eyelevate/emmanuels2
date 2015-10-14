$(document).ready(function(){
    schedulesadd.pageLoad();
    schedulesadd.events();

});
schedulesadd = {

    pageLoad: function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
        });
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    },
    events: function() {
        $(document).on('click','.schedulesadd',function(){
         
        });
    }
}
request_sd = {

};

