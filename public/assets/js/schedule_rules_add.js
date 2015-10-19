$(document).ready(function() {
    pages.pageLoad();
    pages.events();
    pages.stepy();
});

pages = {
    pageLoad: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        });
        $("#overwrite-date-single-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0,
            onSelect: function(date) {
                remove_calendar_error($(this));
            }
        });
        $("#overwrite-date-range-start-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0,
            onSelect: function(date) {
                remove_calendar_error($(this));
            }
        });
        $("#overwrite-date-range-end-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0,
            onSelect: function(date) {
                remove_calendar_error($(this));
            }
        });
        $("#blackout-input").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0,
            onSelect: function(date) {
                remove_calendar_error($(this));
                add_new_blackout_date(date);
                //CLEAR OUT THE SELECTED DATE AFTER TIMEOUT
                setTimeout(function(){ $('#blackout-input').val(''); }, 500);
            }
        });

        prepare_accordions_color();
    },
    events: function() {
        $(document).on('click', 'input[value=open]', function() {
            $(this).parents('.each-day').removeClass('panel-default').addClass('panel-info');
        });
        $(document).on('click', 'input[value=closed]', function() {
            $(this).parents('.each-day').removeClass('panel-info').addClass('panel-default');
              $('.panel-collapse.in')
                .collapse('hide');
        });
        $(document).on('click', '.blackout-remove-btn', function() {
            $(this).parents('.blackout-single-wrapper').remove();
            reindex_blackouts();
        });





        $(document).find(".form-selects").change(function() {
           if ($(this).val() != 0) {
            $(this).parents('.form-group:first').removeClass('has-error');
            $(this).parents('.form-group:first').find('.select-error:first').addClass('hide');
           };
        });

        $(document).on('click', '#add-overwrite', function() {
            $('#overwrite').find('.panel-collapse').removeClass('in');
            var count = $('.overwrite-wrapper').length;
            request.add_overwrite(count);
        });

        $(document).on('click', '.add-break-btn', function() {
            $('.incomplete-break').addClass('hide');
            $('.form-group-error-not').removeClass('has-error');

            var empty_error = 0;
            var b_count = 1;

            $(this).parents('.breaks-container').find('.form-group').removeClass('has-error');

            $(this).parents('.breaks-container').find('.form-break').each(function( index ) {
                if ($("option:selected", this).val() == '' || $("option:selected", this).val() == '0') {
                        $(this).parents('.form-group:first').addClass('has-error');
                        $(this).parents('.breaks-container:first').find('.incomplete-break:first').removeClass('hide');
                        empty_error = 1;
                };
            });

            if (empty_error == 0) {
                var this_parent = $(this).parents('.breaks-container:first');

                var from_hour = this_parent.find('.from-hour').val();
                var from_minute = this_parent.find('.from-minute').val();
                var from_ampm = this_parent.find('.from-ampm').val();
                var to_hour = this_parent.find('.to-hour').val();
                var to_minute = this_parent.find('.to-minute').val();
                var to_ampm = this_parent.find('.to-ampm').val();


                $(this).parents('.breaks-container').find('.br-alert').each(function( index ) {
                    $(this).find('.b-badge').text(b_count);
                    b_count = b_count + 1;
                });

                var this_day = $(this).parents('.breaks-container:first').attr('this-day');
                var alert_html = '<div class="alert alert-info alert-dismissible br-alert" style="margin-bottom: 1px;" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <span class="badge b-badge">'+b_count+'</span>&nbsp&nbspFrom&nbsp&nbsp'+from_hour+':'+from_minute+''+from_ampm+'&nbsp&nbspTo&nbsp&nbsp'+to_hour+':'+to_minute+''+to_ampm+'</div>';
                var break_input = '<input name="hours['+this_day+'][breaks]['+b_count+'][from_hour]" type="hidden" value="'+from_hour+'">';
                    break_input += '<input name="hours['+this_day+'][breaks]['+b_count+'][from_minute]" type="hidden" value="'+from_minute+'">';
                    break_input += '<input name="hours['+this_day+'][breaks]['+b_count+'][from_ampm]" type="hidden" value="'+from_ampm+'">';
                    break_input += '<input name="hours['+this_day+'][breaks]['+b_count+'][to_hour]" type="hidden" value="'+to_hour+'">';
                    break_input += '<input name="hours['+this_day+'][breaks]['+b_count+'][to_minute]" type="hidden" value="'+to_minute+'">';
                    break_input += '<input name="hours['+this_day+'][breaks]['+b_count+'][to_ampm]" type="hidden" value="'+to_ampm+'">';

                $(this).parents('.breaks-container').find('.breaks-div').append(alert_html);
                $(this).parents('.breaks-container').find('.breaks-div').append(break_input);
            };
            
        });

        $(document).on('click', '.add-area', function() {
            $('#area-dup').addClass('hide');
            var this_text = $(this).parents('.input-group').find('.area-text').val();
            $(this).parents('.input-group').find('.area-text').val('');
            var dup = 0;
            var obj = $('.label-area');
            var count = $('.label-area').length;

            $('.label-area').removeClass('new-zip');

            if (!$.isBlank(this_text)) {
                $('.this-area-t').each(function( index ) {
                  if ($(this).text() == this_text) {
                    dup = 1;
                  };
                });

                if (dup == 0) {

                    var label_html = '<span class="label label-success label-area new-zip '+this_text+'" > <span class="this-area-t">'+this_text+'</span> <i class="glyphicon glyphicon-trash delete-area"></i></span>';
                    var input_html = '<input class="'+this_text+'" type="hidden" name="areas['+count+this_text+']" value="'+this_text+'" >';
                    $('#area-group-wrapper').append(label_html);
                    $('#area-group-wrapper').append(input_html);

                } else {
                    $('#area-dup').removeClass('hide');
                }
            }

        });

        $(document).on('click', '.delete-area', function() {
            var this_text = $(this).parents('.label-area').find('.this-area-t').text();
            $('.'+this_text).remove();
        });

        $(document).on('click', '.remove-overwrite', function() {
            $(this).parents('.this-wrapper').remove();

            //REINDEX 
            var reindex_count = 0;
            $('.this-wrapper').each(function(index) {
                reindex_count = reindex_count + 1;
                //RENAME THE TITLE 
                $(this).find('.this-title').html('OverWrite Date '+reindex_count+ ' '+'<span style="color:#d9534f" class="hide glyphicon glyphicon-warning-sign this-error-sign this-error-sign-'+reindex_count+'"></span>');

                // TRAVERSE THROUGHT ALL FORMS AND CLASSES TO CHANGE THE NUMBER

                //REINDEX TYPE SELECT BOX AND FORM
                $(this).find('.type-select:first').attr('name','overwrite['+reindex_count+'][type]');

                //REINDEX SINGLE DATE SELECT BOX
                $(this).find('.overwrite-date-single:first').attr('name','overwrite['+reindex_count+'][date]');
                $(this).find('.overwrite-date-single:first').attr('id','overwrite-date-single-'+reindex_count);

                //THE ID IS CHANGE, RE-INITIATE THE DATEPICKER
                $('#overwrite-date-single-'+reindex_count).datepicker("destroy");

                $(document).find('#overwrite-date-single-'+reindex_count).datepicker({
                    dateFormat: 'DD, d MM, yy',
                    minDate: 0
                });

                //REINDEX RANGE DATE SELECT BOX

                //START
                $(this).find('.overwrite-date-range-start:first').attr('name','overwrite['+reindex_count+'][start]');
                $(this).find('.overwrite-date-range-start:first').attr('id','overwrite-date-range-start-'+reindex_count);

                //THE ID IS CHANGE, RE-INITIATE THE DATEPICKER
                $('#overwrite-date-range-start-'+reindex_count).datepicker("destroy");

                $(document).find('#overwrite-date-range-start-'+reindex_count).datepicker({
                    dateFormat: 'DD, d MM, yy',
                    minDate: 0
                });
                //END
                $(this).find('.overwrite-date-range-end:first').attr('name','overwrite['+reindex_count+'][end]');
                $(this).find('.overwrite-date-range-end:first').attr('id','overwrite-date-range-end-'+reindex_count);

                //THE ID IS CHANGE, RE-INITIATE THE DATEPICKER
                $('#overwrite-date-range-end-'+reindex_count).datepicker("destroy");

                $(document).find('#overwrite-date-range-end-'+reindex_count).datepicker({
                    dateFormat: 'DD, d MM, yy',
                    minDate: 0
                });

                //REINDEXING CATEGORY
                $(this).find('.overwrite_hours_container .form-selects').attr('this_category',reindex_count);
                
                //REINDEXING HOURS, MINUTS, AMPMS
                $(this).find('.overwrite-select-hour-open:first').attr('name','overwrite['+reindex_count+'][open_hour]');
                $(this).find('.overwrite-select-minute-open:first').attr('name','overwrite['+reindex_count+'][open_minute]');
                $(this).find('.overwrite-select-ampm-open:first').attr('name','overwrite['+reindex_count+'][open_ampm]'); 
                $(this).find('.overwrite-select-hour-close:first').attr('name','overwrite['+reindex_count+'][close_hour]');
                $(this).find('.overwrite-select-minute-close:first').attr('name','overwrite['+reindex_count+'][close_minute]');
                $(this).find('.overwrite-select-ampm-close:first').attr('name','overwrite['+reindex_count+'][close_ampm]');                
            
                //REINDEX TIME ERROR (END TIME IS SMALLER THAN START TIME)
                $(this).find('.time-error-overwrite:first').attr('id','time-error-overwrite-'+reindex_count);
                $(this).find('.employees-no:first').attr('name','overwrite['+reindex_count+'][number_of_employee]');
            });
        });
    },
    stepy: function() {
        $("#deliveryStepy li a").click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            previous_step = $("#deliveryStepy .active");
            var _this = $(this);
            if (!($(this).parents('li:first').hasClass('disabled'))) {
                // IF THE PREVIOUS STEP WAS 1
                if (previous_step.attr('id') == 'schedule-stepy') {
                    //VALIDATE BEFORE CHANGING THE STEP
                    if (href != '#setup') {
                        validate_step_2(_this, href, "stepy");                       
                    } else {
                        validate_step_1(_this, href, "stepy");
                    }
                } else if(previous_step.attr('id') == 'overwrite-stepy'){
                    //VALIDATE DATA IF THE NEXT STEP WAS BLACKOUT DATES
                    if (href == "#blackout_date") {
                        validate_step_3(_this, href, "stepy");
                    } else {
                        $("#deliveryStepy li").removeClass('active');
                        $(this).parents('li:first').addClass('active');
                        $(".steps").addClass('hide');
                        $(href).removeClass('hide');
                    }
                } else {
                    e.preventDefault();
                    $("#deliveryStepy li").removeClass('active');
                    $(this).parents('li:first').addClass('active');
                    $(".steps").addClass('hide');
                    $(href).removeClass('hide');
                }
            }
        });

        $(".next").click(function() {
            var _this = $(this);
            var this_step = parseInt($(this).attr('step'));
            switch(this_step){
                case 2:
                    validate_step_2(_this, null, "btn");
                break;
                default:
                    validate_step_1(_this, null, "btn");
                break;
            }
        });
        $("#set-forgotten-btn").click(function() {
            $('#member-tab').addClass('active');
            $('#new-address-tab').removeClass('active');
            $('#address').removeClass('hide');
            $('#newaddress').removeClass('show').addClass('hide');
        });
        $(".previous").click(function() {
            $("#deliveryStepy .active").prev('li').addClass('row-active');
            $("#deliveryStepy li").removeClass('active');
            $(document).find(".row-active").addClass('active').removeClass('row-active');
            var href = $(document).find('#deliveryStepy .active a').attr('href');
            $(".steps").addClass('hide');
            $(href).removeClass('hide');
        });

        $(document).find(".type-select").change(function() {
            var value = $(this).find('option:selected').val();
            if (value == "single") {
                $(this).parents('.this-wrapper').find('.range-wrapper').addClass('hide');
                $(this).parents('.this-wrapper').find('.single-wrapper').removeClass('hide');
            } else if (value = "range") {
                $(this).parents('.this-wrapper').find('.range-wrapper').removeClass('hide');
                $(this).parents('.this-wrapper').find('.single-wrapper').addClass('hide');
            }
        });
    }
}
request = {
    add_overwrite: function(count) {
        var token = $('meta[name=csrf-token]').attr('content');
        $.post(
            '/admins/schedule-rules/overwrite', {
                "_token": token,
                "count": count
            },
            function(result) {
                var data = result.data;
                var status = 200;
                var html = result.html;
                switch (status) {
                    case 200: // Approved
                        $('#content-wrapper').append(html);
                        $(document).find("#overwrite-date-single-" + count).datepicker({
                            dateFormat: 'DD, d MM, yy',
                            minDate: 0
                        });
                        $(document).find("#overwrite-date-range-start-" + count).datepicker({
                            dateFormat: 'DD, d MM, yy',
                            minDate: 0
                        });
                        $(document).find("#overwrite-date-range-end-" + count).datepicker({
                            dateFormat: 'DD, d MM, yy',
                            minDate: 0
                        });
                        $(document).find(".type-select").change(function() {
                            var value = $(this).find('option:selected').val();
                            if (value == "single") {
                                $(this).parents('.this-wrapper').find('.range-wrapper').addClass('hide');
                                $(this).parents('.this-wrapper').find('.single-wrapper').removeClass('hide');
                            } else if (value = "range") {
                                $(this).parents('.this-wrapper').find('.range-wrapper').removeClass('hide');
                                $(this).parents('.this-wrapper').find('.single-wrapper').addClass('hide');
                            }
                        });
                        break;

                    case 201:

                        break;

                    case 400:

                        break;

                    default:
                        break;
                }
            }
        );
    },
    validate_hours_ajax: function(data, this_this, href, type) {

        // TYPE = STEPY OR THE NEXT BTN
        var token = $('meta[name=csrf-token]').attr('content');
        $.post(
            '/admins/schedule-rules/validate-hours', {
                "_token": token,
                "data": data
            },
            function(result) {
                var status = 200;
                var data = result.validation_result;
                var error = 0;
                switch (status) {
                    case 200: // Approved
                    var first_this = null;
                    var count = 0;
                    if (data) {
                        $.each(data, function(i, val) {
                            //IF IT HAS ERROR GET THE KEY AND SHOW IT
                            count = count + 1;
                            if (val["info"] == "error") {
                                error = 1;
                                $('.time-error-' + i).removeClass('hide');
                                $('.time-error-' + i).parents('.list-group-item:first').find('.form-group').addClass('has-error');
                                $('.day-error-container-'+i).removeClass('hide');
                                $('.day-error-number-'+i).text('End Time');
                                $('.day-success-container-'+ i).addClass('hide');
                                if (count == 1) {
                                    first_this = i;
                                };
                            } else {
                                $('.day-error-container-'+i).addClass('hide');
                                $('.day-error-number-'+i).text('');
                                $('.day-success-container-'+ i).removeClass('hide');
                            }
                        });
                        
                    };
                        if (error == 0) {
                            clear_all_validation_errors();
                            if (type == "stepy") {
                                $("#deliveryStepy li").removeClass('active');
                                this_this.parents('li:first').addClass('active');
                                $(".steps").addClass('hide');
                                $(href).removeClass('hide');
                            } else {
                                $("#deliveryStepy .active").next('li').addClass('row-active');
                                $("#deliveryStepy li").removeClass('active');
                                $(document).find(".row-active").addClass('active').removeClass('row-active');
                                var _href = $(document).find('#deliveryStepy .active a').attr('href');
                                $(".steps").addClass('hide');
                                $(_href).removeClass('hide');
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        );
    },
        validate_hours_ajax_2: function(data, this_this, href, type) {
        // TYPE = STEPY OR THE NEXT BTN
        var token = $('meta[name=csrf-token]').attr('content');
        $.post(
            '/admins/schedule-rules/validate-overwrite-hours', {
                "_token": token,
                "data": data
            },
            function(result) {
                var status = 200;
                var data = result.validation_result;
                var error = 0;
                switch (status) {
                    case 200: // Approved
                    var first_this = null;
                    var count = 0;
                        $.each(data, function(i, val) {
                            //IF IT HAS ERROR GET THE KEY AND SHOW IT
                            count = count + 1;
                            if (val["info"] == "error") {
                                error = 1;
                                $('#time-error-overwrite-' + i).removeClass('hide');
                                $('#time-error-overwrite-' + i).parents('.list-group-item:first').find('.form-group').addClass('has-error');

                                $('.this-error-sign-'+ i).removeClass('hide');
                            };
                        });
                        if (error == 0) {
                            if (type == "stepy") {
                                $("#deliveryStepy li").removeClass('active');
                                this_this.parents('li:first').addClass('active');
                                $(".steps").addClass('hide');
                                $(href).removeClass('hide');
                            } else {
                                $("#deliveryStepy .active").next('li').addClass('row-active');
                                $("#deliveryStepy li").removeClass('active');
                                $(document).find(".row-active").addClass('active').removeClass('row-active');
                                var _href = $(document).find('#deliveryStepy .active a').attr('href');
                                $(".steps").addClass('hide');
                                $(_href).removeClass('hide');
                            }

                        }
                        break;
                    default:
                        break;
                }
            }
        );
    }
}

function validate_step_1(_this, href, type) {
    if (type == "stepy") {
        $("#deliveryStepy li").removeClass('active');
        _this.parents('li:first').addClass('active');
        $(".steps").addClass('hide');
        $(href).removeClass('hide');
    } else {
        $("#deliveryStepy .active").next('li').addClass('row-active');
        $("#deliveryStepy li").removeClass('active');
        $(document).find(".row-active").addClass('active').removeClass('row-active');
        var _href = $(document).find('#deliveryStepy .active a').attr('href');
        $(".steps").addClass('hide');
        $(_href).removeClass('hide');
    }
}

function validate_step_2(_this, href, type){
    //close all accordions
  $('.panel-collapse.in')
    .collapse('hide');
    clear_error_messages();
    var error_count = 0;
    //STEPY WAS CLICKED
    if (type == "stepy") {
        clear_all_validation_errors();
        //FLAG ZERO IS NO ERROR
        var flag = 0;
        $('.step-1').find('tr').each(function(index) {
            var each_error_count = 0;
            //FOR EACH DAY
            var selected_radio = $("input:radio:checked", this).val();
            //IGNORE VALIDATION IF IT WAS CLOSED
            if (selected_radio != "closed") {
                //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                $(this).find('.form-selects').each(function(index) {
                    if ($("option:selected", this).val() == '' || $("option:selected", this).val() == '0') {
                        flag = 1;
                        //TO KEEP TRACK OF THE FIRST ERROR
                        error_count = error_count + 1;
                        each_error_count = each_error_count + 1;

                        //IF THE SELECT WAS NOT SELECTED ADD HAS-ERROR TO IT
                        $(this).parents('.form-group:first').addClass('has-error')
                            .find('.select-error').removeClass('hide');
                            //SAVE THE FIRST ERROR (this), SO LATER WE CAN SCROLL TO IT
                            if (error_count == 1) {
                                last_this = $(this);
                            };
                    }
                    if ($(this).hasClass('drivers-text')) {
                        var this_driver_text = $(this).val();
                        if ($.isBlank(this_driver_text)) {
                            flag = 1;
                            //TO KEEP TRACK OF THE FIRST ERROR
                            error_count = error_count + 1;
                            each_error_count = each_error_count + 1;
                            //IF THE SELECT WAS NOT SELECTED ADD HAS-ERROR TO IT
                            $(this).parents('.form-group:first').addClass('has-error')
                                .find('.select-error').removeClass('hide');
                                //SAVE THE FIRST ERROR (this), SO LATER WE CAN SCROLL TO IT
                                if (error_count == 1 ) {
                                    last_this = $(this);
                                };
                        }
                    };
                });
            }

            if (each_error_count > 0) {
                    $(this).parents('.each-day:first').find('.day-error-container').removeClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').removeClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').text(each_error_count);
            } else {
                    $(this).parents('.each-day:first').find('.day-error-container').addClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').addClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').text('');
                    $(this).parents('.each-day:first').find('.day-success-container').removeClass('hide'); 
            }

        });

        //IF THERE WAS NOW ERRORS THEN PROCEED TO NEXT STEPY
        if (flag == 0) {
            //VALIDATE HOURS
            var data = [];
            // INIT ALL ARRAYS
            for (var i = 0; i <= 7; i++) {
                data[i] = [];
            };
            var f_count = 0;
            $('.step-1').find('tr').each(function(index) {
                //FOR EACH DAY
                var selected_radio = $(" input:radio:checked").val();
                //IGNORE VALIDATION IF IT WAS CLOSED
                if (selected_radio != "closed") {
                        //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                        $(this).find('.form-selects').each(function(index) {
                            if (!$(this).hasClass('drivers-text')) {
                                var this_value = $("option:selected", this).val();
                                var this_category = $(this).attr('this_category');
                                data[this_category].push(this_value);
                                f_count = f_count + 1;
                            } 
                        }); 

                };
            });
            request.validate_hours_ajax(data, _this, href,type);
        };
    } 
    // NEXT BTN WAS CLICKED
    else {
        clear_all_validation_errors();
        var flag = 0;
        $('.step-1').find('tr').each(function(index) {
            var each_error_count = 0;
            //FOR EACH DAY
            var selected_radio = $(" input:radio:checked", this).val();
            //IGNORE VALIDATION IF IT WAS CLOSED
            if (selected_radio != "closed") {
                //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                $(this).find('.form-selects').each(function(index) {
                    if ($("option:selected", this).val() == '' || $("option:selected", this).val() == '0') {
                        flag = 1;
                        error_count = error_count + 1;
                        each_error_count = each_error_count + 1;
                        //IF THE SELECT WAS NOT SELECTED ADD HAS-ERROR TO IT
                        $(this).parents('.form-group:first').addClass('has-error')
                            .find('.select-error').removeClass('hide');
                             //SAVE THE FIRST ERROR, SO LATER WE CAN SCROLL TO IT
                            if (error_count == 1) {
                                last_this = $(this);
                            };
                    };
                    if ($(this).hasClass('drivers-text')) {
                        var this_driver_text = $(this).val();
                        if ($.isBlank(this_driver_text)) {
                            flag = 1;
                            //TO KEEP TRACK OF THE FIRST ERROR
                            error_count = error_count + 1;
                            each_error_count = each_error_count + 1;
                            //IF THE SELECT WAS NOT SELECTED ADD HAS-ERROR TO IT
                            $(this).parents('.form-group:first').addClass('has-error')
                                .find('.select-error').removeClass('hide');
                                //SAVE THE FIRST ERROR (this), SO LATER WE CAN SCROLL TO IT
                                if (error_count == 1) {
                                    last_this = $(this);
                                };
                        }
                    };
                });
            };
            if (each_error_count > 0) {
                    $(this).parents('.each-day:first').find('.day-error-container').removeClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').removeClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').text(each_error_count);
            } else {
                    $(this).parents('.each-day:first').find('.day-error-container').addClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').addClass('hide');
                    $(this).parents('.each-day:first').find('.day-error-number').text('');
                    $(this).parents('.each-day:first').find('.day-success-container').removeClass('hide'); 
            }
        });
        //IF THERE WAS NO ERRORS THEN PROCEED TO NEXT STEPY
        if (flag == 0) {
            //VALIDATE HOURS
            var data = [];
            // INIT ALL ARRAYS
            for (var i = 0; i <= 7; i++) {
                data[i] = [];
            };
            var f_count = 0;
            $('.step-1').find('tr').each(function(index) {
                //FOR EACH DAY
                var selected_radio = $(" input:radio:checked").val();
                //IGNORE VALIDATION IF IT WAS CLOSED
                if (selected_radio != "closed") {

                    //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                    $(this).find('.form-selects').each(function(index) {
                        if (!$(this).hasClass('drivers-text')) {
                          var this_value = $("option:selected", this).val();
                          var this_category = $(this).attr('this_category');
                          data[this_category].push(this_value);
                          f_count = f_count + 1;
                        }   
                    });
                };
            });
            request.validate_hours_ajax(data, _this, href, type);
        };
    }
}

function validate_step_3(_this, href, type){

}

function clear_all_validation_errors() {
    $('.overwrite_hours_container').find('tr').each(function(index) {
        $('select').each(function(index) {
            $(this).parents('.form-group:first').removeClass('has-error');
        });
    });
    $('.select-error').addClass('hide');
    $('.time-error').addClass('hide');
    $('.form-group').removeClass('has-error');





}

function clear_all_validation_errors_2() {
    //PANEL ERROR GLYPHICON
    $('.this-error-sign').addClass('hide');


    $('.first_section').find('tr').each(function(index) {
        $('select').each(function(index) {
            $(this).parents('.form-group:first').removeClass('has-error')
                .find('.select-error').addClass('hide');
        });
    });


    $('.single-date-error').addClass('hide');

    $('.start-date-error').addClass('hide');
    $('.end-date-error').addClass('hide');

    $('.select-error').addClass('hide');
    $('.time-error-overwrite').addClass('hide');
    $('.employees-no-error').addClass('hide');
    $('.employees-no-error-numeric').addClass('hide');
}

function add_new_blackout_date(date) {
    var duplicate_flag = false ;

    //CHECK FOR DUPLICATE
    $('.blackout-form').each(function(index) {
        if ($(this).val() == date) {
            duplicate_flag = true;
            var this_id = $(this).attr('alert_id');

            $('#'+this_id).css('text-decoration','underline');

            setTimeout(function(){ 

               $('#'+this_id).css('text-decoration','');

             }, 2000);
        };
    });

    //THERE WAS NO DUPLICATE
    if (duplicate_flag == false) {
        //COUNT THE BLACKOUTS
        var count = ($('.blackout-date').length) + 1;

        var html = '<div class="blackout-single-wrapper">' +
            '<div class="alert alert-danger alert-style blackout-date clearfix" id="blackout-'+count+'" role="alert" >' +
            '<span class="badge">' + count + '</span>' +
            '   ' + date +
            '<a class="btn btn-danger btn-sm pull-right blackout-remove-btn" id="remove-blackout-' + count + '" >Remove</a>' +
            '</div>' +
            '<input type="hidden" name="blackoutdates[' + count + ']" alert_id="blackout-'+count+'"  class="blackout-form"  value="' + date + '">' +
            '</div>';
        $('#blackout-group-wrapper').append(html);
        //ADD EVENT LISTENER
        $("#remove-blackout-" + count).click(function() {
            $(this).parents('.blackout-single-wrapper:first').remove();
            //REINDEX AFTER EACH REMOVE
            reindex_blackouts();
        });
    };
}

//REINDEX AFTER REMOVE
function reindex_blackouts() {
    $('#blackout-group-wrapper .blackout-single-wrapper').each(function(index) {
        var new_index = index + 1;
        //REINDEX BADGE NUMBERS
        $(this).find('.badge:first').html(new_index);

        //REIDEX FORM NAMES
        $(this).find('.blackout-form:first').attr('name', 'blackoutdates[' + new_index + ']');
    });
}

//REINDEX AFTER REMOVE
function remove_calendar_error(_this) {
    _this.parents('.box:first').find('.error:first').addClass('hide');
}
(function($){
  $.isBlank = function(obj){
    return(!obj || $.trim(obj) === "");
  };
})(jQuery);

function clear_error_messages() {
    $('.day-error-container').addClass('hide');
    $('.day-error-number').addClass('hide');
    $('.day-error-number').text('');
    $('.day-success-container').addClass('hide');
}

function prepare_accordions_color() {
    //CHECK FOR DUPLICATE
    $('.each-day').each(function(index) {
        var selected_radio = $("input:radio:checked", this).val();
        if (selected_radio != "closed") {
            $(this).removeClass('panel-default').addClass('panel-info');
        } 
    });
}


