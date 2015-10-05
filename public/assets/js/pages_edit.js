		$(document).ready(function() {
			page.page_load();
			page.events();
			page.stepy();
		});
		page = {
			page_load: function() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
					}

				});
				tinymce.init({
					fontsize_formats: "8pt 10pt 12pt 14pt",
					selector: ".content-body",
					toolbar: "undo redo pastetext| bold italic | styleselect | fontsizeselect"
				});
				$('.dd').nestable({
					maxDepth: 1
				});
				var count_onload = $(".dd ol li .dd-handle").length;
				if (count_onload > 0) {
					if ($('#is_session').val() == 1) {
						var is_session = 1;
						set_slider_images_onload(is_session);
					} else {

						var is_session = 0;
						set_slider_images_onload(is_session);
					}
					set_browse_btn();
				};


			},
			stepy: function() {
				$("#deliveryStepy li a").click(function(e) {
					previous_step = $("#deliveryStepy .active");
					e.preventDefault();
					var href = $(this).attr('href');
					$("#deliveryStepy li").removeClass('active');
					$(this).parents('li:first').addClass('active');
					$(".steps").addClass('hide');
					$(href).removeClass('hide');
		            // if ((href == "#billingInfo")) {
		            // 	if (previous_step.hasClass('customerInfo') || previous_step.hasClass('menuSelection')) {
		            // 	}
		            // }
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
				$("#title").keyup(function(){

						var have_error = false; 
						var name_array = $(window.controller_names);
						
						var dup_val = "";
						var enterd_title = $(this).val();
						jQuery.each( name_array, function( i, val ) {

							if (val == enterd_title && val != "") {
								dup_val = val;
								have_error = true;
							};
						});
						if (have_error == true) {

							$(this).parents('.form-group:first').addClass('has-error');
							$(this).parents('.form-group:first').find('#title-duplicate').removeClass('hide');
							$('#accordion-pro').collapse('show');
							$(document).find('#labels-div .'+dup_val).removeClass('label-default').addClass('label-danger');
							$('.submit-btn').addClass('disabled');
						} else {
							$(this).parents('.form-group:first').removeClass('has-error');
							$(this).parents('.form-group:first').find('#title-duplicate').addClass('hide');
							$(document).find('#labels-div .label').removeClass('label-danger').addClass('label-default');
							$('.submit-btn').removeClass('disabled');
						}
					});
				$(document).on('click', ".input-group-btn", function() {
					if (!$(this).find('.btn-file').hasClass("disabled")) {
						$('#key_down').val(1);
					};
				});
				$(".dd").on("change", function() {
					if (parseInt($('#key_down').val()) == 0) {
						session_reindex();
						setTimeout(function(){ 
							$('#key_down').val(0);
						}, 1000);
					}

				});

				$('#title').friendurl({
					id: 'url'
				});
				$("#title").on("change", function() {
					$('#url').val("/" + urlfriendly($("#title").val()));
				});

				$(document).on('click', '#content .panel', function() {
					$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
					$(this).removeClass('panel-default').addClass('panel-success');
				});
				$("#add-content").click(function() {
					var content_set_count = $(document).find('#content .panel-collapse').length;
					$(document).find('#content .panel-collapse').removeClass('in');
					$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
					request.add_content(content_set_count);
				});
				$("#addSlide").click(function() {
					request.add_slider_image();
				});
				$("#preview-btn").click(function() {
		            // var serialized_data = $("#add-form").serialize();
		            // request.load_preview(serialized_data);
		        });
				$(document).on('click', '.remove-collapse', function() {
		            // console.log($(document).find('.content-area .content-set').length);
		            var count = 1;
		            $(".content-area .content-set").each(function(index) {
		            	$(this).find('.panel-title a .this-title').html('Content ' + count);
		            	count++;
		            });
		            var this_set = $(this).parents('.content-set').attr('this_set');

		            tinymce.remove('#content-body-' + this_set);
		            $(this).parents('.content-set:first').remove();
		            var count = $('#content_count').val();
		            re_count = (count == 0) ? null : count--;

		            $('#content_count').val(re_count);
		        });
				$(document).on('click', '.remove-img', function() {
		            // var img_name = $(this).parents(".dd-item").attr('img-name');
		            var _img_name = $(this).parents('li:first').find('img:first').attr('alt');
		            var from = $(this).parents('li:first').attr('from');
		            var _this = $(this);
		            request.remove_image_temp(_img_name, from,_this);
		            
		        });
				$(document).on('click', '.test-session', function() {
					request.test_session();
				});
			}
		};
		request = {
			add_content: function(content_set_count) {

				var token = $('meta[name=_token]').attr('content');
				$.post(
					'/admins/pages/content-add', {
						"_token": token,
						"content_set_count": content_set_count
					},
					function(results) {
						var status = results.status;
						var html = results.html;
						switch (status) {
		                    case 200: // Approved

		                    $('#content_count').val((content_set_count--));
		                    $('.content-area').append(html);
		                    tinymce.init({
		                    	fontsize_formats: "8pt 10pt 12pt 14pt",
		                    	selector: ".content-body",
		                    	toolbar: "undo redo pastetext| bold italic | styleselect | fontsizeselect"
		                    });
		                    break;

		                    default:
		                    break;
		                }

		            }
		            );
			},
			remove_image_temp: function(img_name, from,_this) {
				var token = $('meta[name=_token]').attr('content');
				$('.submit-btn').addClass('disabled');
				$('.remove-img').addClass('disabled');
				$.post(
					'/admins/pages/remove-temp', {
						"_token": token,
						"img_name": img_name,
						"from": from
					},
					function(results) {
						var status = results.status;
						switch (status) {
		                    case 200: // Approved
		                    _this.parents('li:first').remove();
		                    if ($(".dd ol li .dd-handle").length == 1) {//THIS IS THE LAST IMAGE
		                    	if ($('#sliderDiv img').length == 0) {//THIS IS AN EMPTY IMAGE FRAME
		                    		if ($('.dd-item').remove()) {//CLEAR ALL FRAMES
		                    			request.add_slider_image();
		                    		};
		                    	};
		                    };
		                    session_reindex();
		                    $('.submit-btn').removeClass('disabled');
		                    $('.remove-img').removeClass('disabled');
		                    break;
		                    case 201: // Image is located at slider folder do not delete

		                    _this.parents('li:first').remove();
	                  		if ($(".dd ol li .dd-handle").length == 1) {//THIS IS THE LAST IMAGE
		                    	if ($('#sliderDiv img').length == 0) {//THIS IS AN EMPTY IMAGE FRAME
		                    		if ($('.dd-item').remove()) {//CLEAR ALL FRAMES
		                    			request.add_slider_image();
		                    		};
		                    	};
		                    };
		                    session_reindex();
		                    $('.submit-btn').removeClass('disabled');
		                    $('.remove-img').removeClass('disabled');
		                    break;
		                    case 400: // error
		                    console.log('name not set');
		                    _this.parents('li:first').remove();
	                  		if ($(".dd ol li .dd-handle").length == 1) {//THIS IS THE LAST IMAGE
		                    	if ($('#sliderDiv img').length == 0) {//THIS IS AN EMPTY IMAGE FRAME
		                    		if ($('.dd-item').remove()) {//CLEAR ALL FRAMES
		                    			request.add_slider_image();
		                    		};
		                    	};
		                    };
		                    session_reindex();
		                    $('.submit-btn').removeClass('disabled');
		                    $('.remove-img').removeClass('disabled');
		                    break;

		                    default:
		                    $('.submit-btn').removeClass('disabled');
		                    $('.remove-img').removeClass('disabled');
		                    break;
		                }
		            }
		            );
	},
	save_image_temp: function(file) {
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/admins/pages/image-temp', {
				"_token": token,
				"file": file
			},
			function(results) {
				var status = results.status;
				switch (status) {
		                    case 200: // Approved
		                        // $('#content_count').val((content_set_count--));
		                        // $('.content-area').append(html);
		                        break;

		                        default:
		                        break;
		                    }
		                }
		                );
	},
	add_slider_image: function() {
		var token = $('meta[name=_token]').attr('content');
		var order = $(".dd ol li .dd-handle").length + 1;
		$.post(
			'/admins/pages/insert-slide', {
				"_token": token,
				order: order
			},
			function(results) {
				var status = results.status;
				var html = results.html;
				var order = results.order;
				switch (status) {
		                    case 200: // Approved

		                    $('.dd-list').append(html);
		                    file_input_init(order);

		                    break;
		                    default:
		                    break;
		                }
		            }
		            );
	},
	session_reindex: function(session_data) {
		var token = $('meta[name=_token]').attr('content');
		$('.submit-btn').addClass('disabled');
		$('#test_form').val(JSON.stringify(session_data));
		$.post(
			'/admins/pages/session-reindex', {
				"_token": token,
				"session_data": session_data
			},
			function(results) {
				var status = results.status;
				$('.submit-btn').removeClass('disabled');
				switch (status) {
		                    case 200: // Approved

		                    break;
		                    default:
		                    break;
		                }
		            }
		            );
	},
	test_session: function() {
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/admins/pages/test-session', {
				"_token": token
			},
			function(results) {
				switch (status) {
		                    case 200: // Approved

		                    break;
		                    default:
		                    break;
		                }
		            }
		            );
	}
};

function file_input_init(order) {
	var $el2 = $("#input-706-" + order);
		    // custom footer template for the scenario
		    // the custom tags are in braces
		    var footerTemplate = '<div class="file-thumbnail-footer">\n' +
		    '   <div style="margin:5px 0">\n' +
		    '       <input class="kv-input kv-new form-control input-sm {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
		    '       <input class="kv-input kv-init form-control input-sm {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n' +
		    '   </div>\n' +
		    '   {actions}\n' +
		    '</div>';
		    $el2.fileinput({
		    	uploadUrl: '/admins/pages/image-temp',
		    	uploadAsync: false,
		    	maxFilesNum: 1,
		    	maxFileCount: 1,
		    	overwriteInitial: false,
		    	layoutTemplates: {
		    		footer: footerTemplate
		    	},
		    	previewThumbTags: {
		            '{TAG_VALUE}': '', // no value
		            '{TAG_CSS_NEW}': '', // new thumbnail input
		            '{TAG_CSS_INIT}': 'hide' // hide the initial input
		        },
		        initialPreview: [],
		        initialPreviewConfig: [

		        ],
		        initialPreviewThumbTags: [

		        ],
		        uploadExtraData: function() { // callback example
		        	var out = {},
		        	key = "order";
		        	out[key] = order;
		        	return out;
		        }
		    }).on("filebatchselected", function(event, files) {
		        // trigger upload method immediately after files are selected
		        $('#key_down').val(0);
		        $el2.fileinput("upload");
		        //xxx
		        // session_reindex();
		        set_browse_btn();
		        set_image_name(order, files[0]['name']);

		    }).on('filebatchuploadcomplete', function(event, files, extra) {
		        // console.log('called');
		        // session_reindex();
		        session_reindex();
		    });
		}

		function list_reindex() {
		    // // $('.submit-btn').addClass('disabled');


		    // var div_count = $(".dd ol li .dd-handle").length;
		    // var session_data = {

		    // };
		    // $('.dd > ol > li > .dd-handle ').each(function(e) {
		    //     var count = e + 1;
		    //     $(this).html('<i class="glyphicon glyphicon-move"></i>&nbsp;' + count + '');
		    //     $(this).attr('order', count);
		    // });
		    // $('.dd > ol > li').each(function(e) {
		    //     var order = $(this).find('.dd-handle').attr('order');
		    //     var image_name = $(this).find('img').attr('alt');
		    //     var from = $(this).attr('from');
		    //     var image_name_new = image_name.replace(/\s+/g, "-");
		    //     if (image_name_new !== undefined) {
		    //         session_data[order] = [image_name_new];
		    //         session_data[order].push(from);
		    //     }
		    // });
		    // request.session_reindex(session_data);

		}

		function session_reindex() {
			$('.submit-btn').addClass('disabled');
			var div_count = $(".dd ol li .dd-handle").length;
			var session_data = {

			};
			$('.dd > ol > li > .dd-handle ').each(function(e) {
				var count = e + 1;
				$(this).html('<i class="glyphicon glyphicon-move"></i>&nbsp;' + count + '');
				$(this).attr('order', count);
			});
			$('.dd > ol > li').each(function(e) {
				var order = $(this).find('.dd-handle').attr('order');
				var image_name = $(this).find('img').attr('alt');
				var from = $(this).attr('from');
				if (image_name !== undefined) {
					var image_name_new = image_name.replace(/\s+/g, "-");
				};
				if (image_name_new !== undefined) {
					session_data[order] = [image_name_new];
					session_data[order].push(from);
				}
			});
			request.session_reindex(session_data);

		}

		function set_slider_images_onload(is_session) {
			$('.dd > ol > li').each(function(e) {
				var order = $(this).find('.dd-handle').attr('order');
				var image_path = $(this).find('.dd-handle').attr('image_path');
				var from = $(this).attr('from');
				file_input_init_onload(order, image_path, is_session, from);
			});

			// session_reindex();
		}

		function set_browse_btn() {
			$('.dd > ol > li').each(function(e) {
				count_images = $(this).find('.file-preview-frame img').length;
				if (count_images != 0) {
					$(this).find('.btn-file').addClass('disabled');
				} else {
					$(this).find('.btn-file').removeClass('disabled');
				}
			});
		}

		function set_image_name(order, img_name) {
			$(document).find('.dd > ol .dd-item[data-id = ' + order + ']').attr('img-name', img_name);
		}

		function file_input_init_onload(order, image_path, is_session, from) {
			var $el2 = $("#input-706-" + order);

		    // custom footer template for the scenario
		    // the custom tags are in braces
		    var footerTemplate = '<div class="file-thumbnail-footer">\n' +
		    '   <div style="margin:5px 0">\n' +
		    '       <input class="kv-input kv-new form-control input-sm {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
		    '       <input class="kv-input kv-init form-control input-sm {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n' +
		    '   </div>\n' +
		    '   {actions}\n' +
		    '</div>';
		    var this_path = '';
		    this_path = '/assets/img/' + from + '/' + image_path;

		    $el2.fileinput({
		    	uploadUrl: '/admins/pages/image-temp',
		    	uploadAsync: false,
		    	maxFilesNum: 1,
		    	maxFileCount: 1,
		    	overwriteInitial: true,
		    	layoutTemplates: {
		    		footer: footerTemplate
		    	},
		    	previewThumbTags: {
		            '{TAG_VALUE}': image_path, // no value
		            '{TAG_CSS_NEW}': 'hide', // new thumbnail input
		            '{TAG_CSS_INIT}': '' // hide the initial input
		        },
		        initialPreview: [

		        "<img src='" + this_path + "' class='file-preview-image' alt='" + image_path + "' title=''>"

		        ],
		        initialCaption: image_path,
		        initialPreviewConfig: [{
		        	caption: image_path,
		        	width: "120px",
		        	url: "/site/file-delete",
		        	key: 1
		        }],
		        initialPreviewThumbTags: [{
		        	'{TAG_VALUE}': image_path,
		        	'{TAG_CSS_NEW}': 'hide',
		        	'{TAG_CSS_INIT}': ''
		        }, {
		        	'{TAG_CSS_NEW}': 'hide',
		        	'{TAG_CSS_INIT}': ''
		        }],


		        uploadExtraData: function() { // callback example
		        	var out = {},
		        	key = "order";
		        	out[key] = order;
		        	return out;
		        }
		    }).on("filebatchselected", function(event, files) {
		        // trigger upload method immediately after files are selected
		        $el2.fileinput("upload");
		        //xxx
		        $('#key_down').val(0);
		        set_browse_btn();
		        set_image_name();
		    }).on('filebatchuploadcomplete', function(event, files, extra) {

		    	session_reindex();
		    });

		}

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