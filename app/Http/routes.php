<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'beforeFilter'], function () {
	//HOME ROUTE
	Route::get('/', ['as'=>'home_index', 'uses' => 'HomeController@home']);
	Route::get('/admins',  ['as'=>'admins_index', 'uses' => 'AdminsController@getIndex']);

	Route::get('registration', ['as'=>'registration_view','uses'=>'UsersController@getRegistration']);
	Route::post('registration', ['uses'=>'UsersController@postRegistration']);
	Route::post('users/return-users',  ['uses' => 'UsersController@postReturnUsers', 'middleware' => ['acl:admins/acl/view']]);
	
	//USER PREFIX
	Route::group(['prefix' => 'users'], function () {
		Route::get('login', ['as'=>'users_login','uses'=>'UsersController@getLogin']);
		Route::post('login',['uses'=>'UsersController@postLogin']);
		Route::post('login-modal', ['uses'=>'UsersController@postLoginModal']);
		Route::get('profile/{username}',  ['as'=>'users_profile','uses' => 'UsersController@getProfile', function ($username) {}]);
		Route::post('profile',  ['as'=>'users_profile_post','uses' => 'UsersController@postProfile']);
		Route::post('user-auth', ['uses'=>'UsersController@postUserAuth']);
		Route::post('send-file', ['uses'=>'UsersController@postSendFile']);
		Route::post('validate', ['uses'=>'UsersController@postValidate']);
		Route::post('send-file-temp', ['uses'=>'UsersController@postSendFileTemp']);
		Route::post('request-users','UsersController@postRequestUsers');
		Route::post('request-user-information','UsersController@postRequestUserInformation');
	});	

	//ADMIN PREFIX
	Route::group(['prefix' => 'admins'], function () {
		Route::get('login', 'AdminsController@getLogin');
		Route::post('login', 'AdminsController@postLogin');
		Route::get('logout', 'AdminsController@getLogout');			
	});

	Route::get('/services', 'HomeController@services');
	Route::get('/marketplace', 'HomeController@marketplace');
	Route::get('/aboutus', 'HomeController@aboutus');
	Route::get('/advice', 'HomeController@advice');
	Route::get('/contactus', 'HomeController@contactus'); 
	Route::get('/reminders/forgot', 'RemindersController@getForgot');
	Route::post('/reminders/forgot', 'RemindersController@postForgot');
	Route::get('/reminders/reset/{token}', 'RemindersController@getReset');
	Route::post('/reminders/reset', 'RemindersController@postReset');


	Route::get('/schedule/new', 'SchedulesController@getNew');
	Route::post('/schedule/new', 'SchedulesController@postNew');
	Route::get('/schedule/details', 'SchedulesController@getDetails');
	Route::post('/schedule/details', 'SchedulesController@postDetails');
	Route::get('/schedule/confirmation', 'SchedulesController@getConfirmation');
	Route::post('/schedule/confirmation', 'SchedulesController@postConfirmation');



	/** ADMINS ACL GROUP **/
	Route::group(['middleware' => ['auth']], function(){
		Route::get('admins',  ['as'=>'admins_index', 'uses' => 'AdminsController@getIndex', 'middleware' => ['acl:admins']]);
			

		Route::group(['prefix' => 'admins'], function () {
			$prefix = 'admins';	
			Route::get('companies',  ['as' => 'companies_index','uses' => 'CompaniesController@getIndex', 'middleware' => ['acl:'.$prefix.'/companies']]);
			Route::get('companies/add',  ['as' => 'companies_add','uses' => 'CompaniesController@getAdd', 'middleware' => ['acl:'.$prefix.'/companies/add']]);
			Route::post('companies/add',  ['uses' => 'CompaniesController@postAdd', 'middleware' => ['acl:'.$prefix.'/companies/add']]);
			Route::get('companies/edit/{id}',  ['as' => 'companies_edit','uses' => 'CompaniesController@getEdit', 'middleware' => ['acl:'.$prefix.'/companies/edit'], function ($id) {}]);
			Route::post('companies/edit',  ['uses' => 'CompaniesController@postEdit', 'middleware' => ['acl:'.$prefix.'/companies/edit']]);
			Route::get('companies/view',  ['as' => 'companies_view','uses' => 'CompaniesController@getView', 'middleware' => ['acl:'.$prefix.'/companies/view'], function ($id) {}]);
			Route::post('companies/view',  ['uses' => 'CompaniesController@postView', 'middleware' => ['acl:'.$prefix.'/companies/view']]);
			Route::post('companies/delete',  ['uses' => 'CompaniesController@postDelete', 'middleware' => ['acl:'.$prefix.'/companies/delete']]);
			
			Route::get('deliveries',  ['as' => 'deliveries_index','uses' => 'DeliveriesController@getIndex', 'middleware' => ['acl:'.$prefix.'/deliveries']]);
			Route::get('deliveries/add',  ['as' => 'deliveries_add','uses' => 'DeliveriesController@getAdd', 'middleware' => ['acl:'.$prefix.'/deliveries/add']]);
			Route::post('deliveries/add',  ['uses' => 'DeliveriesController@postAdd', 'middleware' => ['acl:'.$prefix.'/deliveries/add']]);
			Route::get('deliveries/edit/{id}',  ['as' => 'deliveries_edit','uses' => 'DeliveriesController@getEdit', 'middleware' => ['acl:'.$prefix.'/deliveries/edit'], function ($id) {}]);
			Route::post('deliveries/edit',  ['uses' => 'DeliveriesController@postEdit', 'middleware' => ['acl:'.$prefix.'/deliveries/edit']]);
			Route::get('deliveries/view/{id}',  ['as' => 'deliveries_view','uses' => 'DeliveriesController@getView', 'middleware' => ['acl:'.$prefix.'/deliveries/view'], function ($id) {}]);
			Route::post('deliveries/view',  ['uses' => 'DeliveriesController@postView', 'middleware' => ['acl:'.$prefix.'/deliveries/view']]);
			Route::post('deliveries/delete',  ['uses' => 'DeliveriesController@postDelete', 'middleware' => ['acl:'.$prefix.'/deliveries/delete']]);
			
			Route::get('delivery-rules',  ['as' => 'deliveryRules_index','uses' => 'Delivery-rulesController@getIndex', 'middleware' => ['acl:'.$prefix.'/delivery-rules']]);
			Route::get('delivery-rules/add',  ['as' => 'deliveryRules_add','uses' => 'Delivery-rulesController@getAdd', 'middleware' => ['acl:'.$prefix.'/delivery-rules/add']]);
			Route::post('delivery-rules/add',  ['uses' => 'DeliveryRulesController@postAdd', 'middleware' => ['acl:'.$prefix.'/delivery-rules/add']]);
			Route::get('delivery-rules/edit/{id}',  ['as' => 'deliveryRules_edit','uses' => 'Delivery-rulesController@getEdit', 'middleware' => ['acl:'.$prefix.'/delivery-rules/edit'], function ($id) {}]);
			Route::post('delivery-rules/edit',  ['uses' => 'DeliveryRulesController@postEdit', 'middleware' => ['acl:'.$prefix.'/delivery-rules/edit']]);
			Route::get('delivery-rules/view/{id}',  ['as' => 'deliveryRules_view','uses' => 'Delivery-rulesController@getView', 'middleware' => ['acl:'.$prefix.'/delivery-rules/view'], function ($id) {}]);
			Route::post('delivery-rules/view',  ['uses' => 'DeliveryRulesController@postView', 'middleware' => ['acl:'.$prefix.'/delivery-rules/view']]);
			Route::post('delivery-rules/delete',  ['uses' => 'DeliveryRulesController@postDelete', 'middleware' => ['acl:'.$prefix.'/delivery-rules/delete']]);

			Route::get('inventories',  ['as' => 'inventories_index','uses' => 'InventoriesController@getIndex', 'middleware' => ['acl:'.$prefix.'/inventories']]);
			Route::get('inventories/add',  ['as' => 'inventories_add','uses' => 'InventoriesController@getAdd', 'middleware' => ['acl:'.$prefix.'/inventories/add']]);
			Route::post('inventories/add',  ['uses' => 'InventoriesController@postAdd', 'middleware' => ['acl:'.$prefix.'/inventories/add']]);
			Route::get('inventories/edit/{id}',  ['as' => 'inventories_edit','uses' => 'InventoriesController@getEdit', 'middleware' => ['acl:'.$prefix.'/inventories/edit'], function ($id) {}]);
			Route::post('inventories/edit',  ['uses' => 'InventoriesController@postEdit', 'middleware' => ['acl:'.$prefix.'/inventories/edit']]);
			Route::get('inventories/view/{id}',  ['as' => 'inventories_view','uses' => 'InventoriesController@getView', 'middleware' => ['acl:'.$prefix.'/inventories/view'], function ($id) {}]);
			Route::post('inventories/view',  ['uses' => 'InventoriesController@postView', 'middleware' => ['acl:'.$prefix.'/inventories/view']]);
			Route::post('inventories/delete',  ['uses' => 'InventoriesController@postDelete', 'middleware' => ['acl:'.$prefix.'/inventories/delete']]);

			Route::get('inventory-items',  ['as' => 'inventoryItems_index','uses' => 'Inventory-itemsController@getIndex', 'middleware' => ['acl:'.$prefix.'/inventory-items']]);
			Route::get('inventory-items/add',  ['as' => 'inventoryItems_add','uses' => 'Inventory-itemsController@getAdd', 'middleware' => ['acl:'.$prefix.'/inventory-items/add']]);
			Route::post('inventory-items/add',  ['uses' => 'InventoryItemsController@postAdd', 'middleware' => ['acl:'.$prefix.'/inventory-items/add']]);
			Route::get('inventory-items/edit/{id}',  ['as' => 'inventoryItems_edit','uses' => 'Inventory-itemsController@getEdit', 'middleware' => ['acl:'.$prefix.'/inventory-items/edit'], function ($id) {}]);
			Route::post('inventory-items/edit',  ['uses' => 'InventoryItemsController@postEdit', 'middleware' => ['acl:'.$prefix.'/inventory-items/edit']]);
			Route::get('inventory-items/view/{id}',  ['as' => 'inventoryItems_view','uses' => 'Inventory-itemsController@getView', 'middleware' => ['acl:'.$prefix.'/inventory-items/view'], function ($id) {}]);
			Route::post('inventory-items/view',  ['uses' => 'InventoryItemsController@postView', 'middleware' => ['acl:'.$prefix.'/inventory-items/view']]);
			Route::post('inventory-items/delete',  ['uses' => 'InventoryItemsController@postDelete', 'middleware' => ['acl:'.$prefix.'/inventory-items/delete']]);


			Route::get('roles',  ['as'=>'roles_index', 'uses' => 'RolesController@getIndex', 'middleware' => ['acl:'.$prefix.'/roles']]);
			Route::get('roles/add',  ['as'=>'roles_add', 'uses' => 'RolesController@getAdd','middleware' => ['acl:'.$prefix.'/roles/add']]);
			Route::post('roles/add',  ['uses' => 'RolesController@postAdd', 'middleware' => ['acl:'.$prefix.'/roles/add']]);
			Route::get('roles/edit/{id}',  ['as'=>'roles_edit', 'uses' => 'RolesController@getEdit', 'middleware' => ['acl:'.$prefix.'/roles/edit/{id}'], function ($id) {}]);
			Route::post('roles/edit',  ['as'=>'roles_update','uses' => 'RolesController@postEdit', 'middleware' => ['acl:'.$prefix.'/roles/edit']]);
			Route::get('roles/delete-data/{id}',  ['as'=>'roles_delete', 'uses' => 'RolesController@getDelete', 'middleware' => ['acl:'.$prefix.'/roles/delete-data{id}'], function ($id) {}]);

			Route::get('permissions',  ['as'=>'permissions_index', 'uses' => 'PermissionsController@getIndex', 'middleware' => ['acl:'.$prefix.'/permissions']]);
			Route::get('permissions/add',  ['as'=>'permissions_add','uses' => 'PermissionsController@getAdd', 'middleware' => ['acl:'.$prefix.'/permissions/add']]);
			Route::post('permissions/add',  ['uses' => 'PermissionsController@postAdd', 'middleware' => ['acl:'.$prefix.'/permissions/add']]);
			Route::get('permissions/edit/{id}', ['as' => 'permissions_edit', 'uses' => 'PermissionsController@getEdit','middleware' => ['acl:'.$prefix.'/permissions/edit/{id}'], function ($id) {}]);
			Route::post('permissions/edit',  ['uses' => 'PermissionsController@postEdit', 'middleware' => ['acl:'.$prefix.'/permissions/edit']]);
			Route::get('permissions/delete-data/{id}',  ['as'=>'permissions_delete','uses' => 'PermissionsController@getDelete', 'middleware' => ['acl:'.$prefix.'/permissions/delete-data{id}'], function ($id) {}]);

			Route::get('permission-roles',  ['as'=>'permission_roles_index', 'uses' => 'PermissionRolesController@getIndex', 'middleware' => ['acl:'.$prefix.'/permission-roles']]);
			Route::get('permission-roles/add',  ['as'=>'permission_roles_add', 'uses' => 'PermissionRolesController@getAdd', 'middleware' => ['acl:'.$prefix.'/permission-roles/add']]);
			Route::post('permission-roles/add',  ['uses' => 'PermissionRolesController@postAdd', 'middleware' => ['acl:'.$prefix.'/permission-roles/add']]);
			Route::get('permission-roles/edit/{id}',  ['as'=>'permission_roles_edit', 'uses' => 'PermissionRolesController@getEdit', 'middleware' => ['acl:'.$prefix.'/permission-roles/edit/{id}'], function ($id) {}]);
			Route::post('permission-roles/edit',  ['uses' => 'PermissionRolesController@postEdit', 'middleware' => ['acl:'.$prefix.'/permission-roles/edit']]);
			Route::get('permission-roles/delete-data/{id}',  ['as'=>'permission_roles_delete', 'uses' => 'PermissionRolesController@getDelete', 'middleware' => ['acl:'.$prefix.'/permission-roles/delete-data/{id}'], function ($id) {}]);
			
			//SETUP
			Route::get('schedules/setup',  ['as'=>'schedule_setup','uses' => 'ScheduleLimitsController@getIndex', 'middleware' => ['acl:'.$prefix.'/schedules/setup']]);

			//SCHEDULES
			Route::get('schedules',  ['as' => 'schedules_index','uses' => 'SchedulesController@getIndex', 'middleware' => ['acl:'.$prefix.'/schedules']]);
			Route::get('schedules/add',  ['as' => 'schedules_add','uses' => 'SchedulesController@getAdd', 'middleware' => ['acl:'.$prefix.'/schedules/add']]);
			Route::post('schedules/add',  ['uses' => 'SchedulesController@postAdd', 'middleware' => ['acl:'.$prefix.'/schedules/add']]);
			Route::get('schedules/edit/{id}',  ['as' => 'schedules_edit','uses' => 'SchedulesController@getEdit', 'middleware' => ['acl:'.$prefix.'/schedules/edit'], function ($id) {}]);
			Route::post('schedules/edit',  ['uses' => 'SchedulesController@postEdit', 'middleware' => ['acl:'.$prefix.'/schedules/edit']]);
			Route::get('schedules/view/{id}',  ['as' => 'schedules_view','uses' => 'SchedulesController@getView', 'middleware' => ['acl:'.$prefix.'/schedules/view'], function ($id) {}]);
			Route::post('schedules/view',  ['uses' => 'SchedulesController@postView', 'middleware' => ['acl:'.$prefix.'/schedules/view']]);
			Route::post('schedules/delete',  ['uses' => 'SchedulesController@postDelete', 'middleware' => ['acl:'.$prefix.'/schedules/delete']]);
			Route::post('schedules/preview',  ['uses' => 'SchedulesController@postPreview', 'middleware' => ['acl:'.$prefix.'/schedules/preview']]);
			Route::post('schedules/order-add',  ['uses' => 'SchedulesController@postOrderAdd', 'middleware' => ['acl:'.$prefix.'schedules/order-add']]);
			Route::post('schedules/ajax-validation',  ['uses' => 'SchedulesController@postAjaxValidation', 'middleware' => ['acl:'.$prefix.'schedules/ajax-validation']]);

			//SCHEDULES TRANSACTIONS
			Route::get('schedules/queue',  ['as' => 'schedule_transactions_index','uses' => 'ScheduleTransactionsController@getIndex', 'middleware' => ['acl:'.$prefix.'/schedules/queue']]);
			Route::get('schedules/new',  ['as' => 'schedule_transactions_new','uses' => 'ScheduleTransactionsController@getAdd', 'middleware' => ['acl:'.$prefix.'/schedules/new']]);
			Route::post('schedules/new',  ['uses' => 'ScheduleTransactionsController@postAdd', 'middleware' => ['acl:'.$prefix.'/schedules/new']]);




			//SCHEDULES LIMIT
			Route::get('schedule-limits',  ['as' => 'schedule-limits_index','uses' => 'ScheduleLimitsController@getIndex', 'middleware' => ['acl:'.$prefix.'/schedule-limits']]);
			Route::get('schedule-limits/add',  ['as' => 'schedule-limits_add','uses' => 'ScheduleLimitsController@getAdd', 'middleware' => ['acl:'.$prefix.'/schedule-limits/add']]);
			Route::post('schedule-limits/add',  ['uses' => 'ScheduleLimitsController@postAdd', 'middleware' => ['acl:'.$prefix.'/schedule-limits/add']]);
			Route::get('schedule-limits/edit/{id}',  ['as' => 'scheduleLimits_edit','uses' => 'Schedule-limitsController@getEdit', 'middleware' => ['acl:'.$prefix.'/schedule-limits/edit'], function ($id) {}]);
			Route::post('schedule-limits/edit',  ['uses' => 'ScheduleLimitsController@postEdit', 'middleware' => ['acl:'.$prefix.'/schedule-limits/edit']]);
			Route::get('schedule-limits/view/{id}',  ['as' => 'scheduleLimits_view','uses' => 'Schedule-limitsController@getView', 'middleware' => ['acl:'.$prefix.'/schedule-limits/view'], function ($id) {}]);
			Route::post('schedule-limits/view',  ['uses' => 'ScheduleLimitsController@postView', 'middleware' => ['acl:'.$prefix.'/schedule-limits/view']]);
			Route::post('schedule-limits/delete',  ['uses' => 'ScheduleLimitsController@postDelete', 'middleware' => ['acl:'.$prefix.'/schedule-limits/delete']]);
			Route::post('limits/overwrite',  ['uses' => 'ScheduleLimitsController@postAddOverwrite', 'middleware' => ['acl:'.$prefix.'/limits/overwrite']]);
			Route::post('limits/validate-hours',  ['uses' => 'ScheduleLimitsController@postValidateHours', 'middleware' => ['acl:'.$prefix.'/limits/validate-hours']]);
			Route::post('limits/validate-overwrite-hours',  ['uses' => 'ScheduleLimitsController@postValidateOverWriteHours', 'middleware' => ['acl:'.$prefix.'/limits/validate-overwrite-hours']]);

			//SCHEDULE-RULES
			Route::get('schedule-rules',  ['as' => 'rules_index','uses' => 'ScheduleRulesController@getIndex', 'middleware' => ['acl:'.$prefix.'/schedule-rules']]);
			Route::get('schedule-rules/add/{id}',  ['as' => 'rules_add','uses' => 'ScheduleRulesController@getAdd', 'middleware' => ['acl:'.$prefix.'/schedule-rules/add'], function ($id) {}]);
			Route::post('schedule-rules/add',  ['uses' => 'ScheduleRulesController@postAdd', 'middleware' => ['acl:'.$prefix.'/schedule-rules/add']]);
			Route::get('schedule-rules/edit/{id}',  ['as' => 'scheduleRules_edit','uses' => 'ScheduleRulesController@getEdit', 'middleware' => ['acl:'.$prefix.'/schedule-rules/edit'], function ($id) {}]);
			Route::post('schedule-rules/edit',  ['uses' => 'ScheduleRulesController@postEdit', 'middleware' => ['acl:'.$prefix.'/schedule-rules/edit']]);
			Route::get('schedule-rules/view/{id}',  ['as' => 'scheduleRules_view','uses' => 'ScheduleRulesController@getView', 'middleware' => ['acl:'.$prefix.'/schedule-rules/view'], function ($id) {}]);
			Route::post('schedule-rules/view',  ['uses' => 'ScheduleRulesController@postView', 'middleware' => ['acl:'.$prefix.'/schedule-rules/view']]);
			Route::post('schedule-rules/delete',  ['uses' => 'ScheduleRulesController@postDelete', 'middleware' => ['acl:'.$prefix.'/schedule-rules/delete']]);
			Route::post('schedule-rules/overwrite',  ['uses' => 'ScheduleRulesController@postAddOverwrite', 'middleware' => ['acl:'.$prefix.'/schedule-rules/overwrite']]);
			Route::post('schedule-rules/validate-hours',  ['uses' => 'ScheduleRulesController@postValidateHours', 'middleware' => ['acl:'.$prefix.'/schedule-rules/validate-hours']]);
			Route::post('schedule-rules/validate-overwrite-hours',  ['uses' => 'ScheduleRulesController@postValidateOverWriteHours', 'middleware' => ['acl:'.$prefix.'/schedule-rules/validate-overwrite-hours']]);
			Route::post('schedule-rules/return-rules',  ['uses' => 'ScheduleRulesController@postReturnRules', 'middleware' => ['acl:'.$prefix.'/schedule-rules/return-rules']]);


			Route::get('services',  ['as' => 'services_index','uses' => 'ServicesController@getIndex', 'middleware' => ['acl:'.$prefix.'/services']]);
			Route::get('services/add',  ['as' => 'services_add','uses' => 'ServicesController@getAdd', 'middleware' => ['acl:'.$prefix.'/services/add']]);
			Route::post('services/add',  ['uses' => 'ServicesController@postAdd', 'middleware' => ['acl:'.$prefix.'/services/add']]);
			Route::get('services/edit/{id}',  ['as' => 'services_edit','uses' => 'ServicesController@getEdit', 'middleware' => ['acl:'.$prefix.'/services/edit'], function ($id) {}]);
			Route::post('services/edit',  ['uses' => 'ServicesController@postEdit', 'middleware' => ['acl:'.$prefix.'/services/edit']]);
			Route::get('services/view/{id}',  ['as' => 'services_view','uses' => 'ServicesController@getView', 'middleware' => ['acl:'.$prefix.'/services/view'], function ($id) {}]);
			Route::post('services/view',  ['uses' => 'ServicesController@postView', 'middleware' => ['acl:'.$prefix.'/services/view']]);
			Route::post('services/delete',  ['uses' => 'ServicesController@postDelete', 'middleware' => ['acl:'.$prefix.'/services/delete']]);

			Route::get('resources',  ['as' => 'resources_index','uses' => 'ResourcesController@getIndex', 'middleware' => ['acl:'.$prefix.'/resources']]);
			Route::get('resources/add',  ['as' => 'resources_add','uses' => 'ResourcesController@getAdd', 'middleware' => ['acl:'.$prefix.'/resources/add']]);
			Route::post('resources/add',  ['uses' => 'ResourcesController@postAdd', 'middleware' => ['acl:'.$prefix.'/resources/add']]);
			Route::get('resources/edit',  ['as' => 'resources_edit','uses' => 'ResourcesController@getEdit', 'middleware' => ['acl:'.$prefix.'/resources/edit']]);
			Route::post('resources/edit',  ['uses' => 'ResourcesController@postEdit', 'middleware' => ['acl:'.$prefix.'/resources/edit']]);
			Route::get('resources/view/{id}',  ['as' => 'resources_view','uses' => 'ResourcesController@getView', 'middleware' => ['acl:'.$prefix.'/resources/view'], function ($id) {}]);
			Route::post('resources/view',  ['uses' => 'ResourcesController@postView', 'middleware' => ['acl:'.$prefix.'/resources/view']]);
			Route::post('resources/delete',  ['uses' => 'ResourcesController@postDelete', 'middleware' => ['acl:'.$prefix.'/resources/delete']]);

			Route::get('taxes',  ['as' => 'taxes_index','uses' => 'TaxesController@getIndex', 'middleware' => ['acl:'.$prefix.'/taxes']]);
			Route::get('taxes/add',  ['as' => 'taxes_add','uses' => 'TaxesController@getAdd', 'middleware' => ['acl:'.$prefix.'/taxes/add']]);
			Route::post('taxes/add',  ['uses' => 'TaxesController@postAdd', 'middleware' => ['acl:'.$prefix.'/taxes/add']]);
			Route::get('taxes/edit/{id}',  ['as' => 'taxes_edit','uses' => 'TaxesController@getEdit', 'middleware' => ['acl:'.$prefix.'/taxes/edit'], function ($id) {}]);
			Route::post('taxes/edit',  ['uses' => 'TaxesController@postEdit', 'middleware' => ['acl:'.$prefix.'/taxes/edit']]);
			Route::get('taxes/view/{id}',  ['as' => 'taxes_view','uses' => 'TaxesController@getView', 'middleware' => ['acl:'.$prefix.'/taxes/view'], function ($id) {}]);
			Route::post('taxes/view',  ['uses' => 'TaxesController@postView', 'middleware' => ['acl:'.$prefix.'/taxes/view']]);
			Route::post('taxes/delete',  ['uses' => 'TaxesController@postDelete', 'middleware' => ['acl:'.$prefix.'/taxes/delete']]);

			Route::get('flags',  ['as'=>'flags_index', 'uses' => 'FlagsController@getIndex', 'middleware' => ['acl:'.$prefix.'/flags']]);
			Route::get('flags/view/{id}',  ['as'=>'flag_view', 'uses' => 'FlagsController@getView', 'middleware' => ['acl:'.$prefix.'/flags/view/{id}'], function ($id) {}]);
			Route::post('flags/view',  ['uses' => 'FlagsController@postView', 'middleware' => ['acl:'.$prefix.'/flags/view']]);
			Route::get('flags/approved',  ['as'=>'flags_app', 'uses' => 'FlagsController@getApproved', 'middleware' => ['acl:'.$prefix.'/flags/approved']]);
			Route::get('flags/rejected',  ['as'=>'flags_rej', 'uses' => 'FlagsController@getRejected', 'middleware' => ['acl:'.$prefix.'/flags/rejected']]);
			Route::get('flags/re-flagged',  ['as'=>'flags_re', 'uses' => 'FlagsController@getReflagged', 'middleware' => ['acl:'.$prefix.'/flags/re-flagged']]);
			Route::get('flags/final-approved',  ['as'=>'flags_f_app', 'uses' => 'FlagsController@getFinalApproved', 'middleware' => ['acl:'.$prefix.'/flags/final-approved']]);
			Route::get('flags/final-reject',  ['as'=>'flags_f_rej', 'uses' => 'FlagsController@getFinalRejected', 'middleware' => ['acl:'.$prefix.'/flags/final-reject']]);
			Route::get('flags/banned',  ['as'=>'flags_banned', 'uses' => 'FlagsController@getBanned', 'middleware' => ['acl:'.$prefix.'/flags/banned']]);

			Route::get('acl/view',  ['as' => 'acl_view','uses' => 'AdminsController@getViewAcl', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			Route::get('categories/view',  ['as'=>'category_view', 'uses' => 'AdminsController@getViewCategory', 'middleware' => ['acl:'.$prefix.'/categories/view']]);
			Route::get('categories/add',  ['as'=>'category_add', 'uses' => 'CategoriesController@getAdd', 'middleware' => ['acl:'.$prefix.'/categories/add']]);
			Route::post('categories/add',  ['uses' => 'CategoriesController@postAdd', 'middleware' => ['acl:'.$prefix.'/categories/add']]);
			Route::get('categories/edit',  ['as'=>'category_edit','uses' => 'CategoriesController@getEdit', 'middleware' => ['acl:'.$prefix.'/categories/edit']]);
			Route::post('categories/edit',  ['uses' => 'CategoriesController@postEdit', 'middleware' => ['acl:'.$prefix.'/categories/edit']]);

			//MENUES
			Route::get('menus',  ['as' => 'menus_index','uses' => 'MenusController@getIndex', 'middleware' => ['acl:'.$prefix.'/menus']]);
			Route::get('menus/add',  ['as' => 'menus_add','uses' => 'MenusController@getAdd', 'middleware' => ['acl:'.$prefix.'/menus/add']]);
			Route::post('menus/add',  ['uses' => 'MenusController@postAdd', 'middleware' => ['acl:'.$prefix.'/menus/add']]);
			Route::get('menus/order',  ['as' => 'menus_order','uses' => 'MenusController@getOrder', 'middleware' => ['acl:'.$prefix.'/menus/order']]);
			Route::post('menus/order',  ['uses' => 'MenusController@postOrder', 'middleware' => ['acl:'.$prefix.'/menus/order']]);
			Route::get('menus/edit/{id}',  ['as' => 'menus_edit','uses' => 'MenusController@getEdit', 'middleware' => ['acl:'.$prefix.'/menus/edit'], function ($id) {}]);
			Route::post('menus/edit',  ['uses' => 'MenusController@postEdit', 'middleware' => ['acl:'.$prefix.'/menus/edit']]);
			Route::get('menus/view/{id}',  ['as' => 'menus_view','uses' => 'MenusController@getView', 'middleware' => ['acl:'.$prefix.'/menus/view'], function ($id) {}]);
			Route::post('menus/view',  ['uses' => 'MenusController@postView', 'middleware' => ['acl:'.$prefix.'/menus/view']]);
			Route::post('menus/delete',  ['uses' => 'MenusController@postDelete', 'middleware' => ['acl:'.$prefix.'/menus/delete']]);
			Route::post('menus/count-items',  ['uses' => 'MenusController@postCountItems', 'middleware' => ['acl:'.$prefix.'/menus/count-items']]);
			Route::post('menus/reload-menus',  ['uses' => 'MenusController@postReloadMenus', 'middleware' => ['acl:'.$prefix.'/menus/reload-menus']]);
			
			//MENUES ITEMS
			Route::get('menu-items',  ['as' => 'menu-items_index','uses' => 'MenuItemsController@getIndex', 'middleware' => ['acl:'.$prefix.'/menu-items']]);
			Route::get('menu-items/add/{id}',  ['as' => 'menu-items_add','uses' => 'MenuItemsController@getAdd', 'middleware' => ['acl:'.$prefix.'/menu-items/add'], function ($id) {}]);
			Route::post('menu-items/add',  ['uses' => 'MenuItemsController@postAdd', 'middleware' => ['acl:'.$prefix.'/menu-items/add']]);
			Route::get('menu-items/edit/{id}',  ['as' => 'menu-items_edit','uses' => 'MenuItemsController@getEdit', 'middleware' => ['acl:'.$prefix.'/menu-items/edit'], function ($id) {}]);
			Route::post('menu-items/edit',  ['uses' => 'MenuItemsController@postEdit', 'middleware' => ['acl:'.$prefix.'/menu-items/edit']]);
			Route::get('menu-items/view/{id}',  ['as' => 'menu-items_view','uses' => 'MenuItemsController@getView', 'middleware' => ['acl:'.$prefix.'/menu-items/view'], function ($id) {}]);
			Route::post('menu-items/view',  ['uses' => 'MenuItemsController@postView', 'middleware' => ['acl:'.$prefix.'/menu-items/view']]);
			Route::post('menu-items/delete',  ['uses' => 'MenuItemsController@postDelete', 'middleware' => ['acl:'.$prefix.'/menu-items/delete']]);

			//PAGES
			Route::get('pages',  ['as' => 'pages_index','uses' => 'PagesController@getIndex', 'middleware' => ['acl:'.$prefix.'/pages']]);
			Route::get('pages/add',  ['as' => 'pages_add','uses' => 'PagesController@getAdd', 'middleware' => ['acl:'.$prefix.'/pages/add']]);
			Route::get('pages/preview',  ['as' => 'pages_preview','uses' => 'PagesController@getPreview', 'middleware' => ['acl:'.$prefix.'/pages/preview']]);
			Route::get('pages/preview-edit',  ['as' => 'pages_preview_edit','uses' => 'PagesController@getPreviewEdit', 'middleware' => ['acl:'.$prefix.'/pages/preview-edit']]);
			Route::post('pages/add',  ['uses' => 'PagesController@postAdd', 'middleware' => ['acl:'.$prefix.'/pages/add']]);
			Route::get('pages/edit/{id}',  ['as' => 'pages_edit','uses' => 'PagesController@getEdit', 'middleware' => ['acl:'.$prefix.'/pages/edit'], function ($id) {}]);
			Route::post('pages/edit',  ['uses' => 'PagesController@postEdit', 'middleware' => ['acl:'.$prefix.'/pages/edit']]);
			Route::get('pages/view/{id}',  ['as' => 'pages_view','uses' => 'PagesController@getView', 'middleware' => ['acl:'.$prefix.'/pages/view'], function ($id) {}]);
			Route::post('pages/view',  ['uses' => 'PagesController@postView', 'middleware' => ['acl:'.$prefix.'/pages/view']]);
			Route::post('pages/delete',  ['uses' => 'PagesController@postDelete', 'middleware' => ['acl:'.$prefix.'/pages/delete']]);
			Route::post('pages/content-add',  ['uses' => 'PagesController@postContentAdd', 'middleware' => ['acl:'.$prefix.'/pages/content-add']]);
			Route::post('pages/load-preview',  ['uses' => 'PagesController@postLoadPreview', 'middleware' => ['acl:'.$prefix.'/pages/load-preview']]);
			Route::post('pages/change-status',  ['uses' => 'PagesController@postChangeStatus', 'middleware' => ['acl:'.$prefix.'/pages/change-status']]);
			Route::post('pages/content-image',  ['uses' => 'PagesController@postContentImage', 'middleware' => ['acl:'.$prefix.'/pages/content-image']]);
			Route::post('pages/image-temp',  ['uses' => 'PagesController@postImageTemp', 'middleware' => ['acl:'.$prefix.'/pages/image-temp']]);
			Route::post('pages/insert-slide',  ['uses' => 'PagesController@postInsertSlide', 'middleware' => ['acl:'.$prefix.'/pages/insert-slide']]);
			Route::post('pages/session-reindex',  ['uses' => 'PagesController@postSessionReindex', 'middleware' => ['acl:'.$prefix.'/pages/session-reindex']]);
			Route::post('pages/remove-temp',  ['uses' => 'PagesController@postRemoveTemp', 'middleware' => ['acl:'.$prefix.'/pages/remove-temp']]);
			Route::post('pages/reload-pages',  ['uses' => 'PagesController@postReloadPages', 'middleware' => ['acl:'.$prefix.'/pages/reload-pages']]);
			Route::post('pages/test-session',  ['uses' => 'PagesController@postTestSession', 'middleware' => ['acl:'.$prefix.'/pages/test-session']]);

			
			Route::get('projects',  ['as' => 'projects_index','uses' => 'ProjectsController@getIndex', 'middleware' => ['acl:'.$prefix.'/projects']]);
			Route::get('projects/add',  ['as' => 'projects_add','uses' => 'ProjectsController@getAdd', 'middleware' => ['acl:'.$prefix.'/projects/add']]);
			Route::post('projects/add',  ['uses' => 'ProjectsController@postAdd', 'middleware' => ['acl:'.$prefix.'/projects/add']]);
			Route::get('projects/edit/{id}',  ['as' => 'projects_edit','uses' => 'ProjectsController@getEdit', 'middleware' => ['acl:'.$prefix.'/projects/edit'], function ($id) {}]);
			Route::post('projects/edit',  ['uses' => 'ProjectsController@postEdit', 'middleware' => ['acl:'.$prefix.'/projects/edit']]);
			Route::get('projects/view/{id}',  ['as' => 'projects_view','uses' => 'ProjectsController@getView', 'middleware' => ['acl:'.$prefix.'/projects/view'], function ($id) {}]);
			Route::post('projects/view',  ['uses' => 'ProjectsController@postView', 'middleware' => ['acl:'.$prefix.'/projects/view']]);
			Route::post('projects/delete',  ['uses' => 'ProjectsController@postDelete', 'middleware' => ['acl:'.$prefix.'/projects/delete']]);


			Route::get('tasks',  ['as' => 'tasks_index','uses' => 'TasksController@getIndex', 'middleware' => ['acl:'.$prefix.'/tasks']]);
			Route::get('tasks/add',  ['as' => 'tasks_add','uses' => 'TasksController@getAdd', 'middleware' => ['acl:'.$prefix.'/tasks/add']]);
			Route::post('tasks/add',  ['uses' => 'TasksController@postAdd', 'middleware' => ['acl:'.$prefix.'/tasks/add']]);
			Route::get('tasks/edit/{id}',  ['as' => 'tasks_edit','uses' => 'TasksController@getEdit', 'middleware' => ['acl:'.$prefix.'/tasks/edit'], function ($id) {}]);
			Route::post('tasks/edit',  ['uses' => 'TasksController@postEdit', 'middleware' => ['acl:'.$prefix.'/tasks/edit']]);
			Route::post('tasks/remove',  ['uses' => 'TasksController@postRemove', 'middleware' => ['acl:'.$prefix.'/tasks/remove']]);
			Route::post('tasks/upload',  ['uses' => 'TasksController@postUpload', 'middleware' => ['acl:'.$prefix.'/tasks/upload']]);
			Route::get('tasks/view/{id}',  ['as' => 'tasks_view','uses' => 'TasksController@getView', 'middleware' => ['acl:'.$prefix.'/tasks/view'], function ($id) {}]);
			Route::post('tasks/view',  ['uses' => 'TasksController@postView', 'middleware' => ['acl:'.$prefix.'/tasks/view']]);
			Route::post('tasks/completed',  ['uses' => 'TasksController@postTaskCompleted', 'middleware' => ['acl:'.$prefix.'/tasks/completed']]);
			Route::post('tasks/in-process',  ['uses' => 'TasksController@postTaskInProcess', 'middleware' => ['acl:'.$prefix.'/tasks/in-process']]);

			// Route::get('users/index',  ['as' => 'users_index','uses' => 'AdminsController@getUsersIndex', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			// Route::get('users/add',  ['as' => 'users_add','uses' => 'AdminsController@getUsersAdd', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			// Route::post('users/add',  ['uses' => 'AdminsController@postUsersAdd', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			// Route::get('users/edit/{id}',  ['as' => 'users_edit','uses' => 'AdminsController@getUsersEdit', 'middleware' => ['acl:'.$prefix.'/acl/view'], function ($id) {}]);
			// Route::post('users/edit',  ['uses' => 'AdminsController@postUsersEdit', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
		
			//EMMANUELS USER ROUTE
			Route::get('users',  ['as' => 'users_index','uses' => 'UsersController@getIndex', 'middleware' => ['acl:'.$prefix.'/users']]);
			Route::get('users/add',  ['as' => 'users_add','uses' => 'UsersController@getAdd', 'middleware' => ['acl:'.$prefix.'/users/add']]);
			Route::post('users/add',  ['uses' => 'UsersController@postAdd', 'middleware' => ['acl:'.$prefix.'/users/add']]);
			Route::get('users/edit/{id}',  ['as' => 'users_edit','uses' => 'UsersController@getEdit', 'middleware' => ['acl:'.$prefix.'/users/edit'], function ($id) {}]);
			Route::post('users/edit',  ['uses' => 'UsersController@postEdit', 'middleware' => ['acl:'.$prefix.'/users/edit']]);
			Route::get('users/view/{id}',  ['as' => 'users_view','uses' => 'UsersController@getView', 'middleware' => ['acl:'.$prefix.'/users/view'], function ($id) {}]);
			Route::post('users/view',  ['uses' => 'UsersController@postView', 'middleware' => ['acl:'.$prefix.'/users/view']]);
			Route::post('users/delete',  ['uses' => 'UsersController@postDelete', 'middleware' => ['acl:'.$prefix.'/users/delete']]);
			Route::post('users/invoice-users',  ['uses' => 'UsersController@postInvoiceUsers', 'middleware' => ['acl:admins/acl/view']]);
			Route::post('users/user-info',  ['uses' => 'UsersController@postUserInfo', 'middleware' => ['acl:admins/acl/view']]);

		});
	});

	//PERMISSIONS ROUTE
	Route::group(['prefix' => 'permissions'], function () {
		Route::get('auto-update', ['uses'=>'PermissionsController@getAutoUpdate']);
	});

});
	//DONT REMOVE **
	// Route::get('blank',  ['as' => 'blank_index','uses' => 'BlankController@getIndex', 'middleware' => ['acl:'.$prefix.'/blank']]);
	// Route::get('blank/add',  ['as' => 'blank_add','uses' => 'BlankController@getAdd', 'middleware' => ['acl:'.$prefix.'/blank/add']]);
	// Route::post('blank/add',  ['uses' => 'BlankController@postAdd', 'middleware' => ['acl:'.$prefix.'/blank/add']]);
	// Route::get('blank/edit/{id}',  ['as' => 'blank_edit','uses' => 'BlankController@getEdit', 'middleware' => ['acl:'.$prefix.'/blank/edit'], function ($id) {}]);
	// Route::post('blank/edit',  ['uses' => 'BlankController@postEdit', 'middleware' => ['acl:'.$prefix.'/blank/edit']]);
	// Route::get('blank/view/{id}',  ['as' => 'blank_view','uses' => 'BlankController@getView', 'middleware' => ['acl:'.$prefix.'/blank/view'], function ($id) {}]);
	// Route::post('blank/view',  ['uses' => 'BlankController@postView', 'middleware' => ['acl:'.$prefix.'/blank/view']]);
	// Route::post('blank/delete',  ['uses' => 'BlankController@postDelete', 'middleware' => ['acl:'.$prefix.'/blank/delete']]);
	// Belongs at the bottom. Reason is because if no other link exists this must be true
	Route::get('/{param1}','PagesController@getPage');
	Route::get('/{param1}/{param2}','PagesController@getPage');