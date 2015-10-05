$(document).ready(function(){
	schedules.pageLoad();
	schedules.events();
    schedules.stepy();
});

schedules = {
	pageLoad: function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
        });
       
        $(".estimate-date").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate:0,                  
            onSelect: function(date) {
                //DATE IS SELECTED, SHOW SUBMIT BTN
                date_set()
            }
        });
        $(".cleaning-date").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate:0,                  
            onSelect: function(date) {
                //DATE IS SELECTED, SHOW SUBMIT BTN
                date_set()
            }
        });
	},

    events: function(){

        //TYPE SECTION
        $(document).on('click','#estimate_radio',function(){
            //show relative input
            $('#estimate_calendar').removeClass('hide');
            $('#cleaning_calendar').addClass('hide');

            //RESET THE SUBMIT BTN
            $('#submit-btn').addClass('disables');
        });
        $(document).on('click','#cleaning_radio',function(){
            //show relative input
            $('#cleaning_calendar').removeClass('hide');
            $('#estimate_calendar').addClass('hide');

            //RESET THE SUBMIT BTN
            $('#submit-btn').addClass('disables');
        });


        // //PLACE SECTION
        // $(document).on('click','#house_radio',function(){
        //     $('.third_section').fadeIn();
        // });
        // $(document).on('click','#store_radio',function(){
        //     $('.third_section').fadeIn();
        // });



    },
        stepy: function() {
        $("#stepy li a").click(function(e){
            previous_step = $("#stepy .active");
            e.preventDefault();
            var href = $(this).attr('href');
            $("#stepy li").removeClass('active');
            $(this).parents('li:first').addClass('active');
            $(".steps").addClass('hide');
            $(href).removeClass('hide');
            // if ((href == "#billingInfo")) {
            //  if (previous_step.hasClass('customerInfo') || previous_step.hasClass('menuSelection')) {
            //  }
            // }
        });

        $(".next").click(function(){

            $("#stepy .active").next('li').addClass('row-active');
            $("#stepy li").removeClass('active');
            $(document).find(".row-active").addClass('active').removeClass('row-active');
            var href = $(document).find('#stepy .active a').attr('href');
            $(".steps").addClass('hide');
            $(href).removeClass('hide');
    // if($(this).attr('step') == 4) {//this step is billing info
    //  setDeliveryAddress();
    // }

    });
        $(".previous").click(function(){
            $("#stepy .active").prev('li').addClass('row-active');
            $("#stepy li").removeClass('active');
            $(document).find(".row-active").addClass('active').removeClass('row-active');
            var href = $(document).find('#stepy .active a').attr('href');
            $(".steps").addClass('hide');
            $(href).removeClass('hide');
    // if($(this).attr('step') == 5) {//coming from deliverySetup
    //  updateBillingInfo();
    // }
    });
    }
};
function date_set()
{
    $('#submit-btn').fadeIn();
}
