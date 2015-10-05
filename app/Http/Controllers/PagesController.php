<?php
namespace App\Http\Controllers;

use Input;
use Validator;
use Redirect;
use Hash;
use Request;
use Route;
use Response;
use Auth;
use URL;
use Session;
use Laracasts\Flash\Flash;
use JavaScript;
use View;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\Permission;
use App\PermissionRole;
use App\Website;
use App\Company;
use App\Menu;
use App\Page;

class PagesController extends Controller
{
    public function __construct() {

        // // Define layout
        $this->layout = 'layouts.admins';
        $this_username = null;
        //PROFILE IMAGE
        $this_user_profile_image = null;
        if (Auth::check()) {
        $this_user = User::find(Auth::user()->id);
        $this_username = $this_user->username;

        //PROFILE IMAGE
        $this_user_profile_image = Job::imageValidator($this_user->profile_image);
        }

        View::share('this_username',$this_username);
        View::share('this_user_profile_image',$this_user_profile_image);
        $notif = Job::prepareNotifications();
        View::share('notif',$notif);


        //
        $this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
        $init_message = Website::WebInit();

        $routes           = explode("@", Route::currentRouteAction(), 2);
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method     = $routes[1];
        $this->parameters = Route::current()->parameters();

        $home_active          = ($this->method == 'home') ? 'current' : '';
        $home_nav_active      = ($this->method == 'home') ? 'selected="selected"' : '';
        $services_active      = ($this->method == 'services') ? 'current' : '';
        $services_nav_active  = ($this->method == 'services') ? 'selected="selected"' : '';
        $market_active        = ($this->method == 'marketplace') ? 'current' : '';
        $market_nav_active    = ($this->method == 'marketplace') ? 'selected="selected"' : '';
        $aboutus_active       = ($this->method == 'aboutus') ? 'current' : '';
        $aboutus_nav_active   = ($this->method == 'aboutus') ? 'selected="selected"' : '';
        $advice_active        = ($this->method == 'advice') ? 'current' : '';
        $advice_nav_active    = ($this->method == 'advice') ? 'selected="selected"' : '';
        $contactus_active     = ($this->method == 'contactus') ? 'current' : '';
        $contactus_nav_active = ($this->method == 'contactus') ? 'selected="selected"' : '';


        $nav_html = Website::prepareNavBar();
        View::share('nav_html', $nav_html);

        View::share('home_active', $home_active);
        View::share('services_active', $services_active);
        View::share('market_active', $market_active);
        View::share('aboutus_active', $aboutus_active);
        View::share('advice_active', $advice_active);
        View::share('contactus_active', $contactus_active);
        View::share('home_nav_active', $home_nav_active);
        View::share('services_nav_active', $services_nav_active);
        View::share('market_nav_active', $market_nav_active);
        View::share('aboutus_nav_active', $aboutus_nav_active);
        View::share('advice_nav_active', $advice_nav_active);
        View::share('contactus_nav_active', $contactus_nav_active);

        $prepared_status = Page::prepareStatus();
        View::share('prepared_status', $prepared_status);

    }
    
    public function getIndex()
    {

    	if (Session::get('data_session'))
    		Session::forget('data_session');
    	if (Session::get('slidersession'))
    		Session::forget('slidersession');
    	$user_role = Auth::user()->roles;
    	$pages     = (isset($id)) ? Page::preparePages(Page::where('company_id', $id)->get()) : Page::preparePages(Page::all());
    	$companies = Company::find(1);
    	$count     = count($pages);

    	
        return view('pages.index')
        ->with('pages', $pages)
        ->with('companies', $companies)
        ->with('user_role', $user_role)
        ->with('count', $count)
        ->with('layout',$this->layout)
        ->with('company_id', $companies->id);

    }
    
    public function getAdd()
    {
    	//GET ALL ROUTES
    	Route::get('routes', array('uses'=>'RoutesController@routes'));
    	$name = Route::getRoutes();
    	$routeCollection = Route::getRoutes();
    	$controller_names = [];

    	foreach ($routeCollection as $key => $value) {
				//KEEP THE NAME OF THE ROUTE
    		$new_name = explode("/",$value->getPath());
    		$controller_names[$key] = $new_name[0];
    	}	
		//TAKE OUT DUPLICATE AND REINDEX
    	$new_controller_names = array_values(array_unique($controller_names));
		//PUSH IT TO THE SCRIPT FILE
    	JavaScript::put([
    		'controller_names' => $new_controller_names
    		]);   

    	$form_data = null;
    	if (Session::get('data_session')) {

    		$form_data = Page::prepareAddFormSession(Session::get('data_session'));
    		Session::forget('data_session');
    	}
    	return view('pages.add')
    	->with('new_controller_names',$new_controller_names)
        ->with('layout',$this->layout)
    	->with('form_data', $form_data);
    }
    public function postAdd()
    {
    	$validator    = Validator::make(Input::all(), Page::$pages_add);
    	Session::put('data_session', Input::all());
    	if ($validator->passes()) {
    		$content               = Page::prepareForPreview(Input::get('content'));
    		return view('pages.preview')
            ->with('layout','layouts.pages')
            ->with('content', $content);
    	} else {
            // validation has failed, display error messages    
    		return Redirect::back()->with('message', 'The following errors occurred')->with('alert_type', 'alert-danger')->withErrors($validator)->withInput();
    	}

    }
    public function getEdit($id = null)
    {
    	 //GET ALL ROUTES
    	Route::get('routes', array('uses'=>'RoutesController@routes'));
    	$name = Route::getRoutes();
    	$routeCollection = Route::getRoutes();
    	$controller_names = [];

    	foreach ($routeCollection as $key => $value) {
			//KEEP THE NAME OF THE ROUTE
    		$new_name = explode("/",$value->getPath());
    		$controller_names[$key] = $new_name[0];
    	}	
		//TAKE OUT DUPLICATE AND REINDEX
    	$new_controller_names = array_values(array_unique($controller_names));
		//PUSH IT TO THE SCRIPT FILE
    	JavaScript::put([
    		'controller_names' => $new_controller_names
    		]);   

    	$form_data = null;
    	if (Session::get('data_session')) {
    		$form_data             = Page::prepareEditFormSession(Session::get('data_session'));
    		$session_slider_images = null;
    		if (Session::get('slidersession')) {
    			$session_slider_images = Page::prepareSliderImagesForEditPageSession(Session::get('slidersession'));
    		}
    		
    		$is_session  = 1;
    		$title       = null;
    		$description = null;
    		$url         = null;
    		$keywords    = null;
    		$content     = null;
    		$page_id     = null;
    		$status      = null;
    	} else {
    		$is_session  = null;
    		$page        = Page::find($id);
    		$page_id     = $page->id;
    		$title       = $page->title;
    		$description = $page->description;
    		$url         = $page->url;
    		$keywords    = $page->keywords;
    		$status      = $page->status;
    		$content     = Page::prepareForEdit(json_decode($page->content_data));

    		$session_slider_images = Page::prepareSliderImagesForEditPage(json_decode($page->slider_image));
    		
    	}
    	return view('pages.edit')
        ->with('layout',$this->layout)
    	->with('page_id', $page_id)
    	->with('title', $title)    	
    	->with('description', $description)
    	->with('url', $url)
    	->with('keywords', $keywords)
    	->with('content', $content)
    	->with('form_data', $form_data)
    	->with('status', $status)
    	->with('session_slider_images', $session_slider_images)
    	->with('new_controller_names', $new_controller_names)
    	->with('is_session', $is_session);

    }
    public function postEdit()
    {        
    	$validator = Validator::make(Input::all(), Page::$pages_add);
    	Session::put('data_session', Input::all());
    	if ($validator->passes()) {
    		$page_id = Input::get('page_id');
    		$content = Page::prepareForPreview(Input::get('content'));
            if ($page_id == 1) { //HOME EDIT

            	$session_slider_images = (Session::get('slidersession')) ? Session::get('slidersession') : null;
            	View::share('session_slider_images', $session_slider_images);

            	$menu_html = Website::prepareMenuBarHomeEdit();
            	View::share('menu_html', $menu_html);

            	$nav_html = Website::prepareNavBarHomeEdit();
            	View::share('nav_html', $nav_html);


            	return view('pages.preview_edit_home')
                ->with('layout','layouts.home_edit')
                ->with('content', $content);
            } else {
            	return view('pages.preview_edit')
                ->with('layout','layouts.pages')
                ->with('content', $content);
            }
            
        } else {
            // validation has failed, display error messages    
        	return Redirect::back()->with('message', 'The following errors occurred')->with('alert_type', 'alert-danger')->withErrors($validator)->withInput();
        }
    }
    
    public function getPreview()
    {

    	if (Session::get('data_session')) {
    		$form_data          = Session::get('data_session');
            //add to page
    		$page               = new Page;
    		$page->title        = $form_data['title'];
    		$page->description  = $form_data['description'];
    		$page->url          = $form_data['url'];
    		$page->keywords     = $form_data['keywords'];
    		$page->content_data = !empty($form_data['content']) ? json_encode($form_data['content']) : null;
    		$page->status       = 1;

            if ($page->save()) { // Save
            	if (Session::get('data_session'))
            		Session::forget('data_session');
            	return Redirect::action('PagesController@getIndex')->with('message', 'Successfully added a page')->with('alert_type', 'alert-success');
            } else {
            	return Redirect::back()->with('message', 'Oops, somthing went wrong. Please try again.')->with('alert_type', 'alert-danger');
            }
        } else {
        	return Redirect::back()->with('message', 'Oops, somthing went wrong. Please try again.')->with('alert_type', 'alert-danger');
        }
        
    }
    
    public function getPreviewEdit()
    {
    	if (Session::get('data_session')) {

    		$form_data          = Session::get('data_session');
            //add to page
    		$page               = Page::find($form_data['page_id']);
    		$page->title        = $form_data['title'];
    		$page->description  = $form_data['description'];
    		$page->url          = $form_data['url'];
    		$page->keywords     = $form_data['keywords'];
    		$page->content_data = isset($form_data['content']) ? json_encode($form_data['content']) : null;
    		$page->status       = ($form_data['page_id'] == 1) ? 1 : $form_data['status'];

            $slider_folder = glob('assets/img/slider/*'); // get all file names
            
            if (Session::get('slidersession')) {
            	if (Session::get('slidersession') == "empty") {
					foreach($slider_folder as $file){ // iterate files
						if(is_file($file))
					    unlink($file); // delete file
				}
				$page->slider_image = null;
			} else {
				$images = Session::get('slidersession');
				foreach ($images as $key => $value) {
					$images[$key][1] = "slider";
				}
                    //erase the deleted files from slider
                    foreach ($slider_folder as $file) { // iterate files
                    	$deleted = true;
                    	if (is_file($file)) {
                    		$parts = explode("/", $file);
                    		foreach ($images as $key => $value) {
                    			if ($parts[3] == $images[$key][0]) {
                    				$deleted = false;
                    			}
                    		}
                    		if ($deleted == true) {
                    			unlink($file);
                    		}
                    	}
                    }
                    $new_path = 'assets/img/slider/';
                    if (!file_exists($new_path)) {
                    	@mkdir($new_path);
                    }
                    foreach ($images as $ikey => $ivalue) {
                    	$this_file_path = 'assets/img/tmp/' . $ivalue[0];
                    	while (file_exists($this_file_path)) {
                    		rename('assets/img/tmp/' . $ivalue[0], $new_path . $ivalue[0]);
                    	}
                    }
                    $page->slider_image = json_encode($images);
                }
            } else {
            	$page->slider_image = null;
            }
            
            if ($page->save()) { // Save the user and redirect to freelancers home
            	$temp_folder = glob('assets/img/tmp/*'); // get all file names
            	foreach($temp_folder as $file){ // iterate files
            		if(is_file($file))
				    unlink($file); // delete file
			}
			if (Session::get('slidersession'))
				Session::forget('slidersession');
			if (Session::get('data_session'))
				Session::forget('data_session');
			return Redirect::action('PagesController@getIndex')->with('message', 'Successfully added a page')->with('alert_type', 'alert-success');
		} else {
			return Redirect::back()->with('message', 'Oops, somthing went wrong. Please try again.')->with('alert_type', 'alert-danger');
		}
	} else {
		return Redirect::back()->with('message', 'Oops, somthing went wrong. Please try again.')->with('alert_type', 'alert-danger');
	}

}

public function postDelete()
{
	$page_id      = Input::get('page_id');
	$page         = Page::find($page_id);
	$page->status = 1;

	if ($page->delete()) {
		return Redirect::action('PagesController@getIndex')->with('message', 'Successfully deleted!')->with('alert_type', 'alert-success');
	} else {
		return Redirect::back()->with('message', 'Oops, somthing went wrong. Please try again.')->with('alert_type', 'alert-danger');
	}
}

public function postContentAdd()
{
	if (Request::ajax()) {
		$status = 400;
		$count  = Input::get('content_set_count');
		$html   = Page::prepareContentArea($count);
		return Response::json(array(
			'status' => 200,
			'html' => $html
			));
	}
}
public function postChangeStatus()
{
	if (Request::ajax()) {
		$status          = 400;
		$id              = Input::get('id');
		$selected_status = Input::get('selected_status');
		$page            = Page::find($id);
		$page->status    = $selected_status;
		if ($page->save()) {
			$status = 200;
		}
		return Response::json(array(
			'status' => $status
			));
	}
}
    /**
     * getPage Method
     * retrieves content from url by parameter and displays page based on user input from pages/add || pages/edit
     * Home page being the only special route we need to keep in mind for routing
     * @param $param1 = menu group
     * @param $param2 = menu item
     **/
    public function getPage($param1 = null, $param2 = null)
    {
        // Set layout
    	$this->layout = View::make('layouts.pages');
    	if (!isset($param2)) { //LINK
    		$page = Page::where('status', 2)->where('param_one', $param1)->first();
    		if (isset($page)) {
                //PAGE FOUND
                $title = isset($page->title)?$page->title:null;
    			$page_content          = json_decode($page->content_data);
    			$this->layout->content = View::make('pages.page')
                ->with('title',$title)
                ->with('page_content', $page_content);
    		} else {
    			$this->layout->content = View::make('errors.missing');
    		}
    	} elseif (isset($param1) && isset($param2)) { //GROUP
    		$page = Page::where('status', 2)
            ->where('param_one', $param1)
            ->where('param_two', $param2)->first();
            $title = isset($page->title)?$page->title:null;
    		if (isset($page)) {
                //PAGE FOUND
    			$page_content          = json_decode($page->content_data);
    			return view('pages.page')
                ->with('layout','layouts.pages')
                ->with('title',$title)
                ->with('page_content', $page_content);
    		} else {
                //PAGE NOT FOUND 404
    			return view('errors.missing')
                ->with('layout','layouts.pages');
    		}
    	}

    }
    public function postAddSlider()
    {
    	if (Request::ajax()) {
    		$order  = Input::get('order');
    		$slider = Page::createSlider($order);
    		return Response::json(array(
    			'status' => 200,
    			'slider' => $slider
    			));
    	}
    }
    public function postRemoveTemp()
    {
    	if (Request::ajax()) {
    		$image_name = Input::get('img_name');
    		$from       = Input::get('from');
    		$status     = 400;
    		if (isset($image_name)) {
    			if ($from != "slider") {
                    // $tmp_path = 'img/tmp/';
    				$slider_path = 'assets/img/' . $from . '/';
                    // $tmp_img = 'img/tmp/'.$image_name;
    				$slider_img  = 'assets/img/' . $from . '/' . $image_name;
    				if (file_exists($slider_path)) {
    					if (file_exists($slider_img)) {
    						if (unlink($slider_img)) {
    							$status = 200;
    						}
    					}
    				}
                } else { //IMAGE IS AT SLIDER FOLDER DO NOT DELETE
                	$status = 201;
                }
            }
            return Response::json(array(
            	'status' => $status
            	));
        }
    }
    
    public function postImageTemp()
    {
    	if (Request::ajax()) {
            // $imagePath = "img/tmp/";
            $status = 400;
    		$imagePath = "assets/img/tmp/";
    		$imagename = $_FILES["kartik-input-706"]['name'];
    		$imagetemp = $_FILES["kartik-input-706"]['tmp_name'];
    		$order     = Input::get('order');

    		$now_time      = time();
    		$new_imagename = $now_time . '-' . $imagename[0];
    		if (!file_exists($imagePath)) {
    			@mkdir($imagePath);
    		}

    		if (!is_writable(dirname($imagePath))) {
                $status = 401;
                return Response::json(array(
                    "error" => 'Destination Unwritable'
                    ));
    		} else {
    			$final_path = preg_replace('#[ -]+#', '-', $new_imagename);
                // Job::dump($final_path);
                // Job::dump($imagetemp[0]);
                // Job::dump($imagePath . $final_path);
                if (move_uploaded_file($imagetemp[0], $imagePath . $final_path)) {
                    $status = 200;
    			return Response::json(array(
                    'status' => $status,
    				"initialPreview" => "<img src='/" . $imagePath . $final_path . "' class='file-preview-image' alt='" . $final_path . "' title='Desert'>"
    		  		));
             }
    		}
            return Response::json(array(
                'error' => 'error'
                ));

    	}
    }
    
    public function postInsertSlide()
    {
    	if (Request::ajax()) {

    		$order = Input::get('order');
    		$html  = Page::prepareImage($order);

    		return Response::json(array(
    			'status' => 200,
    			'html' => $html,
    			'order' => $order
    			));
    	}
    }
    
    public function postSessionReindex()
    {
    	if (Request::ajax()) {
    		$status = 400;
    		if ((Session::get('slidersession'))) {
    			Session::forget('slidersession');
    			$status = 401;
    		}
    		if (Input::get('session_data')) {
    			$slidersession = Input::get('session_data');
    		} else {
    			$slidersession = "empty";
    		}

            // if (!empty($slidersession)) {
            // 	foreach ($slidersession as $key => $value) {
            // 		$slidersession[$key][0] = preg_replace('#[ -]+#', '-', $slidersession[$key][0]);

            // 	}
            // }
    		Session::put('slidersession', $slidersession);
    		if ((Session::get('slidersession'))) {
    			$status = 200;
    		}
    		return Response::json(array(
    			'status' => $status
    			));
    	}
    }
    // //FOR TESTING THE SESSION
    public function postTestSession()
    {
    	if (Request::ajax()) {

    		if ((Session::get('slidersession'))) {
                //THE SESSION
    			Job::dump(Session::get('slidersession'));
    		}

    		return Response::json(array(
    			'status' => 200
    			));
    	}
    }
    public function postReloadPages()
    {
    	if (Request::ajax()) {
    		$status         = 200;
    		$pages          = Page::where('status', 2)->whereNotIn('id', array(
    			1
    			))->get();
    		$pages_prepared = Page::prepareForSelect($pages);
    		$pages_option   = Page::prepareOptions($pages_prepared);
    		return Response::json(array(
    			'status' => 200,
    			'pages_option' => $pages_option
    			));
    	}
    }
    
}