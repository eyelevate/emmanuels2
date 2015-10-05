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
use App\MenuItem;

class MenusController extends Controller {


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
    }


public function getIndex()
{
	if ($this->role_id < 3) {
		$companies = Company::find(1);
		$menus = Menu::prepare(Menu::where('status',1)->get());
	    return view('menus.index')
	    ->with('layout',$this->layout)
        ->with('menus',$menus);
	}
}

public function getAdd()
{	
//previously was where status 2 but i dont think we need it
//		$menus = Page::where('status',2)->get();
	$pages = Page::where('status',2)->whereNotIn('id', array(1))->get();
	$pages_prepared = Page::prepareForSelect($pages);
	$prepared_select = Menu::prepareSelect();

	return view('menus.add')
	->with('pages_prepared',$pages_prepared)
	->with('prepared_select',$prepared_select)
	->with('layout',$this->layout)
	->with('pages',$pages);
}

public function postAdd()
{	
	$validator = Validator::make(Input::all(), Menu::$rules_add);
	if ($validator->passes()) {
		$kind = Input::get('kind');
		$url = Input::get('url');
		$url = substr($url, 1);
		if ($kind == 1) { //its a link
			$validator = Validator::make(Input::all(), Menu::$rules_add_link);
			if ($validator->passes()) {
				$name = Input::get('name');
				$page_id = Input::get('page_id');

				//add param_one to menus
				$page = Page::find($page_id);
				$page_url = substr($page->url, 1);
				$page->param_one = $page_url;

				$menu = new Menu;
				$menu->name = $name;
				$menu->page_id = $page_id;
				$menu->url = $url;
				$menu->status = 1;
				if($menu->save() && $page->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully added a menu')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			} else {
				// validation has failed, display error messages    
				return Redirect::back()
				->with('message', 'The following errors occurred')
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	    	
			}
		} else { //its a menu group
			$name = Input::get('name');
			$menu = new Menu;
			$menu->name = $name;
			$menu->url = $url;
			$menu->status = 1;
				if($menu->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully added a menu')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			}

		} 	else {
		// validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}	
	}
	public function getEdit($id = null)
	{
		$this_menu = Menu::find($id);
		$this_menu_id = isset($this_menu)?$this_menu->id:null;
		$is_link = (isset($this_menu->page_id)?1:2);

		$pages = Page::where('status',2)->whereNotIn('id', array(1))->get();
		$pages_prepared = Page::prepareForSelect($pages);
		$menu_page_id = ($this_menu->page_id)?$this_menu->page_id:null;

		$prepared_select = Menu::prepareSelect();

		return view('menus.edit')
		->with('prepared_select',$prepared_select)
		->with('menus',$this_menu)
		->with('menu_id',$this_menu_id)
		->with('pages_prepared',$pages_prepared)
		->with('menu_page_id',$menu_page_id)
		->with('layout',$this->layout)
		->with('is_link',$is_link);
	}
	public function postEdit()
	{
		$validator = Validator::make(Input::all(), Menu::$rules_add);
		if ($validator->passes()) {
			$menu_id = Input::get('menu_id');
			$kind = Input::get('kind');
			$url = Input::get('url');
			$url = substr($url, 1);
		if ($kind == 1) { //its a link
			$validator = Validator::make(Input::all(), Menu::$rules_add_link);
			if ($validator->passes()) {
				$name = Input::get('name');
				$page_id = Input::get('page_id');

				//add param_one to menus
				$page = Page::find($page_id);
				$page_url = substr($page->url, 1);
				$page->param_one = $page_url;
				//param two must be null
				$page->param_two = null;

				$menu = Menu::find($menu_id);
				$menu->name = $name;
				$menu->page_id = $page_id;
				$menu->url = $url;
				$menu->status = 1;
				if($menu->save() && $page->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully Updated!')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			} else {
				// validation has failed, display error messages    
				return Redirect::back()
				->with('message', 'The following errors occurred')
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	    	
			}
		} else { //its a menu group
			$name = Input::get('name');
			$menu = Menu::find($menu_id);
			$menu->name = $name;
			$menu->page_id = null;
			$menu->url = $url;
			$menu->status = 1;
				if($menu->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully Updated!')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			}
		} 	else {
		// validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	

		}	
	}

	public function postDelete()
	{
		$menu_id = Input::get('menu_id');
		$menu = Menu::find($menu_id);
		$count = count(MenuItem::where('menu_id',$menu_id)->get());
		if($count>0){
			$menu_items = MenuItem::where('menu_id',$menu_id);
			if($menu->delete()) {
				if ($menu_items->delete()) {
					return Redirect::back()
					->with('message', 'Successfully Deleted!')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again. items and menus')
					->with('alert_type','alert-danger');
				}
			} else {
				return Redirect::back()
				->with('message', 'Oops, somthing went wrong. Please try again. items and menus')
				->with('alert_type','alert-danger');	
			}

		} elseif($menu->delete()) {

			return Redirect::back()
			->with('message', 'Successfully Deleted!')
			->with('alert_type','alert-success');

		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

	public function getOrder()
	{
		$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
		$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
		$list_html = Menu::prepareNestable($menus,$menu_items);
		return view('menus.order')
		->with('layout',$this->layout)
		->with('list_html',$list_html);

	}

	public function postOrder()
	{
		$menus_arranged = Input::get('menu');
		foreach ($menus_arranged as $key => $value) {
			$menus = Menu::find($key);
			$menus->order = $value['order'];
			if (isset($value['item'])) {
				foreach ($value['item'] as $ikey => $ivalue) {
					$menu_items = MenuItem::find($ikey);
					$menu_items->order = $ivalue['order'];
					$menu_items->save();
				}
			}
			$menus->save();
		}
		return Redirect::action('MenusController@getIndex')
		->with('message', 'Successfully Saved')
		->with('alert_type','alert-success');
	}

	public function postCountItems() {
		if(Request::ajax()) {
			$status = 200;
			$id = Input::get('id');
			$items_count = count(MenuItem::where('menu_id',$id)->get());

			return Response::json(array(
				'status' => 200,
				'count' => $items_count
				));
		}
	}
	public function postReloadMenus() {
		if(Request::ajax()) {
			$status = 200;
			$menus = Menu::where('page_id',null)->get();
			$menus_prepared = Menu::prepareForSelect($menus);
			$menus_option = Menu::prepareOptions($menus_prepared);
			return Response::json(array(
				'status' => 200,
				'menus_option' => $menus_option
				));
		}
	}


}