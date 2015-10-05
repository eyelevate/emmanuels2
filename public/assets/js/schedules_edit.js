$(document).ready(function() {
    page.page_load();
    page.events();
    //KEEO EYES ON THIS *MAY CAUSE BUGS IN FUTURE
    page.events_after();
    page.stepy();
    page.validation();
});
page = {
    page_load: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        //CHECK IF SESSION EXISTS
        if ($('#isset_session').val() == true) {
            //IF THERE WAS A SESSION AND NO NEW ADDRESS THEN
            if ($('#isset_new_address').val() != true) {
                setTimeout(function(){ 
                    check_all_inputs(false);
                }, 500);
            }
            //IF THERE WAS A SESSION AND NEW ADDRESS THEN
            if ($('#isset_new_address').val() == true) {
                checklist_force_true();
            };
        }

        $(".set-date").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate:0
        });
    },
    stepy: function() {
        $("#deliveryStepy li a").click(function(e) {
            var href = $(this).attr('href');
            if (!($(this).parents('li:first').hasClass('disabled'))) {
                previous_step = $("#deliveryStepy .active");
                e.preventDefault();
                $("#deliveryStepy li").removeClass('active');
                $(this).parents('li:first').addClass('active');
                $(".steps").addClass('hide');
                $(href).removeClass('hide');
                if ((href == "#information")) {
                    if ($('#user_id').val() != "") {
                        // check_all_inputs();
                    };
                }
            } else {
                if ((href == "#content")) {
                    check_all_inputs(false);
                }
            }
        });

        $(".next").click(function() {

            $("#deliveryStepy .active").next('li').addClass('row-active');
            $("#deliveryStepy li").removeClass('active');
            $(document).find(".row-active").addClass('active').removeClass('row-active');
            var href = $(document).find('#deliveryStepy .active a').attr('href');
            $(".steps").addClass('hide');
            $(href).removeClass('hide');
            // if($(this).attr('step') == 4) {//this step is billing info
            // 	setDeliveryAddress();
            // }


            if ($('#user_id').val() != "") {
                // check_all_inputs();
            };
        });
        
        $("#set-forgotten-btn").click(function() {
            //NAVIGATE TO ADDRESS TAB, IN ORDER TO FILL NAME, EMAIL OR PHONE
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
            // if($(this).attr('step') == 5) {//coming from deliverySetup
            // 	updateBillingInfo();
            // }
        });
    },
    events: function() {
        //OPEN CALENDARE IF USER CLICKED ON CALENDAR ICON
        $(document).on('click','.calendar',function(e){
            $(this).parents('.input-group:first').find('.set-date').focus();
        });

        //CLICKED ON PREVIEW BTN, CHECK ALL THE ORDERS, ONLY IF ALL ORDERS ARE COMPLETE PROCEED TO NXT PAGE
        $(".submit-btn").click(function(e) {
            e.preventDefault();
            check_orders_for_preview();
        });

        $("#no-new").click(function(e) {//XXX
            clear_new_address();

            //ACTIVATE TABS
            $('#new-address-tab').removeClass('active');
            $('#member-tab').addClass('active');

            //SHOW AND HIDE TABS
            $('#newaddress').addClass('hide');
            $('#address').removeClass('hide');

            //HIDE ERROR
            $('.new-address-error').removeClass('show').addClass('hide');
        });

        $("#searchCustomerNavTabs a").click(function(e) {
            e.preventDefault();
            var tab_href = $(this).attr('href');
            $("#searchCustomerNavTabs li").removeClass('active');
            $(this).parents('li:first').addClass('active');
            $(".customerListDiv").addClass('hide');
            $(tab_href).removeClass('hide');
            if (tab_href == '#newaddress') {
                $('#tabs_checklist').val('newaddress');
            } else {
                $('#tabs_checklist').val('address');
            }
        });
        $(document).find("#searchBy").change(function() {
            var search = $(this).find('option:selected').val();
            $(".searchByFormGroup").addClass('hide');
            $("#searchBy-" + search).removeClass('hide');
        });
        $("#title").on("change", function() {
            $('#url').val("/" + urlfriendly($("#title").val()));
        });
        $(document).on('click', '#content .panel', function() {
            $(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
            $(this).removeClass('panel-default').addClass('panel-success');
        });

        $("#add-content").click(function() {
            var content_set_count = $(document).find('.content-set').length;
            $(document).find('#content .panel-collapse').removeClass('in');
            $(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
            request.add_content(content_set_count);
        });
        $("#preview-btn").click(function() {
            // var serialized_data = $("#add-form").serialize();
            // request.load_preview(serialized_data);
        });
        $("#title").keyup(function() {
            var have_error = false;
            var name_array = $(window.controller_names);
            var dup_val = "";
            var enterd_title = $(this).val();
            jQuery.each(name_array, function(i, val) {
                if (val == enterd_title && val != "") {
                    dup_val = val;
                    have_error = true;
                };
            });
            if (have_error == true) {
                $(this).parents('.form-group:first').addClass('has-error');
                $(this).parents('.form-group:first').find('#title-duplicate').removeClass('hide');
                $('#accordion-pro').collapse('show');
                $(document).find('#labels-div .' + dup_val).removeClass('label-default').addClass('label-danger');
                $('.submit-btn').addClass('disabled');
            } else {
                $(this).parents('.form-group:first').removeClass('has-error');
                $(this).parents('.form-group:first').find('#title-duplicate').addClass('hide');
                $(document).find('#labels-div .label').removeClass('label-danger').addClass('label-default');
                $('.submit-btn').removeClass('disabled');
            }
        });
$(document).on('click', '.remove-collapse', function() {

            // console.log($(document).find('.content-area .content-set').length);
            var this_set = $(this).parents('.content-set').attr('this_set');
            $(this).parents('.content-set:first').remove();


            reorder_orders();
        });

$(".searchByButton").click(function() {
    var company_id = $("#company_id").val();
    var type = $(this).parents('.searchByFormGroup:first').attr('id').replace('searchBy-', '');
    search = {};
    search[type] = {};

    $(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e) {
        var name = $(this).attr('name');
        search[type][name] = $(this).val();

    });
    request.search_users(company_id, search);

});


},
events_after: function() {

    $(".select-make").change(function() {
        var this_category = find_category($(this));
        //CCC
        var parents = $(this).parents('.panel-collapse:first').attr('this_set');
        reset_order_form(parents);
        var element = $("option:selected", this);
        var rate = parseFloat(element.attr("rate"));
        if ($(this).find('option:selected').val() != '') {
            $('#select-item-' + parents).removeAttr('disabled');
            var new_rate = rate.toFixed(2)
            $('#rate-' + parents).val('$'+new_rate);
        } else {
            $('#select-item-' + parents).attr('disabled', 'disabled');
            $('#rate-' + parents).val('-');
        }
        if ($('.service-group-' + parents).length != 0) {
                // var html = '<input class="item-group-'+parents+' item-group" type="hidden" value="" name="item_order" id="item-'+parents+'-0">';
                $('.service-group-' + parents).remove();
            }
        });
    $(".select-item").change(function() {
        var this_category = find_category($(this));
        //CCC
        var parents = $(this).parents('.panel-collapse:first').attr('this_set');
        reset_order_form(parents);
            if ($(this).find('option:selected').val() != '') { //ITEM SELECTED
                $('#height-' + parents).removeAttr('disabled');
                $('#length-' + parents).removeAttr('disabled');
                $('#qty-' + parents).removeAttr('disabled');
            } else {
                $('#height-' + parents).attr('disabled', 'disabled');
                $('#length-' + parents).attr('disabled', 'disabled');
                $('#qty-' + parents).attr('disabled', 'disabled').val('');
            }
            if (this_category == 0) {
                if ($('.service-group-' + parents).length != 0) {
                    // var html = '<input class="item-group-'+parents+' item-group" type="hidden" value="" name="item_order" id="item-'+parents+'-0">';
                    $('.service-group-' + parents).remove();
                }
            } else if (this_category == 1) {

                if ($('.item-group-' + parents).length != 0) {
                    // var html = '<input class="item-group-'+parents+' item-group" type="hidden" value="" name="item_order" id="item-'+parents+'-0">';
                    $('.item-group-' + parents).remove();
                }
            }

        });
$('.radio-option').click(function() {

    var this_id = $(this).attr('id');
            //changed here 
            var parents = $(this).parents('.panel-collapse:first').attr('this_set');
            reset_select_boxes(parents);
            //remove previous orders
            $('.service-group-' + parents).remove();
            $('.item-group-' + parents).remove();

            if (this_id == "service-radio") {
                $('#select-item-' + parents).attr('disabled', 'disabled');
                $('.make-form-' + parents).removeClass('hide').addClass('show');
                $('.item-form-' + parents).removeClass('hide').addClass('show');
                $('.qty-form-' + parents).addClass('hide').removeClass('show');
                $('.di-form-' + parents).removeClass('hide').addClass('show');
                $('.rate-form-' + parents).removeClass('hide').addClass('show');
                $('.price-form-' + parents).removeClass('hide').addClass('show');
            } else if (this_id == "item-radio") {
                $('#select-item-' + parents).removeAttr('disabled');
                $('.make-form-' + parents).removeClass('show').addClass('hide');
                $('.item-form-' + parents).removeClass('hide').addClass('show');
                $('.qty-form-' + parents).removeClass('hide').addClass('show');
                $('.di-form-' + parents).removeClass('show').addClass('hide');
                $('.rate-form-' + parents).removeClass('show').addClass('hide');
                $('.price-form-' + parents).removeClass('hide').addClass('show');
            }
        });

        //QTY---
        //

$(".height").keyup(function() {
            var height = parseInt($(this).val());
            if (height != "0") { //CHECK IF IT IS NUMERIC
                var parents = $(this).parents('.panel-collapse:first').attr('this_set');
                var length = parseInt($('#length-' + parents).val());
                if ($('#length-' + parents).val() != "") { //CHECK IF IT IS NUMERIC
                    var this_category = find_category($(this));
                    var element = $("option:selected", $('#select-make-' + parents));
                    var element_item = $("option:selected", $('#select-item-' + parents));
                    var rate = parseFloat(element.attr("rate"));
  
                    var total = get_total(rate, height, length);

                    $('#total-' + parents).val('$'+total);

                    var di = {
                        height: height,
                        length: length
                    };
                    var this_service_id = element.val();
                    var this_item_id = element_item.val();
                    store_items(this_category, null, parents, this_service_id, di,this_item_id);

                };
            }
        });

$(".length").keyup(function() {
    var length = $(this).val();
            if (length != "0") { //CHECK IF IT IS NUMERIC
                var parents = $(this).parents('.panel-collapse:first').attr('this_set');
                var height = parseInt($('#height-' + parents).val());
                if ($('#height-' + parents).val() != "") { //CHECK IF IT IS NUMERIC
                    var this_category = find_category($(this));
                    var element = $("option:selected", $('#select-make-' + parents));

                    var element_item = $("option:selected", $('#select-item-' + parents));
                    var rate = parseFloat(element.attr("rate"));

                    var total = get_total(rate, height, length);
                    $('#total-' + parents).val('$'+total);

                    var di = {
                        height: height,
                        length: length
                    };
                    var this_service_id = element.val();
                    var this_item_id = element_item.val();
                    store_items(this_category, null, parents, this_service_id, di, this_item_id);
                }

            };
        });
        //QTY---
        $('.minus-q').click(function() {
            var parents = $(this).parents('.panel-collapse:first').attr('this_set');
            if (($('#select-make-' + parents).val() != "") || ($('#select-item-' + parents).val() != "")) {
                var this_category = find_category($(this));
                //THIS_CATEGOR 0 = SERVICES, 1 = ITEMS
                if (this_category == 0) { //SERVICE
                    // var this_e = $(this).parents('.panel:first').find('.select-item');
                    // var this_rate = $("option:selected", this_e).attr('rate');
                    // var qty = parseInt($(this).parents('.input-group:first').find('input').val());
                    // var new_qty = 0;
                    // if (qty > 0) {
                    //     new_qty = qty - 1;
                    // };
                    // $(this).parents('.input-group:first').find('input').val(new_qty);
                } else if (this_category == 1) { //ITEMS
                    var this_e = $(this).parents('.panel:first').find('.select-item');
                    var this_rate = $("option:selected", this_e).attr('rate');
                    var qty = parseInt($(this).parents('.input-group:first').find('input').val());
                    var new_qty = 0;
                    if (qty > 0) {
                        new_qty = qty - 1;
                    };
                    $(this).parents('.input-group:first').find('input').val(new_qty);
                    set_price(this_rate, new_qty, parents);
                    //GATHER DATA AND SAVE IT INTO A FORM
                    var this_item_id = $("option:selected", this_e).val();
                    
                    //remove form
                    remove_single_order(parents);

                };
            };
        });


$('.add-q').click(function() {
    var parents = $(this).parents('.panel-collapse:first').attr('this_set');
    var this_category = find_category($(this));
    var this_parents = $(this).attr('parents');

    if (($('#select-make-' + parents).val() != "") || ($('#select-item-' + parents).val() != "")) {

                //THIS_CATEGOR 0 = SERVICES, 1 = ITEMS
                if (this_category == 0) {//SERVICE
                	//CCC
                    // var this_e = $(this).parents('.panel:first').find('.select-make');
                    // var this_rate = $("option:selected", this_e).attr('rate');
                    // var qty = parseInt($(this).parents('.input-group:first').find('input').val());
                    // var new_qty = 0;
                    // var new_qty = qty + 1;
                    // $(this).parents('.input-group:first').find('input').val(new_qty);
                } else if (this_category == 1) {//ITEM

                    var this_e = $(this).parents('.panel:first').find('.select-item');
                    var this_rate = $("option:selected", this_e).attr('rate');
                    var qty = parseInt($(this).parents('.input-group:first').find('input').val());
                    var new_qty = 0;
                    var new_qty = qty + 1;
                    $(this).parents('.input-group:first').find('input').val(new_qty);
                    console.log();
                    set_price(this_rate, new_qty, parents);
                    var this_item_id = this_e.val();
                    store_items(this_category, new_qty, parents, this_item_id, null ,null);
                }; 
            } else {
            	if (this_category == 0) {
            		$('#select-make-' + parents).parents('.form-group:first').addClass('has-error');
            		setTimeout(function(){ 
            			$('#select-make-' + parents).parents('.form-group:first').removeClass('has-error');
                 }, 1000);
            	} else {
            		$('#select-item-' + parents).parents('.form-group:first').addClass('has-error');
            		setTimeout(function(){ 
            			$('#select-item-' + parents).parents('.form-group:first').removeClass('has-error');
                 }, 1000);
            	}
            }

        });

$(".qty").keyup(function() {
   var parents = $(this).parents('.panel-collapse:first').attr('this_set');
            if ($(this).val().match(/^\d+$/)) { //CHECK IF IT IS NUMERIC
            	if (($('#select-make-' + parents).val() != "") || ($('#select-item-' + parents).val() != "")) {
                   var this_category = find_category($(this));
	                //THIS_CATEGOR 0 = SERVICES, 1 = ITEMS
	                if (this_category == 0) {

	                } else if (this_category == 1) {
                       var parents = $(this).parents('.panel-collapse:first').attr('this_set');
                       var this_e = $(this).parents('.panel:first').find('.select-item');
                       var this_rate = $("option:selected", this_e).attr('rate');
                       var this_qty = parseInt($(this).val());
                       set_price(this_rate, this_qty, parents);
                   };
               } else {
                  if (this_category == 1) {
                     $('#select-item-' + parents).parents('.form-group:first').addClass('has-error');
                     setTimeout(function(){ 
                        $('#select-item-' + parents).parents('.form-group:first').removeClass('has-error');
                    }, 1000);
                 } 
             }
         };
     });

},
validation: function() {
    $("#first_name").blur(function() {
        var type = "name";
        var value = $(this).val();
        var _this = $(this);
        request.ajax_validation(value, type, _this);
    });
   $("#last_name").blur(function() {
        var type = "name";
        var value = $(this).val();
        var _this = $(this);
        request.ajax_validation(value, type, _this);
    });

    $("#email").blur(function() {
        var type = "email";
        var value = $(this).val();
        var _this = $(this);
        request.ajax_validation(value, type, _this);
    });

    $("#telephone").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "phone";
        var message = 'Invalid Format'

         var filter = /^[0-9-+]+$/;

        if (filter.test(form_value)) {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
    });

    $("#street").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "street";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
    });
    $("#unit").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "unit";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
    });
    $("#city").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "city";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
    });
    $("#state").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "state";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
    });
    $("#zipcode").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "zipcode";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
    });

    //NEW ADDRESSES

    $("#new_street").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "street";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
        user_reminder_new_address()
    });
    $("#new_unit").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "unit";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
        user_reminder_new_address()
    });
    $("#new_city").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "city";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
        user_reminder_new_address()
    });
    $("#new_state").blur(function() {
        var form_value = $(this).val();
        var _this = $(this);
        var type = "state";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
        user_reminder_new_address()
    });
    $("#new_zipcode").blur(function() {

        var form_value = $(this).val();
        var _this = $(this);
        var type = "zipcode";
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
        user_reminder_new_address()
    });

    //END OF NEW ADDRESSES

}
};
request = {
    ajax_validation: function(value, type, _this) {
        var token = $('meta[name=csrf-token]').attr('content');
        $.post(
            '/admins/schedules/ajax-validation', {
                "_token": token,
                value: value,
                type: type
            },
            function(result) {
                var data = result.data;
                var status = data['status'];
                var message = data.validator[type];
                switch (status) {
                    case 200: // Approved
                    _this.parents('.form-group:first').addClass('has-success').addClass('has-feedback').removeClass('has-error');
                    _this.parents('.form-group:first').find('.val-error').removeClass('show').addClass('hide');
                    _this.parents('.form-group:first').find('.val-success').removeClass('hide').addClass('show');
                    _this.parents('.form-group:first').find('.val-help').removeClass('show').addClass('hide');
                    $('#checklist').attr(type, true);
                    validate_company_checklist();
                    break;

                    case 201:

                    break;

                    case 400:
                    _this.parents('.form-group:first').addClass('has-error').addClass('has-feedback').removeClass('has-success');
                    _this.parents('.form-group:first').find('.val-success').removeClass('show').addClass('hide');
                    _this.parents('.form-group:first').find('.val-error').removeClass('hide').addClass('show');
                    _this.parents('.form-group:first').find('.val-help').removeClass('hide').addClass('show').html(message);
                    $('#checklist').attr(type, false);
                    validate_company_checklist();

                    break;

                    default:
                    break;
                }
            }
            );
},

search_users: function(company_id, search) {
    var token = $('meta[name=_token]').attr('content');
    $.post(
        '/admins/users/request-users', {
            "_token": token,
            company_id: company_id,
            search: search
        },
        function(result) {
            var status = result.status;
                // var message = result.message;
                var table_tbody = result.users_tbody;
                $("#userSearchTable").removeClass('hide');
                $("#userSearchTable tbody").html(table_tbody);

                $(document).find("#userSearchTable tbody tr").click(function() {
                    var user_id = $(this).find('.checkUser').val();
                    if ($(this).find('.checkUser:checked').length === 0) { //IS NOT ACTIVE
                        $(this).addClass('success').find('.checkUser').prop('checked', true);
                        $(document).find('#userSearchTable tbody tr:not(.success)').addClass('hide');
                        //GET USER INFORMATION
                        request.set_user(user_id);

                    } else { //IS ACTIVE
                        $('#user_id').val(null);
                        $(this).removeClass('success').find('.checkUser').removeAttr('checked');
                        wipe_user_information();
                        // deliveries.remove_customer_info_data();
                    }

                });
                // deliveries.search_customer_events();
            }
            );
},
add_content: function(content_set_count) {
   var count_form = parseInt($('#service_count').val());
   var token = $('meta[name=_token]').attr('content');
   $.post(
    '/admins/schedules/order-add', {
        "_token": token,
        "content_set_count": content_set_count,
        "count_form":count_form
    },
    function(results) {
        var status = results.status;
        var html = results.html;
        switch (status) {
                    case 200: // Approved

                        // $('#content_count').val((content_set_count--));
                        $('.content-area').append(html);
                        page.events_after();
                        count_sections("add");
                        break;
                        default:
                        break;
                    }

                }
                );
},
set_user: function(user_id) {
    $('#myModal').modal('show');
    var token = $("meta[name=_token]").attr('content');
    $.post(
        '/admins/user/request-user-information', {
            "_token": token,
            user_id: user_id,
        },
        function(result) {
            $('#myModal').modal('hide');
            var status = result.status;
            var user_data = result.user_data;

            var first_name = result.user_data['firstname'];
            var last_name = result.user_data['lastname'];
            var phone = result.user_data['phone'];
            var city = result.user_data['city'];
            var state = result.user_data['state'];
            var street = result.user_data['street'];
            var zipcode = result.user_data['zipcode'];
            var email = result.user_data['email'];
            var unit = result.user_data['unit'];

            switch (status) {
                    case 200: // Approved
                    $('#user_id').val(user_id);

                    $("#first_name").val(first_name);
                    $("#last_name").val(last_name);
                    
                    $("#telephone").val(phone);
                    $("#email").val(email);
                    $("#street").val(street);
                    $("#city").val(city);
                    $("#unit").val(unit);
                    $("#state").val(state);
                    $("#zipcode").val(zipcode);
                    //REDIRECT TO USER INFORMATION STEPY
                    redirect_to_user_information();

                    check_all_inputs(false);
                    break;
                    case 400: // Approved

                    break;

                    default:

                    break;
                }
            }
            );
}
};

function urlfriendly(url) {
    url = url
        .toLowerCase() // change everything to lowercase
        .replace(/^\s+|\s+$/g, "") // trim leading and trailing spaces		
        .replace(/[_|\s]+/g, "-") // change all spaces and underscores to a hyphen
        .replace(/[^a-z\u0400-\u04FF0-9-]+/g, "") // remove all non-cyrillic, non-numeric characters except the hyphen
        .replace(/[-]+/g, "-") // replace multiple instances of the hyphen with a single instance
        .replace(/^-+|-+$/g, ""); // trim leading and trailing hyphens
        return url;
    }

    function reset_order_form(id) {


        $('#qty-' + id).val('0');
        $('#total-' + id).val('');
        $('#length-' + id).val('');
        $('#height-' + id).val('');
    }

    function reset_select_boxes(id) {
        $('#select-item-'+id).prop('selectedIndex',0);
        $('#select-make-'+id).prop('selectedIndex',0);

        $('#qty-' + id).val('0');
        $('#total-' + id).val('');
        $('#rate-' + id).val('');
        $('#length-' + id).val('');
        $('#height-' + id).val('');
    }

    function set_price(rate, qty, parents) {
        if (qty > 0) {
            var total = rate * qty;
            var fixed_total = total.toFixed(2);
            $('#total-' + parents).val('$'+fixed_total);
        } else {
            $('#total-' + parents).val('00.0 $');
        }
    }

    function find_category(_this) {
        var result = null;
        if (_this.parents('.panel:first').find('#service-radio').prop('checked') == true) {
            result = 0;
        } else if (_this.parents('.panel:first').find('#item-radio').prop('checked') == true) {
            result = 1;
        }
        return result;
    }
    //SHOWING THE VALIDATION RESULTS
    function uni_show_validation(_this, message, status, type) {
        switch (status) {
        case 1: //SUCCESS
        $('#checklist').attr(type, true);

        _this.parents('.form-group:first').addClass('has-success').addClass('has-feedback').removeClass('has-error');
        _this.parents('.form-group:first').find('.val-error').removeClass('show').addClass('hide');
        _this.parents('.form-group:first').find('.val-success').removeClass('hide').addClass('show');
        _this.parents('.form-group:first').find('.val-help').removeClass('show').addClass('hide');

        validate_company_checklist();
        break;
        case 2: //ERROR
        $('#checklist').attr(type, false);

        _this.parents('.form-group:first').addClass('has-error').addClass('has-feedback').removeClass('has-success');
        _this.parents('.form-group:first').find('.val-success').removeClass('show').addClass('hide');
        _this.parents('.form-group:first').find('.val-error').removeClass('hide').addClass('show');
        _this.parents('.form-group:first').find('.val-help').removeClass('hide').addClass('show').html(message);

        validate_company_checklist();
        break;
    }

}

function validate_company_checklist() {
    var ch = $('#checklist');
    if (ch.attr('name') == "true" &&
        ch.attr('phone') == "true" &&
        ch.attr('email') == "true" &&
        ch.attr('street') == "true" &&
        ch.attr('zipcode') == "true" &&
        ch.attr('city') == "true" &&
        ch.attr('unit') == "true" &&
        ch.attr('state') == "true"
        ) {
        $('#next-btn').removeClass('disabled');
    $('.content-step').removeClass('disabled');

} else {
    $('#next-btn').addClass('disabled');
    $('.content-step').addClass('disabled');

}

}
//SET ALL ATTR TO TRUE, ONLY IF COMING BACK FROM SESSION AND NEW ADDRESS WAS USED
function checklist_force_true() {
    var ch = $('#checklist');
    ch.attr('name',"true");
    ch.attr('phone',"true");
    ch.attr('email',"true");
    ch.attr('street',"true");
    ch.attr('zipcode',"true");
    ch.attr('city',"true");
    ch.attr('unit',"true");
    ch.attr('state',"true");
    validate_company_checklist();
}



function check_all_inputs(new_address) {

    var type = "name";
    var value = $('#first_name').val();
    var _this = $('#first_name');
    request.ajax_validation(value, type, _this);

    var type = "name";
    var value = $('#last_name').val();
    var _this = $('#last_name');
    request.ajax_validation(value, type, _this);

    var type = "email";
    var value = $('#' + type).val();
    var _this = $('#' + type);
    request.ajax_validation(value, type, _this);

    var type = "phone";
    var value = $('#telephone').val();
    var _this = $('#telephone');
    request.ajax_validation(value, type, _this);

    if (new_address == false) {
        var type = "street";
        var value = $('#' + type).val();
        var _this = $('#' + type);
        var form_value = _this.val();
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }

        var type = "unit";
        var value = $('#' + type).val();
        var _this = $('#' + type);
        var form_value = _this.val();
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }

        var type = "city";
        var value = $('#' + type).val();
        var _this = $('#' + type);
        var form_value = _this.val();
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }

        var type = "state";
        var value = $('#' + type).val();
        var _this = $('#' + type);
        var form_value = _this.val();
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }

        var type = "zipcode";
        var value = $('#' + type).val();
        var _this = $('#' + type);
        var form_value = _this.val();
        var message = type + ' is required.'
        if (form_value != '') {
            uni_show_validation(_this, message, 1, type);
        } else {
            uni_show_validation(_this, message, 2, type);
        }
        };
   

    validate_company_checklist();
}

function get_total(rate, height, length) {

    var di = height * length;
    var total = rate * di;
    var fixed_total = total.toFixed(2);
    return fixed_total;
}

function wipe_user_information() {
    $('#first_name').val('');
    $('#last_name').val('');
    $('#telephone').val('');
    $('#email').val('');
    $('#street').val('');
    $('#unit').val('');
    $('#city').val('');
    $('#state').val('');
    $('#zipcode').val('');
    check_all_inputs(false);
}

function store_items(this_category, new_qty, parents, this_order_id, di, this_item) {//THIS ITEM IS FOR SERVICES ONLY
    var category_name = this_category == 1 ? "item" : "service";

    if (this_category == 0) { //SERVICE
        var count_s = $('#service_count').val();
        // if ($('.service-by-count-' + count_s).length != 0) {
        //     $('.service-by-count-' + count_s).remove();
        // };
        //DELETE PREVIOUS ORDERS
        $('.service-group-' + parents).remove();

        var height = di['height'];
        var length = di['length'];
        var html_i = '<input type="hidden" class="service-group-' + parents + ' service-group service-by-count-' + count_s + '" value="' + this_order_id + '" name="service_order[' + parents + '][id]" id="service-' + count_s + '" >';
        //ITEM ID ONLY FOR SERVICES
        var html_i_i = '<input type="hidden" class="service-group-' + parents + ' service-group service-by-count-' + count_s + '" value="' + this_item + '" name="service_order[' + parents + '][item_id]" id="service-' + count_s + '" >';
        var html_h = '<input type="hidden" class="service-group-' + parents + ' service-group service-by-count-' + count_s + '" value="' + height + '" name="service_order[' + parents + '][height]" id="service-' + count_s + '" >';
        var html_l = '<input type="hidden" class="service-group-' + parents + ' service-group service-by-count-' + count_s + '" value="' + length + '" name="service_order[' + parents + '][length]" id="service-' + count_s + '" >';
        $('.collapse-' + parents).append(html_i);
        $('.collapse-' + parents).append(html_i_i);
        $('.collapse-' + parents).append(html_h);
        $('.collapse-' + parents).append(html_l);

    } else { //ITEM 
        var count_form = $('.item-group-' + parents).length;
        var count_i = $('#service_count').val(); //SERVICE COUNT IS SAME AS ITEM COUNT
        var html = '<input type="hidden" class="item-group-' + parents + ' item-group item-by-count-' + count_i + '" value="' + this_order_id + '" name="item_order[' + parents + '][' + count_form + ']" id="item-' + parents + '-' + count_form + '" >';
        $('.collapse-' + parents).append(html);

    }
}

function count_sections(opr) {
    if (opr == "add") {
        var count_s = parseInt($('#service_count').val());
        var new_count_s = (count_s + 1);
        $('#service_count').val(new_count_s);

    } else if (opr == "min") {

    }

}

function reorder_orders() {
    var total_content = $('#content').find('.content-set').length;
    var count = 1;
    var set_no = 0;
    $('.this-title').each(function(e) {
        var pre_set =  $(this).parents('.panel:first').find('.panel-collapse').attr('this_set');
        $(this).html("Order " + count);
        //RESET ATTRIBUTES
        $(this).parents('.panel:first').attr('this_set', set_no);  

        // $(this).parents('.panel:first').find('.form-group-make').;


        count++;
        set_no++;
    });
}

function check_orders_for_preview() {
   var flag = false;
    //ERROR IS ON WHICH STEPY 1 = CONFIRMATION, 0 = INFORMATION
    var which_page = 1;
    //INIT ALL ERRORS
    $('#content .panel').removeClass('panel-danger').addClass('panel-success');

    $('.radio').removeClass('has-feedback has-error');
    $('.form-group-make').removeClass('has-feedback has-error');
    $('.form-group-item').removeClass('has-feedback has-error');
    $('.form-group-qty').removeClass('has-feedback has-error');
    $('.form-group-height').removeClass('has-feedback has-error');
    $('.form-group-length').removeClass('has-feedback has-error');


    $('.radio-error').removeClass('show').addClass('hide');
    $('.make-error').removeClass('show').addClass('hide');
    $('.item-error').removeClass('show').addClass('hide');
    $('.qty-error').removeClass('show').addClass('hide');
    $('.di-error').removeClass('show').addClass('hide');
    $('.empty-order-error').removeClass('show').addClass('hide');
    $('.new-address-error').removeClass('show').addClass('hide');

    $('.pickup-date-error').removeClass('show').addClass('hide');
    $('.pickup-content').removeClass('has-error');
    $('.delivery-date-error').removeClass('show').addClass('hide');
    $('.delivery-content').removeClass('has-error');

    //CHECK IF THE NEW ADDRESS WAS SET, IF SO MAKE SURE IT IS A COMPETE ADDRESS IF NOW SHOW ERROR
    if (    (($('#new_street').val() == '') && 
        ($('#new_unit').val() == '') && 
        ($('#new_city').val() == '') &&
        ($('#new_state').val() == '') &&
        ($('#new_zipcode').val() == '')) ||
        (($('#new_street').val() != '') && 
            ($('#new_unit').val() != '') && 
            ($('#new_city').val() != '') &&
            ($('#new_state').val() != '') &&
            ($('#new_zipcode').val() != ''))
        ) { //SUCCESS

    } else { //NEW ADDRESSES WERE ENTERED BUT WERE INCOMPLETE, SHOW THEM WITH ERROR
        $('.new-address-error').removeClass('hide').addClass('show');

        //ACTIVATE THE SIDEBAR STEPY
        $('#user-info').addClass('active');
        $('#order-step').removeClass('active');

        //SHOW AND HIDE THE STEPY PAGES
        $('#content').removeClass('show').addClass('hide');
        $('#information').removeClass('hide');

        //ACTIVATE TABS
        $('#member-tab').removeClass('active');
        $('#new-address-tab').addClass('active');

        //SHOW AND HIDE TABS
        $('#address').addClass('hide');
        $('#newaddress').removeClass('hide');
        flag = true;
        which_page = 0;
    }

    //PICKUP DATE AND DELIVERY DATE
    if ($('#pickup-date').val() == "") {
        $('.pickup-content').addClass('has-error');

        //ACTIVATE THE SIDEBAR STEPY
        $('#user-info').addClass('active');
        $('#order-step').removeClass('active');

        //SHOW AND HIDE THE STEPY PAGES
        $('#content').removeClass('show').addClass('hide');
        $('#information').removeClass('hide');

        $('.pickup-date-error').removeClass('hide').addClass('show');
        flag = true;

        //SCROLL TO THAT SECTION
        $('html,body').animate({
          scrollTop: $('.pickup-content').offset().top
        }, 1000);
        which_page = 0;
    };

    if ($('#delivery-date').val() == "") {
        $('.delivery-content').addClass('has-error');

        //ACTIVATE THE SIDEBAR STEPY
        $('#user-info').addClass('active');
        $('#order-step').removeClass('active');

        //SHOW AND HIDE THE STEPY PAGES
        $('#content').removeClass('show').addClass('hide');
        $('#information').removeClass('hide');

        $('.delivery-date-error').removeClass('hide').addClass('show');
        flag = true;

        //SCROLL TO THAT SECTION
        $('html,body').animate({
          scrollTop: $('.delivery-content').offset().top
        }, 1000);
        which_page = 0;
    };

    if ( $('.this-title').length > 0 ) {

            $('.this-title').each(function(e) {//GOING THROUGH ALL ORDERS
                var this_category = find_category($(this));
        if (this_category == 0) {//SERVICE

            //CHECKING SERVICES SELECT
            var this_e = $(this).parents('.panel:first').find('.select-make');
            if ($("option:selected", this_e).val() == '') {
                flag = true;
                $(this).parents('.panel:first')
                .removeClass('panel-success').addClass('panel-danger');

                $(this).parents('.panel:first').find('.panel-collapse').
                addClass('in');

                $(this).parents('.panel:first').find('.make-error').
                removeClass('hide').addClass('show');

                //ADD HAS-ERROR TO SELECT
                $(this).parents('.panel:first').find('.form-group-make').
                addClass('has-feedback has-error');

                
            };

            //CHECKING ITEMS SELECT
            var this_i = $(this).parents('.panel:first').find('.select-item');
            if ($("option:selected", this_i).val() == '') {
                flag = true;
                $(this).parents('.panel:first')
                .removeClass('panel-success').addClass('panel-danger');

                $(this).parents('.panel:first').find('.panel-collapse').
                addClass('in');

                $(this).parents('.panel:first').find('.item-error').
                removeClass('hide').addClass('show');

                //ADD HAS-ERROR TO SELECT
                $(this).parents('.panel:first').find('.form-group-item').
                addClass('has-feedback has-error');
            };

            //CHECKING HEIGHT
            var this_height = $(this).parents('.panel:first').find('.height').val();
            if ((this_height == 0)  || (!this_height.match(/^\d+$/)) ) {//QTY IS 0
                flag = true;
                $(this).parents('.panel:first')
                .removeClass('panel-success').addClass('panel-danger');

                $(this).parents('.panel:first').find('.panel-collapse').
                addClass('in');

                $(this).parents('.panel:first').find('.di-error').
                removeClass('hide').addClass('show');

                //ADD HAS-ERROR
                $(this).parents('.panel:first').find('.form-group-height').
                addClass('has-feedback has-error');
            };

            //CHECKING length
            var this_length = $(this).parents('.panel:first').find('.length').val();
            if ((this_length == 0) || (!this_length.match(/^\d+$/)) ) {//QTY IS 0
                flag = true;
                $(this).parents('.panel:first')
                .removeClass('panel-success').addClass('panel-danger');

                $(this).parents('.panel:first').find('.panel-collapse').
                addClass('in');

                $(this).parents('.panel:first').find('.di-error').
                removeClass('hide').addClass('show');

                //ADD HAS-ERROR
                $(this).parents('.panel:first').find('.form-group-length').
                addClass('has-feedback has-error');
            };

        } else if (this_category == 1) {//ITEM
            //CHECKING ITEMS SELECT
            var this_i = $(this).parents('.panel:first').find('.select-item');
            if ($("option:selected", this_i).val() == '') {
                flag = true;
                $(this).parents('.panel:first')
                .removeClass('panel-success').addClass('panel-danger');

                $(this).parents('.panel:first').find('.panel-collapse').
                addClass('in');

                $(this).parents('.panel:first').find('.item-error').
                removeClass('hide').addClass('show');

                //ADD HAS-ERROR
                $(this).parents('.panel:first').find('.form-group-item').
                addClass('has-feedback has-error');
            };
            //CHECKING QTY
            if ($(this).parents('.panel:first').find('.qty').val() == 0) {//QTY IS 0
                flag = true;
                $(this).parents('.panel:first').find('.qty-error').
                removeClass('hide').addClass('show');

                //ADD HAS-ERROR
                $(this).parents('.panel:first').find('.form-group-qty').
                addClass('has-feedback has-error');
            };
        } else {//THERE WAS AN UNSET ORDER, NON OF THE RADIO-BOXES WAS SELECTED
            flag = true;
            $(this).parents('.panel:first')
            .removeClass('panel-success').addClass('panel-danger');

            $(this).parents('.panel:first').find('.panel-collapse').
            addClass('in');

            $(this).parents('.panel:first').find('.radio-error').
            removeClass('hide').addClass('show');
            
            //ADD HAS-ERROR
            $(this).parents('.panel:first').find('.radio').
            addClass('has-feedback has-error');
        }
    });

    if(flag == true){ //THERE WAS AN INCOMPLETE ORDER
        if (which_page == 1) {
            $('html,body').animate({
            scrollTop: $('.panel-danger').offset().top
            }, 1000);
        };

    } else {//THERE WAS NO ERROR, PROCEED TO POST ADD
        $('#add-form').submit();
    }

    } else { //THERE IN NO ORDER CREATED YET
        $('.empty-order-error').removeClass('hide').addClass('show');
    }
}

function remove_single_order(parents) {

    //xxx
    var item_count = $('.item-group-'+parents).length;
    var new_count = item_count - 1;
    $('#item-'+parents+'-'+new_count).remove();
}
function clear_new_address() {
    $('#new_street').val('');
    $('#new_unit').val('');
    $('#new_state').val('');
    $('#new_city').val('');
    $('#new_zipcode').val('');
}
//REMIND USER TO SET NAME, PHONE AND EMAIL IF THE NEW ADDRESS IS SET
function user_reminder_new_address() {
    //IF ALL FIELDS OF [NEW ADDRESS] ARE SET
    if ($('#new_street').val() != "" &&
        $('#new_zipcode').val() != "" &&
        $('#new_city').val() != "" &&
        $('#new_unit').val() != "" && 
        $('#new_state').val() != "") {
        //IF NAME, PHONE OR EMAIL ARE NOT SET
        if ($('#first_name').val() == "" ||
            $('#last_name').val() == "" ||
            $('#telephone').val() == "" ||
            $('#email').val() == "") {
            //SHOW ALERT
            $('#alert-forgotten').removeClass('hide');
        };
        //true = new address
        check_all_inputs(true);
    }
}

function redirect_to_user_information() {
    $('#search').addClass('hide');
    $('#information').removeClass('hide');
    $('#search-stepy').removeClass('active');
    $('#user-info').addClass('active');
}