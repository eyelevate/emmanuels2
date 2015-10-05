<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
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
use App\Page;

class Website extends Model {
	protected $fillable = [];

	public static  function WebInit()
	{
		$message = "Oops, somthing went wrong. Please try again.";
		$error = null;
		//add to page
		$page = Page::find(1);
		if (!isset($page)) {
			$error = $message;
			$page = new Page;
			$page->title = "Home";
			$page->description = "Homepage";
			$page->url = "/home";
			$page->param_one = null;
			$page->keywords = "Homepage";
			$page->content_data = null;
			$page->status = 2;
			if ($page->save()) {
				$error = null;
				$menu = Menu::find(1);
				if (!isset($menu)) {
					$error = $message;
					$menu = new Menu;
					$menu->name = "Home";
					$menu->page_id = 1;
					$menu->url = "home";
					$menu->status = 1;
					if ($menu->save()) $error = null;
				}
			}
		}
		return $error;
	}
	public static  function prepareMenuBar()
	{
		$url = Request::url();
		$html = '';
		$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
		$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
		
		if (isset($menus,$menu_items)) {
			
			$html .= '<ul id="mainMenuList" class="dropdown mainMenuListFull">';
			// $html .= '<li class="dropdown current">';              
			// 		$html .=  '<a class="home_a li_a" style="margin-right:10px;" href="/">Home</a>';
			// $html .= '</li>';
			foreach ($menus as $key => $value) {

					if (isset($value->page_id)) { //MENU LINKS

						$this_page = Page::where('id', $value->page_id)->first();
						$page_class = ($value->page_id == 1) ?"current":"";
						$homepage_class = ($value->page_id == 1) ?"home_a":"li_a";
						$home_style = ($value->page_id == 1) ?"margin-right:1px;":"";
						$page_color = ($value->page_id == 1) ?"#FFFFFF":"#333";
						$html .= '<li class="dropdown '.$page_class.' " style="'.$home_style.'">';              
						$html .=  '<a class="'.$homepage_class.'" href="'.URL::to('/').'/'.$this_page->param_one.'" style="color:'.$page_color.';">'. $value->name.'</a>';
						$html .= '</li>';
					} else { //MENU GROUPS

						$html .= '<li>';
						$html .= '<li class="dropdown">';
						$html .= '<a class="dropdown-toggle li_a" data-toggle="dropdown">';               
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span></a>';
						$html .= '<ul class="dropdown-menu item_ui" role="menu" aria-labelledby="dropdownMenu1">';

								foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
									if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP

										$this_page = Page::where('id', $mivalue->page_id)->first();
	
										$html .= '<li role="presentation" class="item_li"><a class="item_a" role="menuitem" tabindex="-1" href="'.URL::to('/').'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
									}
								}
								$html .= '</ul>';
								$html .= '</li>';
							}
				}//End of menus for loop

				$html .= '</ul>';
			}
			
			return $html;
		}

		public static  function prepareMenuBarHomeEdit()
		{
			$url = Request::url();
		$html = '';
		$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
		$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
		if (isset($menus,$menu_items)) {
			$html .= '<ul id="mainMenuList" class="dropdown mainMenuListFull">';
			// $html .= '<li class="dropdown current">';              
			// 		$html .=  '<a class="home_a li_a" style="margin-right:10px;" href="/">Home</a>';
			// $html .= '</li>';
			foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::where('id', $value->page_id)->first();
						$page_class = ($value->page_id == 1) ?"current":"";
						$homepage_class = ($value->page_id == 1) ?"home_a":"li_a";
						$home_style = ($value->page_id == 1) ?"margin-right:1px;":"";
						$page_color = ($value->page_id == 1) ?"#FFFFFF":"#333";
						$html .= '<li class="dropdown '.$page_class.' " style="'.$home_style.'">';              
						$html .=  '<a class="'.$homepage_class.'" href="#" style="color:'.$page_color.';">'. $value->name.'</a>';
						$html .= '</li>';
					} else { //MENU GROUPS

						$html .= '<li>';
						$html .= '<li class="dropdown">';
						$html .= '<a class="dropdown-toggle li_a" data-toggle="dropdown">';               
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span></a>';
						$html .= '<ul class="dropdown-menu item_ui" role="menu" aria-labelledby="dropdownMenu1">';
								foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
									if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
										$this_page = Page::where('id', $mivalue->page_id)->first();
										$html .= '<li role="presentation" class="item_li"><a class="item_a" role="menuitem" tabindex="-1" href="#">'.$mivalue->name.'</a></li>';
									}
								}
								$html .= '</ul>';
								$html .= '</li>';
							}
				}//End of menus for loop

				$html .= '</ul>';
			}
			return $html;
		}


		public static  function prepareNavBar()
		{
			$url = Request::url();
			$html = '';
			$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
			$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
			if (isset($menus,$menu_items)) {
				$html .= '<ul class="nav navbar-nav navbar-right">';
				// $html .= '<li class="dropdown">';              
				// 	$html .=  '<a  href="/"> Home</a>';
				// $html .= '</li>';
				foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::where('id', $value->page_id)->first();
						$html .= '<li class="dropdown">';              
						$html .=  '<a  href="'.URL::to('/').'/'.$this_page->param_one.'" ">'. $value->name.'</a>';
						$html .= '</li>';

					} else { //MENU GROUPS
						$html .= '<li class="dropdown">';               
						$html .= '<a class="dropdown-toggle" data-toggle="dropdown">';
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span>';
						$html .= '</a>'; 
						$html .= '<ul class="dropdown-menu" role="menu">';
									foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
										if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
											$this_page = Page::where('id', $mivalue->page_id)->first();
											$html .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.URL::to('/').'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
										}
									}
									$html .= '</ul>';
									$html .= '</li>';
								}
				}//End of menus for loop

				$html .= '</ul>';
			}
			return $html;
		}

			public static  function prepareNavBarHomeEdit()
		{
			$url = Request::url();
			$html = '';
			$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
			$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
			if (isset($menus,$menu_items)) {
				$html .= '<ul class="nav navbar-nav navbar-right">';
				// $html .= '<li class="dropdown">';              
				// 	$html .=  '<a  href="/"> Home</a>';
				// $html .= '</li>';
				foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::find($value->page_id);
						$html .= '<li class="dropdown">';              
						$html .=  '<a  href="#">'. $value->name.'</a>';
						$html .= '</li>';

					} else { //MENU GROUPS
						$html .= '<li class="dropdown">';               
						$html .= '<a class="dropdown-toggle" data-toggle="dropdown">';
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span>';
						$html .= '</a>'; 
						$html .= '<ul class="dropdown-menu" role="menu">';
									foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
										if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
											$this_page = Page::find($mivalue->page_id);
											$html .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.$mivalue->name.'</a></li>';
										}
									}
									$html .= '</ul>';
									$html .= '</li>';
								}
				}//End of menus for loop

				$html .= '</ul>';
			}
			return $html;
		}

	}