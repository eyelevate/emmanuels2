$(document).ready(function(){
	company.events();
	company.typeahead();
	company.validation();
	company.phone();
	company.url();
});

company = {
	typeahead: function(){
		$('#city').typeahead({
			source: function (query, process) {
				c = [];
				map = {};
				$.ajax({
					url:'/worlds/cities',
					type:'POST',
					data: {
						query:query
					},
					dataType:'json',
					success: function(data) {
						var city_name = '/'+convertToSlug($(this).val());
						var company_name = '/'+convertToSlug($('#name').val());
						var final_url = 'http://www.orderbooth.com'+city_name+company_name;
						$('#url').val(final_url);
						$.each(data, function (i, cities) {
							var country = cities.country;
							map[cities.city] = cities;
							c.push(cities.city);
						});
						process(c);
					}
				});
				
			},

		});
	},
	phone: function(){
		var telInput = $(".form-phone");
		
		telInput.intlTelInput({validationScript: "../packages/intl-tel-input/lib/libphonenumber/build/isValidNumber.js"});
		// on blur: validate
		telInput.blur(function() {

			if ($.trim(telInput.val())) {
				if (telInput.intlTelInput("isValidNumber")) {
					$(this).parents('.form-group:first').removeClass('has-error')
						.find('.help-block').addClass('hide').html('')
						.parents('.form-group:first').addClass('has-success').addClass('has-feedback').find('.glyphicon').removeClass('hide');
				} else {
					$(this).parents('.form-group:first').addClass('has-error').addClass('has-feedback').find('.glyphicon').removeClass('hide')
						.parents('.form-group:first').find('.help-block').removeClass('hide').html('Error with number');
				}}
		});

		//on keydown: reset
		telInput.keydown(function(e) {

			telInput.parents('.form-group:first').removeClass('has-success').removeClass("has-error").removeClass('has-feedback')
				.find('.help-block').addClass("hide").html('')
				.parents('.form-group:first').find('.glyphicon').addClass("hide");
			
		});
	},
	events: function(){
		$(".panel input, .panel select").focus(function(){
			$(".panel").removeClass("panel-info").removeClass("panel-default");
			$(".panel").addClass("panel-default");
			$(this).parents('.panel').removeClass("panel-default").addClass("panel-info");
		});

		$(".hoursOpenRadio").click(function(){
			var open = $(this).val();
			if(open == "open") {
				$(this).parents('tr:first').find("fieldset").removeAttr('disabled');
			} else {
				$(this).parents('tr:first').find("fieldset").attr('disabled','true');
			}
		});
	},
	validation: function(){
		//general info 
		$("#step1_panel .form-control").blur(function(){
			var type = $(this).attr('type');
			var not_empty = $(this).attr('not_empty');
			var form_value = $(this).val();

			switch(not_empty){
				case 'true':
					if(form_value === ''){
						$(this).parents('.form-group:first').addClass('has-error').addClass('has-feedback').find('.glyphicon').removeClass('hide')
							.parents('.form-group:first').find('.help-block').removeClass('hide').html('This field cannot be left empty.');
					} else {
						$(this).parents('.form-group:first').removeClass('has-error')
							.find('.help-block').addClass('hide').html('')
							.parents('.form-group:first').addClass('has-success').addClass('has-feedback').find('.glyphicon').removeClass('hide');
					}
					
				break;

				default:
					$(this).parents('.form-group').removeClass('has-error').find('.help-block').html('');
				break;
			}
		});

		//time validation
		$(".closed , .twentyfour").click(function(){
			$(this).parents('.setTimeDiv:first').find('h5 span').removeClass('label-default').addClass('label-success').html('Set');
			$(this).parents('.setTimeDiv:first').find('.timeSet').addClass('hide');
		});

		$(".between").click(function(){
			$(this).parents('.setTimeDiv:first').find('h5 span').removeClass('label-success').addClass('label-default').html('Not Set');
			$(this).parents('.setTimeDiv:first').find('.timeSet').removeClass('hide');
		});

		$(".open_hours,.closed_hours,.open_ampm,.closed_ampm").change(function(){
			var time_data = $(this).find('option:selected').val();
			$(this).parents('.form-group:first').removeClass('has-error').removeClass('has-feedback').find('.help-block').html('');

			company.time_check(time_data,$(this));


		});



	},
	time_check: function(data, element){
		
		var span_class;
		if(element.hasClass('open_hours')){
			span_class = '.open_hours_span';
		} else if(element.hasClass('open_ampm')){
			span_class = '.open_ampm_span';
		} else if(element.hasClass('closed_hours')){
			span_class = '.closed_hours_span';
		} else {
			span_class = '.closed_ampm_span';
		}

		if(data === ''){
			element.parents('.form-group:first').addClass('has-error').addClass('has-feedback').find('.help-block').html('This field cannot be left empty.');
			element.parents('.timeSet:first').find(span_class).html(data).attr('status','false');
			element.parents('.setTimeDiv').find('.page-header span').removeClass('label-success').addClass('label-default').html('Not Set');
		} else {
			element.parents('.form-group:first').addClass('has-success').addClass('has-feedback').find('.help-block').html('');
			element.parents('.timeSet:first').find(span_class).html(data).attr('status','true');

			status_open_hours = element.parents('.timeSet:first').find('.open_hours_span').attr('status');
			status_open_ampm = element.parents('.timeSet:first').find('.open_ampm_span').attr('status');
			status_closed_hours = element.parents('.timeSet:first').find('.closed_hours_span').attr('status');
			status_closed_ampm = element.parents('.timeSet:first').find('.closed_ampm_span').attr('status');

			if(status_open_hours == 'true' && status_open_ampm == 'true' && status_closed_hours == 'true' && status_closed_ampm == 'true'){
				element.parents('.setTimeDiv').find('.page-header span').removeClass('label-default').addClass('label-success').html('Set');
			}
		
		}


	},
	url: function(){
		$('#name').blur(function(){
			//var city_name = '/'+convertToSlug($(this).val());
			var company_name = '/'+convertToSlug($('#name').val());
			var final_url = 'http://www.orderbooth.com'+company_name;
			console.log(final_url);
			$('#url').val(final_url);

		});
	}
};

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'');
}
